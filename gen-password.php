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
<header>
	<title>Générateur de mots de passe</title>

<style type='text/css'>
	table {
		border: 1px solid black;
	}
	td {
		margin : 5px;
		padding: 0;
		/*border: 1px solid black;*/
	}
</style>

</head>
<body>
<?php

// Générateur de mots de passe
DEFINE("MAJUS", "ABCDEFGHIJKLMNOPQRSTUVWXYZ");
DEFINE("MINUS", "abcdefghijklmnopqrstuvwxyz");
DEFINE("CHIFFRE", "0123456789");
DEFINE("SIGNE", '+-=_%:!;.?,*&@\|#/<>[]{}');

DEFINE("MAX_MAJUS", 4);
DEFINE("MAX_MINUS", 4);
DEFINE("MAX_CHIFFRE", 4);
DEFINE("MAX_SIGNE", 2);

DEFINE("MIN_MAJUS", 1);
DEFINE("MIN_MINUS", 1);
DEFINE("MIN_CHIFFRE", 1);
DEFINE("MIN_SIGNE", 1);

DEFINE("MIN_LETTRE", 6);

DEFINE("MAX_ITER", 20);

$min_majus = MIN_MAJUS;
$max_majus = MAX_MAJUS;
$min_minus = MIN_MINUS;
$max_minus = MAX_MINUS;
$min_chiffre = MIN_CHIFFRE;
$max_chiffre = MAX_CHIFFRE;
$min_signe = MIN_SIGNE;
$max_signe = MAX_SIGNE;
$min_longueur = MIN_LETTRE;
$max_iter = MAX_ITER;

if (isset($_POST['min_chiffre'])) $min_chiffre = $_POST['min_chiffre'];
if (isset($_POST['max_chiffre'])) $max_chiffre = $_POST['max_chiffre'];
if (isset($_POST['min_majus'])) $min_majus = $_POST['min_majus'];
if (isset($_POST['max_majus'])) $max_majus = $_POST['max_majus'];
if (isset($_POST['min_minus'])) $min_minus = $_POST['min_minus'];
if (isset($_POST['max_minus'])) $max_minus = $_POST['max_minus'];
if (isset($_POST['max_signe'])) $max_signe = $_POST['max_signe'];
if (isset($_POST['min_signe'])) $min_signe = $_POST['min_signe'];
if (isset($_POST['min_longueur'])) $min_longueur = $_POST['min_longueur'];
if (isset($_POST['max_iter'])) $max_iter = $_POST['max_iter'];

$min_requis = $min_chiffre + $min_majus + $min_minus + $min_signe;
$max_requis = $max_chiffre + $max_majus + $max_minus + $max_signe;

if ($min_longueur < $min_requis) {
	echo "La longueur doit être au moins égale ou supérieure à la somme des minimaux";
	die();
}

if ($min_longueur > $max_requis) {
	echo "La longueur doit être au moins égale ou inférieure à la somme des maximaux";
	die();
}

function alea($nb) {
	return mt_rand(1, $nb);
}

class Groupe  {
	public $ensemble;
	public $tirage_min;
	public $tirage_max;

	private $nb_tirage = 0;

	public function __construct($ensemble, $tirage_min, $tirage_max) {
		$this->ensemble = $ensemble;
		$this->tirage_min = $tirage_min;
		$this->tirage_max = $tirage_max;
		$this->reset();
	}

	public function reset() {
		$this->nb_tirage = 0;
	}

	public function tirage_lettre($nb = 0) {
		$rez = '';
		if ($nb == 0) {
			$nb = $this->tirage_min;
		}
		//echo "nb: $nb, nb_tirage: $this->nb_tirage, max: $this->tirage_max<br>";
		for ($cnt = 0; $cnt < $nb && $this->nb_tirage < $this->tirage_max; ++ $cnt) {
			$index = alea(strlen($this->ensemble)) - 1;
			$rez .= $this->ensemble[$index];
			++$this->nb_tirage;
		}
		//echo htmlentities($rez), strlen($rez), "<br>";
		return $rez;
	}
}

function tirage_lettre($nombre, $ensemble) {
	$rez = "";
	for ($compteur = 0; $compteur < $nombre; ++$compteur) {
		$index = alea(strlen($ensemble)) - 1;
		$rez .= $ensemble[$index];
	}
	return $rez;
}

function tirage_mot() {
	global $max_chiffre, $max_minus, $max_majus, $max_signe;
	global $min_chiffre, $min_minus, $min_majus, $min_signe;

	echo "Avant tirage<br/>";
	$mot = tirage_lettre($max_chiffre, CHIFFRE);
	$mot .= tirage_lettre($max_minus, MINUS);
	$mot .= tirage_lettre($max_majus, MAJUS);
	$mot .= tirage_lettre($max_signe, SIGNE);
	echo "Avant mélange : $mot<br/>";
	melange($mot);
	echo "Après mélange : $mot<br/>";
	return $mot;
}

function tirage_mot_requis($longueur, $groupes) {
	$mot = '';
	$nb_groupe = count($groupes);

	foreach($groupes as $grp) {
		$grp->reset();
	}

	// tirage du minimun requis dans chaque groupe
	global $min_requis;
	for ($groupe = 0; $groupe < $nb_groupe; ++$groupe) {
		#echo "($groupe) ";
		$mot .= $groupes[$groupe]->tirage_lettre();
	}

	//echo 'tempo:', htmlentities($mot);
	//printf("longueur: %d -> %d<br/>", strlen($mot), $longueur);

	// tirage aléatoire jusqu'à obtenir la longueur désirée et sans dépasser le
	// maximum dans chaque groupe.
	for ($taille = strlen($mot);$taille < $longueur; $taille = strlen($mot)) {
		$groupe = alea($nb_groupe) -1;
		//echo "($groupe) ";
		$mot .= $groupes[$groupe]->tirage_lettre(1);
	}
	melange($mot);
	return $mot;
}

function melange(&$mot) {
	$lg = strlen($mot);
	for ($index = 0; $index < $lg; ++$index) {
		$idx1 = alea($lg) - 1;
		$idx2 = alea($lg) - 1;

		$c = $mot[$idx1];
		$mot[$idx1] = $mot[$idx2];
		$mot[$idx2] = $c;
	}
}

// initialisation des groupes de mots
$groupes_lettres = array(
		new Groupe(CHIFFRE, $min_chiffre, $max_chiffre),
		new Groupe(MAJUS, $min_majus, $max_majus),
		new Groupe(MINUS, $min_minus, $max_minus),
		new Groupe(SIGNE, $min_signe, $max_signe)
	);

?>
<form method="post">
	<table style='border: 1px solid black'>
		<tr><th></th><th>Mini</th><th>Maxi</th></tr>
		<tr>
			<td>Majuscule</td>
			<td><input type="text" name="min_majus" id="min_majus" value="<?php echo $min_majus; ?>" onchange='verif(this)'/></td>
			<td><input type="text" name="max_majus" id="max_majus" value="<?php echo $max_majus; ?>" onchange='verif(this)'/></td>
		</tr>
		<tr>
			<td>Minuscule</td>
			<td><input type="text" name="min_minus" id="min_minus" value="<?php echo $min_minus; ?>" onchange='verif(this)'/></td>
			<td><input type="text" name="max_minus" id="max_minus" value="<?php echo $max_minus; ?>" onchange='verif(this)'/></td>
		</tr>
		<tr>
			<td>Chiffres</td>
			<td><input type="text" name="min_chiffre" id="min_chiffre" value="<?php echo $min_chiffre; ?>" onchange='verif(this)'/></td>
			<td><input type="text" name="max_chiffre" id="max_chiffre" value="<?php echo $max_chiffre; ?>" onchange='verif(this)'/></td>
		</tr>
		<tr>
			<td>Signes</td>
			<td><input type="text" name="min_signe" id="min_signe" value="<?php echo $min_signe; ?>" onchange='verif(this)'/></td>
			<td><input type="text" name="max_signe" id="max_signe" value="<?php echo $max_signe; ?>" onchange='verif(this)'/></td>
		</tr>
		<tr>
			<td>Longueur du mot</td>
			<td><input type="text" name="min_longueur" id="min_longueur" value="<?php echo $min_longueur; ?>" onchange='verif(this)'/></td>
			<td><span id='info-long'><?php echo "entre $min_requis et $max_requis"; ?></span></td>
		</tr>
		<tr>
			<td>Nombre d'itération</td>
			<td></td>
			<td><input type="text" name="max_iter" value="<?php echo $max_iter; ?>"/></td>
		</tr>
		<tr><td colspan='3'><input type="submit" name="calcule" value="Calcule"/>
	</table>
</form>

<table style='border: 1px solid black'>
<?php
if (isset($_POST['calcule'])) {
	for ($index = 0; $index < $max_iter; ++$index) {
		$mot = tirage_mot_requis($min_longueur, $groupes_lettres);

		$decompose = "";
		/*
		for( $idxMot = 0; $idxMot < strlen($mot); ++$idxMot) {
			$decompose .= "," . ord($mot[$idxMot]);
		}
		*/

		echo '<tr><td>'. ($index + 1) . ')  </td><td>'
			. htmlspecialchars($mot) .'</td><td>' . $decompose . '</td></tr>';
	}
}


?>
</table>
<script type='text/javascript'>
function verif(item) {
	var min_chiffre = parseInt(document.getElementById("min_chiffre").value);
	var max_chiffre = parseInt(document.getElementById("max_chiffre").value);
	var min_majus = parseInt(document.getElementById("min_majus").value);
	var max_majus = parseInt(document.getElementById("max_majus").value);
	var min_minus = parseInt(document.getElementById("min_minus").value);
	var max_minus = parseInt(document.getElementById("max_minus").value);
	var min_signe = parseInt(document.getElementById("min_signe").value);
	var max_signe = parseInt(document.getElementById("max_signe").value);
	//var longueur = document.getElementById("min_longueur");

	var min_requis, max_requis;

	min_requis = min_chiffre + min_majus + min_minus + min_signe;
	max_requis = max_chiffre + max_majus + max_minus + max_signe;

	var info = document.getElementById("info-long");
	info.innerHTML = "entre " + min_requis + " et " + max_requis;
}
</script>

</body>
</html>