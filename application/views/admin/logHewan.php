<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?=$title?> - Admin AREA</h1>
</div>
<!-- /.container-fluid -->

<div class="row">
    <div class="col-lg ml-3 mr-3">
        <?php if (validation_errors()): ?>
        <div class="alert alert-danger" role="alert">
            <?=validation_errors();?>
        </div>
        <?php endif;?>

        <?php echo form_open("admin/logHewan"); ?>
        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubMenuModal">TAMBAH
            HEWAN</a>
        <input type="submit" name="log" class="btn btn-danger mb-3" value="LOG DELETE HEWAN">
        <?php echo form_close(); ?>

        <?=$this->session->flashdata('message');?>

        <table class="table table-striped table-dark table-hover  table-responsive-sm">
            <thead>
                <tr>
                    <th scope="col" class="text-center">No</th>
                    <th scope="col" class="text-center">Nama Hewan</th>
                    <th scope="col" class="text-center">Jenis Hewan</th>
                    <th scope="col" class="text-center">Ukuran Hewan</th>
                    <th scope="col" class="text-center">Tanggal Lahir</th>
                    <th scope="col" class="text-center">Nama Customer</th>
                    <th scope="col" class="text-center">Deleted Date</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;?>
                <?php foreach ($dataHewan as $sm): ?>
                <tr>
                    <th scope="row" class="text-center"><?=$i?></th>
                    <td><?=$sm['nama_hewan']?></td>
                    <td style="text-align:center;"><?=$sm['nama_jenis_hewan']?></td>
                    <td style="text-align:center;"><?=$sm['ukuran_hewan']?></td>
                    <td style="text-align:center;"><?=$sm['tanggal_lahir_hewan']?></td>
                    <td style="text-align:center;"><?=$sm['nama_customer']?></td>
                    <td style="text-align:center;"><?=$sm['deleted_date']?></td>


                    <td style="text-align:center;">
                        <a href="<?= base_url(); ?>admin/restoreHewan/<?= $sm['id_hewan']; ?>"
                            class="badge badge-primary mb-3">RESTORE</a>
                        <a href=" <?= base_url(); ?>admin/deletePermHewan/<?= $sm['id_hewan']; ?>"
                            class="badge badge-danger mb-3">DELETE PREMANENT</a>
                    </td>
                </tr>
                <?php $i++;?>
                <?php endforeach;?>
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
                <h5 class="modal-title" id="newMenuModal">Tambah Hewan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?=base_url('admin/kelola_hewan');?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Hewan">
                    </div>
                    <div class="form-group">
                        <input type="date" class="form-control" id="tanggal" name="tanggal"
                            placeholder="Tanggal Lahir (YYYY-MM-DD)">
                    </div>

                    <div class="form-group">
                        <select class="form-control" id="pilih_customer" name="pilih_customer">
                            <option>Pilih customer</option>
                            <?php foreach ($data_customer->result() as $row) {
    echo '<option value="' . $row->id_customer . '">' . $row->nama_customer . '</option>';}?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="pilih_jenis" name="pilih_jenis">
                            <option>Pilih Jenis Hewan</option>
                            <?php foreach ($data_jenis->result() as $row) {
    echo '<option value="' . $row->id_jenis_hewan . '">' . $row->nama_jenis_hewan . '</option>';}?>
                        </select>
                    </div>

                    <div class="form-group">
                        <select class="form-control" id="pilih_ukuran" name="pilih_ukuran">
                            <option>Pilih Ukuran Hewan</option>
                            <?php foreach ($data_ukuran->result() as $row) {
    echo '<option value="' . $row->id_ukuran_hewan . '">' . $row->ukuran_hewan . '</option>';}?>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="add" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php foreach ($dataHewan as $sm): ?>
<!-- Modal edit -->
<div class="modal fade" id="editSubMenuModal<?=$sm['id_hewan'];?>" tabindex="-1" role="dialog"
    aria-labelledby="#editSubMenuModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubMenuModal">Edit Profile Using Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?=base_url();?>admin/updateHewan/<?=$sm['id_hewan'];?>" method="post">

                <div class="modal-body">
                    <div class="form-group">
                        <input hidden type="text" class="form-control" value="<?=$sm['id_hewan'];?>" id="id" name="id">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama" value="<?=$sm['nama_hewan'];?>"
                            placeholder="Nama Jenis Hewan">
                    </div>

                    <div class="form-group">
                        <input type="date" class="form-control" id="tangal" name="tanggal"
                            value="<?=$sm['tanggal_lahir_hewan'];?>" placeholder="Tanggal Lahir (YYYY-MM-DD)">
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="pilih_customer" name="pilih_customer">
                            <option>Pilih customer</option>
                            <?php foreach ($data_customer->result() as $row) {
    if ($sm['nama_customer'] == $row->nama_customer) {
        echo '<option selected="selected"  value="' . $row->id_customer . '">' . $row->nama_customer . '</>';
    } else {
        echo '<option value="' . $row->id_customer . '">' . $row->nama_customer . '</option>';
    }}?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="pilih_jenis" name="pilih_jenis">
                            <option>Pilih Jenis Hewan</option>
                            <?php foreach ($data_jenis->result() as $row) {
    if ($sm['jenis_hewan'] == $row->jenis_hewan) {
        echo '<option selected="selected"  value="' . $row->id_jenis_hewan . '">' . $row->nama_jenis_hewan . '</option>';} else {
        echo '<option value="' . $row->id_jenis_hewan . '">' . $row->nama_jenis_hewan . '</option>';

    }}?>
                        </select>
                    </div>

                    <div class="form-group">
                        <select class="form-control" id="pilih_ukuran" name="pilih_ukuran">
                            <option>Pilih Ukuran Hewan</option>
                            <?php foreach ($data_ukuran->result() as $row) {
    if ($sm['ukuran_hewan'] == $row->ukuran_hewan) {
        echo '<option selected="selected"  value="' . $row->id_ukuran_hewan . '">' . $row->ukuran_hewan . '</option>';} else {
        echo '<option value="' . $row->id_ukuran_hewan . '">' . $row->ukuran_hewan . '</option>';

    }}?>
                        </select>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach;?>