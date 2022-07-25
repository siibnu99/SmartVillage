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
                <h6><?= $title ?> Ganti Password </h6>
            </div>
            <div class="card-body px-4 py-2">
                <?= form_open();
                csrf_field() ?>
                <input type="hidden" name="id_user" value="<?= $data->id_user ?>">
                <div class="row">
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
                <?= form_close() ?>
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