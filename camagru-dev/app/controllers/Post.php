<?php

Class Post extends Controller{

    public function __construct()
    {
        $this->model = $this->model('Publisher');
    }

    public function index()
    {
        if (isLoggedIn())
        {
            //$dest = imagecreatefrompng('/var/www/html/img/tmp/1.png');
            $this->view('post/camera', $data);

            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {

                $imgData = str_replace(' ','+',$_POST['photo']);
                $imgData =  str_replace('data:image/png;base64,','',$imgData);
                $imgData = base64_decode($imgData);
            
                $filePath = '/var/www/html/img/tmp/'.$_SESSION['id'].'.png';
                
                // $file = fopen($filePath, 'w');
                // fwrite($file, $imgData);
                // fclose($file);
                $dest = imagecreatefromstring($imgData);
                imagepng($dest, $filePath);

                $dest = imagecreatefrompng($filePath);
                $src = imagecreatefrompng('/var/www/html/img/'.$_POST['selected'].'.png');
                imagealphablending($dest, true);
                imagesavealpha($dest, true);
                imagecopyresampled ($dest, $src, 77, 60, 0, 0, 100, 96, 128, 128);
                //header('Content-Type: image/png');
                // imagealphablending($dest, false); 
                // imagesavealpha($dest,true);
                imagepng($dest, '/var/www/html/img/tmp/test.png');
                imagedestroy($dest);
                imagedestroy($src);
                        
                // var_dump(getimagesize('/var/www/html/img/tmp/test.png'));
            }
        }
        else
            $this->view('account/login', $data);
    }

}