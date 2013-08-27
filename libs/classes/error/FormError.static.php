<?PHP
/**
*   
*/
class FormError
{
    static private $_error_messages = array();

    static public function add($type, $msg)
    {
        if(is_array($msg))
        {
            foreach ($msg as $key => $value) {
                self::$_error_messages[$type][$key] = $value;
            }            
        }
        else 
            self::$_error_messages[$type] = $msg;
    }

    static public function is_found()
    {
        return (empty(self::$_error_messages)?false:true);
    }

    static public function get()
    {
        return self::$_error_messages;
    }
}