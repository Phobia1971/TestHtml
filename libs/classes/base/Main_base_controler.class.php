<?PHP
/**
* 
*/
class Main_base_controler
{
    static private $_navigation_buttons_array = Null;
    protected $_header_body = Null;
    protected $login_error_display = Null;

    public function __construct()
    {        
        $this->_build_page_head();
    }

    protected function _build_page_head()
    {
        $header_logo        = Element::div(Element::img(URL_ROOT . "images/logo_600x100.jpg"), "header_wrapper_logo");
        $header_login       = $this->_build_login();
        $this->clear_div    = Element::div(Null, Null, "clear_float");
        $header_nav         = $this->_get_navigation();
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
    {
        $footer = "Morphius.inc &copy;".date("Y");
        return Element::div($footer, "footer_wrapper");             
    }
            
    protected function parse()
    {
        $meta_tags = array( "author" => "Morphius.inc",
                            "description" => "Learning the web (php, html, javascript, jquery, css)");

        $HTML = new Main_base_view( New Html($this->page_name . " - Page") );
        $HTML->set_css(array(URL_ROOT . "public/css/style.css"));
        $HTML->set_meta_tags($meta_tags);
        $HTML->load_body($this->_body);
        $HTML->render();
        echo $HTML->parse();
    }
    
    protected function _build_sidebar($li_name_links = Null)
    {
        if(is_array($li_name_links)) {
            $ul = Element::ul($li_name_links, Null, "side_bar_ul");
            return Element::div( Element::div($ul, Null, "holder")
                                            ,"side_bar_right"
                                            );
        }
        return Null;
    }     
            
    protected function _get_navigation()
    {
        if (self::$_navigation_buttons_array != Null && is_array(self::$_navigation_buttons_array)) {
            return Element::div(Element::ul(self::$_navigation_buttons_array, Null, "nav_bar", true), "header_wrapper_navigation");
        } 
        return Null;
    }
    
    static public function set_navigation_buttons(array $nav_bnt_links)
    {
        self::$_navigation_buttons_array = $nav_bnt_links;
    }        

     private function _load_view($view_name)
    {
        
    }
            

}