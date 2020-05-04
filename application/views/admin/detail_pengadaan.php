<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?=$title?> Detail - Owner AREA</h1>
    <h1 class="h3 mb-4 text-gray-800"><?=$kode_pengadaan?></h1>


</div>
<!-- /.container-fluid -->

<div class="row">
    <div class="col-lg ml-3 mr-3">

        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubMenuModal">TAMBAH PRODUK
            PENGADAAN</a>
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
                    <th scope="col" class="text-center">Gambar Produk</th>
                    <th scope="col" class="text-center">Nama Produk</th>
                    <th scope="col" class="text-center">Satuan Pengadaan</th>
                    <th scope="col" class="text-center">Jumlah Pengadaan</th>
                    <th scope="col" class="text-center">Tanggal Pengadaan</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($dataDetailPengadaan) == false): ?>
                <?php $i = 1;?>
                <?php foreach ($dataDetailPengadaan as $sm): ?>
                <tr>
                    <th scope="row" class="text-center"><?=$i?></th>
                    <td style="text-align:center;"><img style="border:5px solid white" height="100" width="100"
                            src="<?=base_url();?><?=$sm['gambar_produk']?>" </td>
                    <td style="text-align:center;"><?=$sm['nama_produk']?></td>
                    <td style=" text-align:center;"><?=$sm['satuan_pengadaan']?></td>
                    <td style="text-align:center;"><?=$sm['jumlah_pengadaan']?></td>
                    <td style="text-align:center;"><?=$sm['tanggal_pengadaan']?></td>
                    <td style="text-align:center;">
                        <a href="<?=base_url();?>admin/updateDetailPengadaan/<?=$sm['id_detail_pengadaan'];?>"
                            class="badge badge-primary mb-3" data-toggle="modal"
                            data-target="#editSubMenuModal<?=$sm['id_detail_pengadaan'];?>">EDIT</a>
                        <a href="<?=base_url();?>admin/hapusDetailPengadaan/<?=$sm['id_detail_pengadaan'];?>"
                            class="badge badge-danger mb-3">DELETE</a>
                    </td>
                </tr>
                <?php $i++;?>
                <?php endforeach;?>
                <?php else: ?>
                <tr>
                    <td style="color:orange" class="text-center" colspan="10">Transaksi Pengadaan
                        '<?=$kode_pengadaan?>'
                        Belum Memiliki
                        Produk
                        yang
                        ditambahkan! </td>
                </tr>
                <?php endif;?>
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
                <h5 class="modal-title" id="newMenuModal">Tambah Produk Pengadaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?=base_url();?>admin/detail_pengadaan/<?=$id_pengadaan;?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <select class="form-control" id="pilih_produk" name="pilih_produk">
                            <option value="">Pilih Produk Pengadaan</option>
                            <?php foreach ($data_produk->result() as $row) {
    if ($sm['nama_produk'] == $row->nama_produk) {
        echo '<option  value="' . $row->id_produk . '">' . $row->nama_produk . ' | Stok Saat Ini : ' . $row->stok_produk . '</.>';
    } else {
        echo '<option value="' . $row->id_produk . '">' . $row->nama_produk . ' | Stok Saat Ini : ' . $row->stok_produk . '</option>';
    }}?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="jumlah_pengadaan" name="jumlah_pengadaan"
                            placeholder="Jumlah Pengadaan">
                    </div>

                    <div class="form-group">
                        <select class="form-control" id="satuan" name="satuan">
                            <option value="">Pilih Satuan Pengadaan</option>
                            <option>Pack</option>
                            <option>Botol</option>
                            <option>Sachet</option>
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

<?php foreach ($dataDetailPengadaan as $sm): ?>
<!-- Modal edit -->
<div class="modal fade" id="editSubMenuModal<?=$sm['id_detail_pengadaan'];?>" tabindex="-1" role="dialog"
    aria-labelledby="#editSubMenuModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubMenuModal">Edit Produk Pengadaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?=base_url();?>admin/updateDetailPengadaan/<?=$sm['id_detail_pengadaan'];?>" method="post">

                <div class="modal-body">
                    <div class="form-group">
                        <input hidden type="text" class="form-control" value="<?=$sm['id_detail_pengadaan'];?>" id="id"
                            name="id">
                    </div>

                    <div class="form-group">
                        <select class="form-control" id="pilih_produk" name="pilih_produk">
                            <option value="">Pilih Produk Pengadaan</option>
                            <?php foreach ($data_produk->result() as $row) {
    if ($sm['nama_produk'] == $row->nama_produk) {
        echo '<option selected="selected"  value="' . $row->id_produk . '">' . $row->nama_produk . ' | Stok Saat Ini : ' . $row->stok_produk . '</>';
    } else {
        echo '<option value="' . $row->id_produk . '">' . $row->nama_produk . ' | Stok Saat Ini : ' . $row->stok_produk . '</option>';
    }}?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="jumlah_pengadaan" name="jumlah_pengadaan"
                            placeholder="Jumlah Pengadaan" value="<?=$sm['jumlah_pengadaan'];?>">
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="satuan" name="satuan">
                            <option value="">Pilih Satuan Pengadaan</option>
                            <option <?php if ($sm['satuan_pengadaan'] == 'Pack') {echo ("selected");}?>>Pack</option>
                            <option <?php if ($sm['satuan_pengadaan'] == 'Botol') {echo ("selected");}?>>Botol</option>
                            <option <?php if ($sm['satuan_pengadaan'] == 'Sachet') {echo ("selected");}?>>Sachet
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