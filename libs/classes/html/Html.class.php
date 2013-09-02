<?PHP
/**
*       
*/
class Html
{
    protected $_form       = array();
    protected $_jquery_lib = Null;
    protected $_nl         = PHP_EOL;

    public function __construct($title = false)
    {
        if($title) {
            $this->_form["head"]["title"] = "<title>".$title."</title>".$this->_nl;
        }
    }

    public function css($Url)
    {
        if(is_array($Url)) {
            foreach ($Url as $css) {
                $this->_form["head"]["css"][] = '<link rel="stylesheet" href="'.$css.'" style="text/stylesheet" />'.$this->_nl;
            }
        } else
            $this->_form["head"]["css"][] = '<link rel="stylesheet" href="'.$Url.'" style="text/stylesheet" />'.$this->_nl;
        
        return $this;
    }

    public function meta_tags(array $meta_tags)
    {
        $this->_form["head"]["meta"] = $meta_tags;
        return $this;
    }

    public function load_jquery_lib($load_jquery)
    {
        $libs = Null;
        if($load_jquery)
            $libs = '<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>'.$this->_nl;
        $this->_jquery_lib = $libs;
    }

    public function body($content)
    {
       $this->_form["body"] = "<body>" . $this->_nl . $content . $this->_nl . $this->_nl . "</body>" . $this->_nl;
       return $this;
    }

    public function display($content = Null)
    {
        $display  = "<!DOCTYPE html>".$this->_nl."<html>".$this->_nl."<head>".$this->_nl;
        $display .= $this->_build_css().$this->_nl;
        $display .= $this->_form["head"]["title"];
        $display .= $this->_build_meta_tags().$this->_nl."</head>".$this->_nl;
        $display .= $this->_form["body"];
        $display .= $this->_jquery_lib;
        $display .= "</html>";

        return $display;
    }


    private function _build_css()
    {
        $data = null;
        if(isset($this->_form["head"]["css"])) {
            foreach ($this->_form["head"]["css"] as $css) {
                $data .= $css.$this->_nl;
            }
            return $data;
        }
        return Null;
    }

    private function _build_meta_tags()
    {
        $data = Null;
        if(isset($this->_form["head"]["meta"])) {
            foreach ($this->_form["head"]["meta"] as $tags => $value) {
                $data .= '<meta name="'.$tags.'" content="'.$value.'">'.$this->_nl;
            }
        return $data;
        }
        return Null;
    }
            

}// end of class