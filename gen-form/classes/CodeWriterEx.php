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
    class CodeWriterEx
    {
        // Mode insertion/ajout
        const MODE_INSERT = 'i';
        // Mode réécriture
        const MODE_REPLACE = 'r';

        const EOF = null;
        const BOF = 0;

        /**
         * contient le contenu de la ligne en cours
         * @var string
         */
        private $current = '';

        /**
         * contient le numéro de la ligne en cours d'édition
         * null pour une nouvelle ligne
         */
        private $index = self::EOF;

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
         * niveau d'indentation initial
         * @var int
         */
        private $init_indent = 0;

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
            $this->indent = $this->init_indent = $initialIndent;
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
            $this->current = '';
        }

        /**
         * Sélectionne un numéro de ligne en particulier
         * Attention à valider le contenu du tampon avant de se déplacer.
         * @param int $index
         */
        public function select($index, $mode = self::MODE_REPLACE)
        {
            $this->mode = $mode;
            if ($index !== self::EOF) {
                if (isset($this->lines[$index])) {
                    $this->index = $index;
                } else {
                    $this->index = self::EOF;
                }
            }
            // Mise à jour de l'indentation
            if ($index === self::EOF) {
                if (count($this->lines) > 0) {
                    $this->indent = $this->getIndentLevel(end($this->lines));
                } else {
                    $this->indent = $this->init_indent;
                }
            } elseif ($index === self::BOF) {
                $this->indent = $this->init_indent;
            } else {
                switch ($this->mode) {
                    case self::MODE_INSERT:
                        if ($index > 0 && isset($this->lines[$index-1])) {
                            $this->indent = $this->getIndentLevel($this->lines[$index - 1]);
                        } else {
                            $this->indent = $this->getIndentLevel($this->lines[$index]);
                        }
                        break;
                    case self::MODE_REPLACE:
                        $this->indent = $this->getIndentLevel($this->lines[$index]);
                        break;
                    default:
                        // Mode inconnu : a voir
                        break;
                }
            }
            $this->clean();
        }

        /**
         * Récupère le niveau d'indentation pour la ligne indiquée
         */
        private function getIndentLevel($line = '')
        {
            for ($p = 0; $p < strlen($line); ++$p)
            {
               if ($line[$p] !== $this->spacer) break;
            }
            return $p;
        }

        /**
         * Restitution du code
         * @returns string
         */
        public function render() {
            if (strlen($this->current) > 0) $this->nl();
            return implode("\n", $this->lines);
        }

        /**
          * Fusion avec le contenu d'un autre CodeWriter
          */
        public function merge(CodeWriter $writer)
        {
            if (strlen($this->current) > 0) $this->nl();
            foreach ($writer->lines as $line) {
                $this->lines[] = $line;
            }
            return $this;
        }

        public function fromString($text)
        {
            $lines = explode("\n", $text);
            $this->lines = $lines;
            return $this;
        }
    }
