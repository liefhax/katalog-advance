<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <?= view('admin/partials/header') ?>
    
    <div class="flex">
        <?= view('admin/partials/sidebar') ?>
        
        <main class="flex-1 p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold"><?= $title ?></h1>
                <button onclick="openModal()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Tambah Promo
                </button>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($promos as $promo): ?>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-semibold"><?= $promo->name ?></h3>
                            <span class="px-2 py-1 text-xs rounded <?= $promo->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                <?= $promo->is_active ? 'Aktif' : 'Nonaktif' ?>
                            </span>
                        </div>
                        
                        <div class="space-y-2 mb-4">
                            <p><strong>Kode:</strong> <code class="bg-gray-100 px-2 py-1 rounded"><?= $promo->code ?></code></p>
                            <p><strong>Diskon:</strong> 
                                <?= $promo->discount_type === 'percentage' ? 
                                    $promo->discount_value . '%' : 
                                    'Rp ' . number_format($promo->discount_value, 0, ',', '.') ?>
                            </p>
                            <?php if ($promo->min_purchase > 0): ?>
                                <p><strong>Min. Belanja:</strong> Rp <?= number_format($promo->min_purchase, 0, ',', '.') ?></p>
                            <?php endif; ?>
                            <p><strong>Periode:</strong> <?= date('d M Y', strtotime($promo->start_date)) ?> - <?= date('d M Y', strtotime($promo->end_date)) ?></p>
                            <p><strong>Digunakan:</strong> <?= $promo->used_count ?> / <?= $promo->usage_limit ?? '∞' ?></p>
                        </div>

                        <div class="flex space-x-2">
                            <button onclick="editPromo(<?= htmlspecialchars(json_encode($promo), ENT_QUOTES, 'UTF-8') ?>)" 
                                class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-3 rounded text-sm">
                                Edit
                            </button>
                            <a href="/admin/promos/delete/<?= $promo->id ?>" 
                                class="flex-1 bg-red-500 hover:bg-red-600 text-white py-2 px-3 rounded text-sm text-center"
                                onclick="return confirm('Hapus promo ini?')">
                                Hapus
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Modal Tambah/Edit Promo -->
            <div id="promoModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                <div class="bg-white rounded-lg p-6 w-full max-w-md">
                    <h3 id="modalTitle" class="text-lg font-semibold mb-4">Tambah Promo Baru</h3>
                    <form id="promoForm" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" id="promoId" name="id">
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Promo</label>
                                <input type="text" name="name" id="name" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kode Promo</label>
                                <input type="text" name="code" id="code" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 uppercase">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <textarea name="description" id="description"
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2"></textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tipe Diskon</label>
                                    <select name="discount_type" id="discount_type" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                                        <option value="percentage">Persentase</option>
                                        <option value="fixed">Nominal</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nilai Diskon</label>
                                    <input type="number" name="discount_value" id="discount_value" required step="0.01"
                                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Minimum Pembelian</label>
                                <input type="number" name="min_purchase" id="min_purchase" step="0.01"
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Maksimal Diskon (Opsional)</label>
                                <input type="number" name="max_discount" id="max_discount" step="0.01"
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Batas Penggunaan (Opsional)</label>
                                <input type="number" name="usage_limit" id="usage_limit"
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                                    <input type="datetime-local" name="start_date" id="start_date" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Berakhir</label>
                                    <input type="datetime-local" name="end_date" id="end_date" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                                </div>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" class="mr-2">
                                <label class="text-sm font-medium text-gray-700">Aktif</label>
                            </div>
                        </div>

                        <div class="flex space-x-3 mt-6">
                            <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-2 rounded">
                                Simpan
                            </button>
                            <button type="button" onclick="closeModal()" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-2 rounded">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        function openModal() {
            document.getElementById('promoModal').classList.remove('hidden');
            document.getElementById('promoModal').classList.add('flex');
            document.getElementById('promoForm').action = '/admin/promos/add';
            document.getElementById('modalTitle').textContent = 'Tambah Promo Baru';
            document.getElementById('promoForm').reset();
            document.getElementById('promoId').value = '';
        }

        function editPromo(promo) {
            openModal();
            document.getElementById('promoForm').action = '/admin/promos/edit/' + promo.id;
            document.getElementById('modalTitle').textContent = 'Edit Promo';
            
            // Fill form data
            document.getElementById('promoId').value = promo.id;
            document.getElementById('name').value = promo.name;
            document.getElementById('code').value = promo.code;
            document.getElementById('description').value = promo.description || '';
            document.getElementById('discount_type').value = promo.discount_type;
            document.getElementById('discount_value').value = promo.discount_value;
            document.getElementById('min_purchase').value = promo.min_purchase || '';
            document.getElementById('max_discount').value = promo.max_discount || '';
            document.getElementById('usage_limit').value = promo.usage_limit || '';
            document.getElementById('start_date').value = promo.start_date.replace(' ', 'T');
            document.getElementById('end_date').value = promo.end_date.replace(' ', 'T');
            document.getElementById('is_active').checked = promo.is_active == 1;
        }

        function closeModal() {
            document.getElementById('promoModal').classList.add('hidden');
            document.getElementById('promoModal').classList.remove('flex');
        }
    </script>
</body>
</html>