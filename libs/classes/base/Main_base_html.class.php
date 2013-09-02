<?PHP
/**
* 
*/
class Main_base_html
{
    private $_HTML      = Null;
    private $_body      = Null;
    private $_meta_tags = Null;
    private $_css       = Null;


    function __construct(Html $html)
    {
        $this->_HTML = $html;
    }

    public function load_body($body)
    {
        $this->_body = $body;
    }

    public function set_meta_tags(array $meta_tags)
    {
        $this->_meta_tags = $meta_tags;
    }

    public function set_css($css_url)
    {
        if(is_array($css_url)) {
            foreach ($css_url as $css) {
                $this->_css[] = $css;
            }
        } else 
            $this->_css[] = $css;
    }

    public function load_jquery_lib($jquery)
    {
        $this->_HTML->load_jquery_lib($jquery);
    }

    public function render()
    {
        $this->_HTML ->css($this->_css)
                     ->meta_tags($this->_meta_tags)
                     ->body($this->_body);
                     
    }

    public function parse()
    {
        return $this->_HTML->display();
    }
}