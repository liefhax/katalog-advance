<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>
<?= $title ?? 'Kelola Produk' ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="page-heading">
    <div class="d-flex justify-content-between">
        <h3>Kelola Produk</h3>
        
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
            <i class="bi bi-plus-lg"></i> Tambah Produk
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
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <?php if (session()->getFlashdata('errors')) : ?>
                    <div class="alert alert-danger">
                        <h4 class="alert-heading">Gagal!</h4>
                        <p>Terdapat kesalahan validasi:</p>
                        <ul>
                            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="/admin/products" method="get" class="mb-4">
                    <div class="row g-2">
                        <div class="col-md-5">
                            <label for="keyword" class="form-label">Cari Produk</label>
                            <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Masukkan nama produk..." value="<?= esc($keyword) ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="category_id" class="form-label">Filter Kategori</label>
                            <select name="category_id" id="category_id" class="form-select">
                                <option value="">Semua Kategori</option>
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?= $category['id'] ?>" <?= ($category['id'] == $current_category) ? 'selected' : '' ?>>
                                        <?= esc($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">Cari</button>
                            <a href="/admin/products" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="table_products">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Gambar</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($products)) : ?>
                                <tr>
                                    <td colspan="8" class="text-center">Belum ada data produk.</td>
                                </tr>
                            <?php else : ?>
                                <?php $i = 1 + (($currentPage - 1) * $perPage); ?>
                                <?php foreach ($products as $product) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td>
                                            <img src="/uploads/products/<?= esc($product['image_url']) ?>" alt="" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                        </td>
                                        <td><?= esc($product['name']) ?></td>
                                        <td><?= esc($product['category_name']) ?></td>
                                        <td>Rp <?= number_format($product['price'], 0, ',', '.') ?></td>
                                        <td><?= $product['stock'] ?></td>
                                        <td>
                                            <span class="badge <?= ($product['is_active'] == 1) ? 'bg-success' : 'bg-danger' ?>">
                                                <?= ($product['is_active'] == 1) ? 'Aktif' : 'Nonaktif' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button class="btn btn-warning btn-edit" 
                                                    title="Edit"
                                                    data-product="<?= esc(json_encode($product)) ?>">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </button>
                                                <button class="btn btn-danger btn-delete" 
                                                    title="Hapus"
                                                    data-id="<?= $product['id'] ?>" 
                                                    data-name="<?= esc($product['name']) ?>">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        <?php
                        $start = 1 + (($currentPage - 1) * $perPage);
                        $end = min($currentPage * $perPage, $total);
                        ?>
                        Menampilkan <?= $start ?> - <?= $end ?> dari <?= $total ?> produk
                    </div>
                    <?php if ($pager) : ?>
                        <?= $pager->links('products', 'default_full') ?>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modalAdd" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Tambah Produk Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/admin/products/create" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Kategori</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php foreach ($categories as $category) : ?>
                                        <option value="<?= $category['id'] ?>"><?= esc($category['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="price" name="price" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stok</label>
                                <input type="number" class="form-control" id="stock" name="stock" value="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                             <div class="mb-3">
                                <label for="image_url" class="form-label">Gambar Produk</label>
                                <input class="form-control" type="file" id="image_url" name="image_url" required>
                                <small class="text-muted">Max 2MB. (JPG, PNG, JPEG)</small>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">Aktifkan Produk</label>
                        </div>
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
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Edit Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/admin/products/update" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" id="edit_id" name="id">
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="edit_name" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_category_id" class="form-label">Kategori</label>
                                <select class="form-select" id="edit_category_id" name="category_id" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php foreach ($categories as $category) : ?>
                                        <option value="<?= $category['id'] ?>"><?= esc($category['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_price" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="edit_price" name="price" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_stock" class="form-label">Stok</label>
                                <input type="number" class="form-control" id="edit_stock" name="stock" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                             <div class="mb-3">
                                <label for="edit_image_url" class="form-label">Ganti Gambar</label>
                                <br>
                                <img src="" alt="Preview" id="edit_image_preview" class="mb-2" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
                                <input class="form-control" type="file" id="edit_image_url" name="image_url">
                                <small class="text-muted">Biarkan kosong jika tidak ganti. Max 2MB.</small>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="edit_is_active" name="is_active" value="1">
                            <label class="form-check-label" for="edit_is_active">Aktifkan Produk</label>
                        </div>
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
                <h5 class="modal-title text-white">Hapus Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/admin/products/delete" method="post">
                <?= csrf_field() ?>
                <input type="hidden" id="delete_id" name="id">
                
                <div class="modal-body">
                    <p>Yakin mau hapus produk "<strong id="delete_name"></strong>"?</p>
                    <small class="text-danger">Aksi ini tidak bisa dibatalkan!</small>
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
    document.addEventListener("DOMContentLoaded", function() {
        
        // --- 1. LOGIC UNTUK EDIT ---
        const editModalEl = document.getElementById('modalEdit');
        const editModal = new bootstrap.Modal(editModalEl);
        
        // Ambil elemen form di dalam modal edit
        const editIdInput = document.getElementById('edit_id');
        const editNameInput = document.getElementById('edit_name');
        const editCategoryIdInput = document.getElementById('edit_category_id');
        const editPriceInput = document.getElementById('edit_price');
        const editStockInput = document.getElementById('edit_stock');
        const editDescriptionInput = document.getElementById('edit_description');
        const editIsActiveInput = document.getElementById('edit_is_active');
        const editImagePreview = document.getElementById('edit_image_preview');

        // --- 2. LOGIC UNTUK DELETE ---
        const deleteModalEl = document.getElementById('modalDelete');
        const deleteModal = new bootstrap.Modal(deleteModalEl);
        const deleteIdInput = document.getElementById('delete_id');
        const deleteNameSpan = document.getElementById('delete_name');

        // Ambil tabel
        const table = document.querySelector('#table_products');

        // Pasang event listener di tabel (Event Delegation)
        table.addEventListener('click', function (event) {
            
            // --- Cek Tombol Edit ---
            const editButton = event.target.closest('.btn-edit');
            if (editButton) {
                // Ambil data dari atribut data-product
                const productData = JSON.parse(editButton.getAttribute('data-product'));
                
                // Isi form modal edit
                editIdInput.value = productData.id;
                editNameInput.value = productData.name;
                editCategoryIdInput.value = productData.category_id;
                editPriceInput.value = productData.price;
                editStockInput.value = productData.stock;
                editDescriptionInput.value = productData.description;
                editIsActiveInput.checked = (productData.is_active == 1);
                
                // Set preview gambar
                editImagePreview.src = '/uploads/products/' + productData.image_url;
                
                // Tampilkan modal edit
                editModal.show();
            }

            // --- Cek Tombol Delete ---
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

        // Kalo ada error validasi, modal add-nya otomatis kebuka
        <?php if (session()->getFlashdata('errors') && !session()->getFlashdata('is_edit')) : ?>
            const addModal = new bootstrap.Modal(document.getElementById('modalAdd'));
            addModal.show();
        <?php endif; ?>
    });
</script>
<?= $this->endSection() ?>