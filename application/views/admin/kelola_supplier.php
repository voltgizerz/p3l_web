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
        
        
        <?php echo form_open("admin/logSupplier"); ?>
        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubMenuModal">TAMBAH SUPPLIER</a>
        <input type="submit" name="log" class="btn btn-danger mb-3" value="LOG DELETE SUPPLIER">
        <?php echo form_close(); ?>
        
        <div class="form-group">
            <?php echo form_open("admin/cariSupplier"); ?>
            <select name="cariberdasarkan">
                <option value="">Cari Berdasarkan</option>
                <option value="id_supplier">Id Supplier</option>
                <option value="nama_supplier">Nama Supplier</option>
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
                    <th scope="col" class="text-center">Nama Supplier</th>
                    <th scope="col" class="text-center">Alamat Supplier</th>
                    <th scope="col" class="text-center">Nomor Telepon</th>
                    <th scope="col" class="text-center">Created Date</th>
                    <th scope="col" class="text-center">Updated Date</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($dataSupplier as $sm) : ?>
                <tr>
                    <th scope="row" class="text-center"><?= $i ?></th>
                    <td><?= $sm['nama_supplier'] ?></td>
                    <td class="text-center"><?= $sm['alamat_supplier'] ?></td>
                    <td class="text-center"><?= $sm['nomor_telepon_supplier'] ?></td>
                    <td class="text-center"><?= $sm['created_date'] ?></td>
                    <td class="text-center"><?= $sm['updated_date'] ?></td>

                    <td>
                        <a href="<?= base_url(); ?>admin/updateSupplier/<?= $sm['id_supplier']; ?>"
                            class="badge badge-primary mb-3" data-toggle="modal"
                            data-target="#editSubMenuModal<?= $sm['id_supplier']; ?>">EDIT</a>
                        <a href="<?= base_url(); ?>admin/hapusSupplier/<?= $sm['id_supplier']; ?>"
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
                <h5 class="modal-title" id="newMenuModal">Tambah Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/kelola_supplier'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama_supplier" name="nama_supplier"
                            placeholder="Nama Supplier">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="alamat_supplier" name="alamat_supplier"
                            placeholder="Alamat Supplier">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nomor_telepon_supplier"
                            name="nomor_telepon_supplier" placeholder="Nomor Telepon">
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

<?php foreach ($dataSupplier as $sm) : ?>
<!-- Modal edit -->
<div class="modal fade" id="editSubMenuModal<?= $sm['id_supplier']; ?>" tabindex="-1" role="dialog"
    aria-labelledby="#editSubMenuModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubMenuModal">Edit Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url(); ?>admin/updateSupplier/<?= $sm['id_supplier']; ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input hidden type="text" class="form-control" value="<?= $sm['id_supplier']; ?>" id="id"
                            name="id">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama"
                            value="<?= $sm['nama_supplier']; ?>" placeholder="Nama Supplier">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="alamat_supplier" name="alamat_supplier"
                            value="<?= $sm['alamat_supplier']; ?>" placeholder="Alamat Supplier">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nomor_telepon_supplier"
                            name="nomor_telepon_supplier" value="<?= $sm['nomor_telepon_supplier']; ?>"
                            placeholder="Nomor HP">
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