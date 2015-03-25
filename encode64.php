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
<html>
	<head>
		<title>Encodage de fichier en base 64</title>
		<meta http-equiv="Content-Type" content="txt/html; charset=utf-8" />
		<style type='text/css'>
			.bouton {
				background-color: #c0c0c0;
				border-width:4px;
				border-color : lightgray;
				border-style:outset;
				margin: 3px;
				padding: 2px 5px;
				text-decoration : none;
			}

			.bouton:hover {
				background-color: #ddd;
			}

		</style>
	</head>
	<body>
<?php
	if (isset($_POST['envoi'])) {
		//print_r($_FILES);
		// Traitement du fichier envoyé
		$fichier = $_FILES['image']['tmp_name'];
		$nom = $_FILES['image']['name'];

		$txt = file_get_contents($fichier);
		$encode = base64_encode($txt);
		$info = getimagesize($fichier);
		$taille = filesize($fichier);

		// divise le resultat en ligne de 72 caractère
		echo "<p>Résultat</p>";
		echo "<ul>Informations sur le fichier";
		echo "<li>Nom: $nom</li>";
		echo "<li>Taille: $taille octets</li>";
		echo "<li>Largeur : {$info[0]}</li>";
		echo "<li>Hauteur : {$info[1]}</li>";
		echo "<li>mime-type: {$info['mime']}</li>";
		echo "</ul>";

		define ('largeur', 72);
		echo "<pre>";
		for ($start = 0; $start <= strlen($encode); $start += largeur) {
			echo '<div>', substr($encode, $start, largeur), '</div>';
		}
		echo "</pre>";
	}
?>
		<form id="encform" method="post" enctype="multipart/form-data">
			<p>
				<label for="input_image">Fichier image:</label>
				<input type="file" name="image" id="input_image" />
				<input type="hidden" name="MAX_FILE_SIZE" value="1572864" />
			</p>
			<p>
				<input type="submit" class="bouton" name='envoi' value="encode image" />
			</p>
		</form>
	</body>
</html>
