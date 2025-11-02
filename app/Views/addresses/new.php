<?= $this->extend('main_layout') ?>
<?= $this->section('content') ?>

<main class="container-xl my-5 mx-auto" style="max-width: 700px;">
    <h1 class="mb-4 fw-bold"><?= esc($title) ?></h1>

    <?php if (session()->has('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h5 class="alert-heading">Gagal Menyimpan!</h5>
            <ul class="mb-0">
                <?php foreach (session('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4 p-md-5">
            <form action="<?= base_url('profile/addresses/create') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="label" class="form-label">Label Alamat</label>
                    <input type="text" class="form-control" id="label" name="label" value="<?= old('label') ?>" placeholder="Contoh: Rumah, Kantor" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="recipient_name" class="form-label">Nama Penerima</label>
                        <input type="text" class="form-control" id="recipient_name" name="recipient_name" value="<?= old('recipient_name') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="recipient_phone" class="form-label">No. Telepon</label>
                        <input type="tel" class="form-control" id="recipient_phone" name="recipient_phone" value="<?= old('recipient_phone') ?>" placeholder="Contoh: 0812..." required>
                    </div>
                </div>

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label for="select_province" class="form-label">Provinsi</label>
        <select class="form-select" id="select_province" required>
            <option value="" selected disabled>Pilih Provinsi...</option>
        </select>
        <input type="hidden" name="province_kode" id="input_province">
    </div>
    <div class="col-md-6">
        <label for="select_city" class="form-label">Kota / Kabupaten</label>
        <select class="form-select" id="select_city" required disabled>
            <option value="">Pilih Kota/Kabupaten...</option>
        </select>
        <input type="hidden" name="city_kode" id="input_city_code">
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label for="select_subdistrict" class="form-label">Kecamatan</label>
        <select class="form-select" id="select_subdistrict" required disabled>
            <option value="">Pilih Kecamatan...</option>
        </select>
        <input type="hidden" name="subdistrict_kode" id="input_subdistrict_kode">
    </div>
    <div class="col-md-6">
        <label for="postal_code" class="form-label">Kode Pos</label>
        <input type="text" class="form-control" id="postal_code" name="postal_code" required>
    </div>
</div>

                <div class="mb-3">
                    <label for="street_address" class="form-label">Alamat Jalan</label>
                    <textarea class="form-control" id="street_address" name="street_address" rows="3" placeholder="Nama jalan, No. rumah, RT/RW, Patokan" required><?= old('street_address') ?></textarea>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="is_default" name="is_default" value="1">
                    <label class="form-check-label" for="is_default">Jadikan Alamat Utama</label>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">Simpan Alamat</button>
                    <a href="<?= base_url('profile/addresses') ?>" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', async function () {
    const baseUrl = '<?= base_url() ?>';
    const provinceSelect = document.getElementById('select_province');
    const citySelect = document.getElementById('select_city');
    const subdistrictSelect = document.getElementById('select_subdistrict');
    const provinceInput = document.getElementById('input_province');
    const cityInput = document.getElementById('input_city_code');
    const subdistrictInput = document.getElementById('input_subdistrict_kode');

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
        provinceInput.value = provinceCode;

        citySelect.innerHTML = '<option value="">Memuat...</option>';
        citySelect.disabled = true;

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
        cityInput.value = cityCode;

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
        subdistrictInput.value = selectedOption.dataset.id;
    });
});
</script>
<?= $this->endSection() ?>