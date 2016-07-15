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
     * Description of Control
     *
     * @author Guillaume de Lestanville <guillaume.delestanville@proximit.fr>
     */
    class Control
    {
        /**
         * @property int $length
         * @property string $unit
         * @property string $placeholder
         */

        /**
         *
         * @var string
         */
        public $type;


        /**
         *
         * @var \Attribute
         */
        protected $attributes = [];

        public function __construct($type)
        {
            $this->type = $type;
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

        /**
         * Retourne la liste des attributs
         * @return \Attribute
         */
        private function initAttributesList()
        {
            $ret = [];
            $ret[] = new Attribute('length', 'Longueur', 'int', null, false, 30);
            $ret[] = new Attribute('unit', 'Unité', 'enum', ['px','em','%'], false, 'px');

            switch ($this->type) {
                case 'dropdown':
                    $ret[] = new Attribute('source_type', 'type de source', 'enum', ['list','request'], true, 'list');
                    $ret[] = new Attribute('source_value', 'source', 'text', null, true);
                    $ret[] = new Attribute('source_key', 'champ clef', 'text', null, false);
                    $ret[] = new Attribute('source_label', 'champ étiquette', 'text', null, false);
                    break;
                case 'textbox':
                    //$ret[] = new Attribute('width', 'largeur', 'int', null, false);
                    $ret[] = new Attribute('placeholder', 'message de réserve', 'string', null, false);
                    break;
                case 'spin':
                    $ret[] = new Attribute('min_value', 'valeur mini', 'int', null, false);
                    $ret[] = new Attribute('max_value', 'valeur maxi', 'int', null, false);
                    break;
                case 'listbox':
                    $ret[] = new Attribute('height', 'hauteur', 'int', null, true);
                    $ret[] = new Attribute('multiselect', 'multiselect', 'bool', null, false);
                default:
                    break;
            }
            $this->attributes = $ret;
        }

        /**
         * Création du controle HTML en fonction des attributs
         * @param string $name
         * @param mixed $id
         */
        public function writeHtmlTag(CodeWriter $render, $name, $id)
        {
            switch ($this->type) {
                case 'spin':
                    $render->write('<input id="' . $name . '" name="' . $name .'" type="number" value="1" />');
                    break;
                case 'dropdown':
                    $render->writeln('<select name="' . $name . '" id="' . $name . '">');
                    $render->indent();
                    if ($this->source_type == 'list') {
                        $source_value = $this->source_value;
                        if (is_string($source_value)) {
                            $source_value = explode(',', $source_value);
                        }
                        if (is_array($source_value)) {
                            foreach($source_value as $option) {
                                $render->writeln('<option>' . $option . '</option>');
                            }
                        }
                    } elseif ($this->source_type == 'request') {
                        global $cnx;
                        $req = $cnx->query($this->source_value);
                        foreach($req as $row) {
                            $render->writeln('<option>' . $row[$this->source_label] . '</option>');
                        }
                    }
                    $render->unindent();
                    $render->writeln('</select>');
                    break;
                case 'listbox':
                    break;
                case 'date':
                    $render->write('<input type="date" id="' . $name . '" name="' . $name .'" value="" />');
                    break;
                case 'textarea':
                    $render->nl();
                    $render->indent();
                    $render->write('<textarea>');
                    $render->writeln('</textarea>');
                    $render->unindent();
                    break;
                case 'checkbox':
                    $render->write('<input type="checkbox" id="' . $name . '" name="' . $name .'" value="" />');
                    break;
                default:
                    $render->writeln('<input type="text" value="" name="'. $name . '" id="" />');
                    break;
            }
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
            $attrType = new Attribute('type', 'Type', 'string', null, true, $this->type );
            $attrType->storeHtmlValue('ctl', $index);
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
            $attrType = new Attribute('type', 'Type', 'string', null, true, $this->type );
            $attrType->retrieveHtmlValue('ctl', $index);
            foreach ($this->attributes as $attr) {
                $attr->retrieveHtmlValue('ctl', $index);
            }
        }
    }
