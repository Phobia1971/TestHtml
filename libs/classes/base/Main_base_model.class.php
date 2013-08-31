<?PHP
/**
* 
*/
class Main_base_model
{
    static protected $_db = Null;

    function __construct()
    {
        # code...
    }

    protected static function start_database()
    {
        if(self::$_db == Null) {

        }
        return self::$_db;
    }
}