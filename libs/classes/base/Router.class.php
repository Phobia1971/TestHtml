<?PHP
/**
* 
*/
class Router 
{
    static private $_controler = Null;
    private $_uri_class        = Null;
    private $_controler_class  = Null;
    private $_method_class     = Null;
    private $_catch_errors     = Null;

    public function __construct(Uri $uri)
    {
        $this->_uri_class = $uri;
    }

    public function run_controler()
    {
        self::$_controler = $this->_uri_class->controler();
        $controler = self::$_controler."_controler";
        
        if(autoloader\Autoloader::pre_check_controler($controler))
        {
            $this->_controler_class = new $controler;
        } else {
            $this->_catch_errors[] = "Error: Unable to load page:".$controler;
            $this->_uri_class->controler("Error");            
            $this->_controler_class = new Error_controler;
        }
    }

    public function run_method()
    {
        if($this->_uri_class->controler() != "Error"){
            
                if(method_exists($this->_controler_class, $this->_uri_class->method()))
                    $this->_controler_class->{$this->_uri_class->method()}($this->_uri_class->args());    
                else {
                $this->_uri_class->controler("Error");                
                $this->_catch_errors[] = "Unable to run method: <b>".$this->_uri_class->method()."</b>";
                $this->_uri_class->method("process");
                $this->_controler_class = new Error_controler;
                $this->run_method();
                exit();
            }            
        } else {
            $this->_controler_class->process($this->_catch_errors);
        } 
    }       

    static public function controler()
    {
       return self::$_controler; 
    }

}