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
	define('LEFT', 'l');
	define('RIGHT', 'r');
	define('LDOT', LEFT . '.');
	define('RDOT', RIGHT . '.');

	class Pair {
		public $left, $right;

		public function __construct($left, $right) {
			$this->left = $left;
			$this->right = $right;
		}
	}

	function Ajoute($source, $ajout, $sep = null) {
		if (! $source) {
			return $ajout;
		}
		else if ($ajout) {
			return $source . $sep . $ajout;
		}
		return $source;
	}

	function ZoneTexte($nom, $valeur = '') {
		//return sprintf('<input type="text" name="%s" value="%s"/>', $nom, $valeur);
		return sprintf('<textarea name="%s" cols="50" rows="4" wrap="hard">%s</textarea>', $nom, $valeur);
	}

	function EntreParentheses($texte) {
		return $texte[0] == '(' && $texte[strlen($texte)-1] == ')';
	}

	function CheckParentheses(&$texte) {
		if ($texte && ! EntreParentheses($texte)) {
			$texte = '(' . $texte . ')';
		}
	}

	function RequeteDroiteSeulement(Pair $tables, $clefs, $colonnes, $supplements, $where, $order_by) {
		$sel_exp = '';
		$join_exp = '';
		$null_exp = '';

		foreach($clefs as $item) {
			$sel_exp = Ajoute($sel_exp, RDOT . $item->right, ', ');
			$join_exp = Ajoute($join_exp, '(' . LDOT . $item->left . ' = ' . RDOT . $item->right . ')', ' AND ');
			$null_exp = Ajoute($null_exp, '(' . LDOT . $item->left . ' IS NULL)', ' AND ');
		}
		foreach($colonnes as $item) {
			if ($item->right) {
				$sel_exp = Ajoute($sel_exp, RDOT . $item->right, ', ');
			}
		}
		foreach($supplements as $item) {
			if ($item->right) {
				$sel_exp = Ajoute($sel_exp, RDOT . $item->right, ', ');
			}
		}

		$req = "SELECT $sel_exp<br/>"
			."FROM $tables->left AS " . LEFT . "<br/>"
			."RIGHT JOIN $tables->right AS " . RIGHT . " ON $join_exp";
		$req = Ajoute($req, $null_exp, "<br/>WHERE ");
		$req = Ajoute($req, $where->right, " AND ");
		$req = Ajoute($req, $order_by, "<br/>ORDER BY ");
		return $req;
	}

	function RequeteGaucheSeulement(Pair $tables, $clefs, $colonnes, $supplements, Pair $where, $order_by) {
		$sel_exp = '';
		$join_exp = '';
		$null_exp = '';

		foreach($clefs as $item) {
			$sel_exp = Ajoute($sel_exp, LDOT . $item->left, ', ');
			$join_exp = Ajoute($join_exp, '(' . LDOT . $item->left . ' = ' . RDOT . $item->right . ')', ' AND ');
			$null_exp = Ajoute($null_exp, '(' . RDOT . $item->right . ' IS NULL)', ' AND ');
		}

		foreach($colonnes as $item) {
			if ($item->left) {
				$sel_exp = Ajoute($sel_exp, LDOT . $item->left, ', ');
			}
		}
		foreach($supplements as $item) {
			if ($item->left) {
				$sel_exp = Ajoute($sel_exp, LDOT . $item->left, ', ');
			}
		}
		$req = "SELECT $sel_exp<br/>"
			."FROM $tables->left AS " . LEFT . "<br/>"
			."LEFT JOIN $tables->right AS " . RIGHT . " ON $join_exp";
		$req = Ajoute($req, $null_exp, "<br/>WHERE ");
		$req = Ajoute($req, $where->left, " AND ");
		$req = Ajoute($req, $order_by, "<br/>ORDER BY ");

		return $req;
	}

	function RequeteDifferents(Pair $tables, $clefs, $colonnes, $supplements, Pair $where, $order_by) {
		$sel_exp = '';
		$join_exp = '';
		$cmp_exp = '';
		foreach($clefs as $item) {
			$sel_exp = Ajoute($sel_exp, LDOT . $item->left, ', ');
			$sel_exp = Ajoute($sel_exp, RDOT . $item->right, ', ');
			$join_exp = Ajoute($join_exp, '(' . LDOT . $item->left . ' =  ' . RDOT . $item->right . ')', ' AND ');
		}

		foreach($colonnes as $item) {
			if ($item->left) {
				$sel_exp = Ajoute($sel_exp, LDOT . $item->left, ', ');
				if ($item->right) {
					$cmp_exp = Ajoute($cmp_exp, '(' . LDOT . $item->left . ' <> ' . RDOT . $item->right . ')', ' OR ');
				}
			}
			if ($item->right) {
				$sel_exp = Ajoute($sel_exp, RDOT . $item->right, ', ');
			}
		}
		foreach($supplements as $item) {
			if ($item->left) {
				$sel_exp = Ajoute($sel_exp, LDOT . $item->left, ', ');
			}
			if ($item->right) {
				$sel_exp = Ajoute($sel_exp, RDOT . $item->right, ', ');
			}
		}
		$req = "SELECT $sel_exp<br/>FROM $tables->left AS " . LEFT . "<br/>"
			. "INNER JOIN $tables->right AS " . RIGHT . " ON $join_exp";
		$req = Ajoute($req, ($cmp_exp === '' ? '1' :  '(' . $cmp_exp . ')'), "<br/>WHERE ");
		$req = Ajoute($req, $where->left, " AND ");
		$req = Ajoute($req, $where->right, " AND ");
		$req = Ajoute($req, $order_by, "<br/>ORDER BY ");

		return $req;
	}

	function RequeteIdentiques(Pair $tables, $clefs, $colonnes, $supplements, $where, $order_by) {
		$sel_exp = '';
		$join_exp = '';
		$cmp_exp = '';
		foreach($clefs as $item) {
			$sel_exp = Ajoute($sel_exp, LDOT . $item->left, ', ');
			$sel_exp = Ajoute($sel_exp, RDOT . $item->right, ', ');
			$join_exp = Ajoute($join_exp, '(' . LDOT . $item->left . ' =  ' . RDOT . $item->right . ')', ' AND ');
		}

		foreach($colonnes as $item) {
			if ($item->left) {
				$sel_exp = Ajoute($sel_exp, LDOT . $item->left, ', ');
				if ($item->right) {
					$cmp_exp = Ajoute($cmp_exp, '(' . LDOT . $item->left . ' = ' . RDOT . $item->right . ')', ' AND ');
				}
			}
			if ($item->right) {
				$sel_exp = Ajoute($sel_exp, RDOT . $item->right, ', ');
			}
		}
		foreach($supplements as $item) {
			if ($item->left) {
				$sel_exp = Ajoute($sel_exp, LDOT . $item->left, ', ');
			}
			if ($item->right) {
				$sel_exp = Ajoute($sel_exp, RDOT . $item->right, ', ');
			}
		}
		$req = "SELECT $sel_exp<br/>FROM $tables->left AS " . LEFT . "<br/>"
			. "INNER JOIN $tables->right AS " . RIGHT . " ON $join_exp";
		$req = Ajoute($req, ($cmp_exp === '' ? '1' :  '(' . $cmp_exp . ')'), "<br/>WHERE ");
		$req = Ajoute($req, $where->left, " AND ");
		$req = Ajoute($req, $where->right, " AND ");
		$req = Ajoute($req, $order_by, "<br/>ORDER BY ");

		return $req;
	}

	function to_pair_list($left, $right, $max = false) {
		$arrLeft = explode(',', $left);
		$arrRight = explode(',', $right);

		$list = array();

		if ($max) {
			$iCount = max(count($arrLeft), count($arrRight));
		} else {
			$iCount = min(count($arrLeft), count($arrRight));
		}
		for ($idx = 0; $idx < $iCount; ++$idx) {
			if (isset($arrLeft[$idx])) {
				$lItem = trim($arrLeft[$idx]);
			} else {
				$lItem = '';
			}
			if (isset($arrRight[$idx])) {
				$rItem = trim($arrRight[$idx]);
			} else {
				$rItem = '';
			}
			$list[] = new Pair($lItem, $rItem);
		}
		return $list;
	}

	function getRequest($nom, $defaut= null) {
		if (isset($_REQUEST[$nom])) {
			return $_REQUEST[$nom];
		}
		return $defaut;
	}

	$reponse = "";
	$droite_identique = getRequest('identique');
	$table_source = getRequest('table_source');
	$table_cible = getRequest('table_cible');
	$clef_source = getRequest('clef_source');
	$clef_cible = getRequest('clef_cible');
	$comp_source = getRequest('comp_source');
	$comp_cible = getRequest('comp_cible');
	$sup_source = getRequest('sup_source');
	$sup_cible = getRequest('sup_cible');
	$where_source = getRequest('where_source');
	$where_cible = getRequest('where_cible');
	//$where = '';
	$order = '';

	if (isset($_REQUEST["gen"])) {
		if ($droite_identique) {
			$tables = new Pair($table_source, $table_cible);
			$clefs = to_pair_list($clef_source, $clef_source);
			$colonnes = to_pair_list($comp_source, $comp_source);
			$supplements = to_pair_list($sup_source, $sup_cible, true);
			$where = new Pair($where_source, $where_cible);
		}
		else {
			$tables = new Pair($table_source, $table_cible);
			$clefs = to_pair_list($clef_source, $clef_cible);
			$colonnes = to_pair_list($comp_source, $comp_cible);
			$supplements = to_pair_list($sup_source, $sup_cible, true);
			$where = new Pair($where_source, $where_cible);
		}
		CheckParentheses($where->left);
		CheckParentheses($where->right);
		//echo "? " . $where->right[0] . "," .  $where->right[strlen($where->right)-1];

		$reponse = '<h1>Elements de droite</h1>';
		$reponse .= '<p>' . RequeteDroiteSeulement($tables, $clefs, $colonnes, $supplements, $where, $order) . '</p>';
		$reponse .= '<h1>Elements de gauche</h1>';
		$reponse .= '<p>' . RequeteGaucheSeulement($tables, $clefs, $colonnes, $supplements, $where, $order) . '</p>';
		$reponse .= '<h1>Elements différents</h1>';
		$reponse .= '<p>' . RequeteDifferents($tables, $clefs, $colonnes, $supplements, $where, $order) . '</p>';
		$reponse .= '<h1>Elements identiques</h1>';
		$reponse .= '<p>' . RequeteIdentiques($tables, $clefs, $colonnes, $supplements, $where, $order) . '</p>';
		//var_dump($tables);
		//var_dump($clefs);
	}
?>
<html>
<head>
	<title>Construction de requêtes de comparaison</title>
	<style type='text/css'>
		input {

		}
	</style>
</head>
<body>
	<form method='post'>
		<table>
			<tr>
				<td></td>
				<td></td>
				<td><input type='checkbox' name='identique' <?php echo $droite_identique ? 'checked="checked"' : ''; ?>/><label>Droite identique</label></td>
			</tr>
			<tr>
				<td><label>Tables</label></td>
				<td><?php echo ZoneTexte('table_source', $table_source); ?></td>
				<td><?php echo ZoneTexte('table_cible', $table_cible); ?></td>
			</tr>
			<tr>
				<td><label>Colonnes Clefs</label></td>
				<td><?php echo ZoneTexte('clef_source', $clef_source); ?></td>
				<td><?php echo ZoneTexte('clef_cible', $clef_cible); ?></td>
			</tr>
			<tr>
				<td><label>Colonne à comparer</label></td>
				<td><?php echo ZoneTexte('comp_source', $comp_source); ?></td>
				<td><?php echo ZoneTexte('comp_cible', $comp_cible); ?></td>
			</tr>
			<tr>
				<td><label>Colonnes supplémentaires</label></td>
				<td><?php echo ZoneTexte('sup_source', $sup_source); ?></td>
				<td><?php echo ZoneTexte('sup_cible', $sup_cible); ?></td>
			</tr>
			<tr>
				<td><Label>Où</label></td>
				<td><?php echo ZoneTexte('where_source', $where_source); ?></td>
				<td><?php echo ZoneTexte('where_cible', $where_cible); ?></td>
			<tr>
				<td colspan='3' align='right'>
					<input type='submit' value='Générer' name='gen'/>
				</td>
			</tr>
		</table>
	</form>
	<div>
		<?php echo $reponse; ?>
	</div>
</body>