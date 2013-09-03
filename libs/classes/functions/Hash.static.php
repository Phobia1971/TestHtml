<?PHP
/**
* 
*/
class Hash
{
    static private $_stored_salt = Null;

    static public function create($algo, $data, $salt = Null) {
        if ($algo && $data) {
            if($salt != Null && is_string($salt)){
                $context = hash_init($algo, HASH_HMAC, $salt);
            } elseif(self::$_stored_salt != Null) {
                $context = hash_init($algo, HASH_HMAC, self::$_stored_salt);
            } else {
                $context = hash_init($algo);
            }
            
            if(!$context) {
                throw new Exception("Error salting data");
                return false;
            }
            hash_update($context, $data);
            return hash_final($context);
        } else {
            throw new Exception("Creating hash failed");
        }
    }

    static public function token($salt = NULL){
        $data = uniqid(microtime()*rand(100000, 99999999));
        if($salt != Null && is_string($salt))
            return self::create ("sha512", $data, $salt);
        else
            return md5($data);
    }

    static public function create_salt($length = 128, $save_salt = false)
    {
        if(is_string($length)) $length = strlen($length);
        if(is_numeric($length) == false || $length <= 3) $length = rand(50, 120);
        $salt = Null;
        for ($i=0; $i < $length; $i++) { 
            $salt .= chr(rand(20, 120));
        }
        if($save_salt) self::$_stored_salt = $salt;
        return $salt;
    }

}