<?PHP
/**
* 
*/
namespace autoloader;

class Autoloader
{
    private $_root_classes_folder = Null;
    static  $_subfolders          = Null;
    static  $_classes_loaded      = array();

    public function __construct($path_classes_folder)
    {
        if(!isset($path_classes_folder)) throw new Exception("Error: Unable to run autoloader without the path to the classes", 1);
        if(is_dir($path_classes_folder))
        {
            $this->_root_classes_folder = $path_classes_folder;
            if(self::$_subfolders == Null) self::_get_folders($this->_root_classes_folder);
        }
        else
            throw new Exception("Error: Unable to use the path to the classes <br /><b>'" .$path_classes_folder."'</b>", 1);
    }

    public function load_class($class_name)
    {
        $subfolder_tree = explode("\\", $class_name);
        array_filter($subfolder_tree);
        $class_name = ucfirst(array_pop($subfolder_tree));
        $subpath = (!empty($subfolder_tree))?implode("\\", $subfolder_tree). "\\":Null;

        if(in_array($class_name, self::$_classes_loaded)) exit();
        $loaded = false;
        foreach (self::$_subfolders as $subpath) {
            // Build the 2 filenames to test
            $normal_class = $this->_root_classes_folder.$subpath.$class_name . ".class.php";
            $static_class = $this->_root_classes_folder.$subpath.$class_name . ".static.php";

            if(is_readable($normal_class)) {
                include $normal_class;
                self::$_classes_loaded[$class_name] = $normal_class;
                $loaded = true;
            } elseif (is_readable($static_class)) {
                include $static_class;
                self::$_classes_loaded[$class_name] = $static_class;
                $loaded = true;
            }
        }
        
    }


     private function _get_folders($dir)
        {
            $results = scandir($dir);

            foreach ($results as $result) {
                if ($result === '.' or $result === '..') continue;

                if (is_dir($dir . '/' . $result)) 
                {
                    self::$_subfolders[] = $result . '\\';
                }
            }
            array_unshift(self::$_subfolders , '\\');
        }
            
}// End of class