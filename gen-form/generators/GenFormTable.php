<?php

    /*
     * The MIT License
     *
     * Copyright 2017 Guillaume de Lestanville <guillaume.delestanville@proximit.fr>.
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
    namespace Generator;

    /**
     * Génère le code pour insérer les données pour reconstituer le formulaire
     *
     * @author Guillaume de Lestanville <guillaume.delestanville@proximit.fr>
     */
    class genFormTable extends BaseGenerator
    {
        public function __construct(\CodeWriter $writer = null)
        {
            parent::__construct($writer);
        }


        protected function comment($text)
        {
            $this->writer->writeln('-- ' . $text);
        }

        public function prolog()
        {
            // Création de la table
            $this->writer->writeln('CREATE TABLE _controls(');
            $this->writer->indent();
            $this->writer->writeln('name TEXT,');
            $this->writer->writeln('id TEXT,');
            // Le controle sera sérialisé
            $this->writer->writeln('serialized TEXT');
            $this->writer->writeln(');');
            $this->writer->nl();
        }

        protected function insertControl(\BaseGenerator $gen, \Control $c)
        {
            $gen->writer->writeln('INSERT INTO _controls(name, id, serialized)');
            $gen->writer->writeln(sprintf("VALUES(%s, %s, %s)", $c->name, $c->id, serialize($c)));
            $gen->writer->nl();
        }

        public function epilog()
        {
            // Rien à faire
        }

        public function genControlButton(\BaseGenerator $gen, \ControlButton $c)
        {
            $this->insertControl($gen, $c);
        }

        public function genControlCheckbox(\BaseGenerator $gen, \ControlCheckbox $c)
        {
            $this->insertControl($gen, $c);
        }

        public function genControlDate(\BaseGenerator $gen, \ControlDate $c)
        {
            $this->insertControl($gen, $c);
        }

        public function genControlDropdown(\BaseGenerator $gen, \ControlDropdown $c)
        {
            $this->insertControl($gen, $c);
        }

        public function genControlHidden(\BaseGenerator $gen, \ControlHidden $c)
        {
            $this->insertControl($gen, $c);
        }

        public function genControlListbox(\BaseGenerator $gen, \ControlListbox $c)
        {
            $this->insertControl($gen, $c);
        }

        public function genControlRadio(\BaseGenerator $gen, \ControlRadio $c)
        {
            $this->insertControl($gen, $c);
        }

        public function genControlSpin(\BaseGenerator $gen, \ControlSpin $c)
        {
            $this->insertControl($gen, $c);
        }

        public function genControlTextarea(\BaseGenerator $gen, \ControlTextarea $c)
        {
            $this->insertControl($gen, $c);
        }

        public function genControlTextbox(\BaseGenerator $gen, \ControlTextbox $c)
        {
            $this->insertControl($gen, $c);
        }
    }
