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
    namespace Generator;

    class GenVolt extends \BaseGenerator
    {
        public function __construct(\CodeWriter $writer = null)
        {
            parent::__construct($writer);
        }

        protected function comment($text)
        {

        }

        public function epilog()
        {

        }

        public function genControlButton(\CodeWriter $writer, \ControlButton $c)
        {

        }

        public function genControlCheckbox(\CodeWriter $writer, \ControlCheckbox $c)
        {

        }

        public function genControlDate(\CodeWriter $writer, \ControlDate $c)
        {

        }

        public function genControlDropdown(\CodeWriter $writer, \ControlDropdown $c)
        {

        }

        public function genControlHidden(\CodeWriter $writer, \ControlHidden $c)
        {

        }

        public function genControlListbox(\CodeWriter $writer, \ControlListbox $c)
        {

        }

        public function genControlRadio(\CodeWriter $writer, \ControlRadio $c)
        {

        }

        public function genControlSpin(\CodeWriter $writer, \ControlSpin $c)
        {

        }

        public function genControlTextarea(\CodeWriter $writer, \ControlTextarea $c)
        {

        }

        public function genControlTextbox(\CodeWriter $writer, \ControlTextbox $c)
        {
            $gen->writer->write('{{' . '}}');
        }

        public function prolog()
        {

        }

    }
