<!-- Menggunakan kerangka utama -->
<?= $this->extend('main_layout') ?>

<!-- Mendefinisikan isi konten untuk bagian 'content' -->
<?= $this->section('content') ?>

<div class="py-8 px-4">
    <div class="max-w-7xl mx-auto space-y-8 animate-fade-in">

        <!-- Header Section -->
        <div>
            <h1 class="text-4xl font-bold text-gray-900 tracking-tight">
                Tambah Alamat Baru
            </h1>
            <a href="<?= base_url('profile/addresses') ?>"
               class="inline-flex items-center mt-2 text-base text-gray-600 hover:text-gray-900 hover:underline transition-colors duration-200">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar Alamat
            </a>
        </div>

        <!-- Notification Messages -->
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-6 py-4 shadow-sm animate-slide-down" role="alert">
                <ul class="list-disc list-inside">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Address Form -->
        <div class="bg-white shadow-sm border-t-4 border-black overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Informasi Alamat</h2>
            </div>

            <form action="<?= base_url('profile/addresses/store') ?>" method="post" class="p-6 space-y-6">
                <?= csrf_field() ?>

                <!-- Label -->
                <div>
                    <label for="label" class="block text-sm font-medium text-gray-700 mb-2">
                        Label Alamat <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="label"
                           name="label"
                           value="<?= old('label') ?>"
                           class="w-full px-3 py-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                           placeholder="Contoh: Rumah, Kantor, Kos"
                           required>
                    <p class="mt-1 text-sm text-gray-500">Beri nama alamat ini untuk memudahkan identifikasi</p>
                </div>

                <!-- Recipient Name -->
                <div>
                    <label for="recipient_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Penerima <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="recipient_name"
                           name="recipient_name"
                           value="<?= old('recipient_name') ?>"
                           class="w-full px-3 py-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                           placeholder="Masukkan nama lengkap penerima"
                           required>
                </div>

                <!-- Recipient Phone -->
                <div>
                    <label for="recipient_phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Telepon <span class="text-red-500">*</span>
                    </label>
                    <input type="tel"
                           id="recipient_phone"
                           name="recipient_phone"
                           value="<?= old('recipient_phone') ?>"
                           class="w-full px-3 py-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                           placeholder="Contoh: 081234567890"
                           required>
                </div>

                <!-- Street Address -->
                <div>
                    <label for="street_address" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea id="street_address"
                              name="street_address"
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                              placeholder="Masukkan alamat lengkap beserta patokan"
                              required><?= old('street_address') ?></textarea>
                </div>

                <!-- Province, City, Subdistrict -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="province" class="block text-sm font-medium text-gray-700 mb-2">
                            Provinsi <span class="text-red-500">*</span>
                        </label>
                        <select id="province"
                                class="w-full px-3 py-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                required>
                            <option value="">Pilih Provinsi...</option>
                        </select>
                        <input type="hidden" name="province_kode" id="province_kode">
                        <input type="hidden" name="province_name" id="province_name">
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                            Kota/Kabupaten <span class="text-red-500">*</span>
                        </label>
                        <select id="city"
                                class="w-full px-3 py-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                required disabled>
                            <option value="">Pilih Kota/Kabupaten...</option>
                        </select>
                        <input type="hidden" name="city_kode" id="city_kode">
                        <input type="hidden" name="city_name" id="city_name">
                    </div>

                    <div>
                        <label for="subdistrict" class="block text-sm font-medium text-gray-700 mb-2">
                            Kecamatan <span class="text-red-500">*</span>
                        </label>
                        <select id="subdistrict"
                                class="w-full px-3 py-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                required disabled>
                            <option value="">Pilih Kecamatan...</option>
                        </select>
                        <input type="hidden" name="subdistrict_kode" id="subdistrict_kode">
                        <input type="hidden" name="subdistrict_name" id="subdistrict_name">
                    </div>
                </div>

                <!-- Postal Code -->
                <div>
                    <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">
                        Kode Pos <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="postal_code"
                           name="postal_code"
                           value="<?= old('postal_code') ?>"
                           class="w-full px-3 py-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                           placeholder="Contoh: 12345"
                           required>
                </div>

                <!-- Set as Default -->
                <div class="flex items-center">
                    <input type="checkbox"
                           id="is_default"
                           name="is_default"
                           value="1"
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_default" class="ml-2 block text-sm text-gray-700">
                        Jadikan alamat utama
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4">
                    <a href="<?= base_url('profile/addresses') ?>"
                       class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-colors duration-200">
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium text-white bg-black hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Alamat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- RajaOngkir API Integration -->
<script>
document.addEventListener('DOMContentLoaded', async function() {
    const baseUrl = '<?= base_url() ?>';
    const provinceSelect = document.getElementById('province');
    const citySelect = document.getElementById('city');
    const subdistrictSelect = document.getElementById('subdistrict');
    const provinceInput = document.getElementById('province_kode');
    const cityInput = document.getElementById('city_kode');
    const subdistrictInput = document.getElementById('subdistrict_kode');

    // 🚀 1. Load provinsi saat halaman dibuka
    try {
        const res = await fetch(`${baseUrl}/api/wilayah/provinces`);
        const provinces = await res.json();

        provinceSelect.innerHTML = '<option value="">Pilih Provinsi...</option>';
        provinces.forEach(prov => {
            provinceSelect.innerHTML += `<option value="${prov.nama}" data-id="${prov.kode}">${prov.nama}</option>`;
        });
    } catch (e) {
        console.error('Gagal load provinsi:', e);
        provinceSelect.innerHTML = '<option value="">Gagal memuat provinsi</option>';
    }

    // 🏙️ 2. Saat pilih provinsi → ambil kota
    provinceSelect.addEventListener('change', async function () {
        const selectedOption = this.options[this.selectedIndex];
        const provinceCode = selectedOption.dataset.id;
        const provinceName = selectedOption.value;

        provinceInput.value = provinceCode;
        document.getElementById('province_name').value = provinceName;

        citySelect.innerHTML = '<option value="">Memuat...</option>';
        citySelect.disabled = true;
        subdistrictSelect.innerHTML = '<option value="">Pilih Kecamatan...</option>';
        subdistrictSelect.disabled = true;

        try {
            const res = await fetch(`${baseUrl}/api/wilayah/cities/${provinceCode}`);
            const cities = await res.json();

            citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten...</option>';
            cities.forEach(city => {
                citySelect.innerHTML += `<option value="${city.nama}" data-id="${city.kode}">${city.nama}</option>`;
            });
            citySelect.disabled = false;
        } catch (e) {
            console.error('Gagal load kota:', e);
            citySelect.innerHTML = '<option value="">Gagal memuat kota</option>';
        }
    });

    // 🏘️ 3. Saat pilih kota → ambil kecamatan
    citySelect.addEventListener('change', async function () {
        const selectedOption = this.options[this.selectedIndex];
        const cityCode = selectedOption.dataset.id;
        const cityName = selectedOption.value;

        cityInput.value = cityCode;
        document.getElementById('city_name').value = cityName;

        subdistrictSelect.innerHTML = '<option value="">Memuat...</option>';
        subdistrictSelect.disabled = true;

        try {
            const res = await fetch(`${baseUrl}/api/wilayah/districts/${cityCode}`);
            const districts = await res.json();

            subdistrictSelect.innerHTML = '<option value="">Pilih Kecamatan...</option>';
            districts.forEach(d => {
                subdistrictSelect.innerHTML += `<option value="${d.nama}" data-id="${d.kode}">${d.nama}</option>`;
            });
            subdistrictSelect.disabled = false;
        } catch (e) {
            console.error('Gagal load kecamatan:', e);
            subdistrictSelect.innerHTML = '<option value="">Gagal memuat kecamatan</option>';
        }
    });

    // 🗺️ 4. Simpan kode kecamatan terpilih
    subdistrictSelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const subdistrictCode = selectedOption.dataset.id;
        const subdistrictName = selectedOption.value;

        subdistrictInput.value = subdistrictCode;
        document.getElementById('subdistrict_name').value = subdistrictName;
    });
});
</script>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slide-down {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fade-in 0.6s ease-out;
}

.animate-slide-down {
    animation: slide-down 0.4s ease-out;
}
</style>

<?= $this->endSection() ?>