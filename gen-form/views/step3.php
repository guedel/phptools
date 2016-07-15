<?php

    /*
 * The MIT License
 *
 * Copyright 2016 Guillaume de Lestanville <guillaume.delestanville@proximit.fr>.
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

	if ($etape == ETAPE_REQUETE) {
		// Définition de la requête ou choix d'une table dans la base
?>
	<tr>
		<td><label for="table_select">Choix de la table</label></td>
		<td><select id="table_select" name="table_select">
			<option selected="selected" value="">Choisisssez une table</option>
<?php
		if (isset($cmdTables)) {
			foreach($cmdTables as $rowTable) {
				//$nom = $rowTable[0] ? $rowTable[0] . '.' : '';
				//$nom = $rowTable[1] ? $rowTable[1] . '.' : '';
				$nom = $rowTable[0];

				if ($nom == $table_name ) {
					echo "<option selected='selected'>", $nom, "</option>";
				} else {
					echo "<option>", $nom, "</option>";
				}
			}
		}
?>
		</select></td>
	</tr>
	<tr>
		<td><label for="requete">ou saisissez une requête</label></td>
		<td><textarea cols="80" rows="5" name="requete" id="requete"><?= $request ?></textarea></td>
	</tr>
<?php
    }
    else {
?>
    <tr style="">
        <td>
            <input name="table_select" type="hidden" value="<?= $table_name ?>"/>
            <input name="requete" type="hidden" value="<?= $request ?>"/>
        </td>
    </tr>
<?php
    }