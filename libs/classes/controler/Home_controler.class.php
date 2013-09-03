<?PHP
/**
*
*/
class Home_controler extends Main_base_controler
{
    protected $_sb    = Null;
    protected $_body  = Null;
    protected $_model = Null;
    public function __construct()
    {
        $this->page_name = array_shift(explode('_', __CLASS__));
        parent::__construct($this->page_name);
        $this->_model = new Home_model;
    }

    public function index()
    {
        $this->clear_div    = Element::div(Null, Null, "clear_float");
        $this->_view->last_post($this->_model->get_last_post());



        $this->_view->sub_main_data("Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Fusce vulputate eleifend sapien. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Nullam accumsan lorem in dui. Cras ultricies mi eu turpis hendrerit fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In ac dui quis mi consectetuer lacinia.");

        $this->_user->role = "owner";

        $this->_view->add_side_bar(Element::span("User panel:",Null,"sidebar_title")
                                                .(isset($this->_user->role)?$this->_model->build_sidebar(Config::get("role:".$this->_user->role),true)
                                            :$this->_model->build_sidebar(Config::get("role:default"),true)));

        $this->_view->add_side_bar(Element::span("Last entered posts:",Null,"sidebar_title")
                                                .$this->_model->build_sidebar($this->_model->get_last_postnames(),true));

        // Build the complete html document and parse to browser
        $this->_view->parse($this->page_name);
    }
}