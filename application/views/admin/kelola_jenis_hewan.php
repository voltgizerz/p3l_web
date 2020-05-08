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

        <?php echo form_open("admin/logJenisHewan"); ?>
        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubMenuModal">TAMBAH JENIS
            HEWAN</a>
            <input type="submit" name="log" class="btn btn-danger mb-3" value="LOG DELETE JENIS HEWAN">
        <?php echo form_close(); ?>

        <div class="form-group">
            <?php echo form_open("admin/cariJenisHewan"); ?>
            <select name="cariberdasarkan">
                <option value="">Cari Berdasarkan</option>
                <option value="id_jenis_hewan">Id Jenis Hewan</option>
                <option value="nama_jenis_hewan">Nama Jenis Hewan</option>
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
                    <th scope="col" class="text-center">Nama Jenis Hewan</th>
                    <th scope="col" class="text-center">Created Date</th>
                    <th scope="col" class="text-center">Updated Date</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($dataJenisHewan as $sm) : ?>
                <tr>
                    <th scope="row" class="text-center"><?= $i ?></th>
                    <td style="text-align:center;"><?= $sm['nama_jenis_hewan'] ?></td>
                    <td style="text-align:center;"><?= $sm['created_date'] ?></td>
                    <?php if ($sm['updated_date'] == '0000-00-00 00:00:00'): ?>
                    <td style="text-align:center;"> - </td>
                    <?php else: ?>
                    <td style="text-align:center;"><?=$sm['updated_date']?></td>
                    <?php endif;?>

                    <td style="text-align:center;">
                        <a href="<?= base_url(); ?>admin/updateJenisHewan/<?= $sm['id_jenis_hewan']; ?>"
                            class="badge badge-primary mb-3" data-toggle="modal"
                            data-target="#editSubMenuModal<?= $sm['id_jenis_hewan']; ?>">EDIT</a>
                        <a href="<?= base_url(); ?>admin/hapusJenisHewan/<?= $sm['id_jenis_hewan']; ?>"
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
            <form action="<?= base_url('admin/kelola_jenis_hewan'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Jenis Hewan">
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

<?php foreach ($dataJenisHewan as $sm) : ?>
<!-- Modal edit -->
<div class="modal fade" id="editSubMenuModal<?= $sm['id_jenis_hewan']; ?>" tabindex="-1" role="dialog"
    aria-labelledby="#editSubMenuModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubMenuModal">Edit Profile Using Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url(); ?>admin/updateJenisHewan/<?= $sm['id_jenis_hewan']; ?>" method="post">

                <div class="modal-body">
                    <div class="form-group">
                        <input hidden type="text" class="form-control" value="<?= $sm['id_jenis_hewan']; ?>" id="id"
                            name="id">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama"
                            value="<?= $sm['nama_jenis_hewan']; ?>" placeholder="Nama Jenis Hewan">
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