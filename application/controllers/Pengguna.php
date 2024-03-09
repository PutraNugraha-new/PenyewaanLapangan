<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use Dompdf\Dompdf;
use Dompdf\Options;
require_once FCPATH . 'vendor/autoload.php';

class Pengguna extends CI_Controller {

	function __construct(){
        parent::__construct();
		$this->load->model('M_admin', 'M_admin', TRUE);
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
                'judul' => 'Pengguna',
                'pengguna' => $this->M_admin->allData(),
                'isi'   =>  'admin/pengguna/v_home',
            );
            $this->load->view('admin/layout/v_wrapper', $data, FALSE);
        }else{
            redirect(site_url().'login/');
        }
    }

    public function add(){
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');

        // var_dump($data);
        if ($this->form_validation->run() == FALSE) {
            redirect('pengguna','refresh');
        }else{
            if($this->M_admin->isDuplicate($this->input->post('username'))){
                $this->session->set_flashdata('flash_message', 'Username already exists');
                redirect(site_url().'pengguna');
            }else{
                $this->load->library('password');
                $post = $this->input->post(NULL, TRUE);
                $cleanPost = $this->security->xss_clean($post);
                $hashed = $this->password->create_hash($cleanPost['password']);
                $cleanPost['nama'] = $this->input->post('nama');
                $cleanPost['username'] = $this->input->post('username');
                $cleanPost['password'] = $hashed;

                //insert to database
                if(!$this->M_admin->addUser($cleanPost)){
                    $this->session->set_flashdata('flash_message', 'There was a problem add new user');
                }else{
                    $this->session->set_flashdata('success_message', 'New user has been added.');
                }
                redirect(site_url().'pengguna');
            };
        }
    }

    public function edit() {
        echo json_encode($this->M_admin->get_detail_modal($_POST['id']));
    }

    public function update($id){
        $this->form_validation->set_rules('id_admin', 'ID', 'required');
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('nama', 'nama', 'required');

        if ($this->form_validation->run() == FALSE) {
            redirect('pengguna','refresh');
            // die();
        }else{
            $post = $this->input->post(NULL, TRUE);
            $cleanPost = $this->security->xss_clean($post);
            $cleanPost['id_admin'] = $this->input->post('id_admin');
            $cleanPost['nama'] = $this->input->post('nama');
            $cleanPost['username'] = $this->input->post('username');

            // var_dump($cleanPost);
            // die();
                //update to database
                $this->M_admin->edit($cleanPost);
                $this->session->set_flashdata('success_message', 'Berhasil Edit Data.');
                redirect(site_url().'pengguna');
        }
    }

    public function hapus($id) {
        $this->M_admin->deleteUser($id);
        if($this->M_admin->deleteUser($id) == FALSE )
        {
            $this->session->set_flashdata('flash_message', 'Error, cant delete the user!');
        }
        else
        {
            $this->session->set_flashdata('success_message', 'Delete user was successful.');
        }
        redirect(site_url().'pengguna');
    }

}

/* End of file Admin.php */

