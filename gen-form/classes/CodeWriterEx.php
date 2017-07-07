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
      * Représente une ligne dans le code
      */
     class CodeWriterLine
     {
         public $content;
         public $indent;
         
         public function __construct($content = '', $indent = 0)
         {
             $this->content = $content;
             $this->indent = $indent;
         }
     }
     
    /**
     * Permet de stocker et d'écrire du code
     *
     * @author Guillaume de Lestanville <guillaume.delestanville@proximit.fr>
     */
    class CodeWriterEx
    {
        // Mode insertion/ajout
        const MODE_INSERT = 'i';
        // Mode réécriture
        const MODE_REPLACE = 'r';
        
        /**
         * contient le contenu de la ligne en cours
         * @var string
         */
        private $current = '';
        
        /**
         * contient le numéro de la ligne en cours d'édition
         * null pour une nouvelle ligne
         */
        private $index = null;
        
        /**
         * mode d'insertion des lignes
         */
        private $mode = self::MODE_INSERT;

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
         * Valide la ligne en cours d'édition et passe à la suivante
         */
        public function nl()
        {
            if ($this->index !== null) {
                if ($this->mode === self::MODE_REPLACE) {
                    // On écrit par dessus les lignes déjà existantes
                    $this->lines[$this->index++] = $this->current;
                    if (! isset($this->lines[$this->index])) {
                        $this->index = null;
                    }
                } elseif ($this->mode === self::MODE_INSERT) {
                    // On insère ici de nouvelle ligne avant la ligne indiquée.
                    array_splice($this->lines, $this->index++, 1, $this->current);
                }
            } else {
                // Mode ajout
                $this->lines[] = str_repeat($this->spacer, $this->indent) . $this->current;
            }
            // On commence avec un tampon vide
            $this->clean();
        }
        
        /**
         * Vide le contenu temporaire
         */
        public function clean() 
        {
            $this->clean();
        }
        
        /**
         * Sélectionne un numéro de ligne en particulier
         * @param int $index
         */
        public function select($index, $mode = self::MODE_REPLACE)
        {
            $this->mode = $mode;
            if (isset($this->lines[$index]) {
                $this->index = $index;
                $this->clean();
            }
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

        public function merge(CodeWriter $writer)
        {
            if (strlen($this->current) > 0) $this->nl();
            foreach ($writer->lines as $line) {
                $this->lines[] = $line;
            }
        }
    }
