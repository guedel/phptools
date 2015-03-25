<?php
    /*
 * The MIT License
 *
 * Copyright 2015 Guillaume de Lestanville.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
?>
﻿<html>
<head>
</head>
<body>
<?php


define("BASE64CHARS", 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz01234567890+/');
define("BASE16CHARS", '0123456789ABCDEF');
define('BASE32CHARS', '0123456789ABCDEFGHJKLMNPQRTUVWXY');
define('DEBUG_CRYPTAGE', false);


/**
 * Conversion du texte en base 64
 */
function encode_base64($in) {
	$ret = '';
	$BASE64CHARS = BASE64CHARS;

	// on complète pour que la longueur totale soit multiple de 3.
	$l = strlen($in);
	$r = (3 - $l % 3) %3;
	/*
	if ($r == 1)
		$r = 2;
	else if ($r == 2)
		$r = 1;
	*/

	$in .= str_repeat("\0", $r);

	if (DEBUG_CRYPTAGE)
		echo "l: $l, r: $r<br>";

	// on prend par groupe de 3 caractères
	for ($index = 0; $index < $l + $r; $index += 3) {
		$c1 = ord($in[$index]);
		$c2 = ord($in[$index + 1]);
		$c3 = ord($in[$index + 2]);

		if (DEBUG_CRYPTAGE)
			printf("ENC: %2X %2X %2X => ", $c1, $c2, $c3);

		$o1 = $c1 >> 2 & 63;
		$o2 = ($c1 & 3) << 4 | $c2 >> 4;
		$o3 = ($c2 & 15) << 2 | $c3 >> 6;
		$o4 = $c3 & 63 ;

		if (DEBUG_CRYPTAGE)
			printf("%2X %2X %2X %2X", $o1, $o2, $o3, $o4);

		$ret .= $BASE64CHARS[$o1] . $BASE64CHARS[$o2] . $BASE64CHARS[$o3] . $BASE64CHARS[$o4];

		if (DEBUG_CRYPTAGE)
			echo "<br>\n";
	}

	$l2 = strlen($ret);
	if ($r >= 1) {
		$ret[$l2 - 1] = '=';
	}

	if ($r >= 2) {
		$ret[$l2 - 2] = '=';
	}

	return $ret;
}

function ord64($in) {
	$o = ord($in);

	if ($in >= 'A' && $in <= 'Z') {
		return $o - ord('A');
	}
	if ($in >= 'a' && $in <= 'z') {
		return $o - ord('a') + 26;
	}
	if ($in >= '0' && $in <= '9') {
		return $o - ord('0') + 52;
	}
	if ($in == '+') {
		return 62;
	}
	if ($in == '/') {
		return 63;
	}

	return 0;
}

/*
|       1       |       2       |       3       |
|8'7'6'5'4'3'2'1|8'7'6'5'4'3'2'1|8'7'6'5'4'3'2'1|
|6'5'4'3'2'1|6'5'4'3'2'1|6'5'4'3'2'1|6'5'4'3'2'1|
|     1     |     2     |     3     |     4     |
*/

function decode_base64($in) {
	$ret = '';

	// on complète pour que la longueur totale soit multiple de 4.
	$l = strlen($in);
	$r = 4 - $l % 4;
	//echo "l: $l, r: $r<br>";
	$in .= str_repeat("_", $r);

	// on prend par groupe de 4 caractères
	for ($index = 0; $index < $l + $r; $index += 4) {
		$c1 = ord64($in[$index]);
		$c2 = ord64($in[$index + 1]);
		$c3 = ord64($in[$index + 2]);
		$c4 = ord64($in[$index + 3]);

		if (DEBUG_CRYPTAGE)
			printf("DEC: %2X %2X %2X %2X => ", $c1, $c2, $c3, $c4);

		$o1 = ($c1 << 2) | $c2 >> 4;
		$o2 = (($c2 & 0x0F) << 4) | $c3 >> 2;
		$o3 = (($c3 & 0x03) << 6) | $c4;

		if (DEBUG_CRYPTAGE)
			printf("%2X %2X %2X", $o1, $o2, $o3);

		$ret .= chr($o1) . chr($o2) . chr($o3);

		if (DEBUG_CRYPTAGE)
			echo "<br>\n";
	}
	return $ret;
}


function cryptage($text) {
	return encode_base64($text);
}

function decryptage($text) {
	return decode_base64($text);
}

function test_cryptage() {
	$text = "message un peu plus long à crypter";

	$crypt = cryptage($text);
	$decrypt = decryptage($crypt);

	echo "message orginal: $text<br/>\n";
	echo "message crypté: $crypt<br/>\n";
	echo "message décryté: $decrypt<br/>\n";
}

// test_cryptage();
?>

<form method='post'>
<textarea id='source' name='source' rows='10' cols='80'>
<?php
	if (isset($_POST['source'])) {
		echo $_POST['source'];
	}
?>
</textarea>
<div>
<input type='submit' name='encode' value='Encodage'/>
<input type='submit' name='decode' value='Decodage'/>
<div>
<p>Résultat:</p>
<div style='border:1px solid #ff0000'>
<?php
	if (isset($_POST['encode'])) {
		echo cryptage($_POST['source']);
	}

	if (isset($_POST['decode'])) {
		//echo nl2br( htmlentities(decryptage($_POST['source']),  ENT_SUBSTITUTE | ENT_HTML5)  );
		echo nl2br( htmlentities(base64_decode($_POST['source']),  ENT_SUBSTITUTE | ENT_HTML5)  );
	}
?>
</div>


</body>
</html>