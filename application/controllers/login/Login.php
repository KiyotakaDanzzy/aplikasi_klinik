<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login/Login_model');
    }

    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('welcome');
        }
        $this->load->view('login/login');
    }

    public function login_aksi()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->Login_model->login($username);

        if ($user && password_verify($password, $user->password)) {
            $session_data = [
                'id_user' => $user->id,
                'id_pegawai' => $user->id_pegawai,
                'nama_user' => $user->nama_pegawai,
                'username' => $user->username,
                'id_level' => $user->id_level,
                'nama_level' => $user->nama_level,
                'logged_in' => TRUE
            ];
            $this->session->set_userdata($session_data);
            echo 'success';
        } else {
            echo 'error';
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login/login');
    }
}