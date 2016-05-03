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
 * Description of HtmlElement
 *
 * @author fabien.sanchez
 */
class HtmlElement
{

    /**
     * Retourne une liste d'attribu sous forme de chaine formatée
     * @param array $attributs
     * @return string
     */
    protected function compileAttributs(array $attributs)
    {
        $compiled = [];
        foreach ($attributs as $attributName => $value) {
            $compiled[] = $this->compileAttribut($attributName, $value);
        }
        return implode(' ', $compiled);
    }

    private function compileAttribut($attributName, $value)
    {
        $attributName = strtolower($attributName);
        if (is_null($value) || $value === false) {
            return '';
        }
        if ($value === true) {
            return $attributName;
        }
        return sprintf('%s="%s"', $attributName, $value);
    }

    /**
     * Retourne l'ouverture d'un tag HTML formaté
     * @param string $tag
     * @param array $attributs
     * @return string
     */
    protected function tagStart($tag, array $attributs = [])
    {
        return sprintf('<%s %s>', strtolower($tag), $this->compileAttributs($attributs));
    }

    /**
     * Retourne la fermeture d'un tag HTML formaté
     * @param string $tag
     * @return string
     */
    protected function tagClose($tag)
    {
        return sprintf('</%s>', strtolower($tag));
    }

    /**
     * Retourne un tag HTML auto fermant dormaté
     * @param string $tag
     * @param array $attributs
     * @return string
     */
    protected function tagAutoClose($tag, array $attributs = [])
    {
        return sprintf('<%s %s />', strtolower($tag), $this->compileAttributs($attributs));
    }

}
