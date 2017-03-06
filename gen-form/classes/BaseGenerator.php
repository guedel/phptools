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

    /**
     * Classe de base des générateurs
     *
     * @author Guillaume de Lestanville <guillaume.delestanville@proximit.fr>
     */
    abstract class BaseGenerator implements IAttributeVisitor, IWidgetVisitor, IFieldVisitor
    {
        /**
         *
         * @var CodeWriter
         */
        protected $writer = null;

        /**
         * Contient l'inscription des générateurs de contrôle
         * @var array
         */
        private $register = array();


        /**
         *
         * @param CodeWriter $writer
         */
        public function __construct(CodeWriter $writer = null)
        {
            if ($writer === null) {
                $this->writer = new CodeWriter();
            } else {
                $this->writer = $writer;
            }
            $this->registerGenerators();
            $this->prolog();
        }

        /**
         * Génère la partie avant les contrôles
         */
        public abstract function prolog();

        /**
         * Génère la partie finale
         */
        public abstract function epilog();

        /**
         * @returns CodeWriter
         */
        public function finalize()
        {
            $this->epilog();
            return $this->writer;
        }


        /**
         * Inscription d'un générateur de contrôle
         * @param string $name
         * @param callable $fn
         */
        protected function registerGenerator($name, callable $fn)
        {
            $this->register[$name] = $fn;
        }

        /**
         *
         * @param object $o
         */
        protected function generate(object $o)
        {
            $found = false;
            foreach ($this->register as $name => $fn) {
                if ($name == get_class($o)) {
                    $found = true;
                    $fn($this, $o);
                }
            }
            if (! $found ) {
                $this->comment('no generator found for ' . get_class($o));
            }

        }

        public function visitWidget(\Widget $w)
        {
            $this->generate($w);
        }

        public function visitField(\Field $f)
        {
            //$this->generate($f);
        }

        public function visitAttribute(\Attribute $a)
        {
            $this->generate($a);
        }

        /**
         * Inscription des contrôles de base
         */
        protected function registerGenerators()
        {
            $this->registerGenerator(get_class(ControlButton::self), [get_class($this), 'genControlButton']);
            $this->registerGenerator(get_class(ControlCheckbox::self), [get_class($this), 'genControlCheckbox']);
            $this->registerGenerator(get_class(ControlDate::self), [get_class($this), 'genControlDate']);
            $this->registerGenerator(get_class(ControlDropdown::self), [get_class($this), 'genControlDropdown']);
            $this->registerGenerator(get_class(ControlHidden::self), [get_class($this), 'genControlHidden']);
            $this->registerGenerator(get_class(ControlListbox::self), [get_class($this), 'genControlListbox']);
            $this->registerGenerator(get_class(ControlRadio::self), [get_class($this), 'genControlRadio']);
            $this->registerGenerator(get_class(ControlSpin::self), [get_class($this), 'genControlSpin']);
            $this->registerGenerator(get_class(ControlTextarea::self), [get_class($this), 'genControlTextarea']);
            $this->registerGenerator(get_class(ControlTextbox::self), [get_class($this), 'genControlTextbox']);
        }


        /**
         * Procédure d'écriture de commentaire
         */
        protected abstract function comment($text);

        /*
         * Méthodes à mettre en oeuvre
         */
        public abstract function genControlButton(BaseGenerator $gen, ControlButton $c);
        public abstract function genControlCheckbox(BaseGenerator $gen, ControlCheckbox $c);
        public abstract function genControlDate(BaseGenerator $gen, ControlDate $c);
        public abstract function genControlDropdown(BaseGenerator $gen, ControlDropdown $c);
        public abstract function genControlHidden(BaseGenerator $gen, ControlHidden $c);
        public abstract function genControlListbox(BaseGenerator $gen, ControlListbox $c);
        public abstract function genControlRadio(BaseGenerator $gen, ControlRadio $c);
        public abstract function genControlSpin(BaseGenerator $gen, ControlSpin $c);
        public abstract function genControlTextarea(BaseGenerator $gen, ControlTextarea $c);
        public abstract function genControlTextbox(BaseGenerator $gen, ControlTextbox $c);
    }
