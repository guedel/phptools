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

    namespace Widget;

    /**
     * Description of Control
     *
     * @author Guillaume de Lestanville <guillaume.delestanville@proximit.fr>
     */
    class Control extends \Widget
    {
        /**
         * @property int $length
         * @property string $unit
         */

        /**
         *
         * @var string
         */
        public $name;

        protected function initOptionsList()
        {
            parent::initOptionsList();
            $this->addOption(new \Option('length', 'Longueur', 'int', null, false, 30));
            $this->addOption(new \Option('unit', 'Unité', 'enum', ['px','em','%'], false, 'px'));
        }

        /**
         * Création du controle HTML en fonction des attributs
         * @param string $name
         * @param mixed $id
         */
        public function writeHtmlTag(\CodeWriter $render)
        {
            $render->writeln('<input type="text" value="" name="'. $this->name . '" id="'. $this->id . '" />');
        }

        protected function getTag()
        {
            return 'input';
        }

    }
