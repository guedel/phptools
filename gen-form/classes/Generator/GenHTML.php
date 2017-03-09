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
        }

        public function epilog()
        {
            $this->writer->unindent();
            $this->writer->writeln('</body>');
            $this->writer->writeln('</html>');
        }


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

        public function genWidget(\CodeWriter $writer, \Widget $w)
        {
            $w->writeHtmlTag($writer);
        }
    }
