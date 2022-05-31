<?= $this->extend('templates/admin') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-end px-2 py-1">
            <div>
                <a href="<?= admin_url('user') ?> " class="btn btn-sm bg-gradient-info" role="button" aria-pressed="true">Kembali</a>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6><?= $title ?> Tambah Baru </h6>
            </div>
            <div class="card-body px-4 py-2">
                <form action="" method="POST">
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-control-label">Email</label>
                                <input class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : "" ?>" type="text" placeholder="user@camakara.com" id="email" name="email" value="<?= old('email') ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('email') ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="fullname" class="form-control-label">Nama Lengkap</label>
                                <input class="form-control <?= ($validation->hasError('fullname')) ? 'is-invalid' : "" ?>" type="text" placeholder="Camakara Admin" id="fullname" name="fullname" value="<?= old('fullname') ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('fullname') ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role_access" class="form-control-label">Role Access</label>
                                <select class="form-control <?= ($validation->hasError('role_access')) ? 'is-invalid' : "" ?>" id="role_access" name="role_access">
                                    <?php foreach (role_access() as $value) : ?>
                                        <option value="<?= $value[0] ?>" <?= old('role_access') == $value[0] ? 'selected' : '' ?>><?= $value[1] ?></option>
                                    <?php endforeach ?>
                                </select>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('role_access') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class="form-control-label">Password</label>
                                <input class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : "" ?>" type="password" placeholder="Password" id="password" name="password">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('password') ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="re-password" class="form-control-label">Re-Password</label>
                                <input class="form-control <?= ($validation->hasError('re-password')) ? 'is-invalid' : "" ?>" type="password" placeholder="Verify Password" id="re-password" name="re-password">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('re-password') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col text-center">
                            <button type="submit" class="btn btn-sm bg-gradient-warning">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script type="text/javascript">
    $(document).ready(function() {});
</script>
<?= $this->endSection() ?>