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

    // Sélection des champs
    /**
     * @var Field Liste des définitions de champs
     */
    $field_def = array();
    $rendering = 'simple';

    if ($etape >= ETAPE_SELECTION_COL) {
        ini_set('memory_limit', '2048M');
        $cmdFields = null;
		if ($request) {
			$cmdFields = $cnx->query($request);
		} elseif ($table_name) {
            //var_dump($table_name);
			$cmdFields = $cnx->query("SELECT * FROM $databasename.$table_name");
		} else {
			$cmdFields = null;
		}

        if ($cmdFields) {
            $cntFields = $cmdFields->columnCount();
            for ($idxField = 0; $idxField < $cntFields; ++$idxField)
            {
                $info = $cmdFields->getColumnMeta($idxField);

                // création avec les valeurs par défaut
                $field_def[$idxField] = new Field($idxField, $info['name'], $info['native_type'], $info['len'], $info['precision']);

                // attribution des valeurs récupérées
                if (isset($_REQUEST['fld'][$idxField])) {
                    $field_def[$idxField]->selected = true;
                }
                if (isset($_REQUEST['lbl'][$idxField])) {
                    $field_def[$idxField]->label = $_REQUEST['lbl'][$idxField];
                }
                if (isset($_REQUEST['ctl'][$idxField])) {
                    $field_def[$idxField]->control = new Control($_REQUEST['ctl'][$idxField]);
                }
            }
            $cmdFields->closeCursor();
        }


        // Définition de la liste des contrôles
        $controles = [
            'button',
            'checkbox',
            'date',
            'dropdown',
            'hidden',
            'listbox',
            'radio',
            'spin',
            'textarea',
            'textbox',
        ];
        $unite = [
            'px', 'em', '%'
        ];

    }
