<?PHP
/**
*
*/
class  UserValidation
{
    static private $_DBO  = Null;
    static private $_user = Null;

    private function _DBO_connection()
    {
        if(self::$_DBO == Null)
            self::$_DBO = Database::Instance();
    }

    /**
     * verify is login credencials are valid or passed user session data is valid
     *
     * @param mixed $user_data  - 64base_encode serialized user array or
     *                          - array("u_name" => $uname,"pword" => $pword)
     * @return boolean
     */
    static public function verify($user_data)
    {
        self::_DBO_connection();
        $session = false;
        if(is_string($user_data))
        {
            $user_data = self::uncloack($user_data);
            $session = true;
        }
        if(is_array($user_data) && $session == false)
        {
            return self::validate_user($user_data["u_name"],$user_data["pword"]);
        }
        elseif($session == true)
        {
            return self::validate_session($user_data["hash_login"]);
        }
    }

    static public function get_user_data()
    {
        return self::cloack();
    }

    /**
     *
     *   Private methodes
     *
     */

    static private function validate_user($user_name, $password)
    {
        $user_data = self::$_DBO->select("user", array(), "WHERE email = :email", array("email" => $user_name), 1);
        if(empty($user_data[0]) == false){
            if($user_data[0]["hash_pass"] == Hash::create("sha256", $password, $user_data[0]["hash_salt"]))
            {
                // TODO: re-hash password and update hash_pass and hash_salt
                $new_hash_salt  = Hash::create_salt(128,true);
                $new_hash_pass  = Hash::create("sha256", $password);
                $new_hash_login = Hash::create("sha256", Server::client_ip() , microtime());

                self::$_DBO->update("user", "WHERE email =:email", array(":email" => $user_name), array("hash_salt" => $new_hash_salt
                                                                                                            ,"hash_pass" => $new_hash_pass
                                                                                                            ,"hash_token" => $new_hash_login));
                self::$_user['email']      = $user_name;
                self::$_user['user_id']    = $user_data[0]["user_id"];
                self::$_user['hash_login'] = $new_hash_login;
                $Profile = new Profile(self::$_user['user_id']);
                //self::$_user['profile']    = 
                Person::create(self::$_user);
                Person::add($Profile->get(), "profile");
                echo "All okey!!!";
                return true;
            }
        }
    }

    static private function validate_session($hash_login)
    {
        $user_data = self::$_DBO->select("user", array(), "WHERE hash_token = :hash_token", array(":hash_token" => $hash_login), 1);
        if(empty($user_data[0]) == false){
            // TODO: update login_hash with new hash
            $new_hash_login = Hash::create("sha256", Server::client_ip() , microtime());
            self::$_DBO->update("user", "WHERE hash_token =:hash", array("hash" => $hash_login), array("hash_token" => $new_hash_login));
            self::$_user['hash_login'] = $new_hash_login;
            Person::create(self::$_user);
            return true;
        }
    }

    static private function uncloack($url_string)
    {
        return unserialize(base64_decode($url_string));
    }

    static  private function cloack()
    {
        return base64_encode(serialize(self::$_user));
    }



}