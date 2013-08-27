<?PHP
/**
* 
*/
class Error_controler
{
    
    function __construct()
    {
        # load the page make up
    }

    public function process($error_messages = Null)
    {
                echo '<h1>Error page:</h1><hr/><pre>';
                print_r($error_messages);
                echo '</pre>';  
    }
}