<?PHP
/**
* 
*/
class Post_view extends Main_base_view
{
    private $mockup = Null;
    function __construct()
    {
        parent::__construct();
    }

    public function requested_post(array $requested_post)
    {
        
        $post_title  = Element::span($requested_post["title"], Null,"post_title");
        
        $poster_link = Element::a(self::$_url_base . "post/poster/" . strtolower($requested_post["user_nick"]), ucfirst($requested_post["user_nick"]),Null,"poster_title_link");
        $user_nick   = Element::p("Posted by: ". $poster_link,Null,"post_data");
        
        $user_posted = Element::p(Strings::format_date($requested_post["posted"]),Null,"post_data");
        $user_view   = Element::p("views: ".$requested_post["view"],Null,"post_data");
        $user_reply  = Element::p("repleis: ".$requested_post["reply"],Null,"post_data");
        $post_data   = Element::div($user_nick.$user_posted.$user_reply.$user_view, Null,"post_data_wrapper");

        $post_text   = Element::div($requested_post["content"], Null, "post_content");

        $this->post = Element::div($post_title.$post_data.$post_text, Null,"post_container");
    }

    public function post_replies($repleis_array)
    {
        if(!empty($repleis_array)) 
        {
            foreach ($repleis_array as $reply) 
            {
                if($reply["reply"]["ban"] == "N")
                {
                    $poster_link = Element::a(self::$_url_base . "post/poster/" . strtolower($reply["profile"]["user_name"]), ucfirst($reply["profile"]["user_name"]),Null,"poster_title_link");
                    $user_nick   = Element::p("reply by: ". $poster_link,Null,"post_data");

                    $user_posted = Element::p(Strings::format_date($reply["reply"]["reply_date"]),Null,"post_data");
                    $post_data   = Element::div($user_nick . $user_posted, Null,"post_data_wrapper");

                    $post_text   = Element::div($reply["reply"]["reply_text"], Null, "post_content");

                    $this->post .= Element::div($post_data . $post_text, Null,"post_container");
                }
            }
        }
    }

    public function requested_poster($poster_data)
    {
        if(empty($poster_data)) $data = "No Poster found..."; else $data = Null;
        foreach ($poster_data as $key => $value) {
            $data .= Element::p($key . ": ".$value,Null,"post_data");
        }
        $this->post = Element::div($data, Null,"post_container");
    }

    public function sub_main_data($sub_data)
    {
        $this->mockup = Element::div($sub_data);
    }

    public function _build_body()
    {
        $content = Element::div( Element::div($this->post
                                            .$this->mockup
                                            , Null
                                            , "holder")
                                 ,"central_content"
                                );

        $this->_body = Element::div(
                            Element::div($this->_header_body
                                        , "header_wrapper"
                            )     // $header div
                           .Element::div($this->login_error_display
                                        .$content
                                        .$this->_build_side_bar(), "content_wrapper"
                            )   // content div
                           .Element::div($this->_build_footer()
                                        , "footer_wrapper"
                           )     // footer div
                     ,"wrapper_global" // div id
                     );
    }

}