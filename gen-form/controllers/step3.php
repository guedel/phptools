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

// Etape 2 : choix de la table ou sélection d'une requête
    $table_name= "";
    $request = "";

	if (isset($_REQUEST["table_select"])) {
		$table_name = $_REQUEST["table_select"];
	}
	if (isset($_REQUEST["requete"])) {
		$request = $_REQUEST["requete"];
	}
    if ($etape >= ETAPE_REQUETE) {
        if ($driver == 'sqlite') {
            try {
                $cnx = new PDO("sqlite:$hostname/$databasename");
                $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // Lecture de la liste des tables
                $cmdTables = $cnx->query("SELECT name AS TABLE_NAME FROM sqlite_master WHERE type='table'");
            } catch (Exception $ex) {
                $message = "Erreur de connection: " . $e->getMessage();
                $cnx = null;
            }
        } else {
            if ($cnx !== null) {
                $cnx->exec('USE ' . $databasename);
                $cmdTables = $cnx->query("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA='$databasename'");
            }
        }
    }
