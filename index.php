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
// Load the config files User file settings will overwrite the default settings
Config::load(CLASSES."..\config\config.default.json");
Config::load(CLASSES."..\config\config.user.json");
// define the website root url
define('URL_ROOT', Server::http() . Config::get("site:base")."/");
Config::add_base_url(URL_ROOT);
// set the website base url to the classes
Main_base_controler::set_url_base(URL_ROOT);
// strip and read uri
$uri = new Uri(Config::get("site:base"));
// start the session
Session::start();
// run the router and start displaying the site
$router = new Router($uri);
$router->run_controler();
$router->run_method();