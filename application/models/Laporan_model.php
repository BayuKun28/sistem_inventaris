<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_model extends CI_Model
{
    public function readkendaraanpinjam($xtglawal, $xtglakhir,$filter)
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
                    WHERE p.jenis_pinjam = 1 AND p.tgl_kembali IS NULL AND (p.tgl_pinjam BETWEEN '$xtglawal' AND '$xtglakhir') $filter
                    GROUP BY p.id
                    ORDER BY p.id ASC";
        return $this->db->query($query)->result_array();
        echo json_encode($query);
    }
    public function readkendaraankembali($xtglawal, $xtglakhir,$filter)
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
                        WHERE p.jenis_pinjam = 1 AND p.tgl_kembali IS NOT NULL AND (p.tgl_pinjam BETWEEN '$xtglawal' AND '$xtglakhir') $filter
                        GROUP BY p.id
                        ORDER BY p.id ASC";
        // die($query);
        return $this->db->query($query)->result_array();
        echo json_encode($query);
    }

    public function readelektronikpinjam($xtglawal, $xtglakhir,$filter)
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
                WHERE p.jenis_pinjam = 2 AND p.tgl_kembali IS NULL AND (p.tgl_pinjam BETWEEN '$xtglawal' AND '$xtglakhir') $filter
                GROUP BY p.id
                ORDER BY p.id ASC";
        return $this->db->query($query)->result_array();
        echo json_encode($query);
    }
    public function readelektronikkembali($xtglawal, $xtglakhir,$filter)
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
                WHERE p.jenis_pinjam = 2 AND p.tgl_kembali IS NOT NULL AND (p.tgl_pinjam BETWEEN '$xtglawal' AND '$xtglakhir') $filter
                GROUP BY p.id
                ORDER BY p.id ASC";
        return $this->db->query($query)->result_array();
        echo json_encode($query);
    }
}
