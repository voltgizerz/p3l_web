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

        <?php echo form_open("admin/logProduk"); ?>
        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubMenuModal">TAMBAH PRODUK</a>
        <input type="submit" name="log" class="btn btn-danger mb-3" value="LOG DELETE UKURAN HEWAN">
        <?php echo form_close(); ?>

        <div class="form-group">
            <?php echo form_open("admin/cariProduk"); ?>
            <div class="input-group " style="width: 600px;">
                <select class="custom-select" id="inputGroupSelect07" name="cariberdasarkan">
                    <option value="">Cari Berdasarkan</option>
                    <option value="id_produk">Id Produk</option>
                    <option value="nama_produk">Nama Produk</option>
                    <option value="harga_produk">Harga Produk Termurah</option>
                    <option value="harga_produk_mahal">Harga Produk Termahal</option>
                    <option value="stok_produk">Stok Produk Terbanyak</option>
                    <option value="stok_produk_sedikit">Stok Produk Sedikit</option>
                </select>
                <div class="input-group-append">
                    <input type="text" class="form-control" style="border-radius: 0;" placeholder="Kata Pencarian..."
                        name="yangdicari" id="" type="text" aria-label="Text input with dropdown button"
                        aria-describedby="basic-addon2">

                    <button class="btn btn-success" type="submit" name="cari" value="Cari"><i
                            class="fas fa-search"></i></button>
                </div>
            </div>
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
                    <?php if ($sm['stok_produk'] == 0): ?>
                    <td style="text-align:center; color:#FF0000"> STOK KOSONG </td>
                    <?php elseif ($sm['stok_produk'] < $sm['stok_minimal_produk'] ): ?>
                    <td style="text-align:center; color:#FFFF00"><?=$sm['stok_produk']?><br>(Stok Menipis)</br></td>
                    <?php else: ?>
                    <td style="text-align:center;"><?=$sm['stok_produk']?></td>
                    <?php endif;?>
                    <td style="text-align:center;"><?= $sm['stok_minimal_produk'] ?></td>
                    <td style="text-align:center;"><?= $sm['created_date'] ?></td>
                    <?php if ($sm['updated_date'] == '0000-00-00 00:00:00'): ?>
                    <td style="text-align:center;"> - </td>
                    <?php else: ?>
                    <td style="text-align:center;"><?=$sm['updated_date']?></td>
                    <?php endif;?>
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
                <h5 class="modal-title" id="newMenuModal">Tambah Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/kelola_produk'); ?>" method="post" enctype="multipart/form-data">
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
            <form action="<?= base_url(); ?>admin/updateProduk/<?= $sm['id_produk']; ?>" method="post"
                enctype="multipart/form-data">

                <div class="modal-body">
                    <div class="form-group">
                        <input hidden type="text" class="form-control" value="<?= $sm['id_produk']; ?>" id="id"
                            name="id">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= $sm['nama_produk']; ?>"
                            placeholder="Nama Produk">
                    </div>

                    <div class="form-group">

                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="gambar_produk" name="gambar_produk">
                            <label class="custom-file-label" for="gambar_produk">Pilih Gambar Produk</label>
                        </div>

                    </div>

                    <div class="form-group">
                        <input type="number" class="form-control" id="harga" name="harga"
                            value="<?= $sm['harga_produk']; ?>" placeholder="Harga Produk">
                    </div>

                    <div class="form-group">
                        <input type="number" class="form-control" id="stok" name="stok"
                            value="<?= $sm['stok_produk']; ?>" placeholder="Stok Produk">
                    </div>

                    <div class="form-group">
                        <input type="number" class="form-control" id="stok_minimal"
                            value="<?= $sm['stok_minimal_produk']; ?>" name="stok_minimal"
                            placeholder="Stok Minimal Produk">
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