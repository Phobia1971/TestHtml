<?PHP
/**
* 
*/
class Home_controler extends Main_base_controler
{
    protected $_sb   = Null;
    protected $_body = Null;
    public function __construct()
    {
        parent::__construct();
        $this->page_name = array_shift(explode('_', __CLASS__));
    }

    public function index()
    {
        //
        // Build the content div
        // 
        $central_content = Element::div( Element::div("Central content", Null, "holder")
                                                        ,"central_content"
                                                        );

        $sb  = $this->_build_sidebar(array("Element 1","Element 2","Element 3","Element 4"));
        $content= $central_content.$sb.$this->clear_div;

        $this->_body = Element::div(      Element::div($this->_header_body, "header_wrapper")     // $header div
                           .Element::div($this->login_error_display.$content, "content_wrapper")   // content div
                           .Element::div($this->_build_footer(), "footer_wrapper")     // footer div
                     ,"wrapper_global" // div id
                     );

        // Build the complete html document and parse to browser
        $this->parse();
    }            
}