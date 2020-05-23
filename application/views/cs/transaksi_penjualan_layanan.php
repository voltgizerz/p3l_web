<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?=$title?> - Customer Service AREA</h1>


</div>
<!-- /.container-fluid -->

<div class="row">
    <div class="col-lg ml-3 mr-3">
        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubMenuModal">TAMBAH TRANSAKSI
            PENJUALAN LAYANAN</a>

        <div class="form-group">
            <?php echo form_open("cs/cariPenjualanLayanan"); ?>
            <select name="cariberdasarkan">
                <option value="">Cari Berdasarkan</option>
                <option value="kode_penjualan">Kode Penjualan</option>
                <option value="nama_hewan">Nama Hewan</option>
                <option value="nama_cs">Nama Customer Service</option>
            </select>

            <input name="yangdicari" id="" type="text">
            <input type="submit" name="cari" value="Cari">
            <?php echo form_close(); ?>
        </div>
        <?php if (validation_errors()): ?>
        <div class="alert alert-danger" role="alert">
            <?=validation_errors();?>
        </div>
        <?php endif;?>
        <?=$this->session->flashdata('message');?>

        <table class="table table-striped table-dark table-hover  table-responsive-sm">
            <thead>
                <tr>
                    <th scope="col" class="text-center">No</th>
                    <th scope="col" class="text-center">Kode Penjualan</th>
                    <th scope="col" class="text-center">Nama Customer Service</th>
                    <th scope="col" class="text-center">Nama Hewan</th>
                    <th scope="col" class="text-center">Subtotal Harga</th>
                    <th scope="col" class="text-center">Status Penjualan</th>
                    <th scope="col" class="text-center">Detail Penjualan</th>
                    <th scope="col" class="text-center">Created Date</th>
                    <th scope="col" class="text-center">Updated Date</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;?>
                <?php foreach ($dataPenjualanLayanan as $sm): ?>
                <tr>
                    <th scope="row" class="text-center"><?=$i?></th>
                    <td style="text-align:center; color:orange;"><?=$sm['kode_transaksi_penjualan_jasa_layanan']?></td>
                    <td style="text-align:center;"><?=$sm['nama_cs']?></td>
                    <td style="text-align:center;"><?=$sm['nama_hewan']?></td>
                    <td style="text-align:center;">Rp. <?=$sm['total_penjualan_jasa_layanan']?></td>
                    <?php if ($sm['status_penjualan'] == 'Sudah Selesai'): ?>
                    <td style="text-align:center; color:#00FF00;"><?=$sm['status_penjualan']?></td>
                    <?php else: ?>
                    <td style="text-align:center; color:#FF6347;"><?=$sm['status_penjualan']?></td>
                    <?php endif;?>

                    <td style="text-align:center;">
                        <a href="<?=base_url();?>cs/detail_penjualan_layanan/<?=$sm['id_transaksi_penjualan_jasa_layanan'];?>"
                            class="badge badge-info mb-3">INFO</a>
                    </td>
                    <td style="text-align:center;"><?=$sm['created_date']?></td>
                    <?php if ($sm['updated_date'] == '0000-00-00 00:00:00'): ?>
                    <td style="text-align:center;"> - </td>
                    <?php else: ?>
                    <td style="text-align:center;"><?=$sm['updated_date']?></td>
                    <?php endif;?>

                    <td style="text-align:center;">
                        <?php if ($sm['status_penjualan'] == 'Sudah Selesai') {
    $hide = "hidden";
} else {
    $hide = "visible";
}?>
                        <a href="<?=base_url();?>cs/updatePenjualanLayanan/<?=$sm['id_transaksi_penjualan_jasa_layanan'];?>"
                            class="badge badge-primary mb-3" data-toggle="modal"
                            data-target="#editSubMenuModal<?=$sm['id_transaksi_penjualan_jasa_layanan'];?>"
                            style="visibility: <?=$hide?>">EDIT</a>
                        <a href="<?=base_url();?>cs/hapusPenjualanLayanan/<?=$sm['id_transaksi_penjualan_jasa_layanan'];?>"
                            class="badge badge-danger mb-3" style="visibility: <?=$hide?>">DELETE</a>
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
<div class=" modal fade" id="newSubMenuModal" tabindex="-1" role="dialog" aria-labelledby="#newSubMenuModal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModal">Tambah Transaksi Penjualan Layanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?=base_url('cs/transaksi_penjualan_layanan');?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="cs" name="cs" value="Nama hewan Service"
                            placeholder="Kode Pengadaan" readonly>
                    </div>
                    <div class="form-group">
                        <?php $ci = get_instance();?>
                        <input type="text" class="form-control" id="nama" name="nama"
                            value="<?=$ci->session->userdata('nama_pegawai')?>" placeholder="Nama Pegawai" readonly>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="pilih_hewan" name="pilih_hewan">
                            <option value="">Pilih Hewan</option>
                            <?php foreach ($data_hewan->result() as $row) {
    echo '<option value="' . $row->id_hewan . '">' . $row->nama_hewan . '</option>';}?>
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

<?php foreach ($dataPenjualanLayanan as $sm): ?>
<!-- Modal edit -->
<div class="modal fade" id="editSubMenuModal<?=$sm['id_transaksi_penjualan_jasa_layanan'];?>" tabindex="-1"
    role="dialog" aria-labelledby="#editSubMenuModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubMenuModal">Edit Transaksi Penjualan Layanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?=base_url();?>cs/updatePenjualanLayanan/<?=$sm['id_transaksi_penjualan_jasa_layanan'];?>"
                method="post">

                <div class="modal-body">
                    <div class="form-group">
                        <input hidden type="text" class="form-control"
                            value="<?=$sm['id_transaksi_penjualan_jasa_layanan'];?>" id="id" name="id">
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="pilih_hewan" name="pilih_hewan">
                            <option value="">Pilih hewan</option>
                            <?php foreach ($data_hewan->result() as $row) {
    if ($sm['nama_hewan'] == $row->nama_hewan) {
        echo '<option selected="selected"  value="' . $row->id_hewan . '">' . $row->nama_hewan . '</>';
    } else {
        echo '<option value="' . $row->id_hewan . '">' . $row->nama_hewan . '</option>';
    }}?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="status_penjualan" name="status_penjualan">
                            <option value="">Pilih Status Transaksi</option>
                            <option <?php if ($sm['status_penjualan'] == 'Belum Selesai') {echo ("selected");}?>>
                                Belum
                                Selesai
                            </option>
                            <option <?php if ($sm['status_penjualan'] == 'Sudah Selesai') {echo ("selected");}?>>
                                Sudah
                                Selesai
                            </option>
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