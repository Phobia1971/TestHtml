<?PHP
/**
* 
*/
class Repleis
{
    private $_repleis       = Null;
    private $_reply_profile = array();
    private $_DBO           = Null;
    private $_profile_loaded = array();

    public function __construct($reply_array)
    {
        if(is_array($reply_array))
            { 
                $this->_repleis = $reply_array;
                $this->_DBO = Database::Instance();
                $this->_add_profiles();
            }
    }

    public function get_repleis()
    {
       return $this->_reply_profile;
    }

    private function _add_profiles()
    {
            foreach ($this->_repleis as $reply => $data) 
            {
                $this->_reply_profile[$reply]["profile"] = $this->_load_profile($data["user_name"]);
                $this->_reply_profile[$reply]["reply"]   = $data;
            }
    }
            
    private function _load_profile($nick_name)
    {
        if(isset($this->_profile_loaded[$nick_name]))
        {
            return $this->_profile_loaded[$nick_name];
        }
        else
        {
            $nick = strtolower($nick_name);
            $profile = $this->_DBO->select("profile", array(), "WHERE user_name = :user_name", array(":user_name" => $nick),1);
            $this->_profile_loaded[$nick_name] = $profile[0];
            return (is_array($profile[0])?$profile[0]:array());
        }
    }
            

}