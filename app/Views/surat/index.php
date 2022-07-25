<?= $this->extend('templates/admin') ?>

<?= $this->section('content') ?>
<input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
<div class="row">
    <div class="col-12">
        <h6>Tanggal</h6>
        <form class="d-flex align-items-end justify-content-between" action="" method="GET">
            <div class="d-flex align-items-end justify-content-between w-80 flex-wrap ">
                <div class="form-group">
                    <label for="example-date-input" class="form-control-label">Dari</label>
                    <input class="form-control" type="date" id="example-date-input" name="from_date" value="<?= $from_date ?>">
                </div>
                <div class="form-group">
                    <label for="example-date-input" class="form-control-label">Sampai</label>
                    <input class="form-control" type="date" value="<?= $end_date ?>" id="example-date-input" name="end_date">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Jenis Surat</label>
                    <select class="form-control" id="exampleFormControlSelect1" name="type">
                        <option value="0">Semua Surat</option>
                        <?php foreach (surat() as $value) : ?>
                            <option value="<?= $value[0] ?>" <?= $value[0] == $type ? "selected" : "" ?>><?= $value[1] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <button class="btn bg-gradient-success" type="submit">Filter</button>
        </form>
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6><?= $title ?> Tabel </h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class=" table p-3">
                    <table class="table align-items-center mb-0" id="myTable">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">No</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Nama Pengaju</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Surat</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center align-items-center"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal Detail</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#myTable').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "oLanguage": {
                "sLengthMenu": "Tampilkan _MENU_ data per halaman",
                "sSearch": "Pencarian: ",
                "sZeroRecords": "Maaf, tidak ada data yang ditemukan",
                "sInfo": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
                "sInfoEmpty": "Menampilkan 0 s/d 0 dari 0 data",
                "sInfoFiltered": "(di filter dari _MAX_ total data)",
                "oPaginate": {
                    "sFirst": "<<",
                    "sLast": ">>",
                    "sPrevious": '<i class="ni ni-bold-left" aria-hidden="true"></i>',
                    "sNext": '<i class="ni ni-bold-right" aria-hidden="true"></i>'
                }
            },
            "order": [],
            "ajax": {
                "url": "<?= admin_url('surat/listdata') ?>",
                "type": "POST",
                data: function(d) {
                    let token = $('.txt_csrfname').val();
                    d.csrf_test_name = token;
                    d.data = {
                        from_date: "<?= $from_date ?>",
                        end_date: "<?= $end_date ?>",
                        type: "<?= $type ?>"
                    };
                },
                'dataSrc': function(response) {
                    console.log(response);
                    $('.txt_csrfname').val(response.csrf_test_name)
                    console.log(response);
                    return response.data;
                }
            },
            //optional
            "lengthMenu": [
                [5, 10, 25],
                [5, 10, 25]
            ],
            "columnDefs": [{
                "targets": [],
                "orderable": false,
            }, ],
        });
    });
</script>
<?= $this->endSection() ?>