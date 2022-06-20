<?= $this->extend('templates/admin') ?>

<?= $this->section('content') ?>
<input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between px-2 py-1">
            <div>
                <a role="button" href="<?= admin_url('user') ?>" class="btn btn-sm bg-gradient-success">Semua Role</a>
                <?php foreach (role_access() as $value) : ?>
                    <a role="button" href="<?= admin_url('user/' . $value[0]) ?>" class="btn btn-sm bg-gradient-success"><?= $value[1] ?></a>
                <?php endforeach ?>
            </div>
            <div>
                <a href="<?= admin_url('user/add') ?> " class="btn btn-sm bg-gradient-warning" role="button" aria-pressed="true">Buat Baru</a>
            </div>
        </div>
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
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Email</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role</th>
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
                "url": "<?= admin_url('user/listdata/' . $id) ?>",
                "type": "POST",
                data: function(d) {
                    let token = $('.txt_csrfname').val();
                    d.csrf_test_name = token;
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
<?= $this->section('script') ?>
<script>
    function actionDelete(id) {
        var csrfHash = $('.txt_csrfname').val(); // CSRF hash
        var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
        Swalc.fire({
            title: 'Peringatan!',
            text: "Apakah kamu yakin untuk menghapus user ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Iya',
            cancelButtonText: 'tidak',
        }).then((result) => {
            if (result.value) {
                $.post("<?= admin_url('user/delete') ?>", {
                    id: id,
                    csrf_test_name: csrfHash
                }, '', "json").done(function(data) {
                    Toast.fire({
                        title: data.message,
                        icon: 'success',
                    })
                    $('.txt_csrfname').val(data.csrf_test_name)
                    $("#myTable").DataTable().ajax.reload();
                });
            } else if (result.dismiss === Swalc.DismissReason.cancel) {
                Toast.fire({
                    title: 'Hapus user dicancel',
                    icon: 'info',
                })
            }
        })

    }

    function actionActive(id) {
        var csrfHash = $('.txt_csrfname').val(); // CSRF hash
        var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name

        $.post("<?= admin_url('user/active') ?>", {
            id: id,
            csrf_test_name: csrfHash
        }, '', "json").done(function(data) {
            Toast.fire({
                title: data.message,
                icon: 'success',
            })
            $('.txt_csrfname').val(data.csrf_test_name)
            $("#myTable").DataTable().ajax.reload();
        });
    }
    $(document).on('click', '.btnDelete', function() {
        let id = $(this).data('id');
        console.log('click');
        actionDelete(id)
    })
    $(document).on('click', '.btnActive', function() {
        let id = $(this).data('id');
        console.log('click');
        actionActive(id)
    })
</script>
<?= $this->endSection() ?>