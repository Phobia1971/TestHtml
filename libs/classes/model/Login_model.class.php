<?PHP
/**
* 
*/
class Login_model extends Main_base_model
{
    private $_process_form  = Null;
    public  $_error_messages = Null;
    
    function __construct(){}

    public function verify()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST" && Session::check("LoggedIn") == false) 
        {
            $this->_process_form = New FormProcess;

            

            if($this->_form_valid == true) {
                $user = New UserValidation;
                Session::add(true, "LoggedIn");
                return true;
            } else {
                ErrorBuilder::add_rename_array(array("u_name" => "Username", "pword" => "Password"));
                ErrorBuilder::add_data(FormError::get());
                $this->_error_messages = Element::div(ErrorBuilder::parse(), Null, "login_error");
                return false;
            }
        } elseif(Session::check("LoggedIn")) {
            // handle if a session has been found
            // check credentails
            $user = New UserValidation;
            return $user;
        }
    }

    public function fetch_errors()
    {
        return $this->_error_messages;
    }



     private function _form_valid()
        {
            return $process->post("u_name")
                            ->validate("maxlength", 3)            
                            ->post("pword")
                            ->validate("maxlength", 3)
                            ->validate("oneNumber")
                            ->validate("oneCap")
                            ->validate("oneSymbol")
                            ->valid();
        }
            

}