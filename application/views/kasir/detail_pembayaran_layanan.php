<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?> Detail - Customer Service AREA</h1>
    <h1 class="h3 mb-4 text-gray-800"><?= $kode_penjualan ?></h1>


</div>
<!-- /.container-fluid -->

<div class="row">
    <div class="col-lg ml-3 mr-3">

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
                    <th scope="col" class="text-center">Nama Jasa Layanan</th>
                    <th scope="col" class="text-center">Subtotal</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($dataDetailPenjualanLayanan) == false) : ?>
                    <?php $i = 1; ?>
                    <?php foreach ($dataDetailPenjualanLayanan as $sm) : ?>
                        <tr>
                            <th scope="row" class="text-center"><?= $i ?></th>
                            <td style="text-align:center;"><?= $sm['nama_jasa_layanan'] ?> <?= $sm['nama_jenis_hewan'] ?>
                                <?= $sm['ukuran_hewan'] ?></td>
                            <td style="text-align:center;">Rp. <?= $sm['subtotal'] ?></td>
                            <td style="text-align:center;">
                                <a href="<?= base_url(); ?>kasir/updateDetailPembayaranLayanan/<?= $sm['id_detail_penjualan_jasa_layanan']; ?>" class="badge badge-primary mb-3" data-toggle="modal" data-target="#editSubMenuModal<?= $sm['id_detail_penjualan_jasa_layanan']; ?>">EDIT</a>
                                <a href="<?= base_url(); ?>kasir/hapusDetailPembayaranLayanan/<?= $sm['id_detail_penjualan_jasa_layanan']; ?>" class="badge badge-danger mb-3">DELETE</a>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td class="text-center" style="color:orange" colspan="10">Transaksi Penjualan '<?= $kode_penjualan ?>'
                            Belum Memiliki
                            Produk
                            yang
                            ditambahkan! </td>
                    </tr>
                <?php endif; ?>
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
                <h5 class="modal-title" id="newMenuModal">Tambah Jasa Layanan Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url(); ?>kasir/detail_pembayaran_layanan/<?= $id_penjualan; ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <select class="form-control" id="pilih_layanan" name="pilih_layanan">
                            <option value="">Pilih Layanan Penjualan</option>
                            <?php foreach ($data_layanan->result() as $row) {
                                if ($sm['nama_jasa_layanan'] == $row->nama_jasa_layanan) {
                                    echo '<option  value="' . $row->id_jasa_layanan . '">' . $row->nama_jasa_layanan . ' ' . $row->nama_jenis_hewan . ' ' . $row->ukuran_hewan . '</.>';
                                } else {
                                    echo '<option value="' . $row->id_jasa_layanan . '">' . $row->nama_jasa_layanan . ' ' . $row->nama_jenis_hewan . ' ' . $row->ukuran_hewan . '</option>';
                                }
                            } ?>
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

<?php foreach ($dataDetailPenjualanLayanan as $sm) : ?>
    <!-- Modal edit -->
    <div class="modal fade" id="editSubMenuModal<?= $sm['id_detail_penjualan_jasa_layanan']; ?>" tabindex="-1" role="dialog" aria-labelledby="#editSubMenuModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSubMenuModal">Edit Jasa Layanan Penjualan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url(); ?>kasir/updateDetailPembayaranLayanan/<?= $sm['id_detail_penjualan_jasa_layanan']; ?>" method="post">

                    <div class="modal-body">
                        <div class="form-group">
                            <input hidden type="text" class="form-control" value="<?= $sm['id_detail_penjualan_jasa_layanan']; ?>" id="id" name="id">
                        </div>

                        <div class="form-group">
                            <select class="form-control" id="pilih_layanan" name="pilih_layanan">
                                <option value="">Pilih Layanan Penjualan</option>
                                <?php foreach ($data_layanan->result() as $row) {
                                    if (($sm['nama_jasa_layanan'] == $row->nama_jasa_layanan) && ($sm['nama_jenis_hewan'] == $row->nama_jenis_hewan) && ($sm['ukuran_hewan'] == $row->ukuran_hewan)) {
                                        echo '<option selected="selected"  value="' . $row->id_jasa_layanan . '">' . $row->nama_jasa_layanan . ' ' . $row->nama_jenis_hewan . ' ' . $row->ukuran_hewan . '</>';
                                    } else {
                                        echo '<option value="' . $row->id_jasa_layanan . '">' . $row->nama_jasa_layanan . ' ' . $row->nama_jenis_hewan . ' ' . $row->ukuran_hewan . '</option>';
                                    }
                                } ?>
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