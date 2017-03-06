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

    /**
     * Description of Widget
     *
     * @author Guillaume de Lestanville <guillaume.delestanville@proximit.fr>
     */
    class Widget
    {
        /**
         * @var string
         */
        public $id = null;

        /**
         *
         * @var \Attribute
         */
        protected $attributes = [];

        public function __construct()
        {
            $this->initAttributesList();
        }

        public function __get($name)
        {
            foreach($this->attributes as $attr) {
                if ($attr->name == $name) {
                    return $attr->value;
                }
            }
        }

        public function __set($name, $value)
        {
            foreach($this->attributes as $attr) {
                if ($attr->name == $name) {
                    $attr->value = $value;
                }
            }
        }

        protected function addAttribute(Attribute $attr)
        {
            $this->attributes[$attr->name] = $attr;
        }

        /**
         * Retourne la liste des attributs
         * @return \Attribute
         */
        protected function initAttributesList()
        {
            //$this->addAttribute(new Attribute('id', 'Identifiant', 'string', null, false, 30));
        }

        public function getAttributesForm($index)
        {
            $ret = '<table style="border: solid black thin">';
            foreach ($this->attributes as $attr) {
                $ret .= '<tr><th>' . $attr->label . '</th>';

                $ret .= '<td>' . ($attr->required ? '*' : '') . '</td>';
                $ret .= '<td>' . $attr->getHtmlTag('ctl', $index) . '</td></tr>';
            }
            return $ret . '</table>';
        }

        /**
         * Procédure de stockage des attributs du controle
         * @param type $index
         */
        public function storeAttributes($index)
        {
            foreach ($this->attributes as $attr) {
                $attr->storeHtmlValue('ctl', $index);
            }
        }

        /**
         * Procédure de récupération des attributs du controle
         * @param type $index
         */
        public function retrieveAttributes($index)
        {
            foreach ($this->attributes as $attr) {
                $attr->retrieveHtmlValue('ctl', $index);
            }
        }

        /**
         * Procédure d'écriture du widget
         * A revoir par des classes externe qui gèrent le code en fonction des attributs du widget
         * @param CodeWriter $render
         * @param type $name
         * @param type $id
         */
        public function writeHtmlTag(CodeWriter $render, $name, $id)
        {
            $render->writeln('<!-- wiget vide -->');
        }

        public function accept(IWidgetVisitor $visitor)
        {
            $visitor->visitWidget($this);
        }

    }
