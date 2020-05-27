<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?> - Owner AREA</h1>


</div>
<!-- /.container-fluid -->

<div class="row">
    <div class="col-lg ml-3 mr-3">
        <div class="form-group">

            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>
            <form action="<?= base_url('admin/laporan'); ?>" method="post">
                LAPORAN JASA LAYANAN TERLARIS
                <div class="input-group " style="width: 600px;">
                    <select class="custom-select" id="pilih_tahun" name="pilih_tahun">
                        <option value="">Pilih Tahun</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                    </select>
                    <div class=" input-group-append">
                        <button class="btn btn-success" type="submit" id="submit" name="submit" class="badge badge-warning mb-3"><i class="fa fa-print"></i>
                            CETAK</button>
                    </div>
                </div>
            </form>
            <br>
            <form action="<?= base_url('admin/laporan'); ?>" method="post">
                LAPORAN PRODUK TERLARIS
                <div class="input-group " style="width: 600px;">
                    <select class="custom-select" id="pilih_tahun" name="pilih_tahun">
                        <option value="">Pilih Tahun</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                    </select>
                    <div class=" input-group-append">
                        <button class="btn btn-success" id="produk_tahunan" type="submit" name="produk_tahunan" class="badge badge-warning mb-3"><i class="fa fa-print"></i>
                            CETAK</button>
                    </div>
                </div>
            </form>
            <br>
            <form action="<?= base_url('admin/laporan'); ?>" method="post">
                LAPORAN PENDAPATAN TAHUNAN
                <div class="input-group " style="width: 600px;">
                    <select class="custom-select" id="pilih_tahun" name="pilih_tahun">
                        <option value="">Pilih Tahun</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                    </select>
                    <div class=" input-group-append">
                        <button class="btn btn-success" id="pendapatan_tahunan" type="submit" name="pendapatan_tahunan" class="badge badge-warning mb-3"><i class="fa fa-print"></i>
                            CETAK</button>
                    </div>
                </div>
            </form>
        </div>

        <?= $this->session->flashdata('message'); ?>
    </div>
</div>
<!-- End of Main Content -->