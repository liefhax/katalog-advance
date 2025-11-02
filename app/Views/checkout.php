<?= $this->extend('main_layout') ?>

<?= $this->section('content') ?>

<main class="container-xl my-5 mx-auto">
    <h1 class="mb-4 fw-bold">Checkout</h1>

    <form action="<?= base_url('checkout/place-order') ?>" method="post">
        <?= csrf_field() ?>

        <div class="row g-5">

            <div class="col-lg-7">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4 p-md-5">

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold mb-0">Pilih Alamat Pengiriman</h4>
                            <a href="<?= base_url('profile/addresses/new') ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-plus-lg"></i> Tambah Alamat
                            </a>
                        </div>

                        <?php foreach ($addresses as $index => $address): ?>
                            <div class="form-check border rounded-3 p-4 mb-3">
                                <input class="form-check-input" type="radio"
                                       name="user_address_id"
                                       id="address-<?= $address['id'] ?>"
                                       value="<?= $address['id'] ?>"
                                       <?= $address['is_default'] == 1 ? 'checked' : '' ?>
                                       data-city-name="<?= esc($address['city_name']) ?>" required>
                                
                                <label class="form-check-label w-100" 
                                       for="address-<?= $address['id'] ?>" 
                                       style="cursor: pointer;"
                                       data-province-name="<?= esc($address['province_name']) ?>"
                                       data-city-name="<?= esc($address['city_name']) ?>"
                                       data-subdistrict-name="<?= esc($address['subdistrict_name']) ?>"
                                >
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-bold fs-5"><?= esc($address['label']) ?></span>
                                        <?php if ($address['is_default'] == 1): ?>
                                            <span class="badge bg-primary">Utama</span>
                                        <?php endif; ?>
                                    </div>
                                    <p class="fw-bold mb-1 mt-1"><?= esc($address['recipient_name']) ?></p>
                                    <p class="text-muted mb-1"><?= esc($address['recipient_phone']) ?></p>
                                    <p class="text-muted mb-0" style="line-height: 1.6;">
                                        <?= esc($address['street_address']) ?><br>
                                        <?= esc($address['subdistrict_name']) ?>, <?= esc($address['city_name']) ?><br>
                                        <?= esc($address['province_name']) ?>, <?= esc($address['postal_code']) ?>
                                    </p>
                                </label>
                            </div>
                        <?php endforeach; ?>


                        <hr class="my-4">
                        <h4 class="fw-bold mb-4">Pilih Pengiriman</h4>

                        <div class="mb-3">
                            <label for="select_courier" class="form-label">Kurir</label>
                            <select class="form-select" id="select_courier" required>
                                <option value="">Pilih Kurir...</option>
                                <option value="jne">JNE</option>
                                <option value="tiki">TIKI</option>
                                <option value="pos">POS Indonesia</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="select_service" class="form-label">Layanan</label>
                            <select class="form-select" id="select_service" name="shipping_service" required disabled>
                                <option value="">Pilih Layanan...</option>
                            </select>
                            <input type="hidden" name="shipping_service_name" id="input_shipping_service_name">
                        </div>


                        <div class="form-check border rounded-3 p-4 mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" id="pay_bca" value="bca_manual" checked required>
                            <label class="form-check-label w-100 fw-bold" for="pay_bca">
                                Bank Transfer BCA (Manual)
                            </label>
                        </div>

                        <div class="form-check border rounded-3 p-4 mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" id="pay_mandiri" value="mandiri_manual" required>
                            <label class="form-check-label w-100 fw-bold" for="pay_mandiri">
                                Bank Transfer Mandiri (Manual)
                            </label>
                        </div>

                        <div class="form-check border rounded-3 p-4 mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" id="pay_qris" value="qris_manual" required>
                            <label class="form-check-label w-100 fw-bold" for="pay_qris">
                                QRIS (Gopay, OVO, DANA, ShopeePay)
                            </label>

                            <div id="qris-image-container" class="mt-3" style="display: none;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card shadow-sm border-0 rounded-4 sticky-top" style="top: 2rem;">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-4">Ringkasan Pesanan</h4>

                        <?php foreach ($cartItems as $item): ?>
                            <div class="d-flex align-items-center mb-3">
                                <img src="<?= base_url('uploads/products/' . $item['image_url']) ?>" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                <div class="ms-3 flex-grow-1">
                                    <p class="fw-bold mb-0 text-truncate"><?= esc($item['name']) ?></p>
                                    <small class="text-muted"><?= $item['quantity'] ?> x Rp <?= number_format($item['price'], 0, ',', '.') ?></small>
                                </div>
                                <span class="fw-bold ms-3">Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></span>
                            </div>
                        <?php endforeach; ?>

                        <hr>

                        <label for="promo_code" class="form-label">Kode Promo</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="promo_code" name="promo_code" placeholder="Masukkan kode promo">
                            <button class="btn btn-outline-secondary" type="button" id="apply-promo-btn">Gunakan</button>
                        </div>
                        <div id="promo-message" class="mb-3"></div>
                        <hr>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span class="fw-bold">Rp <?= number_format($total, 0, ',', '.') ?></span>
                        </div>

                        <div class="d-flex justify-content-between mb-2 text-danger">
                            <span>Diskon</span>
                            <span class="fw-bold" id="discount-display">- Rp 0</span>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span>Biaya Pengiriman</span>
                            <span class="fw-bold" id="shipping-cost-display">Rp 0</span>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span>Kode Unik</span>
                            <span class="fw-bold" id="unique-code-display">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total Bayar</span>
                            <span id="total-bayar-display">Rp <?= number_format($total, 0, ',', '.') ?></span>
                        </div>

                        <input type="hidden" name="unique_code" id="input_unique_code" value="0">
                        <input type="hidden" name="shipping_cost" id="input_shipping_cost" value="0">
                        <input type="hidden" name="discount_amount" id="input_discount_amount" value="0">
                        <input type="hidden" name="subtotal" id="input_subtotal" value="<?= $total ?>">
                        <input type="hidden" name="total_amount" id="input_total_amount" value="<?= $total ?>">
                        
                        <input type="hidden" name="selected_province_name" id="input_selected_province_name" value="">
                        <input type="hidden" name="selected_city_name" id="input_selected_city_name" value="">
                        <input type="hidden" name="selected_subdistrict_name" id="input_selected_subdistrict_name" value="">


                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Buat Pesanan
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </form>
</main>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Ambil Elemen ---
        const courierSelect = document.getElementById('select_courier');
        const serviceSelect = document.getElementById('select_service');

        // Elemen Tampilan Total
        const shippingCostDisplay = document.getElementById('shipping-cost-display');
        const discountDisplay = document.getElementById('discount-display');
        const uniqueCodeDisplay = document.getElementById('unique-code-display');
        const totalBayarDisplay = document.getElementById('total-bayar-display');

        // Elemen Input Hidden
        const inputShippingCost = document.getElementById('input_shipping_cost');
        const inputTotalAmount = document.getElementById('input_total_amount');
        const inputDiscountAmount = document.getElementById('input_discount_amount');
        const inputShippingServiceName = document.getElementById('input_shipping_service_name');
        const inputUniqueCode = document.getElementById('input_unique_code');

        // ===================================================================
        // MODIFIKASI 3: Ambil elemen 3 hidden input baru
        // ===================================================================
        const inputProvinceName = document.getElementById('input_selected_province_name');
        const inputCityName = document.getElementById('input_selected_city_name');
        const inputSubdistrictName = document.getElementById('input_selected_subdistrict_name');


        // Elemen Promo
        const promoBtn = document.getElementById('apply-promo-btn');
        const promoInput = document.getElementById('promo_code');
        const promoMessage = document.getElementById('promo-message');

        // Elemen Pembayaran
        const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
        const qrisImageContainer = document.getElementById('qris-image-container');

        // --- Nilai Awal ---
        const subtotal = <?= $total ?>;
        let selectedShippingCost = 0;
        let currentDiscount = 0;
        const uniqueCode = Math.floor(Math.random() * 900) + 100;

        inputUniqueCode.value = uniqueCode;

        // --- Fungsi Helper ---
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(angka);
        }

        // Fungsi untuk update total
        function updateTotals() {
            let newTotal = (subtotal - currentDiscount) + selectedShippingCost + uniqueCode;
            if (newTotal < 0) {
                newTotal = 0;
            }

            shippingCostDisplay.textContent = formatRupiah(selectedShippingCost);
            discountDisplay.textContent = `- ${formatRupiah(currentDiscount)}`;
            uniqueCodeDisplay.textContent = formatRupiah(uniqueCode);
            totalBayarDisplay.textContent = formatRupiah(newTotal);

            inputShippingCost.value = selectedShippingCost;
            inputDiscountAmount.value = currentDiscount;
            inputTotalAmount.value = newTotal;

            if (document.getElementById('pay_qris').checked) {
                fetchQrCode();
            }
        }

        // Fungsi untuk ambil ongkir (Tidak diubah)
        async function fetchShippingCost() {
            const courier = courierSelect.value;
            if (!courier) return;

            const checkedAddress = document.querySelector('input[name="user_address_id"]:checked');
            if (!checkedAddress) {
                alert('Pilih alamat pengiriman terlebih dahulu!');
                courierSelect.value = '';
                return;
            }

            // Ini ngambil 'data-city-name' dari <input> (bukan <label>)
            // Biarin aja, ini buat API ongkir, udah bener
            const cityName = checkedAddress.getAttribute('data-city-name');

            serviceSelect.innerHTML = '<option value="">Memuat layanan...</option>';
            serviceSelect.disabled = true;
            selectedShippingCost = 0;
            updateTotals();

            try {
                const formData = new FormData();
                formData.append('courier', courier);
                formData.append('city_name', cityName); // Kirim NAMAnya
                formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

                const response = await fetch('<?= base_url('/api/shipping/cost') ?>', {
                    method: 'POST',
                    body: formData
                });
                const services = await response.json();

                serviceSelect.innerHTML = '<option value="">Pilih Layanan...</option>';
                if (services.error) {
                    serviceSelect.innerHTML = `<option value="">${services.error}</option>`;
                } else if (services.length === 0) {
                    serviceSelect.innerHTML = `<option value="">Layanan tidak tersedia</option>`;
                } else {
                    services.forEach(service => {
                        const cost = service.cost[0].value;
                        const etd = service.cost[0].etd;
                        const serviceName = service.service;

                        serviceSelect.innerHTML += `<option value="${cost}" data-service-name="${serviceName}">${serviceName} (${formatRupiah(cost)}) - ${etd} hari</option>`;
                    });
                    serviceSelect.disabled = false;
                }

            } catch (error) {
                console.error('Error fetching shipping:', error);
                serviceSelect.innerHTML = '<option value="">Gagal memuat ongkir</option>';
            }
        }

        // Fungsi Apply Promo (Tidak diubah)
        async function applyPromo() {
            const code = promoInput.value;
            if (!code) {
                promoMessage.innerHTML = '<small class="text-danger">Masukkan kode promo.</small>';
                return;
            }

            promoMessage.innerHTML = '<small class="text-muted">Mengecek kode...</small>';
            promoBtn.disabled = true;

            try {
                const formData = new FormData();
                formData.append('promo_code', code);
                formData.append('subtotal', subtotal);
                formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

                const response = await fetch('<?= base_url('/api/promo/apply') ?>', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    currentDiscount = parseFloat(result.discount_amount);
                    promoMessage.innerHTML = `<small class="text-success">${result.message}</small>`;
                    promoInput.disabled = true;
                } else {
                    currentDiscount = 0;
                    promoMessage.innerHTML = `<small class="text-danger">${result.message}</small>`;
                    promoBtn.disabled = false;
                }

                updateTotals();

            } catch (error) {
                console.error('Error applying promo:', error);
                promoMessage.innerHTML = '<small class="text-danger">Gagal terhubung ke server.</small>';
                promoBtn.disabled = false;
            }
        }

        // Fungsi Generate QRIS (Tidak diubah)
        let isQrFetching = false;
        async function fetchQrCode() {
            if (isQrFetching) return; 

            isQrFetching = true;
            const total = inputTotalAmount.value; 
            qrisImageContainer.innerHTML = '<p class="text-muted">Memuat QR Code...</p>';
            qrisImageContainer.style.display = 'block';

            try {
                const formData = new FormData();
                formData.append('total_amount', total);
                formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

                const response = await fetch('<?= base_url('/api/qris/generate') ?>', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.qr_image_base64) {
                    qrisImageContainer.innerHTML = `
                    <p class="text-center mb-2">Scan dengan e-wallet kamu:</p>
                    <img src="${result.qr_image_base64}" alt="Scan QRIS" class="img-fluid rounded border" style="max-width: 250px; margin: 0 auto; display: block;">
                `;
                } else {
                    throw new Error('Data QRIS tidak diterima');
                }

            } catch (error) {
                console.error('Error fetching QRIS:', error);
                qrisImageContainer.innerHTML = '<p class="text-danger">Gagal memuat QR Code. Coba lagi.</p>';
            } finally {
                isQrFetching = false; 
            }
        }


        // --- PASANG EVENT LISTENER ---
        courierSelect.addEventListener('change', fetchShippingCost);

        const addressRadios = document.querySelectorAll('input[name="user_address_id"]');
        addressRadios.forEach(radio => {
            // ===================================================================
            // MODIFIKASI 4: Nambahin logic buat ngisi hidden input alamat
            // ===================================================================
            radio.addEventListener('change', () => {
                // Kode lama kamu (biarin aja, buat reset kurir)
                courierSelect.value = '';
                serviceSelect.innerHTML = '<option value="">Pilih Layanan...</option>';
                serviceSelect.disabled = true;
                selectedShippingCost = 0;
                updateTotals();

                // Kode BARU: Ambil data dari <label> yang sesuai
                const selectedLabel = document.querySelector('label[for="' + radio.id + '"]');
                if (selectedLabel) {
                    inputProvinceName.value = selectedLabel.dataset.provinceName;
                    inputCityName.value = selectedLabel.dataset.cityName;
                    inputSubdistrictName.value = selectedLabel.dataset.subdistrictName;
                }
            });
        });

        serviceSelect.addEventListener('change', function() {
            selectedShippingCost = parseInt(this.value) || 0;
            const selectedOption = this.options[this.selectedIndex];
            inputShippingServiceName.value = selectedOption.getAttribute('data-service-name');
            updateTotals();
        });

        promoBtn.addEventListener('click', applyPromo);

        paymentRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'qris_manual') {
                    fetchQrCode();
                } else {
                    qrisImageContainer.style.display = 'none'; 
                    qrisImageContainer.innerHTML = ''; 
                }
            });
        });

        // Panggil updateTotals() sekali di awal
        updateTotals();
        
        // ===================================================================
        // MODIFIKASI 5: Trigger 'change' buat alamat yg 'checked'
        // ===================================================================
        // Ini buat mastiin hidden input alamat keisi pas halaman baru di-load
        const defaultCheckedRadio = document.querySelector('input[name="user_address_id"]:checked');
        if (defaultCheckedRadio) {
            defaultCheckedRadio.dispatchEvent(new Event('change'));
        }
    });
</script>
<?= $this->endSection() ?>