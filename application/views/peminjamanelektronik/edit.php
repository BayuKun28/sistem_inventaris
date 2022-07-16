<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Peminjaman Elektronik
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Peminjaman Elektronik</a></li>
            <li class="active">Edit</li>
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
                        <h3 class="box-title"><b>Informasi Peminjam</b></h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="<?= base_url('Peminjamanelektronik/simpanedit') ?>" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label>Nama Peminjam</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                            </div>
                                            <input type="hidden" name="id_peminjaman" class="form-control" value="<?= $info['id']; ?>" required>
                                            <input type="text" name="nama_peminjam" class="form-control" value="<?= $info['nama_peminjam']; ?>" required>
                                        </div>
                                        <label>Keterangan</label>
                                        <div class="input-group">
                                            <textarea class="form-control" name="keterangan" cols="100" rows="10" required><?= $info['keterangan']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label>Tanggal Pinjam</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="date" name="tgl_pinjam" class="form-control" value="<?= $info['tgl_pinjam']; ?>" required>
                                        </div>
                                        <label>Tanggal Kembali</label>
                                        <div class=" input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control" value="<?= $info['tgl_kembali']; ?>" disabled>
                                        </div>
                                        <label>Nama Unit</label>
                                        <div class=" input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                            </div>
                                            <input type="text" name="nama_unit" class="form-control" value="<?= $info['nama_unit']; ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer text-right">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="<?= base_url('Peminjamanelektronik'); ?>" class="btn btn-danger">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="box-header with-border">
                        <h3 class="box-title"><b>Informasi Elektronik Yang Dipinjam</b></h3>
                    </div>
                    <div class="box-body">
                        <div class="row col-md-12">
                            <div class="table-responsive">
                                <table id="tabledata" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>Nomor Seri Barang</th>
                                            <th>Kondisi</th>
                                            <th>Qty</th>
                                            <th>Gambar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($detail as $b) : ?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td><?= $b['nama_barang']; ?></td>
                                                <td><?= $b['nomor_seri_barang']; ?></td>
                                                <td><?= $b['kondisi']; ?></td>
                                                <td><?= $b['qty']; ?></td>
                                                <td>
                                                    <a href="<?= base_url('upload/') . $b['image']; ?>" class="btn btn-warning" target="_blank">Buka</a>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                        <?php endforeach; ?>

                                    </tbody>
                                </table>
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
            $('#tabledata').DataTable({
                responsive: true
            });
        });
    </script>