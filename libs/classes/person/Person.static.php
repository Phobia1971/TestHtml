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

    static public function all()
    {
        return self::$_person_data;
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

    static public function create_avatar()
    {
        $foldername = md5(self::get("profile:user_name"));
        if(self::get("profile:avatar") == "false")
        {
            self::add("avatars/mini/_default/_default_mini.png", "avatar", "mini");
            self::add("avatars/midi/_default/_default_midi.png", "avatar", "midi");
            self::add("avatars/large/_default/_default_large.png", "avatar", "large");
        } else {
            self::add("avatars/mini/{$foldername}/avatar_mini.png", "avatar", "mini");
            self::add("avatars/midi/{$foldername}/avatar_midi.png", "avatar", "midi");
            self::add("avatars/large/{$foldername}/avatar_large.png", "avatar", "large");
        } 
    }
}