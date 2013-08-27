<?PHP
// site define's 
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__) . DS);
define("CLASSES", ROOT . "libs" . DS . "classes" .DS);
define('URL_ROOT', "http://" . $_SERVER["SERVER_NAME"] . "/TestHtml/");

// Load the autoloader class
include CLASSES . 'autoloader/Autoloader.class.php';

// magic function 
function __autoload($class)
{
    $loader = New autoloader\Autoloader(CLASSES);
    $loader->load_class($class);
}

$uri = new Uri("TestHtml");
$router = new Router($uri);
$router->run_controler();
$router->run_method();

Session::start();

$process             = false;
$user                = false;
$login_error_display = Null;
// Process login form if it is submitted and not yet has been processed
if($_SERVER["REQUEST_METHOD"] == "POST" && Session::check("LoggedIn") == false) 
{
    $process = New FormProcess;

    $valid = $process->post("u_name")
            ->validate("maxlength", 3)            
            ->post("pword")
            ->validate("maxlength", 3)
            ->validate("oneNumber")
            ->validate("oneCap")
            ->validate("oneSymbol")
            ->valid();

    if($valid == true) {
        $user = New UserValidation;
        $login = "Logged In (by form)";
        Session::add(true, "LoggedIn");
    } else {
        ErrorBuilder::add_rename_array(array("u_name" => "Username", "pword" => "Password"));
        ErrorBuilder::add_data(FormError::get());
        $login_error_display = Element::div(ErrorBuilder::parse(), Null, "login_error");
        $process = false;       
        $login = "Login error";
    }
} elseif(Session::check("LoggedIn")) {
    // handle if a session has been found
    // check credentails
    $user = New UserValidation;
    $login   = "Logged In (by session)";
    $process = true;
}

// Build the login-form if not logged in
if ($process == false) 
{
    $login_form = new Form;
    $login = $login_form->create('#', '$login', Null, "login_form", "POST")
               ->input("text", "u_name",Null,"enter your username")
               ->label("Username:")
               ->input("password", "pword",Null)
               ->label("Password:")
               ->input("hidden", "token")
               ->input("submit", "login","Login")
               ->label(" ")
               ->build();
}
// Build html login formñññ


// Navigation array, buttonname and links
 $nav_array = array ( "Home" => "#"
                     ,"Content" => "#"
                     ,"Portfolio" => "#"
                     ,"About us" => "#"
                     ,"Contact" => "#");    
// Build the header div content

$header_logo  = Element::div(Element::img(URL_ROOT . "images/logo_600x100.jpg"), "header_wrapper_logo");
$header_login = $login;
$clear_div = Element::div(Null, Null, "clear_float");
$header_nav   = Element::div(Element::ul($nav_array, Null, "nav_bar", true), "header_wrapper_navigation");

$header = $header_logo.$header_login.$clear_div.$header_nav;

//
// Build the content div
// 
$central_content = Element::div( Element::div("Central content", Null, "holder")
                                ,"central_content"
                                );
$ul = Element::ul(array("Element 1","Element 2","Element 3","Element 4"), Null, "side_bar_ul");
$side_bar_right  = Element::div( Element::div($ul, Null, "holder")
                                ,"side_bar_right"
                                );

$content= $central_content.$side_bar_right.$clear_div;


// build footer div
$footer = "Morphius.inc &copy;".date("Y");

// Build the body element
$body = Element::div(      Element::div($header, "header_wrapper")     // $header div
                           .Element::div($login_error_display.$content, "content_wrapper")   // content div
                           .Element::div($footer, "footer_wrapper")     // footer div
                     ,"wrapper_global" // div id
                     );

// Build the complete html document and parse to browser
$meta_tags = array( "author" => "Morphius.inc",
                    "description" => "Learning the web (php, html, javascript, jquery, css)");

$page = New Html("Test page");
echo $page   ->css(URL_ROOT . "css/style.css")
             ->meta_tags($meta_tags)
             ->body($body)
             ->display();