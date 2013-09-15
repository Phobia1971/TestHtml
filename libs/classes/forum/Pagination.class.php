<?PHP
/**
* 
*/
class Pagination
{
    static private $_total_entries   = Null;
    static private $_max_on_page     = 10;
    static private $_page_on         = Null;
    static private $_pagination_data = array();
    static private $_base_url        = Null;

    static public function get_data()
    {
        self::run_pagination();
        return self::$_pagination_data;   
    }

    static public function set_total_entries($total_entries)
    {
       self::$_total_entries = $total_entries;
    }

    static public function set_page_on($page)
    {
       self::$_page_on = $page;
    }

    static public function set_max_on_page($max = 10)
    {
       self::$_max_on_page = $max;
    }

    static public function set_base_url($base_url)
    {
       self::$_base_url = $base_url;
    }

    static public function get_max_on_page()
    {
        return self::$_max_on_page;
    }   

    static private function run_pagination()
    {
       $num_pages = ceil(self::$_total_entries/self::$_max_on_page);
       if(self::$_page_on == Null)
       {
            self::$_pagination_data["previous"] = Null;
            self::$_pagination_data["now"]      = 1;
            if($num_pages > 1)
            {
                $page_to = ($num_pages <= 4)?$num_pages:4;
                for ($i=2; $i < $page_to; $i++) { 
                    self::$_pagination_data[$i] = self::$_base_url . "/" . $i;
                }
            }
       }
    }

}