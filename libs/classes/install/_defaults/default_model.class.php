<?PHP
/**
* 
*/
class default_model extends Main_base_model
{
    
    public function __construct()
        {
            $this->page_name = array_shift(explode('_', __CLASS__));
            parent::__construct($this->page_name);
            $modelname = $this->page_name."_model";
            $this->_model = new $modelname;
        }

        public function index()
        {
            
        }

}