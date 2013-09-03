<?PHP
/**
* 
*/
class Home_model extends Main_base_model
{
    
    public function __construct()
    {
        parent::__construct();
        // start instance and store database connection
        $this->start_database();
    }


     public function get_last_post()
    {
        $last_post = self::$_db->select("posts", array(), Null, array(),1);
        return (is_array($last_post[0])?$last_post[0]:array());
    }

    public function get_last_postnames()
    {
        $last_post = self::$_db->select("posts", array(), Null, array(),5);
        $return = Null;
        foreach ($last_post as $key => $value) {
                $return[$value["title"]] = "forum/post/".str_replace(" ", "_", $value["title"]);
             }     
        return $return;
    }

}