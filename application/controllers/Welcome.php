<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public $status;
    public $roles;

	function __construct(){
        parent::__construct();
        $this->load->model('M_produk', 'M_produk', TRUE);
        $this->load->model('M_keranjang', 'M_keranjang', TRUE);
        $this->load->model('M_galeri', 'M_galeri', TRUE);
		$this->load->model('User_model', 'user_model', TRUE);
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->status = $this->config->item('status');
        $this->roles = $this->config->item('roles');
        $this->load->library('userlevel');
    }

	public function index()
	{	
		$data = array(  
            'isi'   =>  'users/v_home',
			'produk' => $this->M_produk->allData(),
		);
		$this->load->view('users/layout/v_wrapper', $data, FALSE);
	}

	public function produk(){
		$data = array(
			'isi' => 'users/v_produk',
			'produk' => $this->M_produk->allData(),
		);
		$this->load->view('users/layout/v_wrapper', $data, FALSE);
	}

	public function pemesanan(){
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
        if(empty($this->session->userdata['email'])){
            redirect(site_url().'main/login/');
        }else{
			if($dataLevel == 'is_user'){
				$data = array(
					'isi'=> 'users/v_pemesanan',
					'pemesanan' => $this->M_keranjang->getData($data['id'])
				);
				$this->load->view('users/layout/v_wrapper', $data, FALSE);
			}else{
				redirect(site_url().'main/login/');
			}
		}
	}

	public function riwayat(){
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
        
        if(empty($this->session->userdata['email'])){
            redirect(site_url().'main/login/');
        }else{
			if($dataLevel == 'is_user'){
				$data = array(
					'isi' => 'users/v_riwayat'
				);
				$this->load->view('users/layout/v_wrapper', $data, FalSE);
			}else{
				redirect(site_url().'main/login/');
			}
		}
	}

	public function profile(){
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
        if(empty($this->session->userdata['email'])){
            redirect(site_url().'main/login/');
        }else{
			if($dataLevel == 'is_user'){
				$data =array(
					'isi' => 'users/v_profile',
					'datauser' => $this->session->userdata
				);
				$this->load->view('users/layout/v_wrapper', $data, FALSE);
			}else{
				redirect(site_url().'main/login/');
			}
		}
	}

	public function add_to_cart(){
        $id_produk = $this->input->post('id');
		$id = $this->session->userdata['id'];
		$quantity = 1;

		// Cek apakah produk sudah ada di keranjang
		$existingItem = $this->M_keranjang->get_item_by_product_id($id_produk, $id);
    
        // Panggil model atau metode yang diperlukan untuk mengambil data produk
        // $productData = $this->M_produk->getData($id_produk);
		if ($existingItem) {
			// Produk sudah ada di keranjang, perbarui jumlahnya
			$newQuantity = $existingItem->kuantitas + $quantity;
			$this->M_keranjang->update_jumlah_produk($existingItem->id_keranjang, $newQuantity);
		} else {
			// Produk belum ada di keranjang, tambahkan sebagai item baru
			$data = array(
				'id' => $this->session->userdata['id'],
				'id_produk' => $id_produk,
				'kuantitas' => $quantity
				// ... (sesuaikan dengan struktur tabel Anda)
			);
			$this->M_keranjang->add($data);
		}
	
		// Response sukses
		echo json_encode(['status' => 'success']);
    }

	public function update_cart(){
		if ($this->input->is_ajax_request()) {
            $id_keranjang = $this->input->post('id');
            $jumlah = $this->input->post('jumlah');

            // Panggil model untuk mengupdate jumlah di database
            $this->M_keranjang->update_jumlah_produk($id_keranjang, $jumlah);

            // Kirim tanggapan ke klien (jika diperlukan)
            echo json_encode(['status' => 'success']);
        } else {
            // Tanggapan jika bukan permintaan Ajax
            show_404();
        }
	}

	public function delete(){
		if ($this->input->is_ajax_request()) {
            $id_produk = $this->input->post('id');

            // Panggil model untuk menghapus data dari database
            $this->M_keranjang->delete($id_produk);

            // Kirim tanggapan ke klien
            echo json_encode(['status' => 'success']);
        } else {
            // Tanggapan jika bukan permintaan Ajax
            show_404();
        }
	}

	public function countKuantitas(){
            $id = $this->session->userdata['id'];

			$totalQuantity = $this->M_keranjang->get_total_quantity($id);

			// Kirim respons sebagai JSON
			echo json_encode(['total_quantity' => $totalQuantity]);
	}

	public function detailProduk($id_produk){
		$data = array(
			'isi' => 'users/v_detail',
			'produk' => $this->M_produk->getDetail($id_produk),
			'galeri' => $this->M_galeri->getData($id_produk)
		);
		$this->load->view('users/layout/v_wrapper', $data, FALSE);
	}
}
