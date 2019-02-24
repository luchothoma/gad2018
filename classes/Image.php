<?php
class Image {
    private $_img = null;

    function __construct($imgPath) {
        switch (explode(".",$imgPath)[1])
        {
            case 'jpg':
                $this->_img = imagecreatefromjpeg($imgPath);
                break;
            case 'jpeg':
                $this->_img = imagecreatefromjpeg($imgPath);
                break;
            case 'png':
                $this->_img = imagecreatefrompng($imgPath);
                break;
            default:
                throw exception("Not allowed type: ".$imgPath);
                break;
        }
    }

    public function width(): int {
        return imagesx($this->_img);
    }

    public function height(): int {
        return imagesy($this->_img);
    }

    public function getPixelRGBA(int $x, int $y): stdClass {
        $índice_color = imagecolorat($this->_img, $x, $y);

        // hacerlo legible para humanos
        $color_tran = imagecolorsforindex($this->_img, $índice_color);

        return (object) $color_tran;
    }
}