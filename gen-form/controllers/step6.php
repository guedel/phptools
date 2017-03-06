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

    $mode_gen = 'HTML';

/**
 *
 * @global CodeWriter $render
 * @param Field $field
 * @param string $nomchamp
 */
function saisie_html($field, $nomchamp) {
    global $render;
    switch ($field->control['type']) {
        case 'spin' :
            $render->write('<input id="' . $nomchamp . '" name="' . $nomchamp .'" type="number" value="1" />');
            break;
        case 'dropdown':
            $render->nl();
            $render->indent();
            $render->writeln('<select id="' . $nomchamp . '" name="' . $nomchamp .'">');
            $render->indent();
            $render->writeln('<option>Option 1</option>');
            $render->writeln('<option>Option 2</option>');
            $render->unindent();
            $render->writeln('</select>');
            $render->unindent();
            break;
        case 'textarea':
            $render->nl();
            $render->indent();
            $render->write('<textarea>');
            $render->writeln('</textarea>');
            $render->unindent();
            break;
        case 'date':
            $render->write('<input type="date" id="' . $nomchamp . '" name="' . $nomchamp .'" value="" />');
            break;
        case 'checkbox':
            $render->write('<input type="checkbox" id="' . $nomchamp . '" name="' . $nomchamp .'" value="" />');
            break;
        default:
            $render->write('<input id="' . $nomchamp . '" name="' . $nomchamp .'" type="text" />');
            break;
    }
}

/**
 * Crée des valeurs bidon en fonction du type de la donnée
 * @param array $field
 */
function valeur_html(Field $field)
{
    $len = $field->len;

    switch ($field->type) {
        case 'LONG':
        case 'TINY':
        case 'INT':
            if ($len == 1) {
                // booléen
                return 'x';
            } else {
                return str_repeat('9', $len);
            }
            break;
        case 'FLOAT':
            return str_repeat('9', $len) . '.' . str_repeat('9', $field->prec);
        case 'BLOB':
            return 'xxxx....';
        case 'VAR_STRING':
        default:
            return str_repeat('x', $len);
    }
}

if ($etape >= ETAPE_RENDU) {
    if (isset($_REQUEST['mode_gen'])) {
        $mode_gen = $_REQUEST['mode_gen'];
    }
    $liste_mode_gen = [
        'PHP',
        'HTML',
        'twig',
        'Symfony 1',
    ];

    // Préparation du rendu
    $rendu_html = "";
    $render = new CodeWriter();

    if ($rendering == 'simple') {
        $render->writeln("<table>");
        $render->indent();
        //$field = new Field($id, $name, $type, $len, $prec);
        foreach ($field_def as $field) {
            if (! $field->selected) continue;
            $nom = $field->name;
            $nomchamp = 'fld_' . $nom;
            $render->writeln('<tr>');
            $render->indent();
            $render->write('<td><label for="' . $nomchamp . '">');
            $render->write($field->label);
            $render->writeln('</label></td>');
            $render->write('<td>');
            //$field->control->writeHtmlTag($render, $nomchamp, $field->id);
            $field->control->writeHtmlTag($render, $nomchamp, $nomchamp);
            $render->writeln('</td>');
            $render->unindent();
            $render->writeln('</tr>');
        }
        $render->unindent();
        $render->writeln("</table>");
    }
    if ($rendering == 'table') {
        $render->writeln("<table>");
        $render->indent();
        // Ligne de titre
        $render->writeln('<tr>');
        $render->indent();
        foreach($field_def as $field) {
            if (! $field->selected) continue;
            $render->write('<th>');
            $render->write($field->label);
            $render->writeln('</th>');
        }
        $render->writeln('<th>&nbsp;</th>');
        $render->unindent();
        $render->writeln('</tr>');

        // Ligne de saisie
        $render->writeln('<tr>');
        $render->indent();
        foreach($field_def as $field) {
            if (! $field->selected) continue;
            $render->write('<td>');
            $nomchamp = 'fld_' . $field->name;
            $field->control->writeHtmlTag($render, $nomchamp, $field->id);
            $render->writeln('</td>');
        }
        $render->writeln('<th><input type="button" value="save" /></th>');

        $render->unindent();
        $render->writeln('</tr>');

        // Ligne de valeur
        for ($i = 0; $i < 3; ++$i) {
            $render->writeln('<tr>');
            $render->indent();
            foreach($field_def as $field) {
                if (! $field->selected) continue;
                $render->write('<td>');
                $render->write(valeur_html($field));
                $render->writeln('</td>');
            }
            $render->write('<td>');
            $render->write('<input type="button" value="Edit" />&nbsp;');
            $render->write('<input type="button" value="Delete" />');
            $render->writeln('</td>');
            $render->unindent();
            $render->writeln('</tr>');
        }
        $render->unindent();
        $render->writeln('</table>');
    }
}