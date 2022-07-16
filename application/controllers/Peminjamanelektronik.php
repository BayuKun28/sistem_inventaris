<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peminjamanelektronik extends CI_Controller
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
        $this->load->model('elektronik_model');
        $this->load->model('peminjamanelektronik_model');
        if (!$this->session->userdata('is_logged_in')) {
            redirect('/');
        }
    }
    public function index()
    {

        $data['title'] = 'Peminjaman / Elektronik';
        $data['user'] = $this->db->get_where('pengguna', ['username' => $this->session->userdata('username')])->row_array();
        $user = $this->db->get_where('pengguna', ['username' => $this->session->userdata('username')])->row_array();

        if ($user['level'] == 1) {
            $filter = '';
        }else{
            $filter = ' AND p.id_user = '. $user['id'] . '';
        }
        $data['pinjam'] = $this->peminjamanelektronik_model->read($filter);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('peminjamanelektronik/index', $data);
    }
    public function FormInput()
    {

        $data['title'] = 'Peminjaman / Input Peminjaman Elektronik';
        $data['user'] = $this->db->get_where('pengguna', ['username' => $this->session->userdata('username')])->row_array();
        $data['jenis'] = $this->jenis_model->read();
        $data['barangpinjam'] = $this->elektronik_model->getall();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('peminjamanelektronik/input', $data);
    }


    function add_to_cart()
    {
        $data = array(
            'id' => $this->input->post('id_barang'),
            'name' => $this->input->post('nama_barang'),
            'nomor_seri_barang' =>  $this->input->post('nomor_seri_barang'),
            'price' => 0,
            'qty' => $this->input->post('qty'),
        );
        $this->cart->insert($data);
        // var_dump($data);
        echo $this->show_cart();
    }
    function show_cart()
    {
        $output = '';
        $no = 0;
        foreach ($this->cart->contents() as $items) {
            $no++;
            $output .= '
            <tr>
            <td>' . $items['name'] . '</td>
            <td>' . $items['nomor_seri_barang'] . '</td>
            <td>' . $items['qty'] . '</td>
            <td><button type="button" id="' . $items['rowid'] . '" class="hapus_cart btn btn-danger btn-xs">Batal</button></td>
            </tr>
            ';
        }
        $output .= '


        ';
        return $output;
    }

    function load_cart()
    {
        echo $this->show_cart();
    }
    function hapus_cart()
    {
        $data = array(
            'rowid' => $this->input->post('row_id'),
            'qty' => 0,
        );
        $this->cart->update($data);
        echo $this->show_cart();
    }

    public function tambahlama()
    {
        $data = array(
            'nama' => $this->input->post('nama_peminjam'),
            'nama_barang' => $this->input->post('nama_barang'),
            'nama_unit' => $this->input->post('nama_unit'),
            'tgl_pinjam' => $this->input->post('tgl_pinjam'),
            'keterangan' => $this->input->post('keterangan'),
            'jenis_pinjam' => 2
        );

        $this->db->insert('peminjaman', $data);

        $idupdate = $this->input->post('nama_barang');

        $stok = $this->peminjamanelektronik_model->getStok($idupdate)->jumlah;
        $rumus = max($stok - 1, 0);
        $data2 = array(
            'jumlah' => $rumus
        );

        $this->db->where('id', $idupdate);
        $this->db->update('elektronik', $data2);

        $this->session->set_flashdata('message', 'Berhasil Ditambah');
        redirect('Peminjamanelektronik');
    }

    public function tambah()
    {

        if ($cart = $this->cart->contents()) {
            $data_order = array(
                'nama' => $this->input->post('nama_peminjam'),
                'nama_barang' => 'In Detail',
                'nama_unit' => $this->input->post('nama_unit'),
                'tgl_pinjam' => $this->input->post('tgl_pinjam'),
                'keterangan' => $this->input->post('keterangan'),
                'jenis_pinjam' => 2,
                'id_user' => $this->input->post('id_user')
            );
            $id_pinjam = $this->peminjamanelektronik_model->tambah_pinjam($data_order);
            foreach ($cart as $item) {
                $data_detail = array(
                    'peminjaman_id' => $id_pinjam,
                    'barang' => $item['id'],
                    'qty' => $item['qty']
                );
                $id = $item['id'];
                $jumlah = $item['qty'];
                $stok = $this->peminjamanelektronik_model->getStok($id)->jumlah;
                $rumus = max($stok - $jumlah, 0);
                $addStok = $this->peminjamanelektronik_model->addStok($id, $rumus);
                $proses = $this->peminjamanelektronik_model->tambah_detail_order($data_detail);
            }
            $this->session->set_flashdata('message', 'Berhasil Ditambah');
            $this->cart->destroy();
            redirect('Peminjamanelektronik');
        }else{
            $this->session->set_flashdata('message', 'Gagal');
            redirect('Peminjamanelektronik/FormInput','refresh');
        }
}

public function detail()
{
    $id = $this->uri->segment(3);
    $data['title'] = 'Detail Peminjaman';
    $data['user'] = $this->db->get_where('pengguna', ['username' => $this->session->userdata('username')])->row_array();
    $data['info'] = $this->peminjamanelektronik_model->detail($id);
    $data['detail'] = $this->peminjamanelektronik_model->detail_elektronik($id);
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('peminjamanelektronik/detail', $data);
}

public function kembali()
{
    $id = $this->input->post('idkembali');
    $data = array(
        'tgl_kembali' => $this->input->post('tgl_kembali')
    );
    $this->db->where('id', $id);
    $this->db->update('peminjaman', $data);

    $proses = $this->peminjamanelektronik_model->kembali($id);

    $this->session->set_flashdata('message', 'Berhasil Dikembalikan');
    redirect('Peminjamanelektronik');
}

public function delete($id)
{
    $this->db->where('id', $id);
    $this->db->delete('kendaraan');
    $this->session->set_flashdata('message', 'Berhasil Dihapus');
    redirect('Kendaraan');
}
public function getnamabarang()
{
    $un = $this->input->get('un');
    $query = $this->elektronik_model->getelektronik2($un, 'nama_barang');
    echo json_encode($query);
}
}
