<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?=$title?> Detail - Customer Service AREA</h1>
    <h1 class="h3 mb-4 text-gray-800"><?=$kode_penjualan?></h1>


</div>
<!-- /.container-fluid -->

<div class="row">
    <div class="col-lg ml-3 mr-3">

        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubMenuModal">TAMBAH PRODUK
            PENJUALAN</a>
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
                    <th scope="col" class="text-center">Nama Produk</th>
                    <th scope="col" class="text-center">Gambar Produk</th>
                    <th scope="col" class="text-center">Jumlah Produk</th>
                    <th scope="col" class="text-center">Subtotal</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;?>
                <?php foreach ($dataDetailPenjualanProduk as $sm): ?>
                <tr>
                    <th scope="row" class="text-center"><?=$i?></th>
                    <td style="text-align:center;"><?=$sm['nama_produk']?></td>
                    <td style="text-align:center;"><img height="100" width="100"
                            src="<?=base_url();?><?=$sm['gambar_produk']?>" </td>
                    <td style="text-align:center;"><?=$sm['jumlah_produk']?></td>
                    <td style="text-align:center;"><?=$sm['subtotal']?></td>
                    <td style="text-align:center;">
                        <a href="<?=base_url();?>cs/updateDetailPenjualanProduk/<?=$sm['id_detail_penjualan_produk'];?>"
                            class="badge badge-primary mb-3" data-toggle="modal"
                            data-target="#editSubMenuModal<?=$sm['id_detail_penjualan_produk'];?>">EDIT</a>
                        <a href="<?=base_url();?>cs/hapusDetailPenjualanProduk/<?=$sm['id_detail_penjualan_produk'];?>"
                            class="badge badge-danger mb-3">DELETE</a>
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
                <h5 class="modal-title" id="newMenuModal">Tambah Produk Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?=base_url();?>cs/detail_penjualan_produk/<?=$id_penjualan;?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <select class="form-control" id="pilih_produk" name="pilih_produk">
                            <option value="">Pilih Produk Penjualan</option>
                            <?php foreach ($data_produk->result() as $row) {
    if ($sm['nama_produk'] == $row->nama_produk) {
        echo '<option  value="' . $row->id_produk . '">' . $row->nama_produk.' | Stok Tersedia : '. $row->stok_produk.'</.>';
    } else {
        echo '<option value="' . $row->id_produk . '">' . $row->nama_produk .' | Stok Tersedia : '. $row->stok_produk. '</option>';
    }}?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="jumlah_produk" name="jumlah_produk"
                            placeholder="Jumlah Produk">
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

<?php foreach ($dataDetailPenjualanProduk as $sm): ?>
<!-- Modal edit -->
<div class="modal fade" id="editSubMenuModal<?=$sm['id_detail_penjualan_produk'];?>" tabindex="-1" role="dialog"
    aria-labelledby="#editSubMenuModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubMenuModal">Edit Produk Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?=base_url();?>cs/updateDetailPenjualanProduk/<?=$sm['id_detail_penjualan_produk'];?>"
                method="post">

                <div class="modal-body">
                    <div class="form-group">
                        <input hidden type="text" class="form-control" value="<?=$sm['id_detail_penjualan_produk'];?>"
                            id="id" name="id">
                    </div>

                    <div class="form-group">
                        <select class="form-control" id="pilih_produk" name="pilih_produk">
                            <option value="">Pilih Produk Penjualan</option>
                            <?php foreach ($data_produk->result() as $row) {
    if ($sm['nama_produk'] == $row->nama_produk) {
        echo '<option selected="selected"  value="' . $row->id_produk . '">' . $row->nama_produk .' | Stok Tersedia : '. $row->stok_produk. '</>';
    } else {
        echo '<option value="' . $row->id_produk . '">' . $row->nama_produk .' | Stok Tersedia : '. $row->stok_produk. '</option>';
    }}?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="jumlah_produk" name="jumlah_produk"
                            placeholder="Jumlah Pengadaan" value="<?=$sm['jumlah_produk'];?>">
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