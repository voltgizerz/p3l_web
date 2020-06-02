<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?> - Kasir AREA</h1>


</div>
<!-- /.container-fluid -->

<div class="row">
    <div class="col-lg ml-3 mr-3">
        <div class="form-group">
            <?php echo form_open("kasir/cariPembayaranLayanan"); ?>
            <div class="input-group " style="width: 600px;">
                <select class="custom-select" id="inputGroupSelect07" name="cariberdasarkan">
                    <option value="">Cari Berdasarkan</option>
                    <option value="kode_penjualan">Kode Penjualan</option>
                    <option value="nama_kasir">Nama Kasir</option>
                    <option value="status_pembayaran">Status Pembayaran</option>
                </select>
                <div class="input-group-append">
                    <input type="text" class="form-control" style="border-radius: 0;" placeholder="Kata Pencarian..." name="yangdicari" id="" type="text" aria-label="Text input with dropdown button" aria-describedby="basic-addon2">

                    <button class="btn btn-success" type="submit" name="cari" value="Cari"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
        <?php if (validation_errors()) : ?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors(); ?>
            </div>
        <?php endif; ?>
        <?= $this->session->flashdata('message'); ?>

        <table class="table table-striped table-dark table-hover  table-responsive-sm">
            <thead>
                <tr>
                    <th scope="col" class="text-center">No</th>
                    <th scope="col" class="text-center">Kode Penjualan</th>
                    <th scope="col" class="text-center">Nama Customer Service</th>
                    <th scope="col" class="text-center">Nama Kasir</th>
                    <th scope="col" class="text-center">Nama Hewan</th>
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
                <?php $i = 1; ?>
                <?php foreach ($dataPenjualanLayanan as $sm) : ?>
                    <tr>
                        <th scope="row" class="text-center"><?= $i ?></th>
                        <td style="text-align:center; color:orange;"><?= $sm['kode_transaksi_penjualan_jasa_layanan'] ?></td>
                        <td style="text-align:center;"><?= $sm['nama_cs'] ?></td>
                        <?php if ($sm['id_kasir'] == $sm['id_cs']) : ?>
                            <td style="text-align:center; color:#FF6347;"> Belum Diproses</td>
                        <?php else : ?>
                            <td style="text-align:center;"><?= $sm['nama_kasir'] ?></td>
                        <?php endif; ?>
                        <td style="text-align:center;"><?= $sm['nama_hewan'] ?></td>
                        <td style="text-align:center;">Rp. <?= $sm['total_penjualan_jasa_layanan'] ?></td>
                        <?php if ($sm['diskon'] == 0) : ?>
                            <td style="text-align:center; color:#FF6347;"> - </td>
                        <?php else : ?>
                            <td style="text-align:center;">Rp. <?= $sm['diskon'] ?></td>
                        <?php endif; ?>
                        <td style="text-align:center; color:#FFD700">Rp. <?= $sm['total_harga'] ?></td>
                        <?php if ($sm['status_pembayaran'] == 'Belum Lunas') : ?>
                            <td style="text-align:center; color:#FF6347;"> Belum Lunas </td>
                        <?php else : ?>
                            <td style="text-align:center; color:#00FF00">Lunas</td>
                        <?php endif; ?>
                        <?php if ($sm['tanggal_pembayaran_jasa_layanan'] == '0000-00-00 00:00:00') : ?>
                            <td style="text-align:center;"> - </td>
                        <?php else : ?>
                            <td style="text-align:center;"><?= $sm['tanggal_pembayaran_jasa_layanan'] ?></td>
                        <?php endif; ?>
                        <td style="text-align:center;">
                            <a href="<?= base_url(); ?>kasir/detail_pembayaran_layanan/<?= $sm['id_transaksi_penjualan_jasa_layanan']; ?>" class="badge badge-info mb-3">INFO</a>
                        </td>

                        <td style="text-align:center;">
                            <?php if ($sm['status_pembayaran'] == 'Belum Lunas') {
                                $hide = "hidden";
                            } else {
                                $hide = "visible";
                            } ?>
                            <?php if ($sm['status_pembayaran'] == 'Belum Lunas') : ?>
                                Belum Lunas
                            <?php else : ?>
                                <a href="<?= base_url(); ?>laporan/strukLunasLayanan/<?= $sm['id_transaksi_penjualan_jasa_layanan']; ?>" target="_blank" class="badge badge-warning mb-3" style="visibility: <?= $hide ?> "><span class="glyphicon glyphicon-print"></span> <i class="fa fa-print"></i> CETAK</a>
                            <?php endif; ?>

                        </td>
                        <td style="text-align:center;"><?= $sm['created_date'] ?></td>
                        <?php if ($sm['updated_date'] == '0000-00-00 00:00:00') : ?>
                            <td style="text-align:center;"> - </td>
                        <?php else : ?>
                            <td style="text-align:center;"><?= $sm['updated_date'] ?></td>
                        <?php endif; ?>

                        <td style="text-align:center;">
                            <?php if ($sm['status_pembayaran'] == 'Lunas') {
                                $hide = "hidden";
                            } else {
                                $hide = "visible";
                            } ?>
                            <a href="<?= base_url(); ?>kasir/updatePembayaranLayanan/<?= $sm['id_transaksi_penjualan_jasa_layanan']; ?>" class="badge badge-primary mb-3" data-toggle="modal" data-target="#editSubMenuModal<?= $sm['id_transaksi_penjualan_jasa_layanan']; ?>" style="visibility: <?= $hide ?>">EDIT</a>
                            <a href="<?= base_url(); ?>kasir/hapusPembayaranLayanan/<?= $sm['id_transaksi_penjualan_jasa_layanan']; ?>" class="badge badge-danger mb-3" style="visibility: <?= $hide ?>">DELETE</a>
                        </td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><?php echo $links; ?></p>
    </div>
</div>
<!-- End of Main Content -->



<?php foreach ($dataPenjualanLayanan as $sm) : ?>
    <!-- Modal edit -->
    <div class="modal fade" id="editSubMenuModal<?= $sm['id_transaksi_penjualan_jasa_layanan']; ?>" tabindex="-1" role="dialog" aria-labelledby="#editSubMenuModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSubMenuModal">Edit Transaksi Penjualan Layanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url(); ?>kasir/updatePembayaranLayanan/<?= $sm['id_transaksi_penjualan_jasa_layanan']; ?>" method="post">

                    <div class="modal-body">
                        <div class="form-group">
                            <input hidden type="text" class="form-control" value="<?= $sm['id_transaksi_penjualan_jasa_layanan']; ?>" id="id" name="id">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="diskon" name="diskon" placeholder="Masukan Diskon">
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="pilih_hewan" name="pilih_hewan">
                                <option value="">Pilih hewan</option>
                                <?php foreach ($data_hewan->result() as $row) {
                                    if ($sm['nama_hewan'] == $row->nama_hewan) {
                                        echo '<option selected="selected"  value="' . $row->id_hewan . '">' . $row->nama_hewan . '</>';
                                    } else {
                                        echo '<option value="' . $row->id_hewan . '">' . $row->nama_hewan . '</option>';
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="status_pembyaran" name="status_pembayaran">
                                <option value="">Pilih Status Pembayaran</option>
                                <option <?php if ($sm['status_pembayaran'] == 'Belum Lunas') {
                                            echo ("selected");
                                        } ?>>
                                    Belum Lunas
                                </option>
                                <option <?php if ($sm['status_pembayaran'] == 'Lunas') {
                                            echo ("selected");
                                        } ?>>
                                    Lunas
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
<?php endforeach; ?>