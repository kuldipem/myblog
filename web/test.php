<?php

/*
 * Copyright (C) 2014 KULDIP PIPALIYA <kuldipem@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Description of test
 *
 * @author KULDIP PIPALIYA <kuldipem@gmail.com>
 */
class test {
    
    private  $parameters=array("test"=>array("child"=>"data"));
    

    public function get($path, $default = null, $deep = false) {
        if (!$deep || false === $pos = strpos($path, '[')) {
            return array_key_exists($path, $this->parameters) ? $this->parameters[$path] : $default;
        }

        $root = substr($path, 0, $pos);
        if (!array_key_exists($root, $this->parameters)) {
            return $default;
        }

        $value = $this->parameters[$root];
        $currentKey = null;
        for ($i = $pos, $c = strlen($path); $i < $c; $i++) {
            $char = $path[$i];

            if ('[' === $char) {
                if (null !== $currentKey) {
                    throw new \InvalidArgumentException(sprintf('Malformed path. Unexpected "[" at position %d.', $i));
                }

                $currentKey = '';
            } elseif (']' === $char) {
                if (null === $currentKey) {
                    throw new \InvalidArgumentException(sprintf('Malformed path. Unexpected "]" at position %d.', $i));
                }

                if (!is_array($value) || !array_key_exists($currentKey, $value)) {
                    return $default;
                }

                $value = $value[$currentKey];
                $currentKey = null;
            } else {
                if (null === $currentKey) {
                    throw new \InvalidArgumentException(sprintf('Malformed path. Unexpected "%s" at position %d.', $char, $i));
                }

                $currentKey .= $char;
            }
        }

        if (null !== $currentKey) {
            throw new \InvalidArgumentException(sprintf('Malformed path. Path must end with "]".'));
        }

        return $value;
    }

}

$a=new test;
echo "==".$a->get("test[child]","default",true)."==";