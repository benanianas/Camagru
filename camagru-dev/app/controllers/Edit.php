<?php

class Edit extends Controller{
    
    public function __constrct()
    {
        $this->model = $this->model('Settings');
    }

    public function profile()
    {
        $this->view('edit/profile', $data);
    }
    public function password()
    {
        $this->view('edit/password', $data);
    }
    public function email_notifications()
    {
        $this->view('edit/email_notifications', $data);
    }
}