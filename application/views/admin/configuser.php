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
        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubMenuModal">ADD NEW MEMBERS</a>
        <a href="<?php echo site_url('Laporan/userAdmin') ?>" class="btn btn-primary mb-3"
            style="background-color:RED; ">PRINT TO PDF</a>

        <?= $this->session->flashdata('message'); ?>

        <table class="table table-striped table-dark table-hover  table-responsive-sm">
            <thead>
                <tr>
                    <th scope="col" class="text-center">No</th>
                    <th scope="col" class="text-center">Full Name</th>
                    <th scope="col" class="text-center">Member Email</th>
                    <th scope="col" class="text-center">Profile Image</th>
                    <th scope="col" class="text-center">Role</th>
                    <th scope="col" class="text-center">STATUS</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($dataMember as $sm) : ?>
                <tr>
                    <th scope="row" class="text-center"><?= $i ?></th>
                    <td><?= $sm['name'] ?></td>
                    <td class="text-center"><?= $sm['email'] ?></td>
                    <td class="text-center"><?= $sm['image'] ?></td>
                    <?php if ($sm['role_id'] == '1') : ?>
                    <td class="text-center">ADMIN</td>
                    <?php elseif ($sm['role_id'] == '2') : ?>
                    <td class="text-center">MEMBER</td>
                    <?php endif; ?>
                    <?php if ($sm['is_active'] == '1') : ?>
                    <td class="text-center">ACTIVE</td>
                    <?php elseif ($sm['is_active'] == '0') : ?>
                    <td class="text-center">NOT ACTIVATED</td>
                    <?php elseif ($sm['is_active'] == '3') : ?>
                    <td class="text-center">BANNED USER</td>
                    <?php endif; ?>

                    <td>
                        <a href="<?= base_url(); ?>admin/updateMember/<?= $sm['id']; ?>"
                            class="badge badge-primary mb-3" data-toggle="modal"
                            data-target="#editSubMenuModal<?= $sm['id']; ?>">EDIT</a>
                        <a href="<?= base_url(); ?>admin/hapusMemberAdmin/<?= $sm['id']; ?>"
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
                <h5 class="modal-title" id="newMenuModal">Add New Cars</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/configuser'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Full Name">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email Member">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Password">
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="role_id" id="role_id">
                            <option value=''>ROLE</option>
                            <option value="1">ADMIN</option>
                            <option value="2" selected>MEMBER</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="is_active" id="is_active">
                            <option value=''>Active This User ?</option>
                            <option value="1" selected>ACTIVE</option>
                            <option value="0">NOT ACTIVATED</option>
                            <option value="3">BANNED USER</option>
                        </select>
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

<?php foreach ($dataMember as $sm) : ?>
<!-- Modal edit -->
<div class="modal fade" id="editSubMenuModal<?= $sm['id']; ?>" tabindex="-1" role="dialog"
    aria-labelledby="#editSubMenuModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubMenuModal">Edit Profile Using Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url(); ?>admin/updateMember/<?= $sm['id']; ?>" method="post">

                <div class="modal-body">
                    <div class="form-group">
                        <input hidden type="text" class="form-control" value="<?= $sm['id']; ?>" id="id" name="id"
                            placeholder="Full Name">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" value="<?= $sm['name']; ?>"
                            placeholder="Full Name">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="email" name="email" value="<?= $sm['email']; ?>"
                            placeholder="Email Member" readonly>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password" value=" "
                            placeholder="Password">
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="role_id" id="role_id">
                            <?php if ($sm['role_id'] == '1') : ?>
                            <option value=''>ROLE</option>
                            <option value="1" selected>ADMIN</option>
                            <option value="2">MEMBER</option>
                            <?php elseif ($sm['role_id'] == '2') : ?>
                            <option value=''>ROLE</option>
                            <option value="1">ADMIN</option>
                            <option value="2" selected>MEMBER</option>
                            <?php endif; ?>

                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="is_active" id="is_active">
                            <?php if ($sm['is_active'] == '1') : ?>
                            <option value=''>Active This User ?</option>
                            <option value="1" selected>ACTIVE</option>
                            <option value="0">NOT ACTIVATED</option>
                            <option value="3">BANNED USER</option>
                            <?php elseif ($sm['is_active'] == '0') : ?>
                            <option value=''>Active This User ?</option>
                            <option value="1">ACTIVE</option>
                            <option value="0" selected>NOT ACTIVATED</option>
                            <option value="3">BANNED USER</option>
                            <?php elseif ($sm['is_active'] == '3') : ?>
                            <option value=''>Active This User ?</option>
                            <option value="1">ACTIVE</option>
                            <option value="0">NOT ACTIVATED</option>
                            <option value="3" selected>BANNED USER</option>
                            <?php endif; ?>

                        </select>
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