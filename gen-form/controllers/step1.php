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

    $hostname = "localhost";
    $port = "";
    $username= "";
    $password = "";

    if (isset($_REQUEST["hote"])) {
        $hostname = $_REQUEST["hote"];
    }
    if (isset($_REQUEST["port"])) {
        $port = $_REQUEST["port"];
    }
    if (isset($_REQUEST["user_name"])) {
        $username = $_REQUEST["user_name"];
    }
    if (isset($_REQUEST["password"])) {
        $password = $_REQUEST["password"];
    }

    if ($etape >= ETAPE_AUTHENTIFICATION) {
        // Validation du formulaire
    }
