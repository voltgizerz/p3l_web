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

            <div class="col-lg-3">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="<?= base_url('assets/img/LogoKPS.png'); ?>" style="width:133px;height:80px;">
                                        <h1 class=" h4 text-gray-900 mb-4">Silahkan Login dengan Akun Pegawai Anda!</h1>
                                    </div>
                                    <?= $this->session->flashdata('message'); ?>
                                    <form method="post" action="<?= base_url('auth') ?>">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username" value="<?= set_value('username') ?>">
                                            <?= form_error('username', '<small class="text-danger pl-3">', '</small>'); ?>

                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                            <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>

                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>

                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>