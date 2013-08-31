<?PHP
/**
* 
*/
class Main_base_controler
{
    static private $_url_base = Null;
    protected $_header_body = Null;
    protected $login_error_display = Null;

    public function __construct()
    {        
        $this->_build_page_head();
    }

    protected function _build_page_head()
    {
        $header_logo        = (Config::get("display:header_logo") == true)
                                ?Element::div(Element::img(URL_ROOT . "images/".Config::get("site:header_logo")), "header_wrapper_logo")
                                :Null;
        $header_login       = (Config::get("display:login") == true)
                                ?$this->_build_login()
                                :Null;
        $this->clear_div    = Element::div(Null, Null, "clear_float");
        $header_nav         = (Config::get("display:navigation") == true)
                                ?$this->_get_navigation()
                                :Null;
        $this->_header_body = $header_logo.$header_login.$this->clear_div.$header_nav;
    }

    protected function _build_login()
    {        
        // Process login form if it is submitted and not yet has been processed
        $Login_model = new Login_model();
        // Build the login-form if not logged in
        if ($Login_model->verify() == false) 
        {
            include VIEW."forms".DS."login.include.php";
            $this->login_error_display = $Login_model->fetch_errors();
        } else {
            $login = "a user is logged in";
        }$footer = "Morphius.inc &copy;".date("Y");
        return $login;
    }
    
    protected function _build_footer()
    {   $ip = (Config::get("display:user_ip") == true)
                                ?"<br/>your ip = " . $this->get_client_ip()
                                :Null;
        $footer = Config::get("site:builder")." &copy;".date("Y"). "by ".Config::get("site:webmaster") . $ip;
        return Element::div($footer, "footer_wrapper");             
    }
            
    protected function parse()
    {
        $HTML = new Main_base_view( New Html($this->page_name . " - ".Config::get("site:sitename")) );
        $HTML->set_css(array(self::$_url_base . "public/css/style.css"));
        $HTML->set_meta_tags(Config::get("site:meta_tags"));
        $HTML->load_body($this->_body);
        $HTML->render();
        echo $HTML->parse();
    }
    
    protected function _build_sidebar($li_name_links = Null)
    {
        if(is_array($li_name_links) && Config::get("display:sidebar" == true) ) {
            $ul = Element::ul($li_name_links, Null, "side_bar_ul");
            return Element::div( Element::div($ul, Null, "holder")
                                            ,"side_bar_right"
                                            );
        }
        return Null;
    }     
            
    protected function _get_navigation()
    {
        $_navigation_buttons_array = Null;
        foreach (Config::get("navigation:buttons") as $key => $value) {
            $_navigation_buttons_array[$key] = self::$_url_base.$value;
        }
        if ($_navigation_buttons_array != Null && is_array($_navigation_buttons_array)) {
            return Element::div(Element::ul($_navigation_buttons_array, Null, "nav_bar", true), "header_wrapper_navigation");
        } 
        return Null;
    }
    
    static public function set_url_base($url_base)
    {
        self::$_url_base = $url_base;
    }        

     private function _load_view($view_name)
    {
        
    }
            
    protected function get_client_ip() 
    {
         $ipaddress = '';
         if (getenv('HTTP_CLIENT_IP'))
             $ipaddress = getenv('HTTP_CLIENT_IP');
         else if(getenv('HTTP_X_FORWARDED_FOR'))
             $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
         else if(getenv('HTTP_X_FORWARDED'))
             $ipaddress = getenv('HTTP_X_FORWARDED');
         else if(getenv('HTTP_FORWARDED_FOR'))
             $ipaddress = getenv('HTTP_FORWARDED_FOR');
         else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
         else if(getenv('REMOTE_ADDR'))
             $ipaddress = getenv('REMOTE_ADDR');
         else
             $ipaddress = 'UNKNOWN';

         return $ipaddress; 
    }

}