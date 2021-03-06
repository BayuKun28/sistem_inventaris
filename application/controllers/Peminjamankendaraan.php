<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peminjamankendaraan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('jenis_model');
        $this->load->model('jenis_ranmor_model');
        $this->load->model('unit_pengguna_model');
        $this->load->model('kondisi_model');
        $this->load->model('jenis_bbm_model');
        $this->load->model('kendaraan_model');
        $this->load->model('peminjamankendaraan_model');
        if (!$this->session->userdata('is_logged_in')) {
            redirect('/');
        }
    }
    public function index()
    {

        $data['title'] = 'Peminjaman / Kendaraan';
        $data['user'] = $this->db->get_where('pengguna', ['username' => $this->session->userdata('username')])->row_array();
        $user = $this->db->get_where('pengguna', ['username' => $this->session->userdata('username')])->row_array();

        if ($user['level'] == 1) {
            $filter = '';
        }else{
            $filter = ' AND p.id_user = '. $user['id'] . '';
        }
        $data['pinjam'] = $this->peminjamankendaraan_model->read($filter);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('peminjamankendaraan/index', $data);
    }
    public function FormInput()
    {

        $data['title'] = 'Peminjaman / Input Peminjaman Kendaraan';
        $data['user'] = $this->db->get_where('pengguna', ['username' => $this->session->userdata('username')])->row_array();
        $data['jenis'] = $this->jenis_model->read();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('peminjamankendaraan/input', $data);
    }

    public function tambah()
    {

        $banyakbarang = $this->input->post('nama_barang');
        $jadisatu = implode(",", $banyakbarang);
        $data = array(
            'nama' => $this->input->post('nama_peminjam'),
            'nama_unit' => $this->input->post('nama_unit'),
            // 'nama_barang' => 'In Detail',
            'nama_barang' => implode(",",$this->input->post('nama_barang')),
            'tgl_pinjam' => $this->input->post('tgl_pinjam'),
            'keterangan' => $this->input->post('keterangan'),
            'jenis_pinjam' => 1,
            'id_user' => $this->input->post('id_user')
        );

        $id_pinjam = $this->peminjamankendaraan_model->tambah($data);

        $data2 = array(
            'status' => 1
        );

        foreach ($banyakbarang as $b) {
            $idupdate = $b;
            $this->db->where('id', $idupdate);
            $this->db->update('kendaraan', $data2);  

            $datadetail = array(
                        'peminjaman_id' => $id_pinjam,
                        'barang' => $b
            );
            $this->db->insert('detail_transaksi_kendaraan', $datadetail);
        }
        $this->session->set_flashdata('message', 'Berhasil Ditambah');
        redirect('Peminjamankendaraan');
    }

    public function detail()
    {
        $id = $this->uri->segment(3);
        $data['title'] = 'Detail Peminjaman';
        $data['user'] = $this->db->get_where('pengguna', ['username' => $this->session->userdata('username')])->row_array();
        $data['info'] = $this->peminjamankendaraan_model->detail($id);
        $data['infokendaraan'] = $this->peminjamankendaraan_model->detailkendaraan($id);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('peminjamankendaraan/detail', $data);
    }

    public function edit()
    {

        $id = $this->uri->segment(3);
        $data['title'] = 'Edit Peminjaman';
        $data['user'] = $this->db->get_where('pengguna', ['username' => $this->session->userdata('username')])->row_array();
        $data['info'] = $this->peminjamankendaraan_model->detail($id);
        $data['infokendaraan'] = $this->peminjamankendaraan_model->detailkendaraan($id);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('peminjamankendaraan/edit', $data);
    }

    public function simpanedit()
    {

        $id = $this->input->post('id_peminjaman');
        $data = array(
            'nama' => $this->input->post('nama_peminjam'),
            'tgl_pinjam' => $this->input->post('tgl_pinjam'),
            'keterangan' => $this->input->post('keterangan')
        );

        $this->db->where('id', $id);
        $this->db->update('peminjaman', $data);

        $this->session->set_flashdata('message', 'Berhasil Di Update');
        redirect('Peminjamankendaraan');
    }

    public function kembali()
    {
        $id = $this->input->post('idkembali');
        $data = array(
            'tgl_kembali' => $this->input->post('tgl_kembali')
        );
        $this->db->where('id', $id);
        $this->db->update('peminjaman', $data);

        $idbarang = $this->input->post('idbarang');
        
        $this->peminjamankendaraan_model->kembali($idbarang);

        $this->session->set_flashdata('message', 'Berhasil Dikembalikan');
        redirect('Peminjamankendaraan');
    }

    public function getnamabarang()
    {
        $un = $this->input->get('un');
        $query = $this->kendaraan_model->getkendaraan2($un, 'no_pol');
        echo json_encode($query);
    }
}
