<?PHP
 /**
 *    FormProcess class
 *    in folder where class is stored must also
 *    contain the folder form with 
 *    * file_validator.class.php
 *    * post_validator.class.php
 *
 *  
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
 * @category   form processing
 * @package    FormProcess
 * @subpackage File_Validator, Post_Validator
 * @author     Phobia <morphius.inc@upcmail.nl>
 * @copyright  2012 Phobia.
 * @license    http://www.opensource.org/licenses/mit-license.php  MIT License
 * @version    v1.0
 * @link       http://[ Your website ]
 */

class FormProcess
{
    private $_post_fields       = array();
    private $_current_post      = Null;
    private $_current_post_type = Null;
    private $_errors_found      = False;
    private $_validator_post    = Null;
    private $_validator_files   = Null;

    /**
     * data will store and enable validation of $_POST datafields
     * @param  array  $posted_field     $_POST datafield
     * @return object(FormProcess)      return the FormProcess class
     */
    public function post($posted_field)
    {
        if(isset($_POST[$posted_field])) {
            $this->_post_fields[$posted_field] = $_POST[$posted_field];
            $this->_current_post             = $posted_field;
            $this->_current_post_type        = 'post';
        }
        return $this;
    }

    /**
     * Files will store and enable validation of $_FILES data
     * @param  array  $posted_file     $_FILES one uploaded file or an array
     * @return object(FormProcess)     return the FormProcess class
     */
    public function files(array $posted_file)
    {
        if(isset($_FILES[$posted_file])) {
            $this->_post_fields[$posted_file] = $_FILES[$posted_file];
            $this->_current_post              = $posted_file;
            $this->_current_post_type         = 'file';
        }
        return $this;
    }

    /**
     * Validate the provided data
     * @param  string $validator       the validator to test the data agianst
     * @param  mixed $arg              if needed the data to test
     * @return object(FormProcess)     return the FormProcess class
     */
    public function validate($validator, $arg = Null)
    {
        if($this->_current_post_type == "file") {
            if($this->_validator_files == Null) {
                include 'form/File_validator.class.php';
                $this->_validator_files = File_Validator;
            } 
            $error = $this->_validator_files->{$validator}($this->_current_post, $arg);
            if($error) 
                {
                    $this->_errors_found = true;
                    FormError::add($this->_current_post, array($validator => $error));
                }
        } elseif ($this->_current_post_type == "post") {
            if($this->_validator_post == Null) {
                include 'form/Post_validator.class.php';
                $this->_validator_post = New Post_Validator;
            }
            $error = $this->_validator_post->{$validator}($this->_current_post, $arg);
            if($error) 
                {
                    $this->_errors_found = true;
                    FormError::add($this->_current_post, array($validator => $error));
                }
        }
        return $this;
    }

    /**
     * Fetch the data of a provided field or all the data in the class
     * @param  string $post_field name of the field or default is null
     * @return mixed              requested data string or array
     */
    public function fetch($post_field = Null)
    {
        if($post_field == Null) return $this->_post_fields;
        if(isset($this->_post_fields[$post_field])) return $this->_post_fields[$post_field];
        return Null;
    }
    
    public function valid()
    {
        return ($this->_errors_found)?false:true;
    }
}