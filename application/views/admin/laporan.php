<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?> - Owner AREA</h1>


</div>
<!-- /.container-fluid -->

<div class="row">
    <div class="col-lg ml-3 mr-3">
        <div class="form-group">

            <div class="d-flex justify-content-center">
                <img height="150px" width=230px" style="text-align: center;" src=" <?= base_url('assets/img/logoKPS.png'); ?>">
            </div>
            <div class="d-flex justify-content-center">
                <h1 class="text-dark"><strong>LAPORAN TAHUNAN DAN BULANAN KOUVEE PETSHOP</h1>
            </div>

            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>

            <table class="table table-hover table-info">

                <body>
                    <tr>
                        <td style="padding: 10px;">
                            <form action="<?= base_url('admin/laporan'); ?>" method="post">
                                <p class="font-weight-bold text-primary"">LAPORAN JASA LAYANAN TERLARIS</p>
                                    <div class=" input-group " style=" width: 560px;">
                                    <select class="custom-select" id="pilih_tahun" name="pilih_tahun">
                                        <option value="">Pilih Tahun</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                    </select>
                                    <div class=" input-group-append">
                                        <button class="btn btn-success" type="submit" id="submit" name="submit" class="badge badge-warning mb-3"><i class="fa fa-print"></i>
                                            CETAK</button>
                                    </div>
        </div>
        </form>
        </td>
        <td style="padding: 10px;">
            <form action="<?= base_url('admin/laporan'); ?>" method="post">
                <p class="font-weight-bold text-primary">LAPORAN PRODUK TERLARIS</p>
                <div class="input-group " style="width: 560px;">
                    <select class="custom-select" id="pilih_tahun" name="pilih_tahun">
                        <option value="">Pilih Tahun</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                    </select>
                    <div class=" input-group-append">
                        <button class="btn btn-success" id="produk_tahunan" type="submit" name="produk_tahunan" class="badge badge-warning mb-3"><i class="fa fa-print"></i>
                            CETAK</button>
                    </div>
                </div>
            </form>
        </td>
        <td style="padding: 10px;">
            <form action="<?= base_url('admin/laporan'); ?>" method="post">
                <p class="font-weight-bold text-primary">LAPORAN PENGADAAN TAHUNAN</p>
                <div class="input-group " style="width: 560px;">
                    <select class="custom-select" id="pilih_tahun" name="pilih_tahun">
                        <option value="">Pilih Tahun</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                    </select>
                    <div class=" input-group-append">
                        <button class="btn btn-success" id="pengadaan_tahunan" type="submit" name="pengadaan_tahunan" class="badge badge-warning mb-3"><i class="fa fa-print"></i>
                            CETAK</button>
                    </div>
                </div>
            </form>
        </td>
        </tr>
        <tr>
            <td style="padding: 10px;">
                <form action="<?= base_url('admin/laporan'); ?>" method="post">
                    <p class="font-weight-bold text-primary">LAPORAN PENDAPATAN TAHUNAN</p>
                    <div class=" input-group " style="width: 560px;">
                        <select class="custom-select" id="pilih_tahun" name="pilih_tahun">
                            <option value="">Pilih Tahun</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                        </select>
                        <div class=" input-group-append">
                            <button class="btn btn-success" id="pendapatan_tahunan" type="submit" name="pendapatan_tahunan" class="badge badge-warning mb-3"><i class="fa fa-print"></i>
                                CETAK</button>
                        </div>
                    </div>
                </form>
            </td>
            <td style="padding: 10px;">
                <form action="<?= base_url('admin/laporan'); ?>" method="post">
                    <p class="font-weight-bold text-primary">LAPORAN PENDAPATAN BULANAN</p>
                    <div class=" input-group " style="width: 560px;">
                        <select class="custom-select" id="pilih_bulan" name="pilih_bulan">
                            <option value="">Pilih Bulan</option>
                            <option value="1">Januari</option>
                            <option value="2">Febuari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                        <select class="custom-select" id="pilih_tahun" name="pilih_tahun">
                            <option value="">Pilih Tahun</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                        </select>

                        <div class=" input-group-append">
                            <button class="btn btn-success" id="pendapatan_bulanan" type="submit" name="pendapatan_bulanan" class="badge badge-warning mb-3"><i class="fa fa-print"></i>
                                CETAK</button>
                        </div>
                    </div>
                </form>
            </td>
            <td style="padding: 10px;">
                <form action="<?= base_url('admin/laporan'); ?>" method="post">
                    <p class="font-weight-bold text-primary">LAPORAN PENGADAAN BULANAN</p>
                    <div class="input-group " style="width: 560px;">
                        <select class="custom-select" id="pilih_bulan" name="pilih_bulan">
                            <option value="">Pilih Bulan</option>
                            <option value="1">Januari</option>
                            <option value="2">Febuari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                        <select class="custom-select" id="pilih_tahun" name="pilih_tahun">
                            <option value="">Pilih Tahun</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                        </select>
                        <div class=" input-group-append">
                            <button class="btn btn-success" id="pengadaan_bulanan" type="submit" name="pengadaan_bulanan" class="badge badge-warning mb-3"><i class="fa fa-print"></i>
                                CETAK</button>
                        </div>
                    </div>
                </form>
            </td>
        </tr>

        </body>
        </table>
    </div>

    <?= $this->session->flashdata('message'); ?>
</div>
</div>
<!-- End of Main Content -->