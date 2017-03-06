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

/*
 * Etape initiale : connexion à la base
 */

	if ($etape == ETAPE_AUTHENTIFICATION) {
        $drivers = array(
            "" => "veuillez choisir",
            "mysql" => "MySql",
            "sqlite" => "Sqlite",
        )
?>
    <tr>
      <td><label for="">Système</label></td>
      <td><select id="system" name="driver">
<?php
        foreach($drivers as $name => $label) {
            if ($name == $driver) {
                echo "<option selected='selected' value='$name'>$label</option>\n";
            } else {
                echo "<option value='$name'>$label</option>\n";
            }
        }
?>
        </select>
      </td>
    </tr>
    <tr>
        <td><label for="">Nom de l'hôte</label></td>
        <td><input type="text" id="hote" name="hote" size="64" value="<?=$hostname ?>" /></td>
    </tr>
    <tr>
        <td><label for="">Numéro de port</label></td>
        <td><input type="text" id="port" name="port" size="20" value="<?=$port ?>" /></td>
    </tr>
    <tr>
        <td><label for="">Nom d'utilisateur</label></td>
        <td><input type="text" id="user_name" name="user_name" value="<?= $username ?>" size="64" /></td>
    </tr>
    <tr>
        <td><label for="">Mot de passe</label></td>
        <td><input type="password" id="password" name="password" value="<?= $password ?>" size="64" /></td>
    </tr>
<?php
	} else {
?>
        <tr style="">
            <td>
                <input type="hidden" id="driver" name="driver" value="<?=$driver ?>" />
                <input type="hidden" id="hote" name="hote" value="<?=$hostname ?>" />
                <input type="hidden" id="port" name="port" value="<?=$port ?>" />
                <input type="hidden" id="user_name" name="user_name" value="<?= $username ?>" />
                <input type="hidden" id="password" name="password" value="<?= $password ?>" />
            </td>
        </tr>
<?php
    }
