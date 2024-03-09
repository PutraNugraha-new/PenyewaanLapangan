<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
        parent::__construct();
		$this->load->model('M_admin', 'M_admin', TRUE);
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->load->library('email');
    }

	//index dasboard
	public function index()
	{
	    //user data from session
	    $data = $this->session->userdata;

	    if(empty($data)){
	        redirect(site_url().'login/login/');
	    }

	    $data['title'] = "Dashboard Admin";
	    
        if(empty($this->session->userdata['username'])){
            redirect(site_url().'login/login/');
        }else{
            redirect(site_url().'pemesanan');
        }

	}

    public function login()
    {
        $data = $this->session->userdata;
        if(!empty($data['username'])){
	        redirect(site_url().'login/');
	    }else{
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if($this->form_validation->run() == FALSE) {
                $this->load->view('admin/login/v_home', $data);
            }else{
                $post = $this->input->post();
                $clean = $this->security->xss_clean($post);
                $userInfo = $this->M_admin->checkLogin($clean);
                
                if(!$userInfo)
                {
                    $this->session->set_flashdata('flash_message', 'Wrong password or email.');
                    redirect(site_url().'login/login');
                }
                elseif($userInfo) //recaptcha check, success login, ban or unban
                {
                    foreach($userInfo as $key=>$val){
                    $this->session->set_userdata($key, $val);
                    }
                    redirect(site_url().'login/');
                }
                else
                {
                    $this->session->set_flashdata('flash_message', 'Something Error!');
                    redirect(site_url().'login/login/');
                    exit;
                }
            }
	    }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(site_url().'login/');
    }

}
