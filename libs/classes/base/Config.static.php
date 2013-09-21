<?PHP
/**
* 
*/
class Config
{
    static private $_config          = Null;
    
    static public function load($path_to_config_file)
    {
        if(is_readable($path_to_config_file)) {
            $string        = file_get_contents($path_to_config_file);
            if(is_array(self::$_config))
                self::$_config = array_merge(self::$_config, json_decode($string,true));
            else
                self::$_config = json_decode($string,true);
        } else {
            echo "Unable to load config file from: $path_to_config_file";
        }

    }

    static public function add_base_url($url)
    {
       foreach (self::get("add_url") as $value) {
            $keys = explode(":", $value);
           foreach (self::get($value) as $subkey => $value) {
               self::$_config[$keys[0]][$keys[1]][$subkey] = $url . $value;
           }
       }
    }

    static public function show()
    {
        return self::$_config;
    }

    static public function get($data_path)
    {
        
        if(is_array($data_path)) {
            $looper = self::$_config;
            $length = count($data_path) - 1;
            for ($i=0; $i <= $length ; $i++) {
                if(isset($looper[$data_path[$i]])){
                    $looper = $looper[$data_path[$i]];
                } else {
                    $looper = Null;
                }
            }// end for loop
            return $looper;
        } else if(is_string($data_path)) {
            $path = trim($data_path,": ");
             return self::get(explode(":", $data_path));
        }
    }

}