<body class="bg-gradient-dark">

    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light ">
            <a class="navbar-brand" href="<?= base_url('auth/home'); ?>">RichzAuto</a>
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

            <div class="col-lg-13">

                <div class="card o-hidden border-0 my-1">
                    <div class="card-body p-0"> 
                    <img src=" <?= base_url('assets/img/homeuas.jpg'); ?>">


                    </div>
                </div>

            </div>

        </div>

    </div>