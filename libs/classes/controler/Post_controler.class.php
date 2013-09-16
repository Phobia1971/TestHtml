<?PHP
/**
*   
*/
class Post_controler extends Main_base_controler
{
    protected $_sb    = Null;
    protected $_body  = Null;
    protected $_model = Null;
    public function __construct()
    {
        $this->page_name = array_shift(explode('_', __CLASS__));
        parent::__construct($this->page_name);
        $modelname = $this->page_name."_model";
        $this->_model = new $modelname;
    }

    public function poster($data)
    {
        $this->_view->requested_poster($this->_model->get_request_poster($data[0]));


        $this->_user->role = Person::get("role");
        $this->_view->add_side_bar(Element::span("User panel:",Null,"sidebar_title")
                                                .(isset($this->_user->role)
                                                ?$this->_model->build_sidebar(Config::get("role:".$this->_user->role),true)
                                                :$this->_model->build_sidebar(Config::get("role:default"),true)));

        $this->_view->add_side_bar(Element::span("Last entered posts:",Null,"sidebar_title")
                                                .$this->_model->build_sidebar($this->_model->get_last_postnames(),true));

        // Build the complete html document and parse to browser
        $this->_view->parse($this->page_name);
    }

    public function view($data)
    {
        Pagination::set_total_entries(1110);
        if(isset($data[2]))Pagination::set_page_on($data[2]);
        Pagination::set_base_url(self::$_url_base . "post/view/" . $data[0] . "/" . $data[1]);

        $this->clear_div     = Element::div(Null, Null, "clear_float");
        $requested_post_data = $this->_model->get_request_post($data[0],$data[1]);
        $this->_view->requested_post($requested_post_data);

        $repleis = New Repleis($this->_model->get_repleis($requested_post_data["post_id"]));

        $this->_view->post_replies($repleis->get_repleis());
        $this->_view->Pagination(Pagination::get_data());

        $this->_user->role = Person::get("role");
        $this->_view->add_side_bar(Element::span("User panel:",Null,"sidebar_title")
                                                .(isset($this->_user->role)
                                                ?$this->_model->build_sidebar(Config::get("role:".$this->_user->role),true)
                                                :$this->_model->build_sidebar(Config::get("role:default"),true)));

        $this->_view->add_side_bar(Element::span("Last entered posts:",Null,"sidebar_title")
                                                .$this->_model->build_sidebar($this->_model->get_last_postnames(),true));

        // Build the complete html document and parse to browser
        $this->_view->parse($this->page_name);
    }
}