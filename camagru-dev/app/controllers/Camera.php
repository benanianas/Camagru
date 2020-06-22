<?php

Class Camera extends Controller{

    public function __construct()
    {
        $this->model = $this->model('Publisher');
    }

  
    public function index()
    {
        if (isLoggedIn())
        {

            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                if(isset($_POST['camera']))
                {
                    // $files = glob('/var/www/html/img/posts/*');  
                    // foreach($files as $file) { 
                    //     if(is_file($file))  
                    //     unlink($file);
                    // } 

                    if (!file_exists('/var/www/html/img/tmp')) {
                        mkdir('/var/www/html/img/tmp', 0777);
                    }

                    if($_POST['camera'])
                    {
                        $imgData = str_replace(' ','+',$_POST['photo']);
                        $imgData =  str_replace('data:image/png;base64,','',$imgData);
                        $imgData = base64_decode($imgData);
                    
                        $fileName = $_SESSION['id'].bin2hex(random_bytes(8)).time();
                        $filePath = '/var/www/html/img/tmp/'.$fileName.'.png';
                        
                        // $file = fopen($filePath, 'w');
                        // fwrite($file, $imgData);
                        // fclose($file);
                        $dest = imagecreatefromstring($imgData);
                        imagepng($dest, $filePath);

                        $dest = imagecreatefrompng($filePath);
                        $src = imagecreatefrompng('/var/www/html/img/'.$_POST['selected'].'.png');
                        imagecopyresampled ($dest, $src, 77, 57, 0, 0, 100, 96, 128, 128);
                        //header('Content-Type: image/png');
                        imagepng($dest, '/var/www/html/img/tmp/'.$fileName.'.png');
                        echo URLROOT.'/img/tmp/'.$fileName.'.png';
                    }
                    else
                    {
                        $imgData = str_replace(' ','+',$_POST['photo']);
                        $imgData =  str_replace('data:image/png;base64,','',$imgData);
                        $imgData =  str_replace('data:image/jpeg;base64,','',$imgData);
                        $imgData = base64_decode($imgData);
                    
                        $fileName = $_SESSION['id'].bin2hex(random_bytes(8)).time();
                        $filePath = '/var/www/html/img/tmp/'.$fileName.'.png';
                        
                        
                        $dest = imagecreatefromstring($imgData);
                        imagepng($dest, $filePath);
                        $param = getimagesize('/var/www/html/img/tmp/'.$fileName.'.png');

                        $dest = imagecreatefrompng($filePath);
                        $src = imagecreatefrompng('/var/www/html/img/'.$_POST['selected'].'.png');
                        $mid = ($param[1]+$param[2])/6;
                        imagecopyresampled ($dest, $src, $param[1]/10, $param[0]/10, 0, 0, $mid, $mid, 128, 128);
                        imagepng($dest, '/var/www/html/img/tmp/'.$fileName.'.png');
                        echo URLROOT.'/img/tmp/'.$fileName.'.png';
                    }
                }
                else if(isset($_POST['post']))
                {
                    if(!$_POST['post'])
                    {
                        $img = end(explode('/',$_POST['imgpath']));
                        unlink('/var/www/html/img/tmp/'.$img);
                    }
                    else
                    {
                        if (!file_exists('/var/www/html/img/posts')) {
                            mkdir('/var/www/html/img/posts', 0777);
                        }
                        $img = end(explode('/',$_POST['imgpath']));
                        rename('/var/www/html/img/tmp/'.$img, '/var/www/html/img/posts/'.$img);
                        $this->model->postIt($_SESSION['id'], '/img/posts/'.$img);
                        echo URLROOT.'/img/posts/'.$img;
                    }
                }
                else if(isset($_POST['delete']))
                {
                    $img = end(explode('/',$_POST['imgpath']));
                    if($this->model->deletePost($_SESSION['id'], '/img/posts/'.$img))
                        unlink('/var/www/html/img/posts/'.$img); 
                }
                        
            }
            else
            {
                $data = $this->model->getPosts($_SESSION['id']);
                $this->view('publish/camera', $data);
                // print_r($data);
            }
        }
        else
            $this->view('account/login', $data);
    }

}