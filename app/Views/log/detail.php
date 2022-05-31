<?= $this->extend('templates/admin') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6><?= $title ?></h6>
            </div>
            <div class="card-body px-5  pt-0 pb-2">
                <div class="card bg-gradient-secondary text-white mb-4 ">
                    <div class="card-body overflow-auto max-height-vh-80 px-3 py-3">
                        <?= nl2br($data) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>