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
     * Détermine les attributs d'un controle.
     *
     * @author Guillaume de Lestanville <guillaume.delestanville@proximit.fr>
     */
    class Option
    {
        /**
         * @var string Nom de l'attribut
         */
        public $name;
        /**
         * @var string Etiquette affichée
         */
        public $label;
        public $type;
        public $extra;
        public $required;
        public $default;
        public $value;

        const TYPE_ENUM = 'enum';       # enumération de valeurs
        const TYPE_INT = 'int';         # valeur numérique entière
        const TYPE_BOOL = 'bool';       # booléen
        const TYPE_FLOAT = 'float';     # valeur décimale
        const TYPE_STRING = 'string';   # texte
        const TYPE_QUERY = 'query';     # requête dans la base qui ramène une liste de valeurs
        const TYPE_OBJECT = 'object';   # un objet

        /**
         *
         * @param string $name
         * @param string $label
         * @param string $type
         * @param string $extra
         * @param bool $required
         * @param mixed $default
         */
        public function __construct($name, $label, $type, $extra = null, $required = false, $default = null)
        {
            $this->name = $name;
            $this->label = $label;
            $this->type = $type;
            $this->extra = $extra;
            $this->required = $required;
            $this->value = $this->default = $default;
        }

        private function getHtmlName($owner, $index = null) {
            if ($index === null) {
                return $owner . '_attr_' . $this->name;
            }
            return $owner . '_attr_' . $this->name . '[' . $index . ']';
        }

        /**
         *
         * @param string $owner nom du propriétaire de l'attribut
         * @param type $index
         */
        public function storeHtmlValue($owner, $index)
        {
            echo '<input type="hidden" name="' . $this->getHtmlName($owner, $index) . '" value="' . $this->value . '" />';
        }

        /**
         *
         * @param string $owner nom du propriétaire
         * @param type $index
         */
        public function retrieveHtmlValue($owner, $index)
        {
            $name = $this->getHtmlName($owner);
            if (isset($_REQUEST[$name][$index])) {
                $this->value = $_REQUEST[$name][$index];
            }
        }

        /**
         * Récupère le tag HTML pour la saisie de l'attribut
         * @param type $owner
         * @param type $index
         * @return string
         */
        public function getHtmlTag($owner, $index = null)
        {
            switch ($this->type) {
                case self::TYPE_ENUM:
                    $ret = '<select name="' . $this->getHtmlName($owner, $index) . '" >"';
                    foreach ($this->extra as $val) {
                        $ret .= '<option';
                        if ($val == $this->value) {
                            $ret .= ' selected="selected"';
                        }
                        $ret .= '>' . $val . '</option>';
                    }
                    return $ret;
                case self::TYPE_INT:
                    return '<input type="number" name="' . $this->getHtmlName($owner, $index) . '" value="' . $this->value . '" />';
                case self::TYPE_BOOL:
                    $ret =  '<input type="checkbox" name="'
                        . $this->getHtmlName($owner, $index)
                        . '" value="' . $index . '"';
                    if ($this->value) {
                        $ret .= ' checked="checked"';
                    }
                    return $ret . '/>';
                case self::TYPE_QUERY:
                    $ret = '<select name="' . $this->getHtmlName($owner, $index) . '" >"';
                    $qry = $this->extra;
                    foreach($qry as $row) {
                        $ret .= '<option';
                        if ($$row[0] == $this->value) {
                            $ret .= ' selected="selected"';
                        }
                        $ret .= '>' . isset($row[1]) ? $row[1] : $row[0] . '</option>';
                    }
                    return $ret;
                default:
                    return '<input type="text" name="' . $this->getHtmlName($owner, $index) . '" value="' . $this->value . '" />';
            }
        }
    }
