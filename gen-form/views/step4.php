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

if ($etape == ETAPE_SELECTION_COL) {
?>
    <tr>
        <th>Nom de la base de données</th>
        <td><?= $databasename ?></td>
    </tr>
    <tr>
<?php
    if ($request) {
?>
        <th>Rappel de la requête</th>
        <td><?= $request ?></td>
<?php
    }
    elseif ($table_name) {
?>
        <th>Nom de la table</th>
        <td><?= $table_name ?></td>
<?php
    }
?>
    </tr>
	<tr>
		<th>Choisissez les champs</th>
		<td>
            <table style="border: solid black thin">
                <tr>
                    <th colspan="2">Nom du champ</th>
                    <th>Type</th>
                    <th>Taille</th>
                    <th>Précision</th>
                    <th>Libellé</th>
                    <th>Contrôle</th>
                </tr>
            <?php
                //var_dump($field_def);
                foreach ($field_def as $field)
                {
                    $id = $field->id;
                    if ($field->selected) {
                        $checked = 'checked="checked"';
                    } else {
                        $checked = '';
                    }
?>
                <tr>
                    <td><input type="checkbox" name="fld[<?= $id ?>]"  id= "fld_<?=  $id ?>" value="<?= $id ?>" <?= $checked ?>/></td>
                    <td><label for="fld_<?=  $id ?>"><?= $field->name ?></label></td>
                    <td><?= $field->type ?></td>
                    <td><?= $field->len ?></td>
                    <td><?= $field->prec ?></td>
                    <td><input name="lbl[<?= $id ?>]" type="text" value="<?= $field->label ?>" /></td>
                    <td><select name="ctl[<?= $id ?>]" >
<?php
                    foreach($controles as $ctl) {
                            echo '<option';;
                        if ($ctl == $field->control->type) {
                            echo ' selected';
                        }
                        echo '>', $ctl, '</option>', "\n";
                    }
?>
                    </select></td>
                </tr>
<?php
                }
?>
            </table>
        <td>
	</tr>
<?php
} else {
?>
    <tr>
        <td>
<?php
    foreach ($field_def as $field) {
        $id = $field->id;
        if ($field->selected) {
?>
            <input type="hidden" name="fld[<?= $id ?>]" value="<?= $id ?>"/>
<?php
        }
?>
            <input type="hidden" name="lbl[<?= $id ?>]" value="<?= $field->label ?>" />
            <input type="hidden" name="ctl[<?= $id ?>]" value="<?= $field->control->type ?>" />
<?php
    }
?>
        </td>
    </tr>
<?php
}
