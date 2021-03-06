<?PHP
/**
* 
*/
class Main_base_controler
{
    protected $_view = Null;

    static public $_url_base = Null;
    protected $_header_body = Null;
    protected $login_error_display = Null;

    public function __construct($pagename)
    {       
        
        $pagename = $pagename."_view";
        $this->_view  = new $pagename;
        $this->_login = new Login_model();
        //$this->_login->verify();
        $this->_view->build_login($this->_login);
        $this->_view->_build_page_head();
    }

    public function logout()
    {
        Session::destroy();
        header("Location:" . self::$_url_base);
    }

    
    static public function set_url_base($url_base)
    {
        self::$_url_base = $url_base;
        Main_base_view::$_url_base = self::$_url_base;
    }        

}