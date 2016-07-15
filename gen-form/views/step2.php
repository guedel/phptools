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
if ($etape == ETAPE_DATABASE) {
?>
<tr>
    <td>Sélection de la base de données</td>
    <td><select name="database" id="database">
<?php
        if (isset($cmdDatabases)) {
            foreach($cmdDatabases as $rowDatabase) {
                echo '<option ';
                if ($rowDatabase[0] == $databasename) {
                    echo ' selected="selected"';
                }
                echo '>', $rowDatabase[0], '</option>';
            }
        }
?>
        </select>
    </td>
</tr>
<?php
} else {
?>
<tr>
    <td><input type="hidden" id="database" name="database" value="<?= $databasename ?>" /></td>
</tr>
<?php
}
