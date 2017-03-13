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
     * Description of Component
     *
     * @author Guillaume de Lestanville <guillaume.delestanville@proximit.fr>
     *
     * @property string $id
     */
    abstract class Component implements IPropertyCustomer
    {
        protected $options = array();

        public function __construct()
        {
            $this->initProperties();
        }

        public function __get($name)
        {
            foreach($this->options as $attr) {
                if ($attr->name == $name) {
                    return $attr->value;
                }
            }
        }

        public function __set($name, $value)
        {
            foreach($this->options as $attr) {
                if ($attr->name == $name) {
                    $attr->value = $value;
                }
            }
        }

        public function initProperties()
        {
            $this->addOption(Option::createOption('id', Option::TYPE_STRING));
        }

        /**
         *
         * @param \Component\PropertyBag $bag
         */
        public function readProperties(PropertyBag $bag)
        {
            $this->options['id']->value = $bag->read('id', null);
        }

        /**
         *
         * @param \Component\PropertyBag $bag
         */
        public function writeProperties(PropertyBag $bag)
        {
            $bag->write(('id'), $this->id, null);
        }

        /**
         *
         * @param \Component\Option $option
         */
        protected function addOption(Option $option)
        {
            $this->options[$option->name] = $option;
        }

        /**
         *
         * @return array|Option
         */
        public function getOptions()
        {
            return $this->options;
        }

    }
