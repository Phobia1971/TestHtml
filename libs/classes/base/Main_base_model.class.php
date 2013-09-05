<?PHP
/**
* 
*/
class Main_base_model
{
    static protected $_db = Null;

    function __construct()
    {
        if(self::$_db == Null) self::$_db = new Database( Config::get("database:type")
                                                         ,Config::get("database:host")
                                                         ,Config::get("database:database")
                                                         ,Config::get("database:username")
                                                         ,Config::get("database:password"));
        return self::$_db;
    }

    public function build_sidebar(array $li_name_links, $link = false)
    {
        if(is_array($li_name_links) && Config::get("display:sidebar") == true ) {
            $ul = Element::ul($li_name_links, Null, "side_bar_ul", $link);
            return Element::div($ul, Null, "holder");
        }
        return Null;
    }
            
}