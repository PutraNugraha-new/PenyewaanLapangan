<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use Dompdf\Dompdf;
use Dompdf\Options;
require_once FCPATH . 'vendor/autoload.php';

class Laporan extends CI_Controller {
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
                'judul' => 'Laporan',
                'isi'   =>  'admin/laporan/v_home',
                'pemesanan' => $this->M_pemesanan->getAll()
            );
            $this->load->view('admin/layout/v_wrapper', $data, FALSE);
        }else{
            redirect(site_url().'login/');
        }
    }

    public function getData() {
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
            $tgl_awal = $this->input->get('tgl_awal');
            $tgl_akhir = $this->input->get('tgl_akhir');

            // ---------------
            if (!empty($tgl_awal) && !empty($tgl_akhir)) {
                // Menampilkan semua data
                $data = array(
                    'title' => 'Laporan',
                    'isi'   =>  'admin/laporan/v_home',
                    'pemesanan' => $this->M_pemesanan->get_filtered_data($tgl_awal, $tgl_akhir),
                );
            } else {
                // Kondisi default jika tidak ada form yang terisi
                $data = array(
                    'title' => 'Laporan',
                    'isi'   =>  'admin/laporan/v_home',
                    'pemesanan' => $this->M_pemesanan->getAll(),
                );
            }
            $this->load->view('admin/layout/v_wrapper', $data, FALSE);
        }else{
            redirect(site_url().'login/');
        }
    }

    public function cetakLaporan(){
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

            $tgl_awal = $this->input->get('tgl_awal'); // Menggunakan input get untuk mendapatkan parameter dari URL
            $tgl_akhir = $this->input->get('tgl_akhir'); // Menggunakan input get untuk mendapatkan parameter dari URL
    
                // ---------------
                if (!empty($tgl_awal) && !empty($tgl_akhir)) {
                    // Menampilkan data berdasarkan rentang tanggal
                    $data = array(
                        'pemesanan' => $this->M_pemesanan->get_filtered_data($tgl_awal, $tgl_akhir),
                    );
                } else {
                    // Kondisi default jika tidak ada form yang terisi
                    $data = array(
                        'pemesanan' => $this->M_pemesanan->getAll(),
                    );
                }
        
        
                // Load library Dompdf
                $options = new Options();
                $options->set('isHtml5ParserEnabled', true);
                $options->set('isPhpEnabled', true);
        
                $dompdf = new Dompdf($options);
        
                $html = $this->load->view('admin/laporan/cetakLaporan', $data, true);
                $dompdf->loadHtml($html);
        
                $dompdf->setPaper('A4', 'landscape');
        
                // Render PDF (stream to browser atau save ke file)
                $dompdf->render();
                $dompdf->stream('laporan.pdf', array('Attachment' => 0));
        }else{
            redirect(site_url().'login/');
        }
    }


}

/* End of file Admin.php */

