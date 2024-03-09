<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use Dompdf\Dompdf;
use Dompdf\Options;
require_once FCPATH . 'vendor/autoload.php';

class Pemesanan extends CI_Controller {
    public $status;
    public $roles;

	function __construct(){
        parent::__construct();
		$this->load->model('M_pemesanan', 'M_pemesanan', TRUE);
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
                'judul' => 'Pemesanan',
                'isi'   =>  'admin/pemesanan/v_home',
                'pemesanan' => $this->M_pemesanan->getAll()
            );
            // var_dump($data['pemesanan']);die;
            $this->load->view('admin/layout/v_wrapper', $data, FALSE);
        }else{
            redirect(site_url().'login/');
        }
    }

    public function updateProses(){
        if ($this->input->is_ajax_request()) {
            $id_detail = $this->input->post('id');
            $status = $this->input->post('status');

            // Panggil model untuk mengupdate jumlah di database
            $this->M_pemesanan->updateStatus($id_detail, $status);

            // Kirim tanggapan ke klien (jika diperlukan)
            echo json_encode(['status' => 'success']);
        } else {
            // Tanggapan jika bukan permintaan Ajax
            show_404();
        }
    }

}

/* End of file Admin.php */

