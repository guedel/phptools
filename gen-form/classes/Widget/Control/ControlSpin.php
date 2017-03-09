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
     * Description of ControlSpin
     *
     * @author Guillaume de Lestanville <guillaume.delestanville@proximit.fr>
     *
     * @property int $min_value
     * @property int $max_value
     */
    class ControlSpin extends \Widget\Control\ControlTextbox
    {
        protected function initOptionsList()
        {
            parent::initOptionsList();
            $this->addOption(new \Option('min_value', 'valeur mini', 'int', null, false));
            $this->addOption(new \Option('max_value', 'valeur maxi', 'int', null, false));
        }

        public function writeHtmlTag(\CodeWriter $render)
        {
            $extra = '';
            $valeur = 1;
            if ($this->min_value !== null) {
                $extra .= sprintf('min="%s"', $this->min_value);
                $valeur = $this->min_value;
            }
            if ($this->max_value !== null) {
                $extra .= sprintf('max="%s"', $this->max_value);
            }
            $render->write(sprintf('<input id="%s" name="%s" type="number" value="%s" %s/>', $this->id, $this->name, $valeur, $extra));
        }
    }
