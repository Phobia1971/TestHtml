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
$router->run_controler();
$router->run_method();

Session::start();


// Navigation array, buttonname and links
 $nav_array = array ( "Home"      => URL_ROOT."home"
                     ,"Content"   => URL_ROOT."content"
                     ,"Portfolio" => URL_ROOT."portfolio"
                     ,"About us"  => URL_ROOT."about"
                     ,"Contact"   => URL_ROOT."contact");   

Main_base_controler::set_navigation_buttons($nav_array); 
