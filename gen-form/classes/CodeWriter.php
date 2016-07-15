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

    /**
     * Permet de stocker et d'écrire du code
     *
     * @author Guillaume de Lestanville <guillaume.delestanville@proximit.fr>
     */
    class CodeWriter
    {
        /**
         * contient le contenu de la ligne en cours
         * @var string
         */
        private $current = '';

        /**
         * contient la liste des lignes de code
         * @var array|string
         */
        private $lines = [];

        /**
         * niveau d'indentation
         * @var int
         */
        private $indent = 0;

        /**
         * caratère d'espacement
         * @var string
         */
        public $spacer = "\t";

        /**
         *
         * @param string $spacer
         */
        public function __construct($spacer = "\t", $initialIndent = 0)
        {
            $this->spacer = $spacer;
            $this->indent = $initialIndent;
        }

        /**
         * Augmente le niveau d'indentation
         */
        public function indent() {
            $this->indent++;
        }

        /**
         * Réduit le niveau d'indentation
         */
        public function unindent() {
            if ($this->indent > 0) {
                $this->indent--;
            }
        }

        /**
         * Ecriture d'une partie de texte
         * @param string $text
         */
        public function write($text)
        {
            $this->current .= $text;
        }

        /**
         * Ecriture d'une fin de ligne de texte
         * @param string $text
         */
        public function writeln($text)
        {
            $this->write($text);
            $this->nl();
        }

        /**
         * Réalise un saut de ligne
         */
        public function nl()
        {
            $this->lines[] = str_repeat($this->spacer, $this->indent) . $this->current;
            $this->current = '';
        }

        /**
         * Restitution du code
         * @returns string
         */
        public function render() {
            if (strlen($this->current) > 0) $this->nl();
            $ret = '';
            foreach($this->lines as $line) {
                $ret .= $line . "\n";
            }
            return $ret;
        }
    }
