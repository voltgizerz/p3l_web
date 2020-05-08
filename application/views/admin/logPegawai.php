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

        <?php echo form_open("admin/logPegawai"); ?>
        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubMenuModal">TAMBAH PEGAWAI</a>
        <input type="submit" name="log" class="btn btn-danger mb-3" value="LOG DELETE PEGAWAI">
        <?php echo form_close(); ?>

        <?= $this->session->flashdata('message'); ?>

        <table class="table table-striped table-dark table-hover  table-responsive-sm">
            <thead>
                <tr>
                    <th scope="col" class="text-center">No</th>
                    <th scope="col" class="text-center">Nama Pegawai</th>
                    <th scope="col" class="text-center">Alamat Pegawai</th>
                    <th scope="col" class="text-center">Tanggal Lahir</th>
                    <th scope="col" class="text-center">Nomor Hp</th>
                    <th scope="col" class="text-center">Role</th>
                    <th scope="col" class="text-center">Username</th>
                    <th scope="col" class="text-center">Deleted Date</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($dataPegawai as $sm) : ?>
                <tr>
                    <th scope="row" class="text-center"><?= $i ?></th>
                    <td><?= $sm['nama_pegawai'] ?></td>
                    <td class="text-center"><?= $sm['alamat_pegawai'] ?></td>
                    <td class="text-center"><?= $sm['tanggal_lahir_pegawai'] ?></td>
                    <td class="text-center"><?= $sm['nomor_hp_pegawai'] ?></td>
                    <td class="text-center"><?= $sm['role_pegawai'] ?></td>
                    <td class="text-center"><?= $sm['username'] ?></td>
                    <td class="text-center"><?= $sm['deleted_date'] ?></td>

                    <td>
                        <a href="<?= base_url(); ?>admin/restorePegawai/<?= $sm['id_pegawai']; ?>"
                            class="badge badge-primary mb-3" data-toggle="modal"
                            data-target="#editSubMenuModal<?= $sm['id_pegawai']; ?>">RESTORE</a>
                        <a href="<?= base_url(); ?>admin/deletePermPegawai/<?= $sm['id_pegawai']; ?>"
                            class="badge badge-danger mb-3">DELETE PERMANENT</a>
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
                <h5 class="modal-title" id="newMenuModal">Tambah Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/kelola_pegawai'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Pegawai">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat Pegawai">
                    </div>
                    <div class="form-group">
                        <input type="date" class="form-control" id="tanggal" name="tanggal"
                            placeholder="Tanggal Lahir (YYYY-MM-DD) ">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nohp" name="nohp" placeholder="Nomor Handphone">
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="role" name="role">
                            <option value="">Pilih Role</option>
                            <option>Owner</option>
                            <option>Customer Service</option>
                            <option>Kasir</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Password">
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

<?php foreach ($dataPegawai as $sm) : ?>
<!-- Modal edit -->
<div class="modal fade" id="editSubMenuModal<?= $sm['id_pegawai']; ?>" tabindex="-1" role="dialog"
    aria-labelledby="#editSubMenuModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubMenuModal">Edit Profile Using Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url(); ?>admin/updatePegawai/<?= $sm['id_pegawai']; ?>" method="post">

                <div class="modal-body">
                    <div class="form-group">
                        <input hidden type="text" class="form-control" value="<?= $sm['id_pegawai']; ?>" id="id"
                            name="id">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama"
                            value="<?= $sm['nama_pegawai']; ?>" placeholder="Full Name">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="alamat" name="alamat"
                            value="<?= $sm['alamat_pegawai']; ?>" placeholder="Full Name">
                    </div>
                    <div class="form-group">
                        <input type="date" class="form-control" id="tanggal" name="tanggal"
                            value="<?= $sm['tanggal_lahir_pegawai']; ?>" placeholder="Tanggal Lahir (YYYY-MM-DD)">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nohp" name="nohp"
                            value="<?= $sm['nomor_hp_pegawai']; ?>" placeholder="Full Name">
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <select class="form-control" id="role" name="role">
                                <option value="">Pilih Role</option>
                                <option <?php if($sm['role_pegawai'] == 'Owner'){echo("selected");}?>>Owner</option>
                                <option <?php if($sm['role_pegawai'] == 'Customer Service'){echo("selected");}?>>
                                    Customer Service
                                </option>
                                <option <?php if($sm['role_pegawai'] == 'Kasir'){echo("selected");}?>>Kasir</option>
                            </select>
                        </div>
                    </div>
                    <div class=" form-group">
                        <input type="text" class="form-control" id="username" name="username"
                            value="<?= $sm['username']; ?>" placeholder="Username" readonly>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password" value=""
                            placeholder="Password">
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