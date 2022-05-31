<?= $this->extend('templates/auth') ?>
<?= $this->section('content') ?>
<section>
    <div class="page-header min-vh-75">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                    <div class="card card-plain mt-8">
                        <div class="card-header pb-0 text-left bg-transparent">
                            <h3 class="font-weight-bolder">Selamat Datang </h3>
                            <p class="mb-0">Silahkan login! Masukan email dan password kamu</p>
                        </div>
                        <div class="card-body">
                            <?php if (session()->getFlashdata('failed')) : ?>
                                <div class="alert alert-warning p-2 text-center" role="alert">
                                    <strong class="text-white"><?= session()->getFlashdata('failed') ?></strong>
                                </div>
                            <?php elseif (session()->getFlashdata('success')) : ?>
                                <div class="alert alert-success p-2 text-center" role="alert">
                                    <strong class="text-white"><?= session()->getFlashdata('success') ?></strong>
                                </div>
                            <?php endif ?>
                            <?= form_open();
                            csrf_field() ?>
                            <label>Email</label>
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control <?= $validation->hasError('email') ? 'is-invalid' : '' ?>" placeholder="Email" aria-label="Email" aria-describedby="email-addon" value="<?= old('email') ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('email') ?>
                                </div>
                            </div>
                            <label>Password</label>
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control <?= $validation->hasError('password') ? 'is-invalid' : '' ?>" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('password') ?>
                                </div>
                            </div>
                            <!-- <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="rememberMe" checked="">
                                    <label class="form-check-label" for="rememberMe">Remember me</label>
                                </div> -->
                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-success w-100 mt-4 mb-0">Masuk</button>
                            </div>
                            <?= form_close() ?>
                        </div>
                        <!-- <div class="card-footer text-center pt-0 px-lg-2 px-1">
                            <p class="mb-4 text-sm mx-auto">
                                Belum mempunyai akun?
                                <a href="<?= admin_url('auth/register') ?>" class="text-info text-gradient font-weight-bold">Daftar</a>
                            </p>
                        </div> -->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="h-100" style="background-image:url('<?= base_url() ?>/assets/img/illustrations/Branding.png');background-repeat: no-repeat;background-position: center;background-size: contain;"></div>
                    <!-- <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                        <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('<?= base_url() ?>/assets/img/illustrations/Branding.png')"></div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>