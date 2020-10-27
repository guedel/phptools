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
   * Description of ControlDropdown
   *
   * @author Guillaume de Lestanville <guillaume.delestanville@proximit.fr>
   */
  class ControlDropdown extends \Widget\Control
  {

    protected function initOptionsList()
    {
      parent::initOptionsList();
      $this->addOption(new \Option('source_type', 'type de source', 'enum', ['list', 'query'], true, 'list'));
      $this->addOption(new \Option('source_value', 'source', 'text', null, true));
      $this->addOption(new \Option('source_key', 'champ clef', 'text', null, false));
      $this->addOption(new \Option('source_label', 'champ étiquette', 'text', null, false));
      $this->addOption(new \Option('empty_option', 'élément vide', 'bool', null, false, true));
    }

    /**
     *
     * @global \PDO $cnx
     * @param \CodeWriter $render
     */
    public function writeHtmlTag(\CodeWriter $render)
    {
      $render->writeln('<select name="' . $this->name . '" id="' . $this->id . '">');
      $render->indent();
      if ($this->source_type == 'list') {
        $source_value = $this->source_value;
        if (is_string($source_value)) {
          $source_value = explode(',', $source_value);
        }
        if ($this->empty_option) {
          $render->writeln('<option></option>');
        }
        if (is_array($source_value)) {
          foreach ($source_value as $option) {
            $render->writeln('<option>' . $option . '</option>');
          }
        }
      } elseif ($this->source_type == 'query') {
        global $cnx;
        try {
          $req = $cnx->query($this->source_value);
        } catch (\Exception $e) {
          echo $e->getTraceAsString(), '<br/>';
          var_dump($cnx->errorInfo());
          throw new \Exception('Erreur dans la requête', 1, $e);
        }

        if (!$this->source_label) {
          $idx_label = 1;
        } else {
          $idx_label = $this->source_label;
        }
        if (!$this->source_key) {
          $idx_key = 0;
        } else {
          $idx_key = $this->source_key;
        }
        if ($req->columnCount() == 1) {
          $idx_label = $idx_key;
        }
        if ($this->empty_option) {
          $render->writeln('<option></option>');
        }
        foreach ($req as $row) {
          //var_dump($row);
          $render->writeln(sprintf('<option value="%s">%s</option>', $row[$idx_key], $row[$idx_label]));
        }
      }
      $render->unindent();
      $render->writeln('</select>');
    }

  }
