<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Form Input Peminjaman
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Peminjaman</a></li>
            <li class="active">Form Input</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="<?= base_url('Peminjamankendaraan/tambah'); ?>" method="POST" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="nama_peminjam">Nama Peminjam</label>
                                        <input type="hidden" class="form-control" id="id_user" name="id_user" value="<?= $user['id']; ?>" required>
                                        <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nama_barang">No Pol Kendaraan</label>
                                        <select id="nama_barang" name="nama_barang[]" class="itemNama_barang form-control" multiple="multiple" required>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="nama_unit">Nama Unit</label>
                                        <input type="text" class="form-control" id="nama_unit" name="nama_unit" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tgl_pinjam">Tanggal Pinjam</label>
                                        <input type="date" class="form-control" id="tgl_pinjam" name="tgl_pinjam" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea class="form-control" name="keterangan" id="keterangan" cols="25" rows="5"></textarea>
                            </div>
                            <div class="box-footer text-right">
                                <a href="<?= base_url('Peminjamankendaraan'); ?>" class="btn btn-danger">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?php $this->load->view('templates/footer'); ?>
<script>
    $(function() {
        $('.itemNama_barang').select2({
            width: '100%',
            ajax: {
                url: "<?= base_url(); ?>/Peminjamankendaraan/getnamabarang",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        un: params.term
                    };
                },
                processResults: function(data) {
                    var results = [];
                    $.each(data, function(index, item) {
                        results.push({
                            id: item.id,
                            text: item.no_pol
                        });
                    });
                    return {
                        results: results
                    }
                }
            }
        });
    });
</script>
<?php
if (!empty($this->session->flashdata('message'))) {
    $pesan = $this->session->flashdata('message');
    if ($pesan == "Berhasil Ditambah") {
        $script = "
                    <script>
                            Swal.fire({
                              icon: 'success',
                              title: 'Data',
                              text: 'Data Berhasil Ditambah'
                            }) 
                    </script>
                ";
    } elseif ($pesan == "Berhasil Dihapus") {
        // die($pesan);
        $script = "
                    <script>
                            Swal.fire({
                              icon: 'success',
                              title: 'Data',
                              text: 'Berhasil Dihapus'
                            }) 
                    </script>
                ";
    } elseif ($pesan == "Berhasil Di Update") {
        // die($pesan);
        $script = "
                    <script>
                            Swal.fire({
                              icon: 'success',
                              title: 'Data',
                              text: 'Berhasil Di Update'
                            }) 
                    </script>
                ";
    } else {
        $script =
            "
                    <script>
                                Swal.fire({
                                  icon: 'error',
                                  title: 'Data',
                                  text: 'Gagal'
                                }) 

                    </script>
                    ";
    }
} else {
    $script = "";
}
echo $script;
?>