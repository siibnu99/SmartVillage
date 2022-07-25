<?= $this->extend('templates/admin') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between px-2 py-1">
            <div>
                <?php foreach (statusSurat() as $key => $value) : if ($key == 0) continue;  ?>
                    <button type="button" class="btn bg-gradient-success" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $value[1] ?>">
                        <?= $value[1] ?>
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal<?= $value[1] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <form action="<?= admin_url('surat/change') ?>" method="GET">
                                    <input type="hidden" name="id" value="<?= $id ?>">
                                    <input type="hidden" name="status" value="<?= $value[0] ?>">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><?= $value[1] ?></h5>
                                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">Pesan:</label>
                                            <textarea class="form-control" id="message-text" name="message"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Keluar</button>
                                        <button type="submit" class="btn bg-gradient-success">Kirim</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- <a role="button" href="<?= admin_url('surat/change/?id=' . $id . '&status=' . $value[0]) ?>" class="btn btn-sm bg-gradient-success"><?= $value[1] ?></a> -->
                <?php endforeach ?>
            </div>
            <div>
                <a href="<?= admin_url('surat') ?> " class="btn btn-sm bg-gradient-info" role="button" aria-pressed="true">Kembali</a>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6><?= $title ?> Detail </h6>
            </div>
            <div class="card-body px-4 py-2">
                <form action="" method="POST">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 ">Atribut</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Isi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0;
                                        foreach (json_decode($data->data) as $key => $value) : $no++;
                                            if ($key == 'feedback') continue ?>
                                            <tr>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0"><?= $no ?></p>
                                                </td>
                                                <td>
                                                    <p class=" font-weight-bold mb-0"><?= keyObstractor($key) ?></p>
                                                </td>
                                                <td class="align-middle  text-sm  w-50">
                                                    <?php if ($key == "foto_user" || $key == "tanda_tangan" || $key == "foto_ktp_rusak" || $key == "foto_ktp" || $key == "foto_kk" || $key == "pengantar_rt") :
                                                        if ($value) :
                                                            echo "<img src='" . base_url(' assets/images/surat/' . $value) . "' class='h-50 w-50' alt='Responsive image'>";
                                                        endif;
                                                    elseif (($key == "suket_hilang" || $key == "suket_pindah")) : ?>
                                                        <?php if ($value) :   ?>
                                                            <a class="font-weight-bold mb-0" href="<?= base_url(' assets/images/surat/' . $value) ?>"><?= base_url(' assets/images/surat/' . $value) ?></a>
                                                        <?php endif ?>
                                                    <?php else : ?>
                                                        <p class=" font-weight-bold mb-0">
                                                        <?php
                                                        if ($key == 'type') {
                                                            echo pengajuanKtp($value)[1];
                                                        } else if ($key == 'jenis_kelamin') {
                                                            if ($value == 0) {
                                                                echo 'Laki-laki';
                                                            } else {
                                                                echo 'Perempuan';
                                                            }
                                                        } else if ($key == 'tanggal_lahir') {
                                                            echo date('d-M-Y', strtotime($value));
                                                        } else if ($key == "id_dusun") {
                                                            echo dusunId($value)[1];
                                                        } else if ($key == "kebangsaan") {
                                                            echo kebangsaanId($value)[1];
                                                        } else if ($key == "status_perkawinan") {
                                                            echo perkawinanId($value)[1];
                                                        } else if ($key == "agama") {
                                                            echo agamaId($value)[1];
                                                        } else if ($key == "feedback") {
                                                            continue;
                                                        } else {
                                                            echo $value;
                                                        }
                                                    endif; ?>
                                                        </p>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
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