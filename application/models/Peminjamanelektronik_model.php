<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peminjamanelektronik_model extends CI_Model
{
    public function read($filter)
    {
        $query = "SELECT p.id,p.nama,
                        p.jenis_pinjam,
                        (GROUP_CONCAT(concat(e.nama_barang,' -> ',d.qty,'<br>') SEPARATOR '\n')) as nama_barang,
                        p.nama_barang as idbarang,p.nama_unit,
                        p.tgl_pinjam,
                        p.tgl_kembali,
                        p.keterangan
                FROM peminjaman p
                    LEFT JOIN jenis j on j.id = p.jenis_pinjam
                    LEFT JOIN detail_transaksi_elektronik d on d.peminjaman_id = p.id
                    LEFT JOIN elektronik e on e.id  = d.barang
                WHERE p.jenis_pinjam = 2 $filter
                GROUP BY p.id
                ORDER BY p.id DESC";
        return $this->db->query($query)->result_array();
        echo json_encode($query);
    }

    public function detail($id)
    {
        $query = "SELECT p.id,p.nama as nama_peminjam,
                    p.jenis_pinjam,
                    (CASE
                        WHEN j.id = 1 THEN (
                                                SELECT concat('Kendaraan Dengan No Pol', ' ', k.no_pol)
                                                FROM kendaraan k
                                                WHERE k.id = p.nama_barang
                        )
                        WHEN j.id = 2 THEN (
                                                SELECT e.nama_barang
                                                FROM elektronik e
                                                WHERE e.id = p.nama_barang
                        )
                        END) as nama_barang,p.nama_barang as idbarang,p.nama_unit, e.nomor_seri_barang,ko.kondisi,e.image,e.status,
                    p.tgl_pinjam,
                    p.tgl_kembali,
                    p.keterangan
            FROM peminjaman p
                LEFT JOIN jenis j on j.id = p.jenis_pinjam
                LEFT JOIN elektronik e on e.id = p.nama_barang
                LEFT JOIN kondisi ko on ko.id = e.kondisi
            WHERE p.jenis_pinjam = 2 AND p.id = '$id'
            ORDER BY p.id ASC";
        return $this->db->query($query)->row_array();
        echo json_encode($query);
    }

    public function detail_elektronik($id)
    {
        $query = "SELECT e.nama_barang,e.nomor_seri_barang, k.kondisi ,d.qty,e.image
                    FROM detail_transaksi_elektronik d 
                    LEFT JOIN elektronik e on e.id = d.barang
                    LEFT JOIN kondisi k on k.id = e.kondisi
                    WHERE d.peminjaman_id = '$id'
                    ORDER BY e.id ASC";
        return $this->db->query($query)->result_array();
        echo json_encode($query);
    }

    public function getStok($id)
    {
        $this->db->select('jumlah');
        $this->db->where('id', $id);
        return $this->db->get('elektronik')->row();
    }

    public function tambah_pinjam($data)
    {
        $this->db->insert('peminjaman', $data);
        $id = $this->db->insert_id();
        return (isset($id)) ? $id : FALSE;
    }

    public function addStok($id, $jumlah)
    {
        $this->db->where('id', $id);
        $this->db->set('jumlah', $jumlah);
        return $this->db->update('elektronik');
    }
    public function tambah_detail_order($data)
    {
        $this->db->insert('detail_transaksi_elektronik', $data);
    }
    public function kembali($id)
    {
        $query = "
                UPDATE elektronik e 
                JOIN (SELECT d.barang,d.qty FROM detail_transaksi_elektronik d  WHERE d.peminjaman_id = '$id' ORDER BY d.barang ASC ) z on z.barang = e.id
                SET
                e.jumlah = e.jumlah + z.qty
        ";
        return $this->db->query($query);
    }
}
