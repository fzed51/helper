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
 * Description of Session
 *
 * @author fabien.sanchez
 */
class Session implements \ArrayAccess /* , \Iterator */
{

    const SID_FLASH = "<<__MESSAGE_FLASH__>>";

    private $iterator_position = 0;
    private $iterator_keys = [];
    private $flashs;
    private $flash_type;

    public function __construct()
    {
        $session_status = session_status();
        $header_sended = headers_sent();

        if ($session_status === PHP_SESSION_DISABLED) {
            if ($header_sended) {
                throw new \RuntimeException("Impossible de démarer une Session.");
            }
            if (session_start()) {
                throw new \RuntimeException("Erreur lors du lancement de la Session.");
            }
        }

        // $this->rewind();
    }

    public function &read($offset, $else = null)
    {
        if (!isset($_SESSION[$offset])) {
            return $else;
        }
        return $_SESSION[$offset];
    }

    public function write($offset, $value)
    {
        $_SESSION[$offset] = $value;
    }

    public function has($offset)
    {
        return isset($_SESSION[$offset]);
    }

    public function del($offset)
    {
        unset($_SESSION[$offset]);
    }

    public function raz()
    {
        $_SESSION = [];
    }

    // #######################################################
    // ############## implements messages flash ##############
    // #######################################################

    public function setFlashType(array $types = [])
    {
        $this->flash_type = $types;
    }

    public function setFlash($type, $message)
    {
        if (!empty($this->flash_type) && false === array_search($type, $this->flash_type)) {
            throw \RuntimeException("Le type '$type' de message flash n'est pas autorisé");
        }
        if (!$this->has(self::SID_FLASH)) {
            $this->clearFlash();
        }
        if (!array_key_exists($type, $_SESSION[self::SID_FLASH])) {
            $_SESSION[self::SID_FLASH][$type] = [];
        }
        $_SESSION[self::SID_FLASH][$type][] = $message;
    }

    public function getFlash($glue = "\n", $clear = true)
    {
        $out = [];
        if (isset($_SESSION[self::SID_FLASH])) {
            foreach ($_SESSION[self::SID_FLASH] as $type => $messages) {
                $out[$type] = implode($glue, $messages);
            }
        }
        if ($clear) {
            $this->clearFlash();
        }
        return $out;
    }

    private function clearFlash()
    {
        $this->write(self::SID_FLASH, []);
    }

    // #####################################################
    // ############## implements \ArrayAccess ##############
    // #####################################################

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->read($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->write($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->del($offset);
    }

    /*
      // ##################################################
      // ############## implements \Iterator ##############
      // ##################################################

      public function current()
      {
      return $_SESSION[$this->key()];
      }

      public function key()
      {
      return $this->iterator_keys[$this->iterator_position];
      }

      public function next()
      {
      $this->iterator_position++;
      }

      public function rewind()
      {
      $this->iterator_keys = array_keys($_SESSION);
      $this->iterator_position = 0;
      }

      public function valid()
      {
      $this->has($this->key());
      }
     */
}
