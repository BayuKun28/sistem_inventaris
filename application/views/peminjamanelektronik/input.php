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
                    <form action="<?= base_url('Peminjamanelektronik/tambah'); ?>" method="POST" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="nama_peminjam">Nama Peminjam</label>
                                        <input type="hidden" class="form-control" id="id_user" name="id_user" value="<?= $user['id']; ?>" required>
                                        <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nama_unit">Nama Unit</label>
                                        <input type="text" class="form-control" id="nama_unit" name="nama_unit" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="tgl_pinjam">Tanggal Pinjam</label>
                                        <input type="date" class="form-control" id="tgl_pinjam" name="tgl_pinjam" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="keterangan">Keterangan</label>
                                        <textarea class="form-control" name="keterangan" id="keterangan" cols="25" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer text-right">
                                <a href="<?= base_url('Peminjamanelektronik'); ?>" class="btn btn-danger">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h4><b>Barang Tersedia</b></h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="tablebarang">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Barang</th>
                                                <th>Nomor Seri Barang</th>
                                                <th>Jumlah</th>
                                                <th>Qty</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($barangpinjam as $row) : ?>
                                                <tr>
                                                    <td><?= $i; ?></td>
                                                    <td><?php echo $row->nama_barang; ?></td>
                                                    <td><?php echo $row->nomor_seri_barang; ?></td>
                                                    <td>
                                                        <?php echo $row->jumlah; ?>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="number" name="quantity" id="<?php echo $row->id; ?>" value="1" class="quantity form-control">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><button class="add_cart btn btn-success" data-id_barang="<?php echo $row->id; ?>" data-nama_barang="<?php echo $row->nama_barang; ?>" data-nomor_seri_barang="<?php echo $row->nomor_seri_barang; ?>" data-jumlah="<?php echo $row->jumlah; ?>">
                                                            <i class=" fa fa-fw fa-shopping-bag"></i> Add</button></td>
                                                </tr>
                                                <?php $i++; ?>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h4><b>Daftar Pinjam</b></h4>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Nomor Seri Barang</th>
                                            <th>Qty</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detail_cart">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</section>
</div>

<?php $this->load->view('templates/footer'); ?>
<script>
    $(document).ready(function() {

        $('#tablebarang').DataTable({
            fixedColumns: true,
            responsive: true,
            "paging": false,
            "scrollY": "300px",
            "scrollCollapse": true,

        });
        $('#tablecart').DataTable({
            "columnDefs": [{
                "width": "5",
                "targets": 0
            }],
            fixedColumns: true,
            responsive: true

        });

        $('.add_cart').click(function() {
            var id_barang = $(this).data("id_barang");
            var nama_barang = $(this).data("nama_barang");
            var jumlah = $(this).data("jumlah");
            var nomor_seri_barang = $(this).data("nomor_seri_barang");
            var qty = $('#' + id_barang).val();
            if (qty > jumlah) {
                alert('Stok Kurang');
            } else {
                $.ajax({
                    url: "<?php echo base_url(); ?>Peminjamanelektronik/add_to_cart",
                    method: "POST",
                    data: {
                        id_barang: id_barang,
                        nama_barang: nama_barang,
                        nomor_seri_barang: nomor_seri_barang,
                        qty: qty
                    },
                    success: function(data) {
                        $('#detail_cart').html(data);
                    }
                });
            }
        });


        $('#detail_cart').load("<?php echo base_url(); ?>Peminjamanelektronik/load_cart");

        $(document).on('click', '.hapus_cart', function() {
            var row_id = $(this).attr("id");
            $.ajax({
                url: "<?php echo base_url(); ?>Peminjamanelektronik/hapus_cart",
                method: "POST",
                data: {
                    row_id: row_id
                },
                success: function(data) {
                    $('#detail_cart').html(data);
                }
            });
        });
    });



    $(function() {
        $('.itemNama_barang').select2({
            width: '100%',
            ajax: {
                url: "<?= base_url(); ?>/Peminjamanelektronik/getnamabarang",
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
                            text: item.nama_barang
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