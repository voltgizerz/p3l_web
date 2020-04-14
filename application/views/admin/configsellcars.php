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
        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubMenuModal">SELL CAR</a>
        <a href="<?php echo site_url('Laporan/laporanJualMobilAdmin') ?>" class="btn btn-primary mb-3" style="background-color:RED; ">PRINT TO PDF</a>

        <?= $this->session->flashdata('message'); ?>

        <table class="table table-striped table-dark table-hover  table-responsive-sm">
            <thead>
                <tr>
                    <th scope="col" class="text-center">No</th>
                    <th scope="col" class="text-center">Full Name</th>
                    <th scope="col" class="text-center">Cars Type</th>
                    <th scope="col" class="text-center">Cars Colour</th>
                    <th scope="col" class="text-center">Price</th>
                    <th scope="col" class="text-center">Fuel</th>
                    <th scope="col" class="text-center">E-Mail</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($dataJualMobil as $sm) : ?>
                    <tr>
                        <th scope="row" class="text-center"><?= $i ?></th>
                        <td><?= $sm['name'] ?></td>
                        <td class="text-center"><?= $sm['merk'] ?></td>
                        <td class="text-center"><?= $sm['warna'] ?></td>
                        <td class="text-center"><?= $sm['harga'] ?></td>
                        <td class="text-center"><?= $sm['bahan_bakar'] ?></td>
                        <td class="text-center"><?= $sm['email_pembeli'] ?></td>
                        <td>
                            <a href="<?= base_url(); ?>admin/updateJualMobilAdmin/<?= $sm['id']; ?>" class="badge badge-primary mb-3" data-toggle="modal" data-target="#editSubMenuModal<?= $sm['id']; ?>">EDIT</a>
                            <a href="<?= base_url(); ?>admin/hapusJualMobilAdmin/<?= $sm['id']; ?>" class="badge badge-danger mb-3">DELETE</a>
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
<div class="modal fade" id="newSubMenuModal" tabindex="-1" role="dialog" aria-labelledby="#newSubMenuModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModal">Add New Car For Sale</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/configsellcars'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Full Name">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="merk" name="merk" placeholder="Cars Type">
                    </div>
                    <div class="form-group">
                        <input type="textarea" class="form-control" id="warna" name="warna" placeholder="Cars Color">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="harga" name="harga" placeholder="Price">
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="bahan_bakar" id="bahan_bakar">
                            <option value=''>Fuel</option>
                            <option value="BENSIN">BENSIN</option>
                            <option value="LISTRIK">LISTRIK</option>
                            <option value="DIESEL">DIESEL</option>
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

<?php foreach ($dataJualMobil as $sm) : ?>
    <!-- Modal edit -->
    <div class="modal fade" id="editSubMenuModal<?= $sm['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="#editSubMenuModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSubMenuModal">Edit Sparepart</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url(); ?>admin/updateJualMobilAdmin/<?= $sm['id']; ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <input hidden type="text" class="form-control" value="<?= $sm['id']; ?>" id="id" name="id">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name" value="<?= $sm['name']; ?>" placeholder=" Full Name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="merk" name="merk" value="<?= $sm['merk']; ?>" placeholder=" Cars Type">
                        </div>
                        <div class="form-group">
                            <input type="textarea" class="form-control" id="warna" name="warna" value="<?= $sm['warna']; ?>" placeholder=" Cars Color">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="harga" name="harga" value="<?= $sm['harga']; ?>" placeholder=" Price">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="bahan_bakar" id="bahan_bakar">
                                <?php if ($sm['bahan_bakar'] == 'BENSIN') : ?>
                                    <option value=''>Fuel</option>
                                    <option value="BENSIN" selected>BENSIN</option>
                                    <option value="LISTRIK">LISTRIK</option>
                                    <option value="DIESEL">DIESEL</option>
                                <?php elseif ($sm['bahan_bakar'] == 'LISTRIK') : ?>
                                    <option value=''>Fuel</option>
                                    <option value="BENSIN">BENSIN</option>
                                    <option value="LISTRIK" selected>LISTRIK</option>
                                    <option value="DIESEL">DIESEL</option>
                                <?php elseif ($sm['bahan_bakar'] == 'DIESEL') : ?>
                                    <option value=''>Fuel</option>
                                    <option value="BENSIN">BENSIN</option>
                                    <option value="LISTRIK">LISTRIK</option>
                                    <option value="DIESEL" selected>DIESEL</option>
                                <?php endif; ?>
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

<?php endforeach; ?>