<!-- Menggunakan kerangka utama -->
<?= $this->extend('main_layout') ?>

<!-- Mendefinisikan isi konten untuk bagian 'content' -->
<?= $this->section('content') ?>

<div class="py-8 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto space-y-8 animate-fade-in">

        <!-- Header Section -->
        <div>
            <h1 class="text-4xl font-bold text-gray-900 tracking-tight">
                Keranjang Belanja Anda
            </h1>
            <a href="<?= base_url('/') ?>"
               class="inline-flex items-center mt-2 text-base text-gray-600 hover:text-gray-900 hover:underline transition-colors duration-200">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Continue Shopping
            </a>
        </div>

        <!-- Notification Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-6 py-4 shadow-sm animate-slide-down max-w-4xl mx-auto" role="alert">
                <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
            </div>
        <?php endif; ?>

        <!-- Dynamic notification area for AJAX operations -->
        <div id="notification-area" class="max-w-4xl mx-auto"></div>

        <?php if (empty($cartItems)): ?>

            <!-- Empty Cart State -->
            <div class="max-w-2xl mx-auto">
                <div class="bg-white p-12 shadow-lg border-t-4 border-black text-center">
                    <div class="inline-block p-6 bg-gray-100 mb-6">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5H19M7 13l-1.1 5M7 13h10m0 0v8a2 2 0 01-2 2H9a2 2 0 01-2-2v-8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">
                        Keranjang Anda Masih Kosong
                    </h3>
                    <p class="text-gray-600 mb-8">
                        Yuk, cari produk keren dan tambahkan ke sini!
                    </p>
                    <a href="<?= base_url('/') ?>"
                       class="inline-flex items-center px-8 py-3 border border-transparent text-base font-semibold text-white bg-black hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Mulai Belanja
                    </a>
                </div>
            </div>

        <?php else: ?>

            <!-- Cart Items and Summary -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-4">
                    <!-- Select All Header -->
                    <div class="bg-white border border-gray-200 p-4 shadow-sm" style="pointer-events: auto;">
                        <div class="flex items-center justify-between" style="pointer-events: auto;">
                            <div class="flex items-center">
                                <input type="checkbox" id="select-all" class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" checked>
                                <label for="select-all" class="ml-3 text-sm font-medium text-gray-900 cursor-pointer">Pilih Semua</label>
                            </div>
                            <button id="remove-selected" class="inline-flex items-center px-3 py-1.5 border border-red-300 text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200" style="pointer-events: auto; cursor: pointer; z-index: 10;">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus Terpilih
                            </button>
                        </div>
                    </div>

                    <?php foreach ($cartItems as $item): ?>
                        <!-- Cart Item Card -->
                        <div class="bg-white border border-gray-200 p-4 shadow-sm" data-cart-item-id="<?= $item['cart_item_id'] ?>">
                            <div class="flex flex-row gap-4">
                                <!-- Checkbox Column -->
                                <div class="flex flex-row items-start">
                                    <input type="checkbox"
                                           class="item-checkbox w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2 mt-1"
                                           data-cart-item-id="<?= $item['cart_item_id'] ?>"
                                           checked>
                                </div>

                                <!-- Content Column -->
                                <div class="flex-1 flex flex-col gap-3">
                                    <!-- Product Info Row -->
                                    <div class="flex flex-row items-start gap-4">
                                        <!-- Product Image -->
                                        <img src="<?= base_url('uploads/products/' . $item['image_url']) ?>"
                                             alt="<?= esc($item['name']) ?>"
                                             class="w-16 h-16 object-cover">

                                        <!-- Product Name -->
                                        <div class="flex-1">
                                            <h3 class="text-lg font-medium text-gray-900">
                                                <?= esc($item['name']) ?>
                                            </h3>
                                        </div>

                                        <!-- Product Price -->
                                        <div class="text-sm font-bold text-gray-900 unit-price">
                                            Rp <?= number_format($item['price'], 0, ',', '.') ?>
                                        </div>
                                    </div>

                                    <!-- Actions Row -->
                                    <div class="flex flex-row items-center justify-end gap-3">
                                        <!-- Trash Icon -->
                                        <button class="remove-item text-gray-400 hover:text-red-500 transition-colors p-2" data-cart-item-id="<?= $item['cart_item_id'] ?>" title="Remove Item">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>

                                        <!-- Quantity Controller -->
                                        <div class="flex items-center border border-gray-300">
                                            <button class="quantity-decrease px-2 py-1 text-gray-600 hover:bg-gray-100" data-cart-item-id="<?= $item['cart_item_id'] ?>">-</button>
                                            <input type="number"
                                                   value="<?= $item['quantity'] ?>"
                                                   min="1"
                                                   class="quantity-input w-12 text-center border-0 focus:outline-none"
                                                   readonly>
                                            <button class="quantity-increase px-2 py-1 text-gray-600 hover:bg-gray-100" data-cart-item-id="<?= $item['cart_item_id'] ?>">+</button>
                                        </div>

                                        <!-- Total Price -->
                                        <div class="text-right">
                                            <span class="item-total text-lg font-bold text-gray-900">
                                                Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white shadow-lg border-t-4 border-black p-6 sticky top-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">
                            Ringkasan Belanja
                        </h2>

                            <div class="border-t border-gray-200 pt-4">
                                <!-- Voucher Section -->
                                <div class="mb-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-3">Kode Voucher</h3>
                                    <div class="flex space-x-2">
                                        <input type="text" id="voucher-code"
                                               class="flex-1 px-3 py-2 border border-gray-300 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                               placeholder="Masukkan kode voucher">
                                        <button type="button" id="apply-voucher"
                                                class="px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                            Terapkan
                                        </button>
                                    </div>
                                    <div id="voucher-message" class="mt-2 text-sm"></div>
                                </div>

                                <div class="flex justify-between items-center mb-6">
                                    <span class="text-lg text-gray-700">Total</span>
                                    <span id="total-amount" class="text-3xl font-bold text-gray-900">
                                        Rp <?= number_format($total, 0, ',', '.') ?>
                                    </span>
                                </div>

                                <a href="<?= base_url('checkout') ?>"
                                   class="w-full flex justify-center items-center px-6 py-4 border border-transparent text-base font-semibold text-white bg-black hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-lg">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    Lanjut ke Checkout
                                </a>
                            </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Recommended Products Section -->
<?php if (!empty($relatedProducts)): ?>
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4  ">
        <div class="text-left mb-12">
            <h2 class="text-4xl font-bold text-gray-900 tracking-tight mb-4">Produk Terkait</h2>
            <p class="text-lg text-gray-600">Produk lain yang mungkin Anda suka berdasarkan item di keranjang Anda</p>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <?php foreach ($relatedProducts as $product): ?>
            <div class="bg-white border border-gray-300 group">
                <a href="<?= base_url('product/' . $product['slug']) ?>">
                    <img src="<?= base_url('uploads/products/' . $product['image_url']) ?>" class="w-full aspect-square object-cover transition-transform duration-300 group-hover:-translate-y-1" alt="<?= esc($product['name']) ?>">
                </a>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">
                        <a href="<?= base_url('product/' . $product['slug']) ?>" class="text-black hover:text-gray-600 transition-colors">
                            <?= esc($product['name']) ?>
                        </a>
                    </h3>
                    <p class="text-sm text-gray-600 mb-3">SKU: <?= esc($product['id'] ?? 'N/A') ?></p>
                    <p class="text-xl font-semibold text-black">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- View All Products Button -->
        <div class="text-center">
            <a href="<?= base_url('products') ?>" class="inline-block bg-black text-white px-8 py-3 text-sm font-medium hover:bg-white hover:text-black hover:border hover:border-black transition-colors">
                Lihat Semua Produk
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

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

<script>

let originalTotal = 0;
let appliedDiscount = 0;

function removeSelectedItems() {
    console.log('removeSelectedItems function called');
    const selectedCheckboxes = document.querySelectorAll('.item-checkbox:checked');
    console.log('Found selected checkboxes:', selectedCheckboxes.length);
    console.log('Selected checkboxes elements:', selectedCheckboxes);
    
    if (selectedCheckboxes.length === 0) {
        console.log('No checkboxes selected, returning early');
        return;
    }
    
    const promises = [];
    console.log('Creating promises for', selectedCheckboxes.length, 'items');

    selectedCheckboxes.forEach(checkbox => {
        const cartItemId = checkbox.dataset.cartItemId;
        const cartItem = checkbox.closest('[data-cart-item-id]');
        console.log('Processing checkbox for item ID:', cartItemId, 'cartItem found:', !!cartItem);

        const promise = fetch('<?= base_url('cart/remove/') ?>' + cartItemId, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            console.log('Response status:', response.status, 'for item:', cartItemId);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text();
        })
        .then(text => {
            console.log('Response text for item', cartItemId, ':', text);
            try {
                const data = JSON.parse(text);
                if (data.success) {
                    console.log('Removing cart item element for ID:', cartItemId);
                    // Find the element again to ensure we have a fresh reference
                    const itemToRemove = document.querySelector(`[data-cart-item-id="${cartItemId}"]`);
                    console.log('Item to remove:', itemToRemove);
                    if (itemToRemove) {
                        // Get the item total before removing
                        const itemTotalElement = itemToRemove.querySelector('.item-total');
                        const itemTotal = itemTotalElement ? parseInt(itemTotalElement.textContent.replace(/[^\d]/g, '')) : 0;
                        console.log('Item total to subtract:', itemTotal);
                        
                        itemToRemove.parentNode.removeChild(itemToRemove);
                        console.log('Cart item removed from DOM');
                        
                        // Update total by subtracting the removed item's price
                        const totalAmountElement = document.getElementById('total-amount');
                        if (totalAmountElement) {
                            const currentTotal = parseInt(totalAmountElement.textContent.replace(/[^\d]/g, ''));
                            const newTotal = Math.max(0, currentTotal - itemTotal); // Ensure total doesn't go negative
                            totalAmountElement.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(newTotal);
                            console.log('Updated total after removal:', newTotal);
                        }
                    } else {
                        console.error('Cart item element not found for removal');
                    }
                    return { success: true, id: cartItemId };
                }
                return { success: false, id: cartItemId, message: data.message };
            } catch (e) {
                console.error('JSON parse error for item', cartItemId, ':', e);
                throw new Error('Invalid JSON response');
            }
        })
        .catch(error => {
            console.error('Error removing item', cartItemId, ':', error);
            return { success: false, id: cartItemId, error: error.message };
        });

        promises.push(promise);
    });

    Promise.all(promises).then(results => {
        console.log('Promise.all results:', results);
        const successResults = results.filter(result => result.success);
        const successCount = successResults.length;
        const totalCount = results.length;
        
        console.log(`Success count: ${successCount}, Total count: ${totalCount}`);
        console.log('Success results:', successResults);

        if (successCount > 0) {
            if (successCount === totalCount) {
                showMessage(`${successCount} item berhasil dihapus dari keranjang`, 'success');
                
                // Double-check total is 0 when all items removed
                const totalAmount = document.getElementById('total-amount');
                if (totalAmount) {
                    totalAmount.textContent = 'Rp 0';
                    console.log('Final total set to Rp 0');
                }
                
                // Always reload after successful removal to ensure UI is updated
                console.log('All items removed successfully, reloading page...');
                setTimeout(() => location.reload(), 100); // Small delay to show the 0 total
            } else {
                // For partial removals, the totals should already be updated individually
                updateSelectAllState();
                showMessage(`${successCount} dari ${totalCount} item berhasil dihapus`, 'success');
            }
        } else {
            showMessage('Gagal menghapus item dari keranjang', 'error');
        }
    }).catch(error => {
        console.error('Error in Promise.all:', error);
        showMessage('Terjadi kesalahan saat menghapus item', 'error');
    });
}

document.addEventListener('DOMContentLoaded', function() {
    try {
        console.log('DOM Content Loaded - initializing cart functionality');
        const applyVoucherBtn = document.getElementById('apply-voucher');
        const voucherCodeInput = document.getElementById('voucher-code');
        const voucherMessage = document.getElementById('voucher-message');
        const totalAmount = document.getElementById('total-amount');

        originalTotal = parseFloat(<?= json_encode($total) ?>);
        appliedDiscount = 0;

        console.log('Total amount element:', totalAmount);
        console.log('Original total:', originalTotal);

    // Remove selected items functionality - bind early
    const removeSelectedBtn = document.getElementById('remove-selected');
    console.log('Remove selected button element:', removeSelectedBtn);
    if (removeSelectedBtn) {
        console.log('Binding click event to remove selected button');
        removeSelectedBtn.addEventListener('click', function() {
            console.log('Remove selected button clicked');
            const selectedCheckboxes = document.querySelectorAll('.item-checkbox:checked');
            console.log('Selected checkboxes count:', selectedCheckboxes.length);
            console.log('All checkboxes:', document.querySelectorAll('.item-checkbox'));
            console.log('Checked checkboxes:', selectedCheckboxes);
            if (selectedCheckboxes.length === 0) {
                showMessage('Pilih item yang ingin dihapus terlebih dahulu.', 'error');
                return;
            }

            if (confirm(`Apakah Anda yakin ingin menghapus ${selectedCheckboxes.length} item yang dipilih?`)) {
                removeSelectedItems();
            }
        });
    }
    document.querySelectorAll('.quantity-increase').forEach(button => {
        button.addEventListener('click', function() {
            const cartItemId = this.dataset.cartItemId;
            const quantityInput = this.parentElement.querySelector('.quantity-input');
            const currentValue = parseInt(quantityInput.value);
            const newValue = currentValue + 1;

            quantityInput.value = newValue;
            updateCartQuantity(cartItemId, newValue);
        });
    });

    document.querySelectorAll('.quantity-decrease').forEach(button => {
        button.addEventListener('click', function() {
            const cartItemId = this.dataset.cartItemId;
            const quantityInput = this.parentElement.querySelector('.quantity-input');
            const currentValue = parseInt(quantityInput.value);

            if (currentValue > 1) {
                const newValue = currentValue - 1;
                quantityInput.value = newValue;
                updateCartQuantity(cartItemId, newValue);
            }
        });
    });

    // Remove item handlers
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function() {
            const cartItemId = this.dataset.cartItemId;
            const cartItem = this.closest('[data-cart-item-id]');

            if (confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) {
                removeCartItem(cartItemId, cartItem);
            }
        });
    });

    // Checkbox handlers for selection
    document.querySelectorAll('.item-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const cartItemId = this.dataset.cartItemId;
            const cartItem = this.closest('[data-cart-item-id]');
            const isChecked = this.checked;

            // Update visual state
            if (isChecked) {
                cartItem.classList.remove('opacity-50');
            } else {
                cartItem.classList.add('opacity-50');
            }

            updateTotal();
            updateSelectAllState();
        });
    });

    // Select All functionality
    const selectAllCheckbox = document.getElementById('select-all');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;
            document.querySelectorAll('.item-checkbox').forEach(checkbox => {
                checkbox.checked = isChecked;
                const cartItem = checkbox.closest('[data-cart-item-id]');
                if (isChecked) {
                    cartItem.classList.remove('opacity-50');
                } else {
                    cartItem.classList.add('opacity-50');
                }
            });
            updateTotal();
        });
    }

    function updateSelectAllState() {
        try {
            const selectAllCheckbox = document.getElementById('select-all');
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');
            const checkedItemCheckboxes = document.querySelectorAll('.item-checkbox:checked');

            console.log('updateSelectAllState called - selectAllCheckbox:', selectAllCheckbox, 'itemCheckboxes:', itemCheckboxes.length, 'checked:', checkedItemCheckboxes.length);

            if (selectAllCheckbox) {
                selectAllCheckbox.checked = itemCheckboxes.length > 0 && itemCheckboxes.length === checkedItemCheckboxes.length;
                console.log('selectAllCheckbox.checked set to:', selectAllCheckbox.checked);
            }
        } catch (error) {
            console.error('Error in updateSelectAllState:', error);
        }
    }

    

    function updateCartQuantity(cartItemId, quantity) {
        fetch('<?= base_url('cart/update') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new URLSearchParams({
                cart_item_id: cartItemId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the item total price in the UI
                const cartItem = document.querySelector(`[data-cart-item-id="${cartItemId}"]`);
                if (cartItem) {
                    const unitPrice = parseInt(cartItem.querySelector('.unit-price') ? cartItem.querySelector('.unit-price').textContent.replace(/[^\d]/g, '') : 0);
                    if (unitPrice > 0) {
                        const newTotal = unitPrice * quantity;
                        cartItem.querySelector('.item-total').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(newTotal);
                    }
                }

                updateTotal();
                showMessage('Jumlah berhasil diperbarui', 'success');
            } else {
                showMessage('Gagal memperbarui jumlah', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('Terjadi kesalahan saat memperbarui', 'error');
        });
    }

    function removeCartItem(cartItemId, cartItemElement) {
        fetch('<?= base_url('cart/remove/') ?>' + cartItemId, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (response.ok) {
                // Always reload the page after successful removal
                location.reload();
            } else {
                showMessage('Gagal menghapus item', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('Terjadi kesalahan saat menghapus item', 'error');
        });
    }

    function updateTotal() {
        let newTotal = 0;
        document.querySelectorAll('[data-cart-item-id]').forEach(item => {
            const checkbox = item.querySelector('.item-checkbox');
            if (checkbox && checkbox.checked) {
                const itemTotal = parseInt(item.querySelector('.item-total').textContent.replace(/[^\d]/g, ''));
                newTotal += itemTotal;
            }
        });

        originalTotal = newTotal;
        const finalTotal = newTotal - appliedDiscount;
        const totalAmountElement = document.getElementById('total-amount');
        if (totalAmountElement) {
            totalAmountElement.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(finalTotal);
        }
    }

    // Voucher functionality
    applyVoucherBtn.addEventListener('click', function() {
        const code = voucherCodeInput.value.trim();

        if (!code) {
            showMessage('Masukkan kode voucher terlebih dahulu.', 'error');
            return;
        }

        // Disable button during request
        applyVoucherBtn.disabled = true;
        applyVoucherBtn.textContent = 'Memproses...';

        // Send AJAX request to apply voucher
        fetch('<?= base_url('api/promo/apply') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new URLSearchParams({
                promo_code: code,
                subtotal: originalTotal
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                appliedDiscount = data.discount_amount;
                const newTotal = originalTotal - appliedDiscount;

                totalAmount.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(newTotal);
                showMessage(`Voucher berhasil diterapkan! Diskon: Rp ${new Intl.NumberFormat('id-ID').format(appliedDiscount)}`, 'success');

                // Store voucher info in session/localStorage for checkout
                localStorage.setItem('applied_voucher', JSON.stringify({
                    code: code,
                    discount: appliedDiscount
                }));
            } else {
                showMessage(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('Terjadi kesalahan saat memproses voucher.', 'error');
        })
        .finally(() => {
            applyVoucherBtn.disabled = false;
            applyVoucherBtn.textContent = 'Terapkan';
        });
    });

    function showMessage(message, type) {
        // For voucher messages - show in voucher section
        if (voucherMessage && message.toLowerCase().includes('voucher')) {
            voucherMessage.className = `mt-2 text-sm ${type === 'success' ? 'text-green-600' : 'text-red-600'}`;
            voucherMessage.textContent = message;
            
            setTimeout(() => {
                voucherMessage.textContent = '';
            }, 5000);
        } else {
            // For other messages - show in notification area at top
            const notificationArea = document.getElementById('notification-area');
            if (notificationArea) {
                const bgColor = type === 'success' ? 'bg-green-100 border-green-500 text-green-700' : 'bg-red-100 border-red-500 text-red-700';
                const notification = document.createElement('div');
                notification.className = `${bgColor} border-l-4 px-6 py-4 shadow-sm animate-slide-down mb-4`;
                notification.setAttribute('role', 'alert');
                notification.innerHTML = `<span class="block sm:inline">${message}</span>`;
                
                notificationArea.appendChild(notification);
                
                // Auto remove after 5 seconds
                setTimeout(() => {
                    notification.style.opacity = '0';
                    notification.style.transition = 'opacity 0.5s';
                    setTimeout(() => notification.remove(), 500);
                }, 5000);
            }
        }
    }

    // Initialize select all state
    try {
        updateSelectAllState();
    } catch (error) {
        console.error('Error calling updateSelectAllState:', error);
    }
    } catch (error) {
        console.error('Error initializing cart functionality:', error);
        console.error('Error stack:', error.stack);
    }
});
</script>

<?= $this->endSection() ?>