<?PHP

/**
*  Validator class to validate uploaded files
*/

class File_Validator
{
    
    static private $_excepted_extention_array = array();


    public function filesize($source, $arg = 2079152)
    {
        $error = false;
        if(isset($source['tmp_name'])) {
            if($source['size'] >= $arg) $error = "The size of the uploaded file is to big";
        } else {            
            foreach ($source as $file => $data) {
                if($file['size'] >= $arg) $error[] - "The size of the uploaded file is to big";
            }
        }
        return $error;
    }

    public function extention($source, $arg = Null)
    {
        if(empty(self::$_excepted_extention_array)) throw new Exception("ERROR: No excepted extentions array provided", 1);
        
        $error = false;
        if(isset($source['tmp_name'])) {
            $ext = array_pop(explode(".", $source['name']));
            if(in_array($ext, self::$_excepted_extention_array)) $error = "The extention of the uploaded file '".$source['name']."' is to not valid";
        } else {            
            foreach ($source as $file => $data) {
                $ext = array_pop(explode(".", $file['name']));
                if(in_array($ext, self::$_excepted_extention_array)) $error[] - "The extention of the uploaded file '".$source['name']."' is to not valid";
            }
        }
        return $error;        
    }

    static public function set_good_extentions(array $extentions) 
    {
        if(is_array($extentions)) {
            self::$_excepted_extention_array = $extentions;
        }
    }
}