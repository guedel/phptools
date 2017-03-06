<?php
// Assistant de génération de formulaires simplifié
// Version Mysql

// Etape 1: définition de la connexion à la base
// Etape 2: requête de sélection
// Etape 3: Sélection des champs
// Etape 4: Mode de rendu (formulaire simple ou tabulaire) + prévisu du rendu
// Etape 5: Génération du code

require 'config.php';


if (isset($_REQUEST['etape'])) {
	$etape = $_REQUEST['etape'];
}
if (isset($_REQUEST['retour'])) {
	$etape--;
}
if (isset($_REQUEST['suivant'])) {
	$etape++;
}

for ($i=1; $i <= 7; ++$i) {
    include_once  "controllers/step$i.php";
}
?>
<html>
<header>
	<title>Assistant formulaire</title>
</header>
<body>
	<form method="post" name="frmWizard" id="frmWizard">
	<input type="hidden" name="etape" value="<?php echo $etape; ?>" />
	<table>
	  <tr><td></td><td>
<?php
	if ($etape > ETAPE_AUTHENTIFICATION) {
?>
		<input type="submit" value="Retour" name="retour"/>Etape n° <?= $etape ?> : <?= $step_names[$etape] ?>
<?php
	} else {
		echo $step_names[$etape];
	}
?>
	 </td></tr>
<?php
    for ($i=1; $i <= 7; ++$i) {
        include_once "views/step$i.php";
    }

	if (isset($message)) {
?>
		<tr><td></td><td><?= $message ?></td></td>
<?php
	}
?>
		<tr><td></td><td>
			<input type="submit" value="Actualise" name="actualise"/>
<?php
	if ($etape < ETAPE_GENERATION) {
?>
			<input type="submit" value="Suivant" name="suivant"/>
<?php
	} else {
		echo "&nbsp;";
	}
?>
		</td></tr>

	</table>
	</form>
</body>
</html>
