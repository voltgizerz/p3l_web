<body class="bg-gradient-dark">

    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="font-size: 1.8em !important;">
            <a href="<?= base_url('auth/home'); ?>"><img height="90px" width=100px" style="text-align: center;" src=" <?= base_url('assets/img/logoKPS.png'); ?>">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="nav navbar-nav navbar-right">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('auth/home'); ?>">HOME </a>
                    </li>
                    <li class="nav-item active ">
                        <a class="nav-link" href="<?= base_url('customer/status'); ?>">CEK STATUS LAYANAN <span class="sr-only">(current)</span></a>
                    </li>

                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item ">
                        <a class="btn btn-primary" href="<?= base_url('auth'); ?>">LOGIN</a>
                    </li>
                </ul>
            </div>
        </nav>


        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-lg-13">

                <div class="card o-hidden border-0 my-3">
                    <div class="bg-dark  ">
                        <div class="text-center">
                            <img height="120px" width=150px" style="text-align: center;" src=" <?= base_url('assets/img/logoKPS.png'); ?>">
                            <h1 class="text-warning"><strong>INFORMASI STATUS LAYANAN</h1>
                            <h3 class="text-warning">
                                KOUVEE PETSHOP</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg ml-3 mr-3">
                            <div class="form-group">
                                <?php echo form_open("customer/cari"); ?>
                                <div class="input-group " style="width: 600px;">
                                    <select class="custom-select" id="inputGroupSelect07" name="cariberdasarkan">
                                        <option value="">Cari Berdasarkan</option>
                                        <option value="kode_penjualan">Kode Transaksi</option>
                                        <option value="nama_hewan">Nama Hewan</option>
                                        <option value="nama_cs">Nama Customer Service</option>
                                        <option value="sudah_selesai">Status Layanan Selesai</option>
                                        <option value="belum_selesai">Status Layanan Belum Selesai</option>
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

                            <table class="table table-hover table-warning table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center text-dark">No</th>
                                        <th scope="col" class="text-center font-weight-bold text-dark">Kode Penjualan</th>
                                        <th scope="col" class="text-center text-dark">Nama Customer Service</th>
                                        <th scope="col" class="text-center text-dark">Nama Kasir</th>
                                        <th scope="col" class="text-center text-dark">Nama Hewan</th>
                                        <th scope="col" class="text-center text-dark">Status Layanan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($dataPenjualanLayanan as $sm) : ?>
                                        <tr>
                                            <th scope="row" class="text-center text-dark"><?= $i ?></th>
                                            <td class="text-center text-dark"><?= $sm['kode_transaksi_penjualan_jasa_layanan'] ?></td>
                                            <td class="text-center text-dark"><?= $sm['nama_cs'] ?></td>
                                            <?php if ($sm['id_kasir'] == $sm['id_cs']) : ?>
                                                <td style="text-align:center; color:#FF6347;"> Dalam Proses Pembayaran</td>
                                            <?php else : ?>
                                                <td class="text-center text-dark"><?= $sm['nama_kasir'] ?></td>
                                            <?php endif; ?>
                                            <td class="text-center text-dark"><?= $sm['nama_hewan'] ?></td>

                                            <?php if ($sm['status_layanan'] == 'Belum Selesai') : ?>
                                                <td style="text-align:center; color:#FF6347;"> Sedang Diproses</td>
                                            <?php else : ?>
                                                <td class="text-center text-success"><?= $sm['status_layanan'] ?></td>
                                            <?php endif; ?>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card o-hidden border-0 my-3">
                        <div class="bg-dark  ">
                            <div class="text-center">
                                <h1 class="text-warning"><strong>Tentang Kita</h1>
                                <h3 class="text-warning">
                                    Kouvee Pet Shop Merupakan sebuah toko yang menjual berbagai kebutuhan
                                    untuk hewan peliharaan berbasis online. Di Kouvee Pet Shop kita menyediakan
                                    berbagai macam produk dan jasa layanan untuk hewan peliharaan anda.
                                    Ayo manjakan hewan peliharaan anda dengan fasilitas yang kami sediakan</h3>
                                <h3 class="text-warning">Alamat : Jalan Babarsari Merdeka</h3>
                                <h3 class="text-warning">Kontak : (0274) 7556622</h3>
                            </div>
                        </div>
                    </div>
                    <footer class="sticky-footer bg-white">
                        <div class="container my-auto">
                            <div class="copyright text-center my-auto">
                                <span>Copyright &copy; Kouvee PetShop 2020</span>
                            </div>
                        </div>
                    </footer>


                </div>

            </div>

        </div>

    </div>

    </div>