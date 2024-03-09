<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct(){
        parent::__construct();
		$this->load->model('M_pelanggan', 'M_pelanggan', TRUE);
		$this->load->model('M_pemesanan', 'M_pemesanan', TRUE);
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->load->library('email');
    }

	public function index()
	{	
		$data = array(  
            'isi'   =>  'users/v_home',
		);
		$this->load->view('users/layout/v_wrapper', $data, FALSE);
	}

	public function login(){
		$data = array(  
            'isi'   =>  'login/v_home',
		);
		$this->load->view('users/layout/v_wrapper', $data, FALSE);
	}

	public function registrasi(){
		$data = array(  
            'isi'   =>  'login/v_registrasi',
		);
		$this->load->view('users/layout/v_wrapper', $data, FALSE);
	}

	public function pemesanan(){
		$data = array(  
            'isi'   =>  'users/v_pemesanan',
		);
		$this->load->view('users/layout/v_wrapper', $data, FALSE);
	}
	public function riwayat(){
        $id_user=$this->session->userdata('id_pelanggan');

		$data = array(  
            'isi'   =>  'users/v_riwayat',
            'riwayat' => $this->M_pemesanan->getPesanan($id_user)
		);
		$this->load->view('users/layout/v_wrapper', $data, FALSE);
	}

	public function logout()
    {
        $this->session->sess_destroy();
        redirect(site_url().'welcome/');
    }


	public function loginUser()
    {
        $data = $this->session->userdata;
        if(!empty($data['username'])){
	        redirect(site_url().'login/');
	    }else{
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if($this->form_validation->run() == FALSE) {
                $data = array(  
					'isi'   =>  'login/v_home',
				);
				$this->load->view('users/layout/v_wrapper', $data, FALSE);
            }else{
                $post = $this->input->post();
                $clean = $this->security->xss_clean($post);
                $userInfo = $this->M_pelanggan->checkLogin($clean);
                
                if(!$userInfo)
                {
                    $this->session->set_flashdata('flash_message', 'Wrong password or email.');
                    redirect(site_url().'welcome/login');
                }
                elseif($userInfo) //recaptcha check, success login, ban or unban
                {
                    foreach($userInfo as $key=>$val){
                    $this->session->set_userdata($key, $val);
                    }
                    redirect(site_url().'welcome/');
                }
                else
                {
                    $this->session->set_flashdata('flash_message', 'Something Error!');
                    redirect(site_url().'welcome/login/');
                    exit;
                }
            }
	    }
    }

	public function adduserPengguna()
    {
        $this->form_validation->set_rules('nama_pelanggan', 'Nama', 'required');
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'jenis kelamin', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');
        $this->form_validation->set_rules('email', 'email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => 'Registrasi',
                'isi' => 'login/v_registrasi'
            );
            $this->load->view('users/layout/v_wrapper', $data, FALSE);
        }else{
            if($this->M_pelanggan->isDuplicate($this->input->post('username'))){
                $this->session->set_flashdata('flash_message', 'Username sudah digunakan');
                redirect(site_url().'welcome/registrasi');
            }else{
                $this->load->library('password');
                $post = $this->input->post(NULL, TRUE);
                $cleanPost = $this->security->xss_clean($post);
                $hashed = $this->password->create_hash($cleanPost['password']);
                $cleanPost['nama_pelanggan'] = $this->input->post('nama_pelanggan');
                $cleanPost['username'] = $this->input->post('username');
                $cleanPost['tanggal_lahir'] = $this->input->post('tanggal_lahir');
                $cleanPost['jenis_kelamin'] = $this->input->post('jenis_kelamin');
                $cleanPost['no_hp'] = $this->input->post('no_hp');
                $cleanPost['email'] = $this->input->post('email');
                $cleanPost['level'] = 'user';
                $cleanPost['password'] = $hashed;
                
                unset($cleanPost['passconf']);

                //insert to database
                if($this->M_pelanggan->add($cleanPost) == FALSE){
                    $this->session->set_flashdata('flash_message', 'There was a problem add new user');
                }else{
                    $this->session->set_flashdata('success_message', 'New user has been added.');
                }
                redirect(site_url().'welcome/login');
            };
        }
    }

	public function forgot()
    {
        $data['title'] = "Forgot Password";
        $this->load->library('curl');
        $this->load->library('recaptcha');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => 'Registrasi',
                'isi' => 'login/v_forgot'
            );
            $this->load->view('users/layout/v_wrapper', $data, FALSE);
        }else{
            $email = $this->input->post('email');
            $clean = $this->security->xss_clean($email);
            $userInfo = $this->M_pelanggan->getUserInfoByEmail($clean);

            if(!$userInfo){
                $this->session->set_flashdata('flash_message', 'We cant find your email address');
                redirect(site_url().'welcome/forgot');
            }

            //generate token
            $token = $this->M_pelanggan->insertToken($userInfo->id_pelanggan);
            $qstring = $this->base64url_encode($token);
            $url = site_url() . 'welcome/reset_password/token/' . $qstring;
            $link = '<a href="' . $url . '">' . $url . '</a>';

            $this->load->library('email');
            $this->load->library('sendmail');
            
            $message = $this->sendmail->sendForgot($this->input->post('lastname'),$this->input->post('email'),$link,'Gor Umpu Kakah');
            $to_email = $this->input->post('email');
            $this->email->from($this->config->item('forgot'), 'Reset Password! ' . $this->input->post('firstname') .' '. $this->input->post('lastname')); //from sender, title email
            // Pengaturan email
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'smtp.gmail.com';
            $config['smtp_port'] = 587;
            $config['smtp_user'] = 'simpandrive803@gmail.com'; // Ganti dengan alamat email Anda
            $config['smtp_pass'] = 'tleydnzevvrvmbda'; // Ganti dengan kata sandi email Anda
            $config['smtp_crypto'] = 'tls';
            $config['charset'] = 'utf-8';
            $config['mailtype'] = 'html';
            $config['newline'] = "\r\n";
        
            // Load konfigurasi email
            $this->email->initialize($config);
            // Pengaturan email
            $this->email->from('simpandrive803@gmail.com', 'Admin'); // Ganti dengan alamat email dan nama Anda
            $this->email->to($to_email); // Ganti dengan alamat email penerima
            
            $this->email->subject('Reset Password');
            $this->email->message($message);

            if($this->email->send()){
                redirect(site_url().'welcome/successresetpassword/');
            }else{
                $this->session->set_flashdata('flash_message', 'There was a problem sending an email.');
                exit;
            }
        }

    }

	//reset password
    public function reset_password()
    {
        $token = $this->base64url_decode($this->uri->segment(4));
        $cleanToken = $this->security->xss_clean($token);
        $user_info = $this->M_pelanggan->isTokenValid($cleanToken); //either false or array();


        if(!$user_info){
            $this->session->set_flashdata('flash_message', 'Token is invalid or expired');
            redirect(site_url().'welcome/login');
        }
        $data = array(
            'username'=> $user_info->username,
            'email'=>$user_info->email,
            //'user_id'=>$user_info->id,
            'token'=>$this->base64url_encode($token)
        );

        $data['title'] = "Reset Password";
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => 'Registrasi',
                'isi' => 'login/reset_password.php',
				'username'=> $user_info->username,
				'email'=>$user_info->email,
				//'user_id'=>$user_info->id,
				'token'=>$this->base64url_encode($token)
            );
            $this->load->view('users/layout/v_wrapper', $data, FALSE);
        }else{
            $this->load->library('password');
            $post = $this->input->post(NULL, TRUE);
            $cleanPost = $this->security->xss_clean($post);
            $hashed = $this->password->create_hash($cleanPost['password']);
            $cleanPost['password'] = $hashed;
            $cleanPost['id_pelanggan'] = $user_info->id_pelanggan;
            unset($cleanPost['passconf']);


            if($this->M_pelanggan->updatePassword($cleanPost) == FALSE){
                $this->session->set_flashdata('flash_message', 'There was a problem updating your password');
            }else{
                $this->session->set_flashdata('success_message', 'Your password has been updated. You may now login');
            }
            redirect(site_url().'welcome/login');
        }
    }

	 // if success after set password
	public function successresetpassword()
	{
		$data['title'] = "Success Reset Password";
		$this->load->view('login/reset-pass-info', $data);
	}


	public function base64url_encode($data) {
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
	  }
  
	  public function base64url_decode($data) {
		return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
	  }

      public function add() {
        // Ambil data pesanan dari POST request
		$post = $this->input->post(NULL, TRUE);
        $cleanPost = $this->security->xss_clean($post);
        $cleanPost['id_pelanggan'] = $this->input->post('id_pelanggan');
        $cleanPost['no_lapangan'] = $this->input->post('no_lapangan');
        $cleanPost['tgl_main'] = $this->input->post('tgl_main');
        $cleanPost['jam_bermain'] = $this->input->post('jam_bermain');
        $cleanPost['total_bayar'] = $this->input->post('total_bayar');
        
        
        $kode_pemesanan = $this->M_pemesanan->simpan_pesanan($cleanPost);
        // Tangkap data jam_bermain dari checkbox
        $jam_bermain_array = $this->input->post('jam');

        if(($kode_pemesanan)){
			// Loop melalui setiap nilai jam dan simpan sebagai entri terpisah dalam database
            foreach ($jam_bermain_array as $jam) {
                // Panggil fungsi simpan_detail_pesanan() dari model dan kirimkan setiap nilai jam sebagai parameter
                $this->M_pemesanan->simpan_detail_pesanan($kode_pemesanan, $jam, $cleanPost['tgl_main'], $cleanPost['no_lapangan']);
            }
            $this->session->set_flashdata('success_message', 'Pesanan Sudah Dibuat.');
		}else{
			$this->session->set_flashdata('success_message', 'Pesanan Gagal Dibuat.');
		}
        // Mengembalikan response dalam format JSON
        redirect(site_url().'welcome/pemesanan');
    }

    public function getJadwal() {
        // Ambil data dari request AJAX
        $tgl_main = $this->input->post('tgl_main');
        $no_lapangan = $this->input->post('no_lapangan');

        // Panggil model untuk mendapatkan data pemesanan berdasarkan nomor lapangan dan tanggal
        $pemesanan = $this->M_pemesanan->get_pemesanan($no_lapangan, $tgl_main);

        // Buat array untuk menyimpan jam pemesanan
        $jam_pemesanan = array();

        // Loop melalui hasil pemesanan dan tambahkan jam ke array
        foreach ($pemesanan as $row) {
            $jam_pemesanan[] = $row['jam_dipesan'];
        }

        // Kirim data dalam format JSON
        echo json_encode($jam_pemesanan);
    }
}
