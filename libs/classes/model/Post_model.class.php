<?PHP
/**
* 
*/
class Post_model extends Main_base_model
{
    
    public function __construct()
    {
        parent::__construct();
    }

    public function get_request_poster($nick)
    {
        $poster = self::$_db->select("profile", array(), "WHERE user_name = :user_name", array(":user_name" => $nick),1);
        return (is_array($poster[0])?$poster[0]:array());
    }

     public function get_request_post($nick, $title)
    {
        $db_title = str_replace("-", " ", $title);
        $post = self::$_db->select("posts", array(), "WHERE user_nick = :user_nick AND title = :title ORDER BY posted DESC", array(":user_nick" => $nick, ":title" => $db_title),1);
        return (is_array($post[0])?$post[0]:array());
    }

    public function get_last_postnames()
    {
        $last_post = self::$_db->select("posts", array(), Null, array(),5);
        $return = Null;
        foreach ($last_post as $key => $value) {
                $return[$value["title"]] = Main_base_controler::$_url_base . "post/view/" . strtolower($value["user_nick"]) . "/" . strtolower(str_replace(" ", "-", $value["title"]));
             }     
        return $return;
    }

    public function get_repleis($post_id, $start, $limit)
    {
        $repleis = self::$_db->select("reply", array(), "WHERE post_id = :post_id", array(":post_id" => $post_id), $limit, $start);
        return $repleis;
    }
}