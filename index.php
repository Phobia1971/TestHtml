<?PHP
// site define's 
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__) . DS);
define("CLASSES", ROOT . "libs" . DS . "classes" .DS);
define("VIEW", ROOT . "public" . DS . "view" .DS);
define('URL_ROOT', "http://" . $_SERVER["SERVER_NAME"] . "/TestHtml/");

// Load the autoloader class
include CLASSES . 'autoloader/Autoloader.class.php';

// magic function 
function __autoload($class)
{
    try {
       $loader = New autoloader\Autoloader(CLASSES);
    if($loader->load_class($class) == false) return Null; 
    } catch (Exception $e) {
        echo "No class found";
    }
    
}

$uri = new Uri("TestHtml");
$router = new Router($uri);
try {
    $router->run_controler();
} catch (Exception $e) {
    echo "Error calling class";
}

$router->run_method();

Session::start();

$process             = false;
$user                = false;
$login_error_display = Null;
// Process login form if it is submitted and not yet has been processed
$Login_model = new Login_model();
// Build the login-form if not logged in
if ($Login_model->verify() == false) 
{
    include VIEW."forms".DS."login.form.php";
    $login_error_display = $Login_model->fetch_errors();
} else {
    $login = "a user is logged in";
}
// Build html login form


// Navigation array, buttonname and links
 $nav_array = array ( "Home"      => URL_ROOT."home"
                     ,"Content"   => URL_ROOT."content"
                     ,"Portfolio" => URL_ROOT."portfolio"
                     ,"About us"  => URL_ROOT."about"
                     ,"Contact"   => URL_ROOT."contact");    
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
$HTML = new Main_base_view($page);
$HTML->set_css(array(URL_ROOT . "public/css/style.css"));
$HTML->set_meta_tags($meta_tags);
$HTML->load_body($body);
$HTML->render();
echo $HTML->parse();