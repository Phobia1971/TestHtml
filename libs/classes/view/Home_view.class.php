<?PHP
/**
* 
*/
class Home_view extends Main_base_view
{
    
    function __construct()
    {
        parent::__construct();
    }

    public function last_post(array $last_post)
    {
        $title_link  = Element::a("post/view/" . strtolower($last_post["user_nick"]) . "/" .strtolower(str_replace(" ", "-", $last_post["title"])),$last_post["title"],Null, "post_title_link");
        $post_title  = Element::span($title_link, Null,"post_title");
        $poster_link = Element::a("post/poster/" . strtolower($last_post["user_nick"]), ucfirst($last_post["user_nick"]),Null,"poster_title_link");
        $user_nick   = Element::p("Posted by: ". $poster_link,Null,"post_data");
        $user_posted = Element::p(Strings::format_date($last_post["posted"]),Null,"post_data");
        $user_view   = Element::p("views: ".$last_post["view"],Null,"post_data");
        $user_reply  = Element::p("repleis: ".$last_post["reply"],Null,"post_data");
        $post_data   = Element::div($user_nick.$user_posted.$user_reply.$user_view, Null,"post_data_wrapper");

        $post_text   = Element::div($last_post["content"], Null, "post_content");

        $this->post = Element::div($post_title.$post_data.$post_text, Null,"post_container");
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