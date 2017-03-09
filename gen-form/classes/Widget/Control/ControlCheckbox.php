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
     * Description of ControlCheckbox
     *
     * @author Guillaume de Lestanville <guillaume.delestanville@proximit.fr>
     */
    class ControlCheckbox extends \Widget\Control
    {
        protected function initOptionsList()
        {
            parent::initOptionsList();
            $this->addOption(new \Option('checked', 'Coché', 'bool', false, false));
            $this->addOption(new \Option('value', 'Valeur', 'text', null, false));
        }

        public function writeHtmlTag(\CodeWriter $render)
        {
            $checked = ($this->checked) ? " checked='checked'" : "";
            $render->write('<input type="checkbox" id="' . $this->id . '" name="' . $this->name .'" value="'. $this->value . '" ' . $checked . '/>');
        }

    }
