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
     * Description of GenHTML
     *
     * @author Guillaume de Lestanville <guillaume.delestanville@proximit.fr>
     */
    class GenHTML extends \BaseGenerator
    {
        public function __construct(\CodeWriter $writer = null)
        {
            parent::__construct($writer);
        }

        protected function comment($text)
        {
            $this->writer->writeln('<!--' . $text . '-->' );
        }

        public function prolog()
        {
            $this->writer->writeln('<!DOCTYPE html>');
            $this->writer->writeln('<html>');
            $this->writer->writeln('<body>');
            $this->writer->indent();
            $this->writer->writeln('<form>');
            $this->writer->indent();
        }

        public function epilog()
        {
            $this->writer->unindent();
            $this->writer->writeln('</form>');
            $this->writer->unindent();
            $this->writer->writeln('</body>');
            $this->writer->writeln('</html>');
        }


        protected function registerGenerators()
        {
            parent::registerGenerators();
        }

        public function genControlButton(\BaseGenerator $gen, \ControlButton $c)
        {
            $gen->render->writeln('<input type="button" value="" name="'. $c->name . '" id="'. $c->id . '" />');
        }

        public function genControlCheckbox(\BaseGenerator $gen, \ControlCheckbox $c)
        {
            $checked = ($c->checked) ? " checked='checked'" : "";
            $gen->render->write('<input type="checkbox" id="' . $c->id . '" name="' . $c->name .'" value="'. $c->value . '" ' . $checked . '/>');
        }

        public function genControlDate(\BaseGenerator $gen, \ControlDate $c)
        {
            $gen->render->writeln('<input type="date" value="" name="'. $c->name . '" id="'. $c->id . '" />');
        }

        public function genControlDropdown(\BaseGenerator $gen, \ControlDropdown $c)
        {
            $gen->render->writeln('<select name="' . $c->name . '" id="' . $c->id . '">');
            $gen->render->indent();
            if ($c->source_type == 'list') {
                $source_value = $c->source_value;
                if (is_string($source_value)) {
                    $source_value = explode(',', $source_value);
                }
                if ($c->empty_option) {
                    $gen->render->writeln('<option></option>');
                }
                if (is_array($source_value)) {
                    foreach($source_value as $option) {
                        $gen->render->writeln('<option>' . $option . '</option>');
                    }
                }
            } elseif ($c->source_type == 'query') {
                global $cnx;
                $req = $cnx->query($c->source_value);
                if (! $c->source_label) {
                    $idx_label = 1;
                } else {
                    $idx_label = $c->source_label;
                }
                if (! $c->source_key) {
                    $idx_key = 0;
                } else {
                    $idx_key = $c->source_key;
                }
                if ($req->columnCount() == 1) {
                    $idx_label = $idx_key;
                }
                if ($c->empty_option) {
                    $gen->render->writeln('<option></option>');
                }
                foreach($req as $row) {
                    //var_dump($row);
                    $gen->render->writeln(sprintf('<option value="%s">%s</option>', $row[$idx_key], $row[$idx_label]));
                }
            }
            $gen->render->unindent();
            $gen->render->writeln('</select>');
        }

        public function genControlHidden(\BaseGenerator $gen, \ControlHidden $c)
        {
            $gen->render->writeln('<input type="hidden" value="" name="'. $c->name . '" id="'. $c->id . '" />');

        }

        public function genControlListbox(\BaseGenerator $gen, \ControlListbox $c)
        {
            // TODO
            $gen->comment('ControlListbox Pas encore réalisé');
        }

        public function genControlRadio(\BaseGenerator $gen, \ControlRadio $c)
        {
            $keys = $c->keys;
            $src_values = explode(',', $c->values);
            //var_dump($keys);
            if ($keys) {
                $values = array();
                for($index = 0; $index < count($src_values); $index += 2) {
                    $values[trim($src_values[$index])] = trim($src_values[$index + 1]);
                }
            } else {
                $values = array();
                foreach($src_values as $key => $value) {
                    $values[trim($key)] = trim($value);
                }
            }
            //var_dump($values);
            $gen->render->writeln('<ul style="list-style-type: none">');
            $gen->render->indent();
            foreach($values as $key => $value) {
                $checked = ($key == $c->default) ? ' checked="checked"' : '';
                $tag = sprintf('<input type="radio" id="%s_%s" name="%s" value="%s" %s>%s</input>', $name, $key, $name, $key, $checked, $value);
                $gen->render->writeln('<li>');
                $gen->render->indent();
                $gen->render->writeln($tag);
                $gen->render->unindent();
                $gen->render->writeln('</li>');
            }
            $gen->render->unindent();
            $gen->render->writeln('</ul>');
        }

        public function genControlSpin(\BaseGenerator $gen, \ControlSpin $c)
        {
            // TODO Ajouter les valeurs mini et maxi
            $gen->render->write('<input id="' . $c->id . '" name="' . $c->name .'" type="number" value="1" />');
        }

        public function genControlTextarea(\BaseGenerator $gen, \ControlTextarea $c)
        {
            // TODO Ajouter la hauteur et la largeur de la zone
            $gen->render->nl();
            $gen->render->indent();
            $gen->render->write(sprintf('<textarea id="%s" name="%s">', $c->id, $c->name));
            $gen->render->write($c->default);
            $gen->render->writeln('</textarea>');
            $gen->render->unindent();
        }

        public function genControlTextbox(\BaseGenerator $gen, \ControlTextbox $c)
        {
            $tag = sprintf('<input type="text" value="" name="%s" id="%s" />', $c->name, $c->id);
            $gen->render->writeln($tag);
        }

    }
