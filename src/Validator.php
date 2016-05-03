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
 * Description of Validator
 *
 * @author fabien.sanchez
 */
class Validator
{

    const PATTERN_ALPHANUM = '/[a-zA-Z0-9_]+/';
    const PATTERN_EMAIL = '/[a-zA-Z0-9]+([\+\._][a-zA-Z0-9]+)*@[a-zA-Z0-9_]+([\._][a-zA-Z0-9]+)*\.[a-zA-Z0-9]+/';

    /**
     * @var array
     */
    private $errors;

    /**
     * @var bool
     */
    private $valide;

    /**
     * @var array
     */
    private $data;

    /**
     * @var array
     */
    private $options;

    /**
     *
     * @param array|\ArrayAccess $data
     * @param array $options
     * @throws \InvalidArgumentException
     */
    public function __construct($data, array $options = [])
    {
        if (!is_array($data) && !is_a($data, 'ArrayAccess')) {
            throw new \InvalidArgumentException('Les données ne sont pas valides.');
        }
        $this->data = $data;
        $this->options = $options;
        $this->valide = true;
        $this->errors = [];
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->valide;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param string $key
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function get($key)
    {
        if (!isset($this->data[$key])) {
            throw new \InvalidArgumentException("La donnée '$key' n'existe pas");
        }
        return $this->data[$key];
    }

    /**
     * @param bool $result
     * @param string $message
     * @return bool
     */
    protected function saveResult(bool $result, $message)
    {
        if (!$result) {
            $this->valide = false;
            array_push($this->errors, $message);
        }
        return $result;
    }

    /**
     * @param string $key
     * @param string $message
     * @return bool
     */
    public function isAlphaNum($key, $message = '')
    {
        $value = $this->get($key);
        return $this->saveResult(
                        preg_match(self::PATTERN_ALPHANUM, $value), $message
        );
    }

    /**
     * @param string $key
     * @param string $message
     * @return bool
     */
    public function isEmail($key, $message = '')
    {
        $value = $this->get($key);
        return $this->saveResult(
                        preg_match(self::PATTERN_EMAIL, $value), $message
        );
    }

    /**
     * @param string $key
     * @param string $message
     * @return bool
     */
    public function isConfirmed($key, $message = '')
    {
        $value = $this->get($key);
        $valueConfirmed = $this->get($key . '_confirm');
        return $this->saveResult(
                        (!empty($value) && $value == $valueConfirmed), $message
        );
    }

    public function isNumeric($key, $message = '')
    {
        $value = $this->get($key);
        return $this->saveResult(
                        is_numeric($value), $message
        );
    }

    public function isAlphaNumOrEmail($key, $message = '')
    {
        $value = $this->get($key);
        return $this->saveResult(
                        preg_match(self::PATTERN_ALPHANUM, $value) ||
                        preg_match(self::PATTERN_EMAIL, $value)
                        , $message
        );
    }

}
