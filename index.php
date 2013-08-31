<?PHP
// site define's 
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__) . DS);
define("CLASSES", ROOT . "libs" . DS . "classes" .DS);
define("VIEW", ROOT . "public" . DS . "view" .DS);


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

Config::load(CLASSES."..\config\config.default.json");
Config::load(CLASSES."..\config\config.user.json");
define('URL_ROOT', "http://" . $_SERVER["SERVER_NAME"] . "/".Config::get("site:base")."/");

$uri = new Uri(Config::get("site:base"));
$router = new Router($uri);
$router->run_controler();
$router->run_method();

Session::start(); 

Main_base_controler::set_url_base(URL_ROOT); 
