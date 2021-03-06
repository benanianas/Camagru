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
            $data = $this->model->getPosts($_SESSION['id']);
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                if($_SESSION['token'] != $_POST['token'])
                {
                    unset($_SESSION['token']);
                    $_SESSION['token'] = bin2hex(random_bytes(12));
                    $this->view('publish/camera', $data);
                    return;
                }
                if(isset($_POST['camera']))
                {
                    

                    if (!file_exists('/var/www/html/img/tmp')) {
                        chmod('/var/www/html/img', 0777);
                        mkdir('/var/www/html/img/tmp', 0777);
                        chmod('/var/www/html/img/tmp', 0777);
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
                        unlink($filePath);

                        // $dest = imagecreatefrompng($filePath);
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
                        $tmp = explode('/',$_POST['imgpath']);
                        $img = end($tmp);
                        unlink('/var/www/html/img/tmp/'.$img);
                    }
                    else
                    {
                        if (!file_exists('/var/www/html/img/posts')) {
                            mkdir('/var/www/html/img/posts', 0777);
                            chmod('/var/www/html/img/posts', 0777);
                        }
                        $tmp = explode('/',$_POST['imgpath']);
                        $img = end($tmp);
                        rename('/var/www/html/img/tmp/'.$img, '/var/www/html/img/posts/'.$img);
                        $this->model->postIt($_SESSION['id'], '/img/posts/'.$img);
                        echo URLROOT.'/img/posts/'.$img;
                    }
                }
                else if(isset($_POST['delete']))
                {
                    $tmp = explode('/',$_POST['imgpath']);
                    $img = end($tmp);
                    if($this->model->deletePost($_SESSION['id'], '/img/posts/'.$img))
                        unlink('/var/www/html/img/posts/'.$img); 
                }
                        
            }
            else
            {
                $this->view('publish/camera', $data);
            }
        }
        else
        {
            $data['link'] = '/camera';
            $this->view('account/login', $data);
        }
    }

}