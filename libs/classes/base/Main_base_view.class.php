<?PHP
/**
*
*/
class Main_base_view
{
    static public $_url_base = Null;
    public  $_header_body    = Null;
    private $_login          = Null;


    public function __construct()
    {        
        $this->clear_div    = Element::div(Null, Null, "clear_float");
        
    }

    public function _build_page_head()
    {
        $header_logo        = (Config::get("display:header_logo") == true)
                                ?Element::div(Element::img(self::$_url_base . "public/images/".Config::get("site:header_logo")), "header_wrapper_logo")
                                :Null;
        $header_login       = (Config::get("display:login") == true)
                                ?$this->_login
                                :Null;
        $this->clear_div    = Element::div(Null, Null, "clear_float");
        $header_nav         = (Config::get("display:navigation") == true)
                                ?$this->_get_navigation()
                                :Null;
        $this->_header_body = $header_logo.$header_login.$this->clear_div.$header_nav;
    }

    public function add_side_bar($side_bar)
    {
        $this->side_bar[] = $side_bar;
    }

    public function build_login(Login_model $Login_model)
    {
        // Process login form if it is submitted and not yet has been processed
        //$Login_model = new Login_model();
        // Build the login-form if not logged in
        if ($Login_model->verify() == false)
        {
            $login = $Login_model->login_form("#");
            $this->login_error_display = $Login_model->fetch_errors();
        } else {
            $login = "a user is logged in";
        }
        $this->_login = $login;
    }

    public function _build_footer()
    {   $ip = (Config::get("display:user_ip") == true)
                                ?"<br/>your ip = " . $this->get_client_ip()
                                :Null;
        $webmaster = (Config::get("site:webmaster") != Null)
                                ?"by ".Config::get("site:webmaster")
                                :Null;

        $footer = Config::get("site:builder")
                             ." &copy;".date("Y")
                             .$webmaster
                             . $ip;
        return Element::div($footer, "footer_wrapper");
    }

    public function parse($page_name)
    {
        $this->_build_body();
        $HTML = new Main_base_html( New Html($page_name . " - ".Config::get("site:sitename")) );
        $HTML->set_css(array(self::$_url_base . "public/css/".Config::get("site:css_file")));
        $HTML->set_meta_tags(Config::get("site:meta_tags"));
        $HTML->load_body($this->_body);
        $HTML->load_jquery_lib(Config::get("site:use_jquery"));
        $HTML->render();
        echo $HTML->parse();
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

    protected function _build_side_bar()
    {
        $sidebar = Null;
        if(isset($this->side_bar))
        {
            foreach ($this->side_bar as $sb) {
                $sidebar .= Element::div( $sb.Element::br()
                                    ,"side_bar_right"
                                    );
            }
        }
        return $sidebar;
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