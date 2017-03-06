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

if ($etape == ETAPE_ATTRIBUTS) {
?>
<tr>
    <th>Ajustement des attributs</th>
    <td>
        <table style="border: solid black thin">
            <tr>
                <th>Nom du champ</th>
                <th>Type de Contrôle</th>
                <th>Attributs</th>
            </tr>

<?php
    //$field = new Field();
    foreach($field_def as $field) {
        if (! $field->selected) {
            $field->control->storeAttributes($field->id);
            continue;
        }
?>
            <tr>
                <td><?= $field->name ?></td>
                <td><?= $controles[get_class($field->control)] ?></td>
                <td>
<?php
        echo $field->control->getAttributesForm($field->id);
?>
                </td>
            </tr>
<?php
    }
?>
        </table></td>
</tr>
<tr>
    <th><label for="">Méthode de rendu</label></th>
    <td>
        Formulaire simple
            <input name="rendering" type="radio" value="simple" id="rendering" <?= $rendering=='simple' ? 'checked' : '' ?> />
        Tableau
            <input name="rendering" type="radio" value="table" id="rendering" <?= $rendering=='table' ? 'checked' : '' ?> />
</tr>
<?php
} else {
?>
    <tr><td>
<?php
    foreach ($field_def as $field) {
        $id = $field->id;
        $field->control->storeAttributes($id);
    }
?>
        <input type="hidden" name="rendering" value="<?= $rendering ?>" />
    </td></tr>
<?php
}