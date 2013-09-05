<?PHP
/**
 * MIT License
 * ===========
 *
 * Copyright (c) 2012 Phobia <morphius.inc@upcmail.nl>
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
 * CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @category   [ Category ]
 * @package    [ Package ]
 * @subpackage [ Subpackage ]
 * @author     Phobia <morphius.inc@upcmail.nl>
 * @copyright  2012 Phonia.
 * @license    http://www.opensource.org/licenses/mit-license.php  MIT License
 * @version    [ 0.1 beta ]
 */

class Server
{

    /**
     * Checks if request method is like the param
     * @param string $request eg: 'GET', 'HEAD', 'POST', 'PUT'
     *
     * @return boolean
     */
    static public function request($request = "POST")
    {
       if($_SERVER["REQUEST_METHOD"] == $request) return true;
    }

    /**
     * Get the server name
     * $_SERVER["SERVER_NAME"]
     *
     * @return string
     */
    static public function name()
    {
        return $_SERVER["SERVER_NAME"];
    }

    static public function http()
    {
       return "http://".$_SERVER["SERVER_NAME"];
    }

    static public function https()
    {
       return "https://".$_SERVER["SERVER_NAME"];
    }

    /**
     * Get the client's ip
     * even if client as been forwarded
     *
     * @return string   => client's ip adress eg: 192.168.10.112
     */
    static public function client_ip()
    {
         $ipaddress = '';
         if (getenv('HTTP_CLIENT_IP'))
             $ipaddress = getenv('HTTP_CLIENT_IP');
         else if(getenv('HTTP_X_FORWARDED_FOR'))
             $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
         else if(getenv('HTTP_X_FORWARDED'))
             $ipaddress = getenv('HTTP_X_FORWARDED');
         else if(getenv('HTTP_FORWARDED_FOR'))
             $ipaddress = getenv('HTTP_FORWARDED_FOR');
         else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
         else if(getenv('REMOTE_ADDR'))
             $ipaddress = getenv('REMOTE_ADDR');
         else
             $ipaddress = 'UNKNOWN';

         return $ipaddress;
    }

    /**
     * Get the request form the uri
     * $_SERVER["REQUEST_URI"]
     *
     * @return string  => request_uro
     */
    static public function uri()
    {
        return $_SERVER["REQUEST_URI"];
    }

    /**
     * Get the server port
     * $_SERVER["SERVER_PORT"]
     *
     * @return integer  => server port
     */
    static public function port()
    {
        return "http://".$_SERVER["SERVER_PORT"]."/";
    }

    static public function user_agent()
    {
        return $_SERVER["HTTP_USER_AGENT"];
    }

    static public function doc_root()
    {
        return $_SERVER["DOCUMENT_ROOT"];
    }
}