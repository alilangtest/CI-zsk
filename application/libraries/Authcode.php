<?php

// ------------------------------------------------------------------------


/**
 * CodeIgniter Authcode Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		wintion@gmail.com
 * @link		http://www.kandejian.com
 */
class Authcode
{
    public $CI;
    //字体路径
    public $fontPath;
    public $image;
    //生成几位验证码
    public $charLen = 4; 
    //验证码字符
    public $arrChr = array();
    //图片宽
    public $width = 100; 
    //图片高
    public $height = 30; 
    //字体大小
    public $fontSize = 20;
    //背景色
    public $bgcolor = "#ffffff"; 
    //生成杂点
    public $showNoisePix = true; 
    //生成杂点数量
    public $noiseNumPix = 800; 
    //生成杂线
    public $showNoiseLine = true; 
    //生成杂线数量
    public $noiseNumLine = 3; 
    //边框，当杂点、线一起作用的时候，边框容易受干扰
    public $showBorder = true; 
    public $borderColor = "#000000";
    
    public $session_fix = null;

    public function __construct()
    {
        $this->CI = & get_instance();
        
        //字体文件
        $this->fontPath = realpath(dirname(__FILE__) . '/fonts/');
        //数字字母验证码
        //$this->arrChr = array_merge(range(1, 9) , range('A', 'Z'));
        ////纯字母验证码
        //$this->arrChr = range('A', 'Z');
        //纯数字验证码
        $this->arrChr = range(0, 9);
    }

    /**
     * 显示验证码
     *
     */
    public function show()
    {
        $this->image = imageCreate($this->width, $this->height);
        $this->back = $this->getColor($this->bgcolor);
        imageFilledRectangle($this->image, 0, 0, $this->width, $this->height, $this->back);
        $size = $this->width / $this->charLen - 4;

        if ($size > $this->height) 
        {
            $size = $this->height;
        }

        $left = ($this->width - $this->charLen * ($size + $size / 10)) / $size + 5;
        $code='';

        for($i = 0; $i < $this->charLen; $i ++) 
        {
            $randKey = rand(0, count($this->arrChr) - 1);
            $randText = $this->arrChr[$randKey];
            $code .= $randText;
            $textColor = imageColorAllocate($this->image, rand(0, 100), rand(0, 100), rand(0, 100));
            $font = $this->fontPath . '/' . rand(1, 5) . ".ttf";
            $randsize = rand($size - $size / 10, $size + $size / 10);
            $location = $left + ($i * $size + $size / 10);
            @imagettftext($this->image, $this->fontSize, rand(- 18, 18), $location, 25, $textColor, $font, $randText);
        }

        if ($this->showNoisePix == true) 
        {
            $this->setNoisePix();
        }
        if ($this->showNoiseLine == true) 
        {
            $this->setNoiseLine();
        }

        if ($this->showBorder == true) 
        {
            $this->borderColor = $this->getColor($this->borderColor);
            imageRectangle($this->image, 0, 0, $this->width - 1, $this->height - 1, $this->borderColor);
        }

        $this->CI->session->set_userdata($this->session_fix . "auth_code", $code);        

        header("Content-type: image/jpeg");
        imagejpeg($this->image);
        imagedestroy($this->image);
    }

    /**
     * 显示验证码的JS调用
     *
     */
    public function showScript()
    {
        //显示验证码
        echo "var img_src = '/login/show/?';\n";
        echo "document.writeln('<img id=\"authcode\" src=\"' + img_src + Math.random() + '\" style=\"cursor:hand;\" onclick=\"this.src=img_src + Math.random();\" alt=\"点击更换图片\">');";
    }

    /**
     * 检查验证码是否正确
     *
     * @param string $auth_code
     * @return bool
     */
    public function check($auth_code = null)
    {
        //echo '用户写的：'.$auth_code.'</br>';
        //echo 'session的：'.$this->CI->session->userdata('auth_code').'</br>';
        if(empty($auth_code))
            return false;
        
        return ($this->CI->session->userdata($this->session_fix . "auth_code") && $auth_code) ? ($this->CI->session->userdata($this->session_fix . "auth_code") === $auth_code) : false;
    }

    public function getColor($color)
    {
        $color = preg_replace("/^#/", "", $color);
        $r = $color[0] . $color[1];
        $r = hexdec($r);
        $b = $color[2] . $color[3];
        $b = hexdec($b);
        $g = $color[4] . $color[5];
        $g = hexdec($g);
        $color = imagecolorallocate($this->image, $r, $b, $g);

        return $color;
    }

    public function setNoisePix()
    {
        for($i = 0; $i < $this->noiseNumPix; $i ++) 
        {
            $randColor = imageColorAllocate($this->image, rand(0, 255), rand(0, 255), rand(0, 255));
            imageSetPixel($this->image, rand(0, $this->width), rand(0, $this->height), $randColor);
        }
    }

    public function setNoiseLine()
    {
        for($i = 0; $i < $this->noiseNumLine; $i ++) 
        {
            $randColor = imageColorAllocate($this->image, rand(0, 255), rand(0, 255), rand(0, 255));
            imageline($this->image, rand(1, $this->width), rand(1, $this->height), rand(1, $this->width), rand(1, $this->height), $randColor);
        }
    }
}
