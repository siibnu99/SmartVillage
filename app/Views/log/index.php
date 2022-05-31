<?= $this->extend('templates/admin') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6><?= $title ?></h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="row">
                    <?php foreach ($list as $value) : ?>
                        <a class="px-5 col-md-4" href="<?= admin_url('log/' . explode('.', $value)[0])  ?>">
                            <div class="alert alert-secondary text-white d-flex justify-content-between px-3" role="alert">
                                <strong>Log : </strong>
                                <strong><?= $value ?></strong>
                            </div>
                        </a>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>