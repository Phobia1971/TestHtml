<?PHP
/**
*       
*/
class Session
{
    static private $_starrted = Null;
    static private $_keys_set = Null;

    static public function start()
    {
        if(self::$_starrted == Null) {
            if(session_start() == true) {
                self::$_starrted = true;
                return true;
            }
        }
    }

    static public function add($data, $key, $subkey = Null) 
    {
        if(!empty($data) && !empty($key)) {
            if($subkey == Null)
            {
                $_SESSION[$key] = $data;
                self::$_keys_set[] = $key;
            }
            else
            {
                $_SESSION[$key][$subkey] = $data;
                self::$_keys_set[] = $key;
            }
        }
    }

    static public function fetch($key, $subkey = Null)
    {
        if(empty($subkey))
            return (isset($_SESSION[$key])?$_SESSION[$key]:False);
        else
            return (isset($_SESSION[$key][$subkey])?$_SESSION[$key][$subkey]:False);
    }

    static public function remove($key, $subkey = Null)
    {
        if(!empty($key) && isset($_SESSION[$key])){
            if(!empty($subkey)) {
                if(isset($_SESSION[$key][$subkey])) { 
                    unset($_SESSION[$key][$subkey]); 
                    return true; }
            } else {
                if(isset($_SESSION[$key])) { 
                    unset($_SESSION[$key]); 
                        return true; }
            }            
        }
    }

    static public function display()
    {
                echo '<pre>';
                print_r($_SESSION);
                echo '</pre>';
    }

    static public function destroy()
    {
        if(self::$_starrted == true) {
            foreach (self::$_keys_set as $key) {
                unset($_SESSION[$key]);
            }
            session_destroy();
            self::$_starrted = Null;
            return true;
        }
    }
} // End of the Class