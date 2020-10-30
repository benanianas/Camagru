<?php

class Edit extends Controller{
    
    public function __construct()
    {
        $this->model = $this->model('Settings');
    }

    public function index()
    {
        $this->profile();
    }
    public function profile()
    {
        if (isLoggedIn())
        {
            $ret = $this->model->getDataById($_SESSION['id']);
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                if(isset($_POST['photo']))
                {
                    if($_POST['photo'])
                    {
                        if (!file_exists('/var/www/html/img/profiles')) {
                            chmod('/var/www/html/img', 0777);
                            mkdir('/var/www/html/img/profiles', 0777);
                            chmod('/var/www/html/img/profiles', 0777);
                        }
                        $ret = $this->model->getDataById($_SESSION['id']);
                        if ($ret->p_photo != '/img/profile.png')
                            unlink("/var/www/html".$ret->p_photo);
                        $imgData = str_replace(' ','+',$_POST['photo']);
                        $imgData =  str_replace('data:image/png;base64,','',$imgData);
                        $imgData =  str_replace('data:image/jpeg;base64,','',$imgData);
                        $imgData = base64_decode($imgData);
                        
                        $fileName = '/img/profiles/'.$_SESSION['id'].bin2hex(random_bytes(8)).time().'.png';
                        $filePath = '/var/www/html'.$fileName;
                            
                        $this->model->updatePic($fileName, $_SESSION['id']);
                        $img = imagecreatefromstring($imgData);
                        imagepng($img, $filePath);
                        echo URLROOT.$fileName;
                    }
                    else
                    {
                        if ($ret->p_photo != '/img/profile.png')
                        {
                            unlink("/var/www/html".$ret->p_photo);
                            $this->model->updatePic('/img/profile.png', $_SESSION['id']);
                            echo URLROOT.'/img/profile.png';
                        }
                    }
                }
                else
                {
                $data = [
                    'name' => $_POST['name'],
                    'username' => $_POST['username'],
                    'email' => $_POST['email'],
                    'pic' => $ret->p_photo,
                    'name_err' => '',
                    'username_err' => '',
                    'email_err' => ''
                ];

                if(empty($data['name']))
                    $data['name_err'] = 'Please enter your first name';
                else if(!preg_match("/^[a-zA-Z]*$/",$data['name']))
                        $data['name_err'] = 'Should contains only letters';
                else
                    if(strlen($data['name']) > 30)
                        $data['name_err'] = "Enter a name under 30 characters.";


                if(empty($data['username']))
                    $data['username_err'] = 'Please enter a username';
                else if(!preg_match("/^[0-9a-zA-Z_.]*$/",$data['username']))
                    $data['username_err'] = 'Username can only use letters, numbers, underscores';
                else if($data['username'] != $ret->username && $this->model->checkIfUsernameExist($data['username']))
                    $data['username_err'] = 'Username has already been taken';


                if(empty($data['email']))
                    $data['email_err'] = 'Please enter an email';
                else if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
                    $data['email_err'] = 'Please enter an e-mail address';
                else if($data['email'] != $ret->email && $this->model->checkIfEmailExist($data['email']))
                    $data['email_err'] = 'Email has already been taken';
        
                
                if(empty($data['name_err']) && empty($data['username_err']) && empty($data['email_err']))
                {
                    if ($data['name'] != $ret->first_name)
                        $this->model->updateName($data, $_SESSION['id']);
                    if ($data['usename'] != $ret->username)
                        $this->model->updateUsername($data, $_SESSION['id']);
                    if ($data['email'] != $ret->email)
                    {
                        $token = $this->model->updateEmail($data, $_SESSION['id']);
                        flash_msg('msg', 'You changed your email, we sent you a verification mail please verify your email to log in.');
                        $user = [
                            'first_name' => $data['name'],
                            'email' => $data['email']
                        ];
                        sendVerification($user, $token);
                        $this->logout();
                    }
                }
                $this->view('edit/profile', $data);
                }
            }
            else
            {
                $data = [
                    'name' => $ret->first_name,
                    'username' => $ret->username,
                    'email' => $ret->email,
                    'pic' => $ret->p_photo,
                ];

                $this->view('edit/profile', $data);
            }
        }
        else
        {
            $data['link'] = '/edit/profile';
            $this->view('account/login', $data);
        }  
    }
    public function password()
    {
        if (isLoggedIn())
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $data = [
                    'oldpassword' => $_POST['oldpassword'],
                    'newpassword' => $_POST['newpassword'],
                    'c_newpassword' => $_POST['c_newpassword'],
                    'oldpassword_err' => '',
                    'newpassword_err' => '',
                    'c_newpassword_err' => '',
                    'notification' => ''
                ];
                
                $ret = $this->model->getDataById($_SESSION['id']);
                if (empty($data['oldpassword']))
                    $data['oldpassword_err'] = "Please enter a password.";
                else if (!password_verify($data['oldpassword'], $ret->password))
                    $data['oldpassword_err'] = "The password that you've entered is incorrect.";

                if (empty($data['oldpassword_err']))
                {
                    if(empty($data['newpassword']))
                        $data['newpassword_err'] = 'Please enter a password';
                    else
                    {
                        if(strlen($data['newpassword']) < 8)
                            $data['newpassword_err'] = 'password must be at least 8 characters';
                        else if(strlen($data['newpassword']) > 25)
                            $data['newpassword_err'] = 'password too long!';
                        else if(!preg_match('#[A-Z]#', $data['newpassword']) || !preg_match('#[a-z]#', $data['newpassword']) || !preg_match('#[\W]#', $data['newpassword']))
                            $data['newpassword_err'] = 'password should contain at least :<br>• one uppercase character<br>• one lowercase character<br>• one special character';   
                    }
        
        
                    if(empty($data['c_newpassword']) && empty($data['newpassword_err']))
                        $data['c_newpassword_err'] = 'Please Confirm your password';
                    else{
                            if($data['newpassword'] != $data['c_newpassword'] && empty($data['newpassword_err']))
                                $data['c_newpassword_err'] = 'Passwords do not match';
                    }
                    if($data['newpassword_err'])
                    $data['c_newpassword'] = '';
                }
                if (empty($data['newpassword_err']) && empty($data['oldpassword_err']) && empty($data['c_newpassword_err']))
                {
                    $this->model->updatePassword($data, $_SESSION['id']);
                    $data['notification'] = '1';
                    $data['newpassword'] = $data['oldpassword'] = $data['c_newpassword'] = '';
                }
                $this->view('edit/password', $data);
            }
            else
            {
                $data = [
                    'oldpassword' => '',
                    'newpassword' => '',
                    'c_newpassword' => '',
                    'oldpassword_err' => '',
                    'newpassword_err' => '',
                    'c_newpassword_err' => '',
                    'notification' => ''
                ];
                $this->view('edit/password', $data);
            }
        }
        else
        {
            $data['link'] = '/edit/password';
            $this->view('account/login', $data);
        }
    }
    public function email_notifications()
    {
        $ret = $this->model->notificationStatus($_SESSION['id']);
        if (isLoggedIn())
        {

            $data = [
                'comments_n' => $ret->comments_n,
                'likes_n' => $ret->likes_n
            ];
            $this->view('edit/email_notifications', $data);

            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                if(isset($_POST['comments_n']))
                {
                    if($_POST['comments_n'] == 'true')
                        $this->model->updateNotification('comments_n', '1', $_SESSION['id']);
                    else
                        $this->model->updateNotification('comments_n', '0', $_SESSION['id']);
                }
                if(isset($_POST['likes_n']))
                {
                    if($_POST['likes_n'] == 'true')
                        $this->model->updateNotification('likes_n', '1', $_SESSION['id']);
                    else
                        $this->model->updateNotification('likes_n', '0', $_SESSION['id']);
                }
            }
        }
        else
        {
            $data['link'] = '/edit/email_notifications';
            $this->view('account/login', $data);
        }
    }

    public function logout()
    {
        unset($_SESSION['id']);
        unset($_SESSION['email']);
        unset($_SESSION['username']);
        redirect('/account/login');
    }
}