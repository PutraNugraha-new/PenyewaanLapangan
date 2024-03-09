<?php
date_default_timezone_set('Asia/Jakarta');
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pemesanan extends CI_Model {
    
    public function simpan_pesanan($pesanan) {
        // Lakukan penyimpanan data pesanan ke dalam tabel pesanan (order)
        $data_pesanan = array(
            'id_pelanggan' => $pesanan['id_pelanggan'],
            'no_lapangan' => $pesanan['no_lapangan'],
            'tgl_main' => $pesanan['tgl_main'],
            'jam_bermain' => $pesanan['jam_bermain'],
            'total_bayar' => $pesanan['total_bayar'],
        );

        // Jalankan query untuk menyimpan data ke dalam tabel pesanan (order)
        $this->db->insert('tb_pemesanan', $data_pesanan);

        // Mengembalikan ID pesanan yang baru saja disimpan
        return $this->db->insert_id();
    }

    public function simpan_detail_pesanan($id_pesanan, $jam, $tgl_main, $no_lapangan) {
        // Lakukan penyimpanan detail pesanan ke dalam tabel detail pesanan (order_detail)
        $data_detail_pesanan = array(
            'kode_pemesanan' => $id_pesanan,
            'jam_dipesan' => $jam,
            'tgl_main' => $tgl_main,
            'no_lapangan' => $no_lapangan,
            'status' => 'proses',
        );
        
        // Jalankan query untuk menyimpan data ke dalam tabel detail pesanan (order_detail)
        $this->db->insert('tb_detailpemesanan', $data_detail_pesanan);
    }

    public function getPesanan($id_pelanggan){
        // Lakukan join antara tabel tb_pemesanan dan tb_detailpemesanan
        $this->db->select('p.kode_pemesanan, p.id_pelanggan, p.no_lapangan, p.tgl_main, p.jam_bermain, p.total_bayar, d.jam_dipesan, d.status');
        $this->db->from('tb_pemesanan p');
        $this->db->join('tb_detailpemesanan d', 'p.kode_pemesanan = d.kode_pemesanan AND p.tgl_main = d.tgl_main AND p.no_lapangan = d.no_lapangan');
        
        // Tambahkan kondisi where untuk id_pelanggan
        $this->db->where('p.id_pelanggan', $id_pelanggan);

        // Jalankan query
        $query = $this->db->get();

        // Mengembalikan hasil query
        return $query->result();
    }

    public function getAll(){
        $this->db->select('p.kode_pemesanan, p.id_pelanggan, p.no_lapangan, p.tgl_main, p.jam_bermain, p.total_bayar,  d.id_detail, d.jam_dipesan, d.status, plg.nama_pelanggan, plg.no_hp');
        $this->db->from('tb_pemesanan p');
        $this->db->join('tb_detailpemesanan d', 'p.kode_pemesanan = d.kode_pemesanan AND p.tgl_main = d.tgl_main AND p.no_lapangan = d.no_lapangan');
        $this->db->join('tb_pelanggan plg', 'p.id_pelanggan = plg.id_pelanggan');
    
        // Jalankan query
        $query = $this->db->get();
    
        // Mengembalikan hasil query
        return $query->result();
    }
    

    public function get_pemesanan($no_lapangan, $tgl_main) {
        $this->db->where('no_lapangan', $no_lapangan);
        $this->db->where('tgl_main', $tgl_main);
        $this->db->where('status', 'disewa');
        return $this->db->get('tb_detailpemesanan')->result_array();
    }

    public function updateStatus($id_detail, $status) {
        // Sesuaikan dengan struktur tabel dan query Anda
        $data = array(
            'status' => $status
        );

        $this->db->where('kode_pemesanan', $id_detail);
        $this->db->update('tb_detailpemesanan', $data);
    }
    
    public function get_filtered_data($tgl_awal, $tgl_akhir) {
        $this->db->select('p.kode_pemesanan, p.id_pelanggan, p.no_lapangan, p.tgl_main, p.jam_bermain, p.total_bayar,  d.id_detail, d.jam_dipesan, d.status, plg.nama_pelanggan, plg.no_hp');
        $this->db->from('tb_pemesanan p');
        $this->db->join('tb_detailpemesanan d', 'p.kode_pemesanan = d.kode_pemesanan AND p.tgl_main = d.tgl_main AND p.no_lapangan = d.no_lapangan');
        $this->db->join('tb_pelanggan plg', 'p.id_pelanggan = plg.id_pelanggan');
        // Fetch filtered data based on start and end date
        $this->db->where('p.tgl_main >=', $tgl_awal);
        $this->db->where('p.tgl_main <=', $tgl_akhir);
        $query = $this->db->get();
        return $query->result();
    }
}
