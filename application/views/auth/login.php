<body class="bg-gradient-dark">

    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light ">
            <a class="navbar-brand" href="<?= base_url('auth/home'); ?>">Kouvee Pet Shop</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="nav navbar-nav navbar-right">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= base_url('auth/home'); ?>">HOME <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="<?= base_url('auth'); ?>">LOGIN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('auth/registration'); ?>">REGISTER</a>
                    </li>
                </ul>

            </div>
        </nav>

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-lg-5">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="<?= base_url('assets/img/user.png'); ?>" style="width:80px;height:80px;">
                                        <h1 class=" h4 text-gray-900 mb-4">Welcome Back to RichzAuto!</h1>
                                    </div>
                                    <?= $this->session->flashdata('message'); ?>
                                    <form method="post" action="<?= base_url('auth') ?>">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Email" value="<?= set_value('email') ?>">
                                            <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>

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
                                    <div class="text-center">
                                        <a class="small" href="<?= base_url('auth/registration'); ?>">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>