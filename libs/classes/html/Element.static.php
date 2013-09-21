<?PHP
/**
*   static class to build html elements dynamicly
*
* @author Phobia <morphius.inc@upcmail.nl>
*/
class Element
{
    static protected $_nl   = PHP_EOL;

    /**
     * Create a div element dynamicly
     * @param  string $content the content to put into the div
     * @param  string $id      name of the css id
     * @param  string $class   name of the css class
     * @return string          the builded div element
     */
    static function div($content, $id = Null, $class = Null) 
    {
        return '<div ' . self::_id($id).self::_class($class) . '>'
        .self::$_nl.$content.'</div>'.self::$_nl;
    }
    /**
     * Create a span element dynamicly
     * @param  string $content the content to put into the span
     * @param  string $id      name of the css id
     * @param  string $class   name of the css class
     * @return string          the builded span element
     */
    static function span($content, $id = Null, $class = Null)
    {
        return '<span ' . self::_id($id).self::_class($class) . '>'
        .self::$_nl.$content.'</span>'.self::$_nl;
    }
    /**
     * Create a Unorderd list dynamicly with or without a link
     * @param  array   $list_items an array with list items or an assoc array whit name and link
     * @param  string  $id         name of the css id
     * @param  string  $class      name of the css class
     * @param  boolean $make_link  add a a-tag true/false 
     * 
     * @return string              the builded ul with li's and a-tags if wanted
     *
     * eg: build a navigation unorded list
     * 
     *  $nav_array = array ( "Home" => "#"
     *                ,"Content" => "#"
     *                ,"Portfolio" => "#"
     *                ,"About us" => "#"
     *                ,"Contact" => "#");    
     *
     *  $header = Element::ul($nav_array, Null, "nav_bar", true);
     * 
     */
    static function ul(array $list_items, $id = Null, $class = Null, $make_link = False)
    {
        $display = '<ul'.self::_id($id).self::_class($class).'>'.self::$_nl;
        foreach ($list_items as $list_item => $value) {
            $display .= '<li>'.self::$_nl;
            if($make_link) {
                $display .= self::a($value, $list_item).self::$_nl;
            } else {
                $display .= $value;
            }
            $display .= "</li>".self::$_nl;
        }
        $display .= "</ul>".self::$_nl;

        return $display;
    }
    /**
     * Create a a-tag dynamicly
     * @param  string $link  the href url
     * @param  string $text  name of the title and the link text
     * @param  string $id    name of the css id
     * @param  string $class name of the css class
     * 
     * @return string        the builded a-tag link
     */
    static function a($link, $text, $id = Null, $class = Null)
    {
        return '<a'.self::_id($id).self::_class($class).' href="'. $link.'" title="'.$text.'" >'.$text.'</a>';
    }
    /**
     * Create a p-tag dynamicly 
     * @param  string $content the content ot put into the p-tag
     * @param  string $id      name of the css id
     * @param  string $class   name of the css class
     * 
     * @return string          the builded p-tag
     */
    static function p($content, $id = Null, $class = Null)
    {
        return '<p ' . self::_id($id) . self::_class($class) . '>'.self::$_nl.$content.'</p>'.self::$_nl;
    }
    /**
     * Create dynamicly line breaks
     * @param  integer $num number of breaks to add
     * @return string       the requiered breaklines
     */
    static function br($num = 1)
    {
        $display = Null;
        for ($i=0; $i <= $num ; $i++) { 
            $display .= "<br />".self::$_nl;
        }
        return $display;
    }
    /**
     * Create a image tag dynamicly
     * @param  string $source the image source url
     * @param  string $id     name of the css id
     * @param  string $class  name of the css class
     * 
     * @return string         the builded image tag
     */
    static function img($source, $id = Null, $class = Null)     
    {
        $file_name = array_pop(explode("/", $source));
        $name      = array_shift(explode(".", $file_name));
        return '<img' . self::_id($id) . self::_class($class) . ' src="'.$source.'" title="'.$name.'" alt="'.$name.'" />'.self::$_nl;
    }

    /*    
            The private static functions
     */

    private static function _id($id)
    {
        return ($id == Null)?Null:' id="'.$id.'"';
    }
    private static function _class($class)
    {
        return ($class == Null)?Null:' class="'.$class.'"';
    }

}