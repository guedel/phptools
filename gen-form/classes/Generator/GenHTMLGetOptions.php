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
     * Génère le code HTML qui permet de saisir les options
     *
     * @author Guillaume de Lestanville <guillaume.delestanville@proximit.fr>
     */
    class GenHTMLGetOptions extends \BaseGenerator
    {
        protected function registerGenerators()
        {
            parent::registerGenerators();
            $this->registerGenerator(\Widget\Control\ControlButton::class, [$this, 'genWidget']);
            $this->registerGenerator(\Widget\Control\ControlCheckbox::class, [$this, 'genWidget']);
            $this->registerGenerator(\Widget\Control\ControlDate::class, [$this, 'genWidget']);
            $this->registerGenerator(\Widget\Control\ControlDropdown::class, [$this, 'genWidget']);
            $this->registerGenerator(\Widget\Control\ControlHidden::class, [$this, 'genWidget']);
            $this->registerGenerator(\Widget\Control\ControlListbox::class, [$this, 'genWidget']);
            $this->registerGenerator(\Widget\Control\ControlRadio::class, [$this, 'genWidget']);
            $this->registerGenerator(\Widget\Control\ControlSpin::class, [$this, 'genWidget']);
            $this->registerGenerator(\Widget\Control\ControlTextarea::class, [$this, 'genWidget']);
            $this->registerGenerator(\Widget\Control\ControlTextbox::class, [$this, 'genWidget']);
        }

        protected function comment($text)
        {
            $this->writer->writeln('<!--' . $text . '-->' );
        }

        public function epilog()
        {

        }

        public function prolog()
        {

        }

//put your code here
    }
