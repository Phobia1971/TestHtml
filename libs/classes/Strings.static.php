<?php

/**
 * Description of Strings
 *
 * @author Phobia
 */
class Strings {

    static private $_String = Null;
    static private $_ArrayString = Null;

    /**
     *  input: Set the string to process
     *  if delimitter then the string will be exploded
     *
     * @param string $string
     * @param string $delimiter
     */
    static public function input($string,$delimiter = Null) {
        self::$_String = $string;
        if(empty($delimiter) == False || $delimiter != Null)self::$_ArrayString = explode($delimiter, $string);
    }

    /**
     *
     * @return Mixed => last string from exploded string or Null
     */
    static public function last() {
        if(self::$_String != Null && is_array(self::$_ArrayString)) {
            return array_pop(self::$_ArrayString);
        }
            return Null;
    }

    /**
     *
     * @return Mixed => first string from exploded string or Null
     */
    static public function first() {
        if(self::$_String != Null && is_array(self::$_ArrayString)) {
            return array_shift(self::$_ArrayString);
        }
            return Null;
    }

    static public function get_part($start, $length=Null) {
        if(empty($start) == true) return Null;
        if($length == Null || is_numeric($length) == False) {
            return substr(self::$_String, $start);
        } else {
            return substr(self::$_String, $start, $length);
        }
    }

    static public function insert($string, $position) {
        if(is_numeric($position) == False) return Null;
        if(self::$_String == Null) return Null;
        if(strlen(self::$_String) <= $position) return Null;

        return substr_replace(self::$_String, $string, $position, 0);
    }
}