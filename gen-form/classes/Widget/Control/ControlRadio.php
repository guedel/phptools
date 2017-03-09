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
    namespace Widget\Control;

    /**
     * Description of ControlRadio
     *
     * @author Guillaume de Lestanville <guillaume.delestanville@proximit.fr>
     *
     * @property string $values Texte qui contient les différentes valeurs
     * @property bool $keys Indique des clefs présentes dans la liste
     * @property mixed $default Valeur par défaut à utiliser
     */
    class ControlRadio extends \Widget\Control
    {
        protected function initOptionsList()
        {
            parent::initOptionsList();
            $this->addOption(new \Option('values', 'Valeurs', 'text', null, true));
            $this->addOption(new \Option('keys', 'Clefs présentes', 'bool', null, false, false));
            $this->addOption(new \Option('default', 'Valeur par défaut', null, false));
        }

        public function writeHtmlTag(\CodeWriter $render)
        {
            $keys = $this->keys;
            $src_values = explode(',', $this->values);
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
            $render->writeln('<ul style="list-style-type: none">');
            $render->indent();
            foreach($values as $key => $value) {
                $checked = ($key == $this->default) ? ' checked="checked"' : '';
                $tag = sprintf('<input type="radio" id="%s_%s" name="%s" value="%s" %s>%s</input>', $this->id, $key, $this->name, $key, $checked, $value);
                $render->writeln('<li>');
                $render->indent();
                $render->writeln($tag);
                $render->unindent();
                $render->writeln('</li>');
            }
            $render->unindent();
            $render->writeln('</ul>');
        }
    }
