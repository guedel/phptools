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

    $databasename = '';

    if ($etape >= ETAPE_DATABASE) {
        if (isset($_REQUEST["database"])) {
            $databasename = $_REQUEST["database"];
        }
        try {
            $cnx = null;
            switch ($driver) {
                case 'mysql':
                    $connection_string = "mysql:host=$hostname";
                    if ($port) {
                        $connection_string .= ";port=$port";
                    }
                    if ($username && $password) {
                        $cnx = new PDO($connection_string, $username, $password);
                    } elseif ($username) {
                        $cnx = new PDO($connection_string, $username);
                    } else {
                        $cnx = new PDO($connection_string);
                    }
                    $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    break;
                case 'sqlite':
                    // C'est le nom de l'hote qui sert de répertoire de base
                    // La connexion sera faite à l'étape suivante
                    $cmdDatabases = array();
                    if (is_dir($hostname)) {
                        //var_dump($hostname);
                        $files = scandir($hostname );
                        //var_dump($files);
                        foreach ($files as $file) {
                            if (preg_match('%\.[db|sqlite]%', $file)) {
                                $cmdDatabases[] = array($file);
                            }
                        }
                        //var_dump($cmdDatabases);
                    }

                    //$connection_string = "sqlite:$databasename";
                    //$cnx = new PDO($connection_string);
                    break;
            }
        } catch(Exception $e) {
            $message = "Erreur de connection: " . $e->getMessage();
            $cnx = null;
        }
        if ($cnx) {
            $cmdDatabases = $cnx->query("SELECT SCHEMA_NAME FROM information_schema.SCHEMATA");
        }
    }
