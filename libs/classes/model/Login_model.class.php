<?PHP
/**
*
*/
class Login_model extends Main_base_model
{
    private $_process_form  = Null;
    public  $_error_messages = Null;

    function __construct(){
        parent::__construct();
    }

    public function verify()
    {
        if(Server::request("POST") == true && Session::fetch("LoggedIn") == false)
        {
            $this->_process_form = New FormProcess;
            if($this->_form_valid() == true) {
                if(UserValidation::verify($this->_process_form->fetch()) ) 
                {
                    Session::add(UserValidation::get_user_data(), "profile");
                    Session::add(true, "LoggedIn");
                    return true;
                }
            } else {
                ErrorBuilder::add_rename_array(array("u_name" => "Username", "pword" => "Password"));
                ErrorBuilder::add_data(FormError::get());
                $this->_error_messages = Element::div(ErrorBuilder::parse(), Null, "login_error");
                return false;
            }
        } elseif(Session::fetch("LoggedIn")) {
            // handle if a session has been found
            // check credentails
            if(UserValidation::verify(Session::fetch("profile")) == true)
            {
                Session::add(UserValidation::get_user_data(), "profile");
                return true;
            }   
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
                             ->input("email", "u_name",Null,"enter your email")
                             ->label("Email:")
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
                                        ->validate("maxlength", 50)
                                        ->validate("email")
                                        ->post("pword")
                                        ->validate("maxlength", 20)
                                        ->validate("oneNumber")
                                        ->validate("oneCap")
                                        ->validate("oneSymbol")
                                        ->post("token")
                                        ->validate("token", Session::fetch("form","login"))
                                        ->valid();
        }


}