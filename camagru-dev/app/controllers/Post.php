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
                if($_POST['camera'])
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
                    imagecopyresampled ($dest, $src, 77, 57, 0, 0, 100, 96, 128, 128);
                    //header('Content-Type: image/png');
                    imagepng($dest, '/var/www/html/img/tmp/'.$_SESSION['id'].'.png');
                }
                else
                {
                    $imgData = str_replace(' ','+',$_POST['photo']);
                    $imgData =  str_replace('data:image/png;base64,','',$imgData);
                    $imgData =  str_replace('data:image/jpeg;base64,','',$imgData);
                    $imgData = base64_decode($imgData);
                
                    $filePath = '/var/www/html/img/tmp/'.$_SESSION['id'].'.png';
                    
                    
                    $dest = imagecreatefromstring($imgData);
                    imagepng($dest, $filePath);
                    $param = getimagesize('/var/www/html/img/tmp/'.$_SESSION['id'].'.png');

                    $dest = imagecreatefrompng($filePath);
                    $src = imagecreatefrompng('/var/www/html/img/'.$_POST['selected'].'.png');
                    imagecopyresampled ($dest, $src, $param[1]/8, $param[1]/8, 0, 0, $param[0]/5, $param[0]/5, 128, 128);
                    imagepng($dest, '/var/www/html/img/tmp/'.$_SESSION['id'].'.png');
                }
                        
            }
        }
        else
            $this->view('account/login', $data);
    }

}