<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?> - Log Delete Admin AREA</h1>



</div>
<!-- /.container-fluid -->

<div class="row">
    <div class="col-lg ml-3 mr-3">
        <?php if (validation_errors()) : ?>
        <div class="alert alert-danger" role="alert">
            <?= validation_errors(); ?>
        </div>
        <?php endif; ?>

        <?php echo form_open("admin/logUkuranHewan"); ?>
        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubMenuModal">TAMBAH UKURAN
            HEWAN</a>
        <input type="submit" name="log" class="btn btn-danger mb-3" value="LOG DELETE UKURAN HEWAN">
        <?php echo form_close(); ?>


        <?= $this->session->flashdata('message'); ?>


        <table class="table table-striped table-dark table-hover  table-responsive-sm">
            <thead>
                <tr>
                    <th scope="col" class="text-center">No</th>
                    <th scope="col" class="text-center">Nama Ukuran Hewan</th>
                    <th scope="col" class="text-center">Deleted Date</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($dataUkuranHewan as $sm) : ?>
                <tr>
                    <th scope="row" class="text-center"><?= $i ?></th>
                    <td style="text-align:center;"><?= $sm['ukuran_hewan'] ?></td>
                    <td style="text-align:center;"><?= $sm['deleted_date'] ?></td>

                    <td style="text-align:center;">
                        <a href="<?= base_url(); ?>admin/restoreUkuranHewan/<?= $sm['id_ukuran_hewan']; ?>"
                            class="badge badge-primary mb-3">RESTORE</a>
                        <a href=" <?= base_url(); ?>admin/deletePermUkuranHewan/<?= $sm['id_ukuran_hewan']; ?>"
                            class="badge badge-danger mb-3">DELETE PREMANENT</a>
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
                <h5 class="modal-title" id="newMenuModal">Tambah Ukuran Hewan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/kelola_ukuran_hewan'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Ukuran Hewan">
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

<?php foreach ($dataUkuranHewan as $sm) : ?>
<!-- Modal edit -->
<div class="modal fade" id="editSubMenuModal<?= $sm['id_ukuran_hewan']; ?>" tabindex="-1" role="dialog"
    aria-labelledby="#editSubMenuModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubMenuModal">Edit Profile Using Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url(); ?>admin/updateUkuranHewan/<?= $sm['id_ukuran_hewan']; ?>" method="post">

                <div class="modal-body">
                    <div class="form-group">
                        <input hidden type="text" class="form-control" value="<?= $sm['id_ukuran_hewan']; ?>" id="id"
                            name="id">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama"
                            value="<?= $sm['ukuran_hewan']; ?>" placeholder="Nama Ukuran Hewan">
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