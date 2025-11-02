<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>
<?= $title ?? 'Kelola User' ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="page-heading">
    <div class="d-flex justify-content-between">
        <h3>Kelola User</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
            <i class="bi bi-plus-lg"></i> Tambah User
        </button>
    </div>
</div>

<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-body">

                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="table_users">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            foreach ($users as $u): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= esc($u['name']) ?></td>
                                    <td><?= esc($u['email']) ?></td>
                                    <td><?= $u['is_admin'] ? 'Admin' : 'User' ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-info btn-detail me-1"
                                            data-id="<?= $u['id'] ?>" title="Detail">
                                            <i class="bi bi-eye-fill"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning btn-edit me-1"
                                            data-id="<?= $u['id'] ?>"
                                            data-name="<?= esc($u['name']) ?>"
                                            data-email="<?= esc($u['email']) ?>"
                                            data-role="<?= $u['is_admin'] ?>" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger btn-delete"
                                            data-id="<?= $u['id'] ?>"
                                            data-name="<?= esc($u['name']) ?>" title="Hapus">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>
</div>

<!-- MODAL TAMBAH -->
<div class="modal fade" id="modalAdd" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Tambah User Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/admin/users/store" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="is_admin" class="form-check-input" id="is_admin_add">
                        <label class="form-check-label" for="is_admin_add">Admin?</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDIT -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/admin/users/update" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" id="edit_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="edit_email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password (kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="is_admin" class="form-check-input" id="edit_is_admin">
                        <label class="form-check-label" for="edit_is_admin">Admin?</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL DELETE -->
<div class="modal fade" id="modalDelete" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">Hapus User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/admin/users/delete" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="delete_id">
                <div class="modal-body">
                    <p>Yakin ingin hapus user "<strong id="delete_name"></strong>"?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL DETAIL (TERMASUK ALAMAT) -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white">Detail User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detail_body">
                <!-- Akan diisi via JS -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const editModalEl = document.getElementById('modalEdit');
        const editModal = new bootstrap.Modal(editModalEl);
        const deleteModalEl = document.getElementById('modalDelete');
        const deleteModal = new bootstrap.Modal(deleteModalEl);
        const detailModalEl = document.getElementById('modalDetail');
        const detailModal = new bootstrap.Modal(detailModalEl);

        const table = document.querySelector('#table_users');

        table.addEventListener('click', function(event) {
            const editButton = event.target.closest('.btn-edit');
            if (editButton) {
                document.getElementById('edit_id').value = editButton.dataset.id;
                document.getElementById('edit_name').value = editButton.dataset.name;
                document.getElementById('edit_email').value = editButton.dataset.email;
                document.getElementById('edit_is_admin').checked = editButton.dataset.role == '1';
                editModal.show();
            }

            const deleteButton = event.target.closest('.btn-delete');
            if (deleteButton) {
                document.getElementById('delete_id').value = deleteButton.dataset.id;
                document.getElementById('delete_name').innerText = deleteButton.dataset.name;
                deleteModal.show();
            }

            const detailButton = event.target.closest('.btn-detail');
            if (detailButton) {
                // AJAX fetch alamat user
                fetch('/admin/users/detail/' + detailButton.dataset.id)
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('detail_body').innerHTML = html;
                        detailModal.show();
                    });
            }
        });
    });
    $(document).ready(function() {
    // --- DataTable ---
    $('#table_users').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "lengthMenu": [5, 10, 25, 50]
    });

    // --- Modal Edit/Delete/Detail ---
    const editModalEl = document.getElementById('modalEdit');
    const editModal = new bootstrap.Modal(editModalEl);
    const deleteModalEl = document.getElementById('modalDelete');
    const deleteModal = new bootstrap.Modal(deleteModalEl);
    const detailModalEl = document.getElementById('modalDetail');
    const detailModal = new bootstrap.Modal(detailModalEl);

    $('#table_users').on('click', '.btn-edit', function() {
        const btn = $(this);
        $('#edit_id').val(btn.data('id'));
        $('#edit_name').val(btn.data('name'));
        $('#edit_email').val(btn.data('email'));
        $('#edit_is_admin').prop('checked', btn.data('role') == 1);
        editModal.show();
    });

    $('#table_users').on('click', '.btn-delete', function() {
        const btn = $(this);
        $('#delete_id').val(btn.data('id'));
        $('#delete_name').text(btn.data('name'));
        deleteModal.show();
    });

    $('#table_users').on('click', '.btn-detail', function() {
        const btn = $(this);
        $.get('/admin/users/detail/'+btn.data('id'), function(html){
            $('#detail_body').html(html);
            detailModal.show();
        });
    });
});
</script>
<?= $this->endSection() ?>