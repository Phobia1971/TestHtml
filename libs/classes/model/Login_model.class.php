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
        if($_SERVER["REQUEST_METHOD"] == "POST" && Session::fetch("LoggedIn") == false)
        {
            $this->_process_form = New FormProcess;
            if($this->_form_valid() == true) {
                $user = New UserValidation;
                Session::add(true, "LoggedIn");
                return true;
            } else {
                ErrorBuilder::add_rename_array(array("u_name" => "Username", "pword" => "Password"));
                ErrorBuilder::add_data(FormError::get());
                $this->_error_messages = Element::div(ErrorBuilder::parse(), Null, "login_error");
                return false;
            }
        } elseif(Session::fetch("LoggedIn")) {
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

    public function login_form($link = Null)
    {
        $login_form = new Form;
        $token = Hash::token(Hash::create_salt());
        Session::add($token,"form","login");
        $form = $login_form->create($link, 'login', Null, "login_form", "POST")
                             ->input("text", "u_name",Null,"enter your username")
                             ->label("Username:")
                             ->input("password", "pword",Null)
                             ->label("Password:")
                             ->input("hidden", "token", $token)
                             ->input("submit", "login","Login")
                             ->label(" ")
                             ->build();
        return $form;
    }


     private function _form_valid()
        {
            return $this->_process_form->post("u_name")
                                        ->validate("maxlength", 3)
                                        ->post("pword")
                                        ->validate("maxlength", 3)
                                        ->validate("oneNumber")
                                        ->validate("oneCap")
                                        ->validate("oneSymbol")
                                        ->post("token")
                                        ->validate("token", Session::fetch("form","login"))
                                        ->valid();
        }


}