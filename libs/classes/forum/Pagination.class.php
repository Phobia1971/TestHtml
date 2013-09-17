<?PHP
/**
* 
*/
class Pagination
{
    static private $_total_entries   = Null;
    static private $_max_on_page     = 10;
    static private $_page_on         = 1;
    static private $_pagination_data = array();
    static private $_base_url        = Null;
    static private $_num_pages       = Null;

    static public function get_data()
    {
        self::_run_pagination();
        return Element::div(implode("", self::$_pagination_data), Null, "pagination");
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
       $base_url = trim($base_url, "/") . "/"; 
       self::$_base_url = $base_url;
    }

    static public function get_max_on_page()
    {
        return self::$_max_on_page;
    }   

    static private function _run_pagination()
    {
        self::$_num_pages = ceil(self::$_total_entries/self::$_max_on_page);

        self::_create_previous();
        self::_create_before();
        self::$_pagination_data["now"] = self::_create_link(self::$_page_on, self::$_page_on, "page_active");
        self::_create_after();
        self::_create_next();
    }

    static private function _create_previous()
    {
        if(self::$_page_on >= 2) 
            self::$_pagination_data["previous"] = self::_create_link(self::$_page_on - 1, "Prev", "page_button");
    }

    static private function _create_next()
    {
        if(self::$_page_on <= self::$_num_pages - 1 )
            self::$_pagination_data["next"] = self::_create_link(self::$_page_on + 1, "Next", "page_button");
    }

    static private function _create_before()
    {
        if(self::$_num_pages > 1)
        {
            $page_start = (self::$_page_on - 4 >= 1)?self::$_page_on - 4:1;
            for ($i=$page_start; $i < self::$_page_on; $i++) { 
                    self::$_pagination_data[$i] = self::_create_link($i, $i , "page_inactive");
                }
        }
    }

    static private function _create_after()
    {
        if(self::$_num_pages > 1)
        {
            $page_to = (self::$_num_pages <= self::$_page_on + 5)?self::$_num_pages:self::$_page_on + 5;
            for ($i=self::$_page_on + 1; $i < $page_to; $i++) { 
                    self::$_pagination_data[$i] = self::_create_link($i, $i , "page_inactive");
                }
        }
    }

    static private function _create_link($page,$text, $class)
    {
        return Element::a(self::$_base_url . $page, $text, Null, $class);
    }
}