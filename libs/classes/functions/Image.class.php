<?php

/**
 * Description of Image
 *
 * @author Phobia
 *
 *      //////////////////////////////////////////////////////////////
 *       Loader::class_file("Image.php");
 *       $im = new Image(LOGINBAR_ROOT."css/images/test/setting.png");
 *       $im->SetNewName("Morphius", LOGINBAR_ROOT."css/images/");
 *       $im->SetNewSize(100, 100);
 *       $im->Save();
 *      //////////////////////////////////////////////////////////////
 */
class Image {

    private $_resource = Null;
    private $_ext = Null;
    private $_prefix = "tumb_";
    private $_usePrefix = False;
    private $_path = Null;
    private $_newName = Null;
    private $_newSize = Null;
    private $_maxFileSize = 2097152; // max is set to 2Mb
    private $_imgType = array('gif', 'jpg', 'png');
    public $error = Null;

    public function __construct($resource) {
        if (!empty($resource)) {
            if (!is_array($resource)) {
                $data = $this->_getImageData($resource);
                if (is_readable($resource) && $data) {
                    $this->_resource["name"] = array_pop(explode("/", $resource));
                    $this->_resource["type"] = $data[2];
                    $this->_resource["size"] = filesize($resource);
                    $this->_resource["tmp_name"] = $resource;
                    $this->_resource["dimension"] = array($data[0], $data[1]);
                } else {
                    throw new Exception("ERROR: Please enter an provid a valid resource");
                }
            } else {
                $resource["dimension"] = getimagesize($resource["tmp_name"]);
                $this->_resource = $resource;
            }
        } else {
            throw new Exception("ERROR: Please enter an provid a valid resource");
        }

        if ($this->_fileSizeCheck() == false)
            $this->error[] = "The provided source is too big in filesize max: $this->_maxFileSize";
        if ($this->_validExtention() == false)
            $this->error[] = "The provided source has an invalid extention";
    }

    /*
     *              public functions
     */

    public function SetNewName($newName, $path) {
        if (!empty($newName))
            $this->_newName = strtolower(array_shift(explode(".", $newName)));
        else
            $this->_newName = strtolower(array_shift(explode(".", $this->_resource["name"])));

        if (!empty($path))
            $this->_path = rtrim($path, "/") . "/";
        else
            throw new Exception("ERROR: There is no path provided");
    }

    public function SetNewSize($width, $heigth) {
        if (!empty($width) && !empty($heigth) && is_numeric($width) && is_numeric($heigth))
            $this->_newSize = array($width, $heigth);
    }

    public function SetPreFix($prefix, $usePreFix = True) {
        if (!empty($prefix))
            $this->_prefix = $prefix;
        if (is_bool($usePreFix))
            $this->_usePrefix = $usePreFix;
    }

    public function Save($asTumb = True) {
        if (!is_bool($asTumb))
            $asTumb = false;

        if ($asTumb == true)
            $newName = $this->_prefix . $this->_newName . '.' . $this->_ext;
        else
            $newName = $this->_newName . '.' . $this->_ext;
        // calculate new image size
        $this->_calculateResize();
        // create copy
        $this->_createCopy();
        // create new canvas
        $nm = imagecreatetruecolor($this->_newSize[0], $this->_newSize[1]);
        // create new image
        imagecopyresized($nm, $this->_resource['image'], 0, 0, 0, 0, $this->_newSize[0], $this->_newSize[1], $this->_resource['dimension'][0], $this->_resource['dimension'][1]);
        // save the new image
        return $this->_saveImage($nm, $newName);
    }

    /*
     *              private functions
     */

    private function _calculateResize() {
        if ($this->_newSize == Null) {
            $this->_newSize = $this->_resource['dimension'];
        } else if($this->_resource['dimension'][0] <= $this->_newSize[0] && $this->_resource['dimension'][1] <= $this->_newSize[1]) {
            $this->_newSize = $this->_resource['dimension'];
        } else {
            if ($this->_resource['dimension'][0] == $this->_resource['dimension'][1]) {
                $this->_newSize[1] = $this->_newSize[0];
            } elseif ($this->_resource['dimension'][0] <= $this->_resource['dimension'][1]) {
                $ratio = ($this->_newSize[1] / $this->_resource['dimension'][1]);
                $this->_newSize[0] =floor( $this->_resource['dimension'][0] * $ratio);
                $this->_newSize[1] = floor($this->_resource['dimension'][1] * $ratio);
            } elseif ($this->_resource['dimension'][0] >= $this->_resource['dimension'][1]) {
                $ratio = ($this->_newSize[0] / $this->_resource['dimension'][0]);
                $this->_newSize[0] = floor($this->_resource['dimension'][0] * $ratio);
                $this->_newSize[1] = floor($this->_resource['dimension'][1] * $ratio);
            }
        }
    }

    private function _fileSizeCheck() {
        return ($this->_resource['size'] <= $this->_maxFileSize) ? True : False;
    }

    private function _getImageData($source) {
        $data = getimagesize($source);
        $image_type = $data[2];
        if (in_array($image_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP))) {
            return $data;
        }
        return false;
    }

    private function _validExtention() {
        $this->_ext = strtolower(array_pop(explode(".", $this->_resource["name"])));
        return in_array($this->_ext, $this->_imgType);
    }

    private function _createCopy() {
        switch ($this->_ext) {
            case "jpg":
                $this->_resource["image"] = imagecreatefromjpeg($this->_resource["tmp_name"]);
                break;
            case "gif":
                $this->_resource["image"] = imagecreatefromgif($this->_resource["tmp_name"]);
                break;
            case "png":
                $this->_resource["image"] = imagecreatefrompng($this->_resource["tmp_name"]);
                break;
        }
    }

    private function _saveImage($image, $newFilename) {
        switch ($this->_ext) {
            case "jpg":
                return imagejpeg($image, $this->_path.$newFilename);
                break;
            case "gif":
                return imagegif($image, $this->_path.$newFilename);
                break;
            case "png":
                return imagepng($image, $this->_path.$newFilename);
                break;
        }



    }

}