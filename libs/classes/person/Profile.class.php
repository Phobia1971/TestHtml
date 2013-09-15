<?PHP
/**
*
*/
class Profile
{

    private $_DBO  = Null;
    private $_data = Null;

    function __construct($user_id = Null)
    {
        $this->_DBO = Database::Instance();
        if($user_id != Null && is_numeric($user_id)) {
            $person_data = $this->_DBO->select("profile", Array(), "WHERE user_id = :user_id", array(":user_id" => $user_id));
            if(empty($person_data[0]) == false) $this->add($person_data[0]);
        }
    }

    public function add($data, $key = Null)
    {
        if(is_array($data) && $key == Null) {
            $this->_data = $data;
        } else if($key != Null) {
            $this->$data[$key] = $data;
        }
    }

    public function get($key = Null, $subkey = Null)
    {
        if($key == Null && $subkey == Null)
        {
            return $this->_data;
        } else if($key != NUll && $subkey == Null)
        {
            return $this->_data[$key];
        } else if($key != NUll && $subkey != Null)
        {
            return $this->_data[$key][$subkey];
        }
    }

}