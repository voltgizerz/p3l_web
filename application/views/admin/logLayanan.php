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
        <?php echo form_open("admin/logLayanan"); ?>
        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubMenuModal">TAMBAH JASA
            LAYANAN</a>
        <input type="submit" name="log" class="btn btn-danger mb-3" value="LOG DELETE LAYANAN">
        <?php echo form_close(); ?>

        <?=$this->session->flashdata('message');?>

        <table class="table table-striped table-dark table-hover  table-responsive-sm">
            <thead>
                <tr>
                    <th scope="col" class="text-center">No</th>
                    <th scope="col" class="text-center">Nama Jasa Layanan</th>
                    <th scope="col" class="text-center">Jenis hewan</th>
                    <th scope="col" class="text-center">Ukuran Hewan</th>
                    <th scope="col" class="text-center">Harga Jasa Layanan</th>
                    <th scope="col" class="text-center">Deleted Date</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;?>
                <?php foreach ($dataJasaLayanan as $sm): ?>
                <tr>
                    <th scope="row" class="text-center"><?=$i?></th>
                    <td class="text-center"><?=$sm['nama_jasa_layanan']?></td>
                    <td class="text-center"><?=$sm['nama_jenis_hewan']?></td>
                    <td class="text-center"><?=$sm['ukuran_hewan']?></td>
                    <td class="text-center">Rp. <?=$sm['harga_jasa_layanan']?></td>
                    <td class="text-center"><?=$sm['deleted_date']?></td>

                    <td class="text-center">
                        <a href="<?=base_url();?>admin/restoreJasaLayanan/<?=$sm['id_jasa_layanan'];?>"
                            class="badge badge-primary mb-3">RESTORE </a>
                        <a href="<?=base_url();?>admin/deletePermJasaLayanan/<?=$sm['id_jasa_layanan'];?>"
                            class="badge badge-danger mb-3">DELETE PERMANENT</a>
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
                <h5 class="modal-title" id="newMenuModal">Tambah Jasa Layanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?=base_url('admin/kelola_layanan');?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Jasa Layanan">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="harga" name="harga"
                            placeholder="Harga Jasa Layanan">
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

<?php foreach ($dataJasaLayanan as $sm): ?>
<!-- Modal edit -->
<div class="modal fade" id="editSubMenuModal<?=$sm['id_jasa_layanan'];?>" tabindex="-1" role="dialog"
    aria-labelledby="#editSubMenuModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubMenuModal">Edit Profile Using Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?=base_url();?>admin/updateJasaLayanan/<?=$sm['id_jasa_layanan'];?>" method="post">

                <div class="modal-body">
                    <div class="form-group">
                        <input hidden type="text" class="form-control" value="<?=$sm['id_jasa_layanan'];?>" id="id"
                            name="id">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama"
                            value="<?=$sm['nama_jasa_layanan'];?>" placeholder="Nama Jasa Layanan">
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" id="harga" name="harga"
                            value="<?=$sm['harga_jasa_layanan'];?>" placeholder="Harga Jasa Layanan">
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
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach;?>