<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>
<?= $title ?? 'Kelola Kategori' ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="page-heading">
    <div class="d-flex justify-content-between">
        <h3>Kelola Kategori</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
            <i class="bi bi-plus-lg"></i> Tambah Kategori
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
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')) : ?>
                    <div class="alert alert-danger">
                        <h4 class="alert-heading">Gagal!</h4>
                        <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                            <p><?= esc($error) ?></p>
                        <?php endforeach ?>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="table_categories">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Kategori</th>
                                <th>Slug</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($categories)) : ?>
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada data kategori.</td>
                                </tr>
                            <?php else : ?>
                                <?php $i = 1; ?>
                                <?php foreach ($categories as $cat) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= esc($cat['name']) ?></td>
                                        <td><?= esc($cat['slug']) ?></td>
                                        <td>
    <button class="btn btn-sm btn-warning btn-edit me-1"
        data-id="<?= $cat['id'] ?>"
        data-name="<?= esc($cat['name']) ?>"
        title="Edit"> 
        <i class="bi bi-pencil-fill"></i>
    </button>
    
    <button class="btn btn-sm btn-danger btn-delete"
        data-id="<?= $cat['id'] ?>"
        data-name="<?= esc($cat['name']) ?>"
        title="Hapus">
        <i class="bi bi-trash-fill"></i>
    </button>
</td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modalAdd" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Tambah Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/admin/categories/create" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="name" name="name" required>
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

<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/admin/categories/update" method="post">
                <?= csrf_field() ?>
                <input type="hidden" id="edit_id" name="id">
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
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

<div class="modal fade" id="modalDelete" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">Hapus Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/admin/categories/delete" method="post">
                <?= csrf_field() ?>
                <input type="hidden" id="delete_id" name="id">
                
                <div class="modal-body">
                    <p>Yakin mau hapus kategori "<strong id="delete_name"></strong>"?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
    // Tunggu dokumen siap
    document.addEventListener("DOMContentLoaded", function() {
        
        // --- 1. LOGIC UNTUK EDIT ---
        const editModalEl = document.getElementById('modalEdit');
        const editModal = new bootstrap.Modal(editModalEl);
        
        // Ambil elemen form di dalam modal edit
        const editForm = editModalEl.querySelector('form');
        const editIdInput = editModalEl.querySelector('#edit_id');
        const editNameInput = editModalEl.querySelector('#edit_name');

        // --- 2. LOGIC UNTUK DELETE ---
        const deleteModalEl = document.getElementById('modalDelete');
        const deleteModal = new bootstrap.Modal(deleteModalEl);

        // Ambil elemen form di dalam modal delete
        const deleteForm = deleteModalEl.querySelector('form');
        const deleteIdInput = deleteModalEl.querySelector('#delete_id');
        const deleteNameSpan = deleteModalEl.querySelector('#delete_name');

        // Ambil tabel
        const table = document.querySelector('#table_categories');

        // Pasang event listener di tabel (Event Delegation)
        table.addEventListener('click', function (event) {
            
            // Cek apakah yang diklik tombol .btn-edit
            const editButton = event.target.closest('.btn-edit');
            if (editButton) {
                // Ambil data dari tombol
                const id = editButton.getAttribute('data-id');
                const name = editButton.getAttribute('data-name');
                
                // Isi form modal edit
                editIdInput.value = id;
                editNameInput.value = name;
                
                // Tampilkan modal edit
                editModal.show();
            }

            // Cek apakah yang diklik tombol .btn-delete
            const deleteButton = event.target.closest('.btn-delete');
            if (deleteButton) {
                // Ambil data dari tombol
                const id = deleteButton.getAttribute('data-id');
                const name = deleteButton.getAttribute('data-name');
                
                // Isi form modal delete
                deleteIdInput.value = id;
                deleteNameSpan.innerText = name;
                
                // Tampilkan modal delete
                deleteModal.show();
            }
        });
    });
</script>
<?= $this->endSection() ?>