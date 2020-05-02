<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?> - Admin AREA</h1>



</div>
<!-- /.container-fluid -->

<div class="row">
    <div class="col-lg ml-3 mr-3">
        <?php if (validation_errors()) : ?>
        <div class="alert alert-danger" role="alert">
            <?= validation_errors(); ?>
        </div>
        <?php endif; ?>
        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubMenuModal">TAMBAH PRODUK</a>
        <a href="" class="btn btn-danger mb-3" data-toggle="modal" data-target="#newSubMenuModal">LOG DELETE
            PRODUK</a>

        <div class="form-group">
            <?php echo form_open("admin/cariProduk"); ?>
            <select name="cariberdasarkan">
                <option value="">Cari Berdasarkan</option>
                <option value="id_jenis_hewan">Id Produk</option>
                <option value="nama_jenis_hewan">Nama Produk</option>
            </select>
            <input name="yangdicari" id="" type="text">
            <input type="submit" name="cari" value="Cari">
            <?php echo form_close(); ?>
        </div>
        <?= $this->session->flashdata('message'); ?>

        <table class="table table-striped table-dark table-hover  table-responsive-sm">
            <thead>
                <tr>
                    <th scope="col" class="text-center">No</th>
                    <th scope="col" class="text-center">Gambar Produk</th>
                    <th scope="col" class="text-center">Nama Produk</th>
                    <th scope="col" class="text-center">Harga Produk</th>
                    <th scope="col" class="text-center">Stok Produk</th>
                    <th scope="col" class="text-center">Stok Minimal Produk</th>
                    <th scope="col" class="text-center">Created Date</th>
                    <th scope="col" class="text-center">Updated Date</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($dataProduk as $sm) : ?>
                <tr>
                    <th scope="row" class="text-center"><?= $i ?></th>
                    <td style="text-align:center;"><img height="100" width="100"
                            src="<?=base_url();?><?=$sm['gambar_produk']?>" </td>
                    <td style="text-align:center;"><?= $sm['nama_produk'] ?></td>
                    <td style="text-align:center;">Rp. <?= $sm['harga_produk'] ?></td>
                    <td style="text-align:center;"><?= $sm['stok_produk'] ?></td>
                    <td style="text-align:center;"><?= $sm['stok_minimal_produk'] ?></td>
                    <td style="text-align:center;"><?= $sm['created_date'] ?></td>
                    <td style="text-align:center;"><?= $sm['updated_date'] ?></td>

                    <td style="text-align:center;">
                        <a href="<?= base_url(); ?>admin/updateProduk/<?= $sm['id_produk']; ?>"
                            class="badge badge-primary mb-3" data-toggle="modal"
                            data-target="#editSubMenuModal<?= $sm['id_produk']; ?>">EDIT</a>
                        <a href="<?= base_url(); ?>admin/hapusProduk/<?= $sm['id_produk']; ?>"
                            class="badge badge-danger mb-3">DELETE</a>
                    </td>
                </tr>
                <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- End of Main Content -->


<!-- Modal -->
<div class="modal fade" id="newSubMenuModal" tabindex="-1" role="dialog" aria-labelledby="#newSubMenuModal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModal">Tambah Jenis Hewan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/kelola_produk'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Produk">
                    </div>

                    <div class="form-group">

                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="gambar_produk" name="gambar_produk">
                            <label class="custom-file-label" for="gambar_produk">Pilih Gambar Produk</label>
                        </div>

                    </div>

                    <div class="form-group">
                        <input type="number" class="form-control" id="harga" name="harga" placeholder="Harga Produk">
                    </div>

                    <div class="form-group">
                        <input type="number" class="form-control" id="stok" name="stok" placeholder="Stok Produk">
                    </div>

                    <div class="form-group">
                        <input type="number" class="form-control" id="stok_minimal" name="stok_minimal"
                            placeholder="Stok Minimal Produk">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php foreach ($dataProduk as $sm) : ?>
<!-- Modal edit -->
<div class="modal fade" id="editSubMenuModal<?= $sm['id_produk']; ?>" tabindex="-1" role="dialog"
    aria-labelledby="#editSubMenuModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubMenuModal">Edit Data Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url(); ?>admin/updateProduk/<?= $sm['id_produk']; ?>" method="post">

                <div class="modal-body">
                    <div class="form-group">
                        <input hidden type="text" class="form-control" value="<?= $sm['id_produk']; ?>" id="id"
                            name="id">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= $sm['nama_produk']; ?>"
                            placeholder="Nama Jenis Hewan">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>