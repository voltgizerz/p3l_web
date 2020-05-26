<body class="bg-gradient-dark">

    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="font-size: 1.8em !important;">
            <a href="<?= base_url('auth/home'); ?>"><img height="90px" width=100px" style="text-align: center;" src=" <?= base_url('assets/img/logoKPS.png'); ?>">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="nav navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= base_url('auth/home'); ?>">HOME <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="<?= base_url('customer/status'); ?>">CEK STATUS LAYANAN</a>
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
                    <div class="bg-primary  ">
                        <div class="text-center">
                            <h1 class="text-warning"><strong>Selamat Datang di Kouvee Pet Shop</h1>
                            <h3 class="text-warning">
                                Dimana tempat para pecinta hewan bersatu</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <img height="100%" width=100%" src=" <?= base_url('assets/img/petshop3.jpg'); ?>">

                    <div class="card o-hidden border-0 my-3">
                        <div class="bg-primary  ">
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