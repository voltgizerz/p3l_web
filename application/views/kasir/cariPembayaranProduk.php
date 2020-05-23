<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?=$title?> - Kasir AREA</h1>


</div>
<!-- /.container-fluid -->

<div class="row">
    <div class="col-lg ml-3 mr-3">
        <?php if (validation_errors()): ?>
        <div class="alert alert-danger" role="alert">
            <?=validation_errors();?>
        </div>
        <?php endif;?>

        <div class="form-group">
            <?php echo form_open("kasir/cariPenjualanProduk"); ?>
            <select name="cariberdasarkan">
                <option value="">Cari Berdasarkan</option>
                <option value="kode_penjualan">Kode Penjualan</option>
                <option value="nama_cs">Nama Customer Service</option>
            </select>
            <input name="yangdicari" id="" type="text">
            <input type="submit" name="cari" value="Cari">
            <?php echo form_close(); ?>
        </div>
        <?=$this->session->flashdata('message');?>

        <table class="table table-striped table-dark table-hover  table-responsive-sm">
            <thead>
                <tr>
                    <th scope="col" class="text-center">No</th>
                    <th scope="col" class="text-center">Kode Penjualan</th>
                    <th scope="col" class="text-center">Nama Customer Service</th>
                    <th scope="col" class="text-center">Nama Kasir</th>
                    <th scope="col" class="text-center">Subtotal Harga</th>
                    <th scope="col" class="text-center">Diskon</th>
                    <th scope="col" class="text-center">Total Harga</th>
                    <th scope="col" class="text-center">Status Pembayaran</th>
                    <th scope="col" class="text-center">Tanggal Pembayaran</th>
                    <th scope="col" class="text-center">Detail Pembayaran</th>
                    <th scope="col" class="text-center">Struk Lunas</th>
                    <th scope="col" class="text-center">Created Date</th>
                    <th scope="col" class="text-center">Updated Date</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;?>
                <?php foreach ($dataPembayaranProduk as $sm): ?>
                <tr>
                    <th scope="row" class="text-center"><?=$i?></th>
                    <td style="text-align:center; color:orange;"><?=$sm['kode_transaksi_penjualan_produk']?></td>
                    <td style="text-align:center;"><?=$sm['nama_cs']?></td>
                    <?php if ($sm['id_kasir'] == $sm['id_cs']): ?>
                    <td style="text-align:center; color:#FF6347;"> Belum Diproses </td>
                    <?php else: ?>
                    <td style="text-align:center;"><?=$sm['nama_kasir']?></td>
                    <?php endif;?>
                    <td style="text-align:center;">Rp. <?=$sm['total_penjualan_produk']?></td>
                    <td style="text-align:center;">-Rp. <?=$sm['diskon']?></td>
                    <td style="text-align:center; color:#FFD700">Rp. <?=$sm['total_harga']?></td>
                    <td style="text-align:center;"><?=$sm['status_pembayaran']?></td>
                    <?php if ($sm['tanggal_pembayaran_produk'] == '0000-00-00 00:00:00'): ?>
                    <td style="text-align:center;"> - </td>
                    <?php else: ?>
                    <td style="text-align:center;"><?=$sm['tanggal_pembayaran_produk']?></td>
                    <?php endif;?>
                    <td style="text-align:center;">
                        <a href="<?=base_url();?>kasir/detail_penjualan_produk/<?=$sm['id_transaksi_penjualan_produk'];?>"
                            class="badge badge-info mb-3">INFO</a>
                    </td>
                    <td style="text-align:center;">
                        <?php if ($sm['status_pembayaran'] == 'Belum Lunas'){
                            $hide="hidden";
                        }else{
                            $hide="visible";
                        } ?>
                        <?php if ($sm['status_pembayaran'] == 'Belum Lunas'): ?>
                        Belum Lunas
                        <?php else: ?>
                        <a href="<?=base_url();?>laporan/strukLunasProduk/<?=$sm['id_transaksi_penjualan_produk'];?>"
                            target="_blank" class="badge badge-warning mb-3" style="visibility: <?=$hide?>">CETAK</a>
                        <?php endif;?>

                    </td>
                    <td style="text-align:center;"><?=$sm['created_date']?></td>
                    <?php if ($sm['updated_date'] == '0000-00-00 00:00:00'): ?>
                    <td style="text-align:center;"> - </td>
                    <?php else: ?>
                    <td style="text-align:center;"><?=$sm['updated_date']?></td>
                    <?php endif;?>

                    <td style="text-align:center;">
                        <a href="<?=base_url();?>kasir/updatePenjualanProduk/<?=$sm['id_transaksi_penjualan_produk'];?>"
                            class="badge badge-primary mb-3" data-toggle="modal"
                            data-target="#editSubMenuModal<?=$sm['id_transaksi_penjualan_produk'];?>" ">EDIT</a>
                        <a href="
                            <?=base_url();?>kasir/hapusPenjualanProduk/<?=$sm['id_transaksi_penjualan_produk'];?>"
                            class="badge badge-danger mb-3" ">DELETE</a>
                    </td>
                </tr>
                <?php $i++;?>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>
<!-- End of Main Content -->




<?php foreach ($dataPembayaranProduk as $sm): ?>
<!-- Modal edit -->
<div class=" modal fade" id="editSubMenuModal<?=$sm['id_transaksi_penjualan_produk'];?>" tabindex="-1" role="dialog"
                            aria-labelledby="#editSubMenuModal" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editSubMenuModal">Edit Transaksi Pembayaran Produk
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form
                                        action="<?=base_url();?>kasir/updatePembayaranProduk/<?=$sm['id_transaksi_penjualan_produk'];?>"
                                        method="post">

                                        <div class="modal-body">
                                            <div class="form-group">
                                                <input hidden type="text" class="form-control"
                                                    value="<?=$sm['id_transaksi_penjualan_produk'];?>" id="id"
                                                    name="id">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="diskon" name="diskon"
                                                    placeholder="Masukan Diskon">
                                            </div>
                                            <div class="form-group">
                                                <select class="form-control" id="status_pembayaran"
                                                    name="status_pembayaran">
                                                    <option value="">Pilih Status Transaksi</option>
                                                    <option
                                                        <?php if ($sm['status_pembayaran'] == 'Belum Lunas') {echo ("selected");}?>>
                                                        Belum
                                                        Lunas
                                                    </option>
                                                    <option
                                                        <?php if ($sm['status_pembayaran'] == 'Lunas') {echo ("selected");}?>>
                                                        Lunas
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Edit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
    </div>
    <?php endforeach;?>