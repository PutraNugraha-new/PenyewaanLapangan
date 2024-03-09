<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    public $status;
    public $roles;

    function __construct(){
        parent::__construct();
        $this->load->model('User_model', 'user_model', TRUE);
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->status = $this->config->item('status');
        $this->roles = $this->config->item('roles');
        $this->load->library('userlevel');
    }

    //index dasboard
	public function index()
	{
	    //user data from session
	    $data = $this->session->userdata;
	    if(empty($data)){
	        redirect(site_url().'main/login/');
	    }

	    //check user level
	    if(empty($data['role'])){
	        redirect(site_url().'main/login/');
	    }
	    $dataLevel = $this->userlevel->checkLevel($data['role']);
	    //check user level
        
	    $data['title'] = "Dashboard Admin";
	    
        if(empty($this->session->userdata['email'])){
            redirect(site_url().'main/login/');
        }else{
            redirect(site_url().'dashboard');
        }

	}

    public function tambahPengguna(){
            $data = array(
                'isi'   =>  'login/v_registrasi',
            );
            $this->load->view('users/layout/v_wrapper', $data, FALSE);
    }
	
	public function checkLoginUser(){
	     //user data from session
	    $data = $this->session->userdata;
	    if(empty($data)){
	        redirect(site_url().'main/login/');
	    }
	    
	$this->load->library('user_agent');
        $browser = $this->agent->browser();
        $os = $this->agent->platform();
        $getip = $this->input->ip_address();
        
        $result = $this->user_model->getAllSettings();
        $stLe = $result->site_title;
	$tz = $result->timezone;
	    
	$now = new DateTime();
        $now->setTimezone(new DateTimezone($tz));
        $dTod =  $now->format('Y-m-d');
        $dTim =  $now->format('H:i:s');
        
        $this->load->helper('cookie');
        $keyid = rand(1,9000);
        $scSh = sha1($keyid);
        $neMSC = md5($data['email']);
        $setLogin = array(
            'name'   => $neMSC,
            'value'  => $scSh,
            'expire' => strtotime("+2 year"),
        );
        $getAccess = get_cookie($neMSC);
	    
        if(!$getAccess && $setLogin["name"] == $neMSC){
            // Konfigurasi SMTP untuk Gmail
            $config = array(
                'protocol' => 'smtp',
                'smtp_host' => 'smtp.gmail.com',
                'smtp_port' =>  465,
                'smtp_user' => 'simpandrive803@gmail.com', // Gantilah dengan alamat email Gmail Anda
                'smtp_pass' => 'sampit2019', // Gantilah dengan password Gmail Anda
                'mailtype' => 'html',
                'charset' => 'utf-8'
            );
             $this->load->library('email', $config);
            $this->load->library('sendmail');
            $bUrl = base_url();
            $message = $this->sendmail->securemail($data['first_name'],$data['last_name'],$data['email'],$dTod,$dTim,$stLe,$browser,$os,$getip,$bUrl);
            $to_email = $data['email'];
            $this->email->from($this->config->item('register'), 'New sign-in! from ' . $browser . '');
            $this->email->to($to_email);
            $this->email->subject('New sign-in! from ' . $browser . '');
            $this->email->message($message);
            $this->email->set_mailtype("html");
        
            // Kirim email menggunakan SMTP
            $this->email->send();
            
            $this->input->set_cookie($setLogin, TRUE);
            redirect(site_url().'main/');
        }else{
            $this->input->set_cookie($setLogin, TRUE);
            redirect(site_url().'main/');
        }
	}

    protected function _islocal(){
        return strpos($_SERVER['HTTP_HOST'], 'local');
    }


    //check login failed or success
    public function login()
    {
        $data = $this->session->userdata;
        if(!empty($data['email'])){
	        redirect(site_url().'main/');
	    }else{
	        $this->load->library('curl');
            $this->load->library('recaptcha');
            $this->form_validation->set_rules('email', 'email', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            
            $data['title'] = "Welcome Back!";
            
            $result = $this->user_model->getAllSettings();
            $data['recaptcha'] = $result->recaptcha;

            if($this->form_validation->run() == FALSE) {
                $data = array(
                    'isi' => 'login/v_home'
                );
                $this->load->view('users/layout/v_wrapper', $data);
            }else{
                $post = $this->input->post();
                $clean = $this->security->xss_clean($post);
                $userInfo = $this->user_model->checkLogin($clean);
                
                if($data['recaptcha'] == 'yes'){
                    //recaptcha
                    $recaptchaResponse = $this->input->post('g-recaptcha-response');
                    $userIp = $_SERVER['REMOTE_ADDR'];
                    $key = $this->recaptcha->secret;
                    $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$key."&response=".$recaptchaResponse."&remoteip=".$userIp; //link
                    $response = $this->curl->simple_get($url);
                    $status= json_decode($response, true);
    
                    if(!$userInfo)
                    {
                        $this->session->set_flashdata('flash_message', 'Wrong password or email.');
                        redirect(site_url().'main/login');
                    }
                    elseif($userInfo->banned_users == "ban")
                    {
                        $this->session->set_flashdata('danger_message', 'You’re temporarily banned from our website!');
                        redirect(site_url().'main/login');
                    }
                    else if(!$status['success'])
                    {
                        //recaptcha failed
                        $this->session->set_flashdata('flash_message', 'Error...! Google Recaptcha UnSuccessful!');
                        redirect(site_url().'main/login/');
                        exit;
                    }
                    elseif($status['success'] && $userInfo && $userInfo->banned_users == "unban") //recaptcha check, success login, ban or unban
                    {
                        foreach($userInfo as $key=>$val){
                        $this->session->set_userdata($key, $val);
                        }
                        redirect(site_url().'main/checkLoginUser/');
                    }
                    else
                    {
                        $this->session->set_flashdata('flash_message', 'Something Error!');
                        redirect(site_url().'main/login/');
                        exit;
                    }
                }else{
                    if(!$userInfo)
                    {
                        $this->session->set_flashdata('flash_message', 'Wrong password or email.');
                        redirect(site_url().'main/login');
                    }
                    elseif($userInfo->banned_users == "ban")
                    {
                        $this->session->set_flashdata('danger_message', 'You’re temporarily banned from our website!');
                        redirect(site_url().'main/login');
                    }
                    elseif($userInfo && $userInfo->banned_users == "unban") //recaptcha check, success login, ban or unban
                    {
                        foreach($userInfo as $key=>$val){
                        $this->session->set_userdata($key, $val);
                        }
                        redirect(site_url().'main/checkLoginUser/');
                    }
                    else
                    {
                        $this->session->set_flashdata('flash_message', 'Something Error!');
                        redirect(site_url().'main/login/');
                        exit;
                    }
                }
            }
	    }
    }

    //add new user from backend
    public function adduserPengguna()
    {
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('alamat', 'alamat', 'required');
        $this->form_validation->set_rules('no_hp', 'no_hp', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');

        $data = array(
            'isi'   =>  'login/v_registrasi',
        );
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('users/layout/v_wrapper', $data, FALSE);
        }else{
            if($this->user_model->isDuplicate($this->input->post('email'))){
                $this->session->set_flashdata('flash_message', 'Username sudah digunakan');
                redirect(site_url().'main/adduserPengguna');
            }else{
                $this->load->library('password');
                $post = $this->input->post(NULL, TRUE);
                $cleanPost = $this->security->xss_clean($post);
                $hashed = $this->password->create_hash($cleanPost['password']);
                $cleanPost['email'] = $this->input->post('email');
                $cleanPost['first_name'] = $this->input->post('first_name');
                $cleanPost['lastname'] = $this->input->post('lastname');
                $cleanPost['no_hp'] = $this->input->post('no_hp');
                $cleanPost['alamat'] = $this->input->post('alamat');
                $cleanPost['banned_users'] = 'unban';
                $cleanPost['role'] = '2';
                $cleanPost['password'] = $hashed;
                unset($cleanPost['passconf']);
                
                //insert to database
                if(!$this->user_model->addUser($cleanPost)){
                    $this->session->set_flashdata('flash_message', 'ada masalah ketika menambahkan data');
                }else{
                    $this->session->set_flashdata('success_message', 'Pengguna berhasil ditambahkan.');
                }
                redirect(site_url().'welcome');
            };
        }
    }

    public function edit() {
        // header('Content-Type: application/json');
        echo json_encode($this->user_model->getData($_POST['id']));
    }

    public function update(){
        $data = $this->session->userdata;
        if(empty($data['role'])){
	        redirect(site_url().'login/login/');
	    }

        //check user level
	    if(empty($data['role'])){
	        redirect(site_url().'login/login/');
	    }
	    $dataLevel = $this->userlevel->checkLevel($data['role']);
	    //check user level

	    //check is admin or not
	    if($dataLevel == "is_admin"){
            $this->form_validation->set_rules('id', 'ID', 'required');
            $this->form_validation->set_rules('role', 'Role', 'required');
            $this->form_validation->set_rules('first_name', 'Nama Pengguna', 'required');

            if ($this->form_validation->run() == FALSE) {
                
                redirect('pelanggan','refresh');
                
                // die();
            }else{
                $id = $this->input->post('id');
                    $edit = [
                        'id' => $id,
                        'first_name' => $this->input->post('first_name'),
                        'role' => $this->input->post('role'),
                        'alamat' => $this->input->post('alamat'),
                        'no_hp' => $this->input->post('no_hp'),
                    ];

                    // var_dump($edit);
                    // die();

                    //update to database
                    $this->user_model->edit($edit);
                    $this->session->set_flashdata('success_message', 'Berhasil Edit Data.');
                    redirect(site_url().'pelanggan');
            }
	    }else{
	        redirect(site_url().'pelanggan/');
	    }
    }

    public function delete($id)
    {
        $this->user_model->deleteUser($id);

        $this->session->set_flashdata('success_message', 'Data Berhasil Dihapus');
        redirect('pelanggan ', 'refresh');
    }
    

    //Logout
    public function logout()
    {
        $this->session->sess_destroy();
        redirect(site_url().'main/login/');
    }


    public function base64url_encode($data) {
      return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function base64url_decode($data) {
      return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }
}
