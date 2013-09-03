<?PHP
/**
*  
*/

class Post_validator
{
    public function maxlength($data, $arg = 10) {
        if (strlen($data) >= $arg)
            return "Text may only be max $arg characters long";
    }

//

    public function minlength($data, $arg = 3) {
        if (strlen($data) <= $arg)
            return "Text must be minimal $arg characters long";
    }

//

    public function length($data, $arg = 64) {
        if (strlen($data) <> $arg)
            return "Text must be $arg characters long, yours is " . strlen($data);
    }

//    

    public function strequal($data, $arg = "") {
        if ($data <> $arg)
            return "Provided date must be equal to suplied argument.";
    }

//

    public function integer($data) {
        if (!is_numeric($data))
            return "Must be a numeric value";
    }

//

    public function minvalue($data, $arg = 0) {
        if ($data < $arg)
            return "Value must be bigger then $arg";
    }

//

    public function maxvalue($data, $arg = 0) {
        if ($data > $arg)
            return "Value must be smaller then $arg";
    }

//

    public function email($data) {
        if (filter_var($data, FILTER_VALIDATE_EMAIL) == False)
            return "Your email is NOT valide";
    }

    public function url($data) {
        if (filter_var($data, FILTER_SANITIZE_URL) == False)
            return "Your url is NOT valide";
    }

//

    public function string($data) {
        if (is_string($data) == False)
            return "The data provided is not a string";
    }

//

    public function oneNumber($data) {
        if (!preg_match("#[0-9]+#", $data)) {
            return "String must include at least one number!";
        }
    }

    public function oneLetter($data) {
        if (!preg_match("#[a-z]+#", $data)) {
            return "String must include at least one letter!";
        }
    }

    public function oneCap($data) {
        if (!preg_match("#[A-Z]+#", $data)) {
            return "String must include at least one CAPS!";
        }
    }

    public function oneSymbol($data) {
        if( !preg_match("#\W+#", $data) ) {
    return "String must include at least one symbol!";
        }
    }
    
    public function noSpaces($data) {
        if( preg_match("#\s#", $data) ) {
    return "String can not have a space!";
        }
    }

    public function token($data, $arg) {
        if ($data != $arg) {
            return "Illegal sumbit atempt of the form";
        }
    }
}