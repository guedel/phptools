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
ini_set('display_errors', true);

define('ETAPE_AUTHENTIFICATION', 1);
define('ETAPE_DATABASE', 2);
define('ETAPE_REQUETE', 3);
define('ETAPE_SELECTION_COL', 4);
define('ETAPE_ATTRIBUTS', 5);
define('ETAPE_RENDU', 6);
define('ETAPE_GENERATION', 7);

$step_names = [
	ETAPE_AUTHENTIFICATION => 'Authentification',
    ETAPE_DATABASE => 'Sélection de la base de données',
	ETAPE_REQUETE => 'Sélection de table ou définition de requête',
	ETAPE_SELECTION_COL => 'Choix des colonnes',
    ETAPE_ATTRIBUTS => 'Définition des attributs des contrôles',
	ETAPE_RENDU => 'Rendu du formulaire',
	ETAPE_GENERATION => 'Génération du code'
];

$etape = ETAPE_AUTHENTIFICATION;

spl_autoload_register(function ($class_name) {
    $filename = __DIR__ . '/classes/' . $class_name . '.php';
    if (file_exists($filename)) {
        include_once $filename;
    }
});
