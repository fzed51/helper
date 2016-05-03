<?php

/*
 * The MIT License
 *
 * Copyright 2016 fabien.sanchez.
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

namespace fzed51\Helper;

/**
 * Description of Form
 *
 * @author fabien.sanchez
 */
class Form extends HtmlElement
{

    function start($options = [])
    {
        $defaultOptions = [
            'action' => '',
            'method' => 'POST'
        ];
        $options = array_merge($defaultOptions, $options);
        return $this->tagStart('form', $options);
    }

    function end()
    {
        return $this->tagClose('form');
    }

    function label($libelle, $options = [])
    {
        return $this->tagStart('label', $options) . $libelle . $this->tagClose('label');
    }

    function input($type, $name, $options = [])
    {
        $options['type'] = $type;
        $options['name'] = $name;
        if (!isset($options['id'])) {
            $options['id'] = $name;
        }
        return $this->tagAutoClose('input', $options);
    }

    /**
     * Retourne un champ text formaté
     * @param string $name
     * @param string $libelle
     * @param bool $required
     * @return string
     */
    function text($name, $libelle, $required = false)
    {
        return $this->tagStart('div', [ 'class' => 'form-group']) . PHP_EOL .
                $this->label($libelle, [ 'for' => $name]) . PHP_EOL .
                $this->input('text', $name, [
                    'class' => 'form-control',
                    'required' => $required
                ]) . PHP_EOL .
                $this->tagClose('div');
    }

    public function email($name, $libelle, $required = false)
    {
        return $this->tagStart('div', [ 'class' => 'form-group']) . PHP_EOL .
                $this->label($libelle, [ 'for' => $name]) . PHP_EOL .
                $this->input('email', $name, [
                    'class' => 'form-control',
                    'required' => $required
                ]) . PHP_EOL .
                $this->tagClose('div');
    }

    public function password($name, $libelle, $required = false)
    {
        return $this->tagStart('div', [ 'class' => 'form-group']) . PHP_EOL .
                $this->label($libelle, [ 'for' => $name]) . PHP_EOL .
                $this->input('password', $name, [
                    'class' => 'form-control',
                    'required' => $required
                ]) . PHP_EOL .
                $this->tagClose('div');
    }

    public function checkBox($name, $libelle)
    {
        return $this->tagStart('div', ['class' => 'form-group']) . PHP_EOL .
                $this->tagStart('label') . PHP_EOL .
                $this->input('checkbox', $name) . ' ' . $libelle . PHP_EOL .
                $this->tagClose('label') . PHP_EOL .
                $this->tagClose('div');
    }

    public function submit($libelle)
    {
        return $this->tagStart('button', [
                    'class' => 'btn btn-primary'
                ]) . $libelle . $this->tagClose('button');
    }

}
