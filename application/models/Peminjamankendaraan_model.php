<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peminjamankendaraan_model extends CI_Model
{

    public function tambah($data)
    {
        $this->db->insert('peminjaman', $data);
        $id = $this->db->insert_id();
        return (isset($id)) ? $id : FALSE;
    }
    public function read($filter)
    {
        $query = "SELECT p.id,p.nama,
                        p.jenis_pinjam,
                        (GROUP_CONCAT(concat('Kendaraan Dengan No Pol', ' ', k.no_pol,'<br>') SEPARATOR '\n')) as nama_barang,
                        p.nama_barang as idbarang,p.nama_unit,
                        p.tgl_pinjam,
                        p.tgl_kembali,
                        p.keterangan
                FROM peminjaman p
                    LEFT JOIN jenis j on j.id = p.jenis_pinjam
                    LEFT JOIN detail_transaksi_kendaraan d on d.peminjaman_id = p.id
                    LEFT JOIN kendaraan k on k.id = d.barang
                WHERE p.jenis_pinjam = 1 $filter
                GROUP BY p.id
                ORDER BY p.id DESC";
        // die($query);
        return $this->db->query($query)->result_array();
        echo json_encode($query);
    }

    public function detail($id)
    {
        $query = "SELECT p.id,p.nama as nama_peminjam,
                        p.jenis_pinjam,
                        p.tgl_pinjam,
                        p.tgl_kembali,
                        p.keterangan
                FROM peminjaman p
                WHERE p.jenis_pinjam = 1 AND p.id = '$id'
                ORDER BY p.id ASC";
        return $this->db->query($query)->row_array();
        // var_dump($query);
        echo json_encode($query);
    }
    public function detail2($id)
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
                        END) as nama_barang,p.nama_barang as idbarang,p.nama_unit,k.merk,k.tipe_ranmor,u.unit_pengguna,k.no_pol,k.no_rangka,k.no_mesin,
                        k.tahun_perolehan,k.asal_perolehan,ko.kondisi,jb.nama_jenis_bbm,k.file,jr.nama_jenis_ranmor,
                        p.tgl_pinjam,
                        p.tgl_kembali,
                        p.keterangan,p.nama_barang as barangpinjam
                FROM peminjaman p
                    LEFT JOIN jenis j on j.id = p.jenis_pinjam
                    LEFT JOIN kendaraan k on k.id = p.nama_barang
                    LEFT JOIN unit_pengguna u on u.id = k.unit_pengguna
                    LEFT JOIN kondisi ko on ko.id = k.kondisi_ranmor
                    LEFT JOIN jenis_bbm jb on jb.id = k.jenis_bbm
                    LEFT JOIN jenis_ranmor jr on jr.id = k.jenis_ranmor
                WHERE p.jenis_pinjam = 1 AND p.id = '$id'
                ORDER BY p.id ASC";
        return $this->db->query($query)->row();
        echo json_encode($query);
    }
    public function detailkendaraan($id)
    {
        $query = "SELECT u.unit_pengguna,
                   u.unit_pengguna as nama_unit,
                   k.no_pol,
                   (CONCAT('Kendaraan Dengan No Pol ', k.no_pol)) as nama_barang,
                   k.file,
                   k.no_rangka,
                   k.merk,
                   k.no_mesin,
                   jr.nama_jenis_ranmor,
                   k.tahun_perolehan,
                   k.asal_perolehan,
                   jb.nama_jenis_bbm,
                   ko.kondisi,
                   k.tipe_ranmor
            FROM detail_transaksi_kendaraan d
                 LEFT JOIN kendaraan k on k.id = d.barang
                 LEFT JOIN unit_pengguna u on u.id = k.unit_pengguna
                 LEFT JOIN kondisi ko on ko.id = k.kondisi_ranmor
                 LEFT JOIN jenis_bbm jb on jb.id = k.jenis_bbm
                 LEFT JOIN jenis_ranmor jr on jr.id = k.jenis_ranmor
            WHERE d.peminjaman_id = $id ";
        return $this->db->query($query)->result_array();
        // die($query);
        // var_dump($query);
        echo json_encode($query);
    }
    public function kembali($xbarang)
    {
        $query = "UPDATE kendaraan set status = 0 WHERE id IN ($xbarang)";
        return $this->db->query($query);
        echo json_encode($query);
    }
}
