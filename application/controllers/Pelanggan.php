<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use Dompdf\Dompdf;
use Dompdf\Options;
require_once FCPATH . 'vendor/autoload.php';

class Pelanggan extends CI_Controller {
    public $status;
    public $roles;

	function __construct(){
        parent::__construct();
		$this->load->model('M_pelanggan', 'M_pelanggan', TRUE);
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $options = new Options();
        $options->set('defaultFont', 'Times New Roman');
        $dompdf = new Dompdf($options);
    }

    public function index()
    {
         //user data from session
	    $data = $this->session->userdata;
	    if(empty($data['username'])){
            redirect(site_url().'login/login/');
	    }

	    //check user level
	    if(empty($data['role'])){
	        redirect(site_url().'login/login/');
	    }

	    //check user level
        if($data['role'] == "admin"){
            $data = array(  
                'judul' => 'Pelanggan',
                'isi'   =>  'admin/pelanggan/v_home',
                'pelanggan' => $this->M_pelanggan->allData()
            );
            $this->load->view('admin/layout/v_wrapper', $data, FALSE);
        }else{
            redirect(site_url().'login/');
        }
    }

    public function add(){
        $data = $this->session->userdata;
	    if(empty($data['username'])){
            redirect(site_url().'login/login/');
	    }

	    //check user level
	    if(empty($data['role'])){
	        redirect(site_url().'login/login/');
	    }

	    //check user level
        if($data['role'] == "admin"){
            $data = array(  
                'judul' => 'Tambah Pelanggan',
                'isi'   =>  'admin/pelanggan/v_tambah',
            );
            $this->load->view('admin/layout/v_wrapper', $data, FALSE);
        }else{
            redirect(site_url().'login/');
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
                'judul' => 'Tambah Pelanggan',
                'isi'   =>  'admin/pelanggan/v_tambah',
            );
            $this->load->view('admin/layout/v_wrapper', $data, FALSE);
        }else{
            if($this->M_pelanggan->isDuplicate($this->input->post('username'))){
                $this->session->set_flashdata('flash_message', 'Username sudah digunakan');
                redirect(site_url().'pelanggan/add');
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
                if($this->M_pelanggan->add($cleanPost)){
                    $this->session->set_flashdata('success_message', 'New user has been added.');
                }else{
                    $this->session->set_flashdata('flash_message', 'There was a problem add new user');
                }
                redirect(site_url().'pelanggan');
            };
        }
    }

    public function edit() {
        echo json_encode($this->M_pelanggan->get_detail_modal($_POST['id']));
    }

    public function update(){
        $this->form_validation->set_rules('id_pelanggan', 'ID', 'required');
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('nama_pelanggan', 'nama', 'required');

        if ($this->form_validation->run() == FALSE) {
            redirect('pelanggan','refresh');
        }else{
            $post = $this->input->post(NULL, TRUE);
            $cleanPost = $this->security->xss_clean($post);
            $cleanPost['id_pelanggan'] = $this->input->post('id_pelanggan');
            $cleanPost['nama_pelanggan'] = $this->input->post('nama_pelanggan');
            $cleanPost['username'] = $this->input->post('username');
            $cleanPost['no_hp'] = $this->input->post('no_hp');
            $cleanPost['email'] = $this->input->post('email');
            $cleanPost['jenis_kelamin'] = $this->input->post('jenis_kelamin');

            //update to database
            $this->M_pelanggan->edit($cleanPost);
            $this->session->set_flashdata('success_message', 'Berhasil Edit Data.');
            redirect(site_url().'pelanggan');
        }
    }

    public function hapus($id) {
        $this->M_pelanggan->deleteUser($id);
        if($this->M_pelanggan->deleteUser($id) == FALSE )
        {
            $this->session->set_flashdata('flash_message', 'Error, cant delete the user!');
        }
        else
        {
            $this->session->set_flashdata('success_message', 'Delete user was successful.');
        }
        redirect(site_url().'pelanggan');
    }

}

/* End of file Admin.php */

