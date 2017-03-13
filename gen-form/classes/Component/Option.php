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

    namespace Component;

    /**
     * Description of Option
     *
     * @author Guillaume de Lestanville <guillaume.delestanville@proximit.fr>
     */
    final class Option
    {
        /**
         * @var string Nom de l'attribut
         */
        private $name;
        /**
         * @var string Etiquette affichée
         */
        private $label;
        private $type;
        private $extra;
        private $required;
        private $default;
        private $value;

        const TYPE_ENUM = 'enum';       # enumération de valeurs
        const TYPE_INT = 'int';         # valeur numérique entière
        const TYPE_BOOL = 'bool';       # booléen
        const TYPE_FLOAT = 'float';     # valeur décimale
        const TYPE_STRING = 'string';   # texte
        const TYPE_QUERY = 'query';     # requête dans la base qui ramène une liste de valeurs
        const TYPE_OBJECT = 'object';   # un objet

        protected function __construct()
        {
        }

        /**
         * Procédure générale de création d'une option
         * @param type $name
         * @param type $type
         * @param type $required
         * @param type $label
         * @param type $default
         * @return \Component\Option
         */
        public static function createOption($name, $type = self::TYPE_STRING, $required = false, $label = null, $default = null)
        {
            $opt = new Option();
            $opt->name = $name;
            if ($label === null) {
                $opt->label = $name;
            } else {
                $opt->label = $label;
            }
            $opt->type = $type;
            $opt->default = $default;
            $opt->value = $default;
            $opt->required = $required;
            return $opt;
        }

        /**
         * Procédure de création d'une option de type énumérée
         * @param string $name
         * @param mixed $extra
         * @param bool $required
         * @param string $label
         * @param mixed $default
         * @return \Component\Option
         */
        public static function createEnumOption($name, $extra = null, $required = false, $label = null, $default = null)
        {
            $opt = new Option();
            $opt->name = $name;
            if ($label === null) {
                $opt->label = $name;
            } else {
                $opt->label = $label;
            }
            $opt->type = self::TYPE_ENUM;
            $opt->default = $default;
            $opt->value = $default;
            $opt->required = $required;
            if (is_array($extra)) {
                $opt->extra = $extra;
            } else {
                $opt->extra = explode(',', $extra);
            }
            return $opt;
        }

        public function setValue($value)
        {
            switch($this->type) {
                case self::TYPE_BOOL:
                    $this->value = ($value !== 0);
                    break;
                case self::TYPE_ENUM:
                    if (in_array($value, $this->extra))  {
                        $this->value = $value;
                    }
                    break;
                case self::TYPE_FLOAT:
                    if (is_float($value)) {
                        $this->value = $value;
                    }
                    break;
                case self::TYPE_INT:
                    if (is_int($value)) {
                        $this->value = $value;
                    }
                    break;
                default:
                    $this->value = $value;
                    break;
            }
        }

        public function getValue()
        {
            return $this->value;
        }

        public function getName()
        {
            return $this->name;
        }
    }
