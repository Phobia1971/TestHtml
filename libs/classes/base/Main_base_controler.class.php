<?PHP
/**
* 
*/
class Main_base_controler
{
    protected $_view = Null;

    static private $_url_base = Null;
    protected $_header_body = Null;
    protected $login_error_display = Null;

    public function __construct($pagename)
    {        
        $pagename = $pagename."_view";
        $this->_view = new $pagename(self::$_url_base);
        //$this->_build_page_head();
    }

    
    static public function set_url_base($url_base)
    {
        self::$_url_base = $url_base;
    }        

}