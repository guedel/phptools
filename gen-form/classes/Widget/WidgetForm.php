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

    namespace Widget;
    /**
     * Représente un formulaire
     *
     * @author Guillaume de Lestanville <guillaume.delestanville@proximit.fr>
     *
     * @property string $method Méthode d'envoi du formulaire
     * @property string $target Cible du formulaire
     * @property string $action Url de destination
     */
    class WidgetForm extends \Widget
    {
        protected function initOptionsList()
        {
            parent::initOptionsList();
            $this->addOption(new \Option('method', 'Méthode d\'envoi', Option::TYPE_ENUM, array('post', 'get')));
            $this->addOption(new \Option('target', 'Cible du formulaire', Option::TYPE_ENUM, array('_blank', '_self', '_parent', '_top')));
            $this->addOption(new \Option('action', 'Url de destination', Option::TYPE_STRING));
        }
    }
