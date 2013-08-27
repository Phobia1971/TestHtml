<?PHP
/**
* 
*/
class ErrorBuilder
{
    static private $_error_data   = Null;
    static private $_error_msg    = Null;
    static private $_rename_array = Null;

    static public function add_rename_array(array $data)
    {
        if(!empty($data))
            self::$_rename_array = $data;
    }

    static function add_data($error_data)
    {
        self::$_error_data = $error_data;
       if(is_array(self::$_error_data)) {
            self::_build_of_array(self::$_error_data);
       } else {
            self::_build_line(self::$_error_data);
       }
    }

    static public function parse()
    {
        return self::$_error_msg;
    }


    static  private function _build_line($msg)
        {
                self::$_error_msg .= '<div $class="error_msg_line" >Error: '.$msg.'</div>';
        }
            
            

    static private function _build_of_array($data, $name = Null)
    {
           foreach ($data as $key => $error) {
                    if(is_array($error)) 
                        self::_build_of_array($error, $key);
                    else 
                    {
                        $b_name = ($name == Null)?self::_rename($key):self::_rename($name);       
                        self::$_error_msg .= '<div $class="error_msg_line" >'.$b_name.': '.$error.'</div>';
                    }
                }     
    }
            
    static private function _rename($name)
    {
        if(is_array(self::$_rename_array)) {
            if(isset(self::$_rename_array[$name]))
                return self::$_rename_array[$name];
        } 
        return ucfirst($name);
    }
            
}