<?PHP
/**
*
*/
class Person
{
    static private $_person_data = Null;

    static public function create(array $person_data)
    {
       self::$_person_data = $person_data;
    }

    static public function add($data, $key, $subkey = Null)
    {
        if($subkey == Null)
            self::$_person_data[$key] = $data;
        else
            self::$_person_data[$key][$subkey] = $data;
    }

    static public function get($data_path)
    {
        if(is_array($data_path)) {
            $looper = self::$_person_data;
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