<?= $this->extend('main_layout') ?>

<?= $this->section('content') ?>

<div class="py-8 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto space-y-8 animate-fade-in">

        <!-- Header Section -->
        <div>
            <h1 class="text-4xl font-bold text-gray-900 tracking-tight">
                Checkout
            </h1>
            <a href="<?= base_url('cart') ?>"
               class="inline-flex items-center mt-2 text-base text-gray-600 hover:text-gray-900 hover:underline transition-colors duration-200">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Keranjang
            </a>
        </div>

        <!-- Notification Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-6 py-4 shadow-sm animate-slide-down max-w-4xl mx-auto" role="alert">
                <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-6 py-4 shadow-sm animate-slide-down max-w-4xl mx-auto" role="alert">
                <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
            </div>
        <?php endif; ?>

        <!-- Dynamic notification area for AJAX operations -->
        <div id="notification-area" class="max-w-4xl mx-auto"></div>

        <form action="<?= base_url('checkout/place-order') ?>" method="post">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- Left Column - Address & Shipping -->
                <div class="space-y-6">

                    <!-- Address Selection -->
                    <div class="bg-white p-6 shadow-lg border border-gray-200">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold text-gray-900">Pilih Alamat Pengiriman</h3>
                            <a href="<?= base_url('profile/addresses/new') ?>"
                               class="inline-flex items-center px-3 py-1.5 border border-blue-300 text-sm font-medium text-blue-700 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah Alamat
                            </a>
                        </div>

                        <div class="space-y-3">
                            <?php foreach ($addresses as $index => $address): ?>
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                                    <div class="flex items-start">
                                        <input class="mt-1 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2"
                                               type="radio"
                                               name="user_address_id"
                                               id="address-<?= $address['id'] ?>"
                                               value="<?= $address['id'] ?>"
                                               <?= $address['is_default'] == 1 ? 'checked' : '' ?>
                                               data-city-name="<?= esc($address['city_name']) ?>" required>

                                        <label class="ml-3 flex-1 cursor-pointer" for="address-<?= $address['id'] ?>">
                                            <div class="flex justify-between items-start mb-2">
                                                <span class="font-bold text-gray-900 text-lg"><?= esc($address['label']) ?></span>
                                                <?php if ($address['is_default'] == 1): ?>
                                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">Utama</span>
                                                <?php endif; ?>
                                            </div>
                                            <p class="font-semibold text-gray-900 mb-1"><?= esc($address['recipient_name']) ?></p>
                                            <p class="text-gray-600 mb-1"><?= esc($address['recipient_phone']) ?></p>
                                            <p class="text-gray-600 text-sm leading-relaxed">
                                                <?= esc($address['street_address']) ?><br>
                                                <?= esc($address['subdistrict_name']) ?>, <?= esc($address['city_name']) ?><br>
                                                <?= esc($address['province_name']) ?>, <?= esc($address['postal_code']) ?>
                                            </p>
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Shipping Selection -->
                    <div class="bg-white p-6 shadow-lg border border-gray-200">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Pilih Pengiriman</h3>

                        <div class="space-y-4">
                            <div>
                                <label for="select_courier" class="block text-sm font-medium text-gray-700 mb-2">Kurir</label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        id="select_courier" required>
                                    <option value="">Pilih Kurir...</option>
                                    <option value="jne">JNE</option>
                                    <option value="tiki">TIKI</option>
                                    <option value="pos">POS Indonesia</option>
                                </select>
                            </div>

                            <div>
                                <label for="select_service" class="block text-sm font-medium text-gray-700 mb-2">Layanan</label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 disabled:bg-gray-100"
                                        id="select_service" name="shipping_service" required disabled>
                                    <option value="">Pilih Layanan...</option>
                                </select>
                                <input type="hidden" name="shipping_service_name" id="input_shipping_service_name">
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method Selection -->
                    <div class="bg-white p-6 shadow-lg border border-gray-200">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Metode Pembayaran</h3>

                        <div class="space-y-3">
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                                <div class="flex items-center">
                                    <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2"
                                           type="radio" name="payment_method" id="pay_bca" value="bca_manual" checked required>
                                    <label class="ml-3 font-semibold text-gray-900 cursor-pointer" for="pay_bca">
                                        Bank Transfer BCA (Manual)
                                    </label>
                                </div>
                            </div>

                            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                                <div class="flex items-center">
                                    <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2"
                                           type="radio" name="payment_method" id="pay_mandiri" value="mandiri_manual" required>
                                    <label class="ml-3 font-semibold text-gray-900 cursor-pointer" for="pay_mandiri">
                                        Bank Transfer Mandiri (Manual)
                                    </label>
                                </div>
                            </div>

                            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                                <div class="flex items-center">
                                    <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2"
                                           type="radio" name="payment_method" id="pay_qris" value="qris_manual" required>
                                    <label class="ml-3 font-semibold text-gray-900 cursor-pointer" for="pay_qris">
                                        QRIS (Gopay, OVO, DANA, ShopeePay)
                                    </label>
                                </div>
                                <div id="qris-image-container" class="mt-3 hidden">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column - Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 shadow-lg border border-gray-200 sticky top-6">

                        <h3 class="text-xl font-bold text-gray-900 mb-6">Ringkasan Pesanan</h3>

                        <!-- Cart Items -->
                        <div class="space-y-4 mb-6">
                            <?php foreach ($cartItems as $item): ?>
                                <div class="flex items-center space-x-3">
                                    <img src="<?= base_url('uploads/products/' . $item['image_url']) ?>"
                                         class="w-16 h-16 object-cover rounded-md border border-gray-200" alt="<?= esc($item['name']) ?>">
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-gray-900 truncate text-sm"><?= esc($item['name']) ?></p>
                                        <p class="text-gray-600 text-sm">
                                            <?= $item['quantity'] ?> x Rp <?= number_format($item['price'], 0, ',', '.') ?>
                                        </p>
                                    </div>
                                    <span class="font-bold text-gray-900 text-sm">
                                        Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <hr class="border-gray-200 mb-6">

                        <!-- Promo Code -->
                        <div class="mb-6">
                            <label for="promo_code" class="block text-sm font-medium text-gray-700 mb-2">Kode Promo</label>
                            <div class="flex space-x-2">
                                <input type="text"
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       id="promo_code" name="promo_code" placeholder="Masukkan kode promo">
                                <button class="px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                                        type="button" id="apply-promo-btn">
                                    Gunakan
                                </button>
                            </div>
                            <div id="promo-message" class="mt-2"></div>
                        </div>

                        <hr class="border-gray-200 mb-4">

                        <!-- Price Breakdown -->
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span class="font-semibold">Rp <?= number_format($total, 0, ',', '.') ?></span>
                            </div>

                            <div class="flex justify-between text-red-600">
                                <span>Diskon</span>
                                <span class="font-semibold" id="discount-display">- Rp 0</span>
                            </div>

                            <div class="flex justify-between text-gray-600">
                                <span>Biaya Pengiriman</span>
                                <span class="font-semibold" id="shipping-cost-display">Rp 0</span>
                            </div>

                            <div class="flex justify-between text-gray-600">
                                <span>Kode Unik</span>
                                <span class="font-semibold" id="unique-code-display">Rp 0</span>
                            </div>

                            <hr class="border-gray-200">

                            <div class="flex justify-between text-lg font-bold text-gray-900">
                                <span>Total Bayar</span>
                                <span id="total-bayar-display">Rp <?= number_format($total, 0, ',', '.') ?></span>
                            </div>
                        </div>

                        <!-- Hidden Inputs -->
                        <input type="hidden" name="unique_code" id="input_unique_code" value="0">
                        <input type="hidden" name="shipping_cost" id="input_shipping_cost" value="0">
                        <input type="hidden" name="discount_amount" id="input_discount_amount" value="0">
                        <input type="hidden" name="subtotal" id="input_subtotal" value="<?= $total ?>">
                        <input type="hidden" name="total_amount" id="input_total_amount" value="<?= $total ?>">

                        <input type="hidden" name="selected_province_name" id="input_selected_province_name" value="">
                        <input type="hidden" name="selected_city_name" id="input_selected_city_name" value="">
                        <input type="hidden" name="selected_subdistrict_name" id="input_selected_subdistrict_name" value="">

                        <!-- Submit Button -->
                        <button type="submit"
                                class="w-full bg-black text-white py-3 px-4 text-lg font-semibold hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-lg">
                            Buat Pesanan
                        </button>

                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

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
                promoMessage.innerHTML = '<small class="text-red-600">Masukkan kode promo.</small>';
                return;
            }

            promoMessage.innerHTML = '<small class="text-gray-600">Mengecek kode...</small>';
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
                    promoMessage.innerHTML = `<small class="text-green-600">${result.message}</small>`;
                    promoInput.disabled = true;
                } else {
                    currentDiscount = 0;
                    promoMessage.innerHTML = `<small class="text-red-600">${result.message}</small>`;
                    promoBtn.disabled = false;
                }

                updateTotals();

            } catch (error) {
                console.error('Error applying promo:', error);
                promoMessage.innerHTML = '<small class="text-red-600">Gagal terhubung ke server.</small>';
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
                    <img src="${result.qr_image_base64}" alt="Scan QRIS" class="w-full max-w-xs mx-auto rounded-md border border-gray-200">
                `;
                } else {
                    throw new Error('Data QRIS tidak diterima');
                }

            } catch (error) {
                console.error('Error fetching QRIS:', error);
                qrisImageContainer.innerHTML = '<p class="text-red-600">Gagal memuat QR Code. Coba lagi.</p>';
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