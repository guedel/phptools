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
         * @var mixed identifiant
         */
        public $id = null;

        /**
         *
         * @var \Option
         */
        protected $options = [];

        /**
         * @var \Widget liste des éléments enfants
         */
        protected $childs = [];

        public function __construct()
        {
            $this->initOptionsList();
        }

        public function __get($name)
        {
            foreach($this->options as $attr) {
                if ($attr->name == $name) {
                    return $attr->value;
                }
            }
        }

        public function __set($name, $value)
        {
            foreach($this->options as $attr) {
                if ($attr->name == $name) {
                    $attr->value = $value;
                }
            }
        }

        /**
         * Ajoute une option à la collection
         * @param Option $attr
         */
        protected function addOption(Option $attr)
        {
            $this->options[$attr->name] = $attr;
        }

        /**
         * Retourne la liste des options
         * @return type
         */
        public function getOptions()
        {
            return $this->options;
        }

        /**
         * Initialise la liste des options
         * @return \Option
         */
        protected function initOptionsList()
        {
            //$this->addOption(new Option('id', 'Identifiant', 'string', null, false, 30));
        }

        /**
         *
         * @param mixed $index
         * @return string
         */
        public function getOptionsForm($index)
        {
            $ret = '<table style="border: solid black thin">';
            foreach ($this->options as $attr) {
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
        public function storeOptions($index)
        {
            foreach ($this->options as $attr) {
                $attr->storeHtmlValue('ctl', $index);
            }
        }

        /**
         * Procédure de récupération des attributs du controle
         * @param type $index
         */
        public function retrieveOptions($index)
        {
            foreach ($this->options as $attr) {
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
        public function writeHtmlTag(CodeWriter $render)
        {
            if (count($this->childs) > 0) {
                $render->writeln('<div id="' . $this->id .'">');
                $render->indent();
                $this->writeChildsTag($render);
                $render->unindent();
                $render->writeln('</div>');
            } else {
                $render->write('<span id="' . $this->id . '"/>');
            }
        }

        private function writeChildsTag(CodeWriter $render)
        {
            foreach ($this->childs as $child) {
                $child->writeHtmlTag($render);
            }
        }

        public function accept(IWidgetVisitor $visitor)
        {
            $visitor->visitWidget($this);
        }

        /**
         * @param Widget $child
         */
        public function appendChild(Widget $child)
        {
            $this->childs[] = $child;
        }

        /**
         * Retourne la liste des éléments enfants s'ils existent
         * @return array|Widget
         */
        public function getChilds()
        {
            return $this->childs;
        }

        protected static function openTag($tag, array $attributes = null)
        {
            $ret = '<' . $tag;
            if ($attributes !== null) {
                foreach ($attributes as $key => $value) {
                    $ret .= sprintf(' %s="%s"', $key, htmlentities($value));
                }
            }
            return $ret;
        }
    }
