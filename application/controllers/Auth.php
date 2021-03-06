<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Auth
 *
 * @author Joe
 */
class Auth extends Application {
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }
    function index() {
        $this->data['pagebody'] = 'login';
        $this->render();
    }
    function submit() {
        $key = $this->input->post('userid');
        if ($key == FALSE) {
            redirect('/auth'); //no user name given?
        }
        $user = $this->users->get($key);
        if ($user == NULL) {
            redirect('/auth'); //use the userID __NOT__ username
        }
        if (password_verify($this->input->post('password'),$user->password)) {
            $this->session->set_userdata('userID',$key);
            $this->session->set_userdata('userName',$user->name);
            $this->session->set_userdata('userRole',$user->role);
            redirect('/');
        } else {
            redirect('/auth');
        }
    }
    function logout() {
        $this->session->sess_destroy();
        redirect('/');
    }
}