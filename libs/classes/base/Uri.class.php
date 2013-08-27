<?PHP
/**
* 
*/      
class Uri 
{
    private $_clean_uri  = Null;
    private $_controler  = Null;
    private $_method     = Null;
    private $_args       = Null;

    public function __construct($default_path = Null)
    {
        $uri = $_SERVER["REQUEST_URI"];
        if($default_path == Null) 
            $this->_clean_uri = trim($uri,"/");
        else
            $this->_clean_uri = trim(str_replace($default_path, "", $uri),"/");

        $this->_read_uri();
    }

    /**
     * Getter/Setter for the controler
     * @param  string $set_controler if a string is provided, the controler will be renamed
     * @return mixed                 the name of the active controler or
     *                               true/false on setting the new controler
     */
    public function controler($set_controler = false)
    {
        if($set_controler == false)
            return $this->_controler;
        elseif(empty($set_controler) == false && is_string($set_controler)) {
            $this->_controler = ucfirst($set_controler);
            return true;
        }
    }

    /**
     * Getter/Setter for the method
     * @param  string $set_controler if a string is provided, the method will be renamed
     * @return mixed                 the name of the active method or
     *                               true/false on setting the new method
     */
    public function method($set_method = false)
    {
        if($set_method == false)
            return $this->_method;
        elseif(empty($set_method) == false && is_string($set_method)) {
            $this->_method = ucfirst($set_method);
            return true;
        }
    }

    /**
     * Getter to get all arguments of one by index
     * @param  integer $index if index exists in arguments array
     * @return Mixed          array of all the passed arguments or
     *                        data in requested array index or
     *                        false if no match is found
     */
    public function args($index = false)
    {
        if($index == false)
            return $this->_args;
        elseif (is_numeric($index) && isset($this->_args[$index])) 
            return $this->_args[$index];
        else 
            return false;
    }

    private function _read_uri()
    {
            $uri_parts = explode("/", $this->_clean_uri);

            $this->_controler = (!empty($uri_parts[0]))?ucfirst(array_shift($uri_parts)):"Home";

            $this->_method    = (!empty($uri_parts[0]))?strtolower(array_shift($uri_parts)):"index";

            $this->_args      = (!empty($uri_parts[0]))?$uri_parts:array();
    }
            


}