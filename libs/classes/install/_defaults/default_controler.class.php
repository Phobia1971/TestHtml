<?PHP
/**
*
*/
class default_controler extends Main_base_controler
{
    protected $_sb    = Null;
    protected $_body  = Null;
    protected $_model = Null;

    public function __construct()
    {
        $this->page_name = array_shift(explode('_', __CLASS__));
        parent::__construct($this->page_name);
        $name = $this->page_name."_model";
        $this->_model = new $name;
    }

    public function index()
    {
        $this->clear_div    = Element::div(Null, Null, "clear_float");

        // Build the complete html document and parse to browser
        $this->_view->parse($this->page_name);
    }
}