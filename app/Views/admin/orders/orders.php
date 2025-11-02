<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>
<?= esc($title ?? 'Kelola Pesanan') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="page-heading">
    <h3>Kelola Pesanan</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12">

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    Daftar Semua Pesanan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="table_orders">
                            <thead>
                                <tr>
                                    <th>Order Code</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($orders)): ?>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td><?= esc($order->order_code) ?></td>
                                            <td>
                                                <div><?= esc($order->customer_name) ?></div>
                                                <small class="text-muted"><?= esc($order->customer_email) ?></small>
                                            </td>
                                            <td>Rp <?= number_format($order->final_amount, 0, ',', '.') ?></td>
                                            <td>
                                                <?php
                                                    // Tampilkan apa adanya (status dari kolom status_pesanan)
                                                    $badgeClass = 'bg-secondary';
                                                    // Jika kamu ingin map ke warna tertentu, sesuaikan mapping di bawah:
                                                    $s = strtolower($order->status);
                                                    if ($s === 'delivered' || $s === 'selesai') $badgeClass = 'bg-success';
                                                    if ($s === 'pending' || $s === 'baru') $badgeClass = 'bg-warning text-dark';
                                                    if ($s === 'processing' || $s === 'diproses') $badgeClass = 'bg-info';
                                                    if ($s === 'shipped' || $s === 'dikirim') $badgeClass = 'bg-primary';
                                                    if ($s === 'cancelled' || $s === 'dibatalkan') $badgeClass = 'bg-danger';
                                                ?>
                                                <span class="badge <?= $badgeClass ?>"><?= ucfirst(esc($order->status)) ?></span>
                                            </td>
                                            <td><?= date('d M Y H:i', strtotime($order->created_at)) ?></td>
<td>
    <button type="button"
        class="btn btn-sm btn-info btn-detail"
        data-id="<?= $order->id ?>">
        Detail
    </button>
    <a href="<?= base_url('/admin/orders/detail/' . $order->id) ?>" class="btn btn-sm btn-secondary">
        Halaman
    </a>
    <a href="<?= base_url('/admin/orders/delete/' . $order->id) ?>"
       class="btn btn-sm btn-danger btn-delete"
       onclick="return confirm('Yakin ingin menghapus pesanan <?= esc($order->order_code) ?> ? Data tidak dapat dikembalikan!')">
       Delete
    </a>
</td>

                                    
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada pesanan</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pesanan #<span id="modal_order_code">...</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="modal_loading" class="text-center">
                    <div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>
                    <p class="mt-2">Memuat data...</p>
                </div>

                <div id="modal_content" style="display: none;">
                    <h6>Informasi Customer</h6>
                    <table class="table table-sm table-borderless">
                        <tr><td style="width: 120px;">Nama</td><td>: <strong id="modal_customer_name"></strong></td></tr>
                        <tr><td>Email</td><td>: <span id="modal_customer_email"></span></td></tr>
                        <tr><td>Telepon</td><td>: <span id="modal_customer_phone"></span></td></tr>
                        <tr><td>Alamat</td><td>: <span id="modal_shipping_address"></span></td></tr>
                    </table>

                    <h6 class="mt-4">Item Pesanan</h6>
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr><th>Produk</th><th>Harga</th><th>Qty</th><th class="text-end">Subtotal</th></tr>
                        </thead>
                        <tbody id="modal_order_items"></tbody>
                    </table>

                    <h6>Ringkasan Pembayaran</h6>
                    <table class="table table-sm table-borderless">
                        <tr><td style="width: 120px;">Total Belanja</td><td>: <span id="modal_total_amount"></span></td></tr>
                        <tr><td>Diskon</td><td>: <span id="modal_discount_amount"></span></td></tr>
                        <tr><td>Ongkir</td><td>: <span id="modal_shipping_cost"></span></td></tr>
                        <tr><td>Kode Unik</td><td>: <span id="modal_kode_unik"></span></td></tr>
                        <tr><td>Total Akhir</td><td>: <strong id="modal_final_amount" class="fs-5"></strong></td></tr>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <form id="formUpdateStatus" action="" method="post" class="w-100">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-8">
                            <select name="status" id="modal_status_select" class="form-select">
                                <option value="baru">Baru</option>
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="dikirim">Shipped</option>
                                <option value="selesai">Delivered</option>
                                <option value="dibatalkan">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-4 text-end">
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
    </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<link rel="stylesheet" href="<?= base_url('assets/extensions/simple-datatables/style.css') ?>">
<script src="<?= base_url('assets/extensions/simple-datatables/simple-datatables.js') ?>"></script>

<script>
console.log("Script Modal Orders Mulai...");

// DataTable init (jaga safe)
let table1 = document.querySelector('#table_orders');
if (table1) {
    try {
        new simpleDatatables.DataTable(table1);
    } catch (e) {
        console.error("Gagal inisialisasi simpleDatatables:", e);
    }
}

const orderDetailModalEl = document.getElementById('orderDetailModal');
if (orderDetailModalEl) {
    const orderDetailModal = new bootstrap.Modal(orderDetailModalEl);
    const table = document.querySelector('#table_orders');

    const modalLoading = document.getElementById('modal_loading');
    const modalContent = document.getElementById('modal_content');
    const modalOrderCode = document.getElementById('modal_order_code');
    const modalCustomerName = document.getElementById('modal_customer_name');
    const modalCustomerEmail = document.getElementById('modal_customer_email');
    const modalCustomerPhone = document.getElementById('modal_customer_phone');
    const modalShippingAddress = document.getElementById('modal_shipping_address');
    const modalOrderItems = document.getElementById('modal_order_items');
    const modalTotalAmount = document.getElementById('modal_total_amount');
    const modalDiscountAmount = document.getElementById('modal_discount_amount');
    const modalShippingCost = document.getElementById('modal_shipping_cost');
    const modalKodeUnik = document.getElementById('modal_kode_unik');
    const modalFinalAmount = document.getElementById('modal_final_amount');
    const modalStatusSelect = document.getElementById('modal_status_select');
    const formUpdateStatus = document.getElementById('formUpdateStatus');

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
    }

    function resetModal() {
        modalContent.style.display = 'none';
        modalLoading.style.display = 'block';
        modalLoading.innerHTML = `<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Memuat data...</p>`;
        modalOrderCode.innerText = '...';
        modalOrderItems.innerHTML = '';
        formUpdateStatus.action = '';
    }

    if (table) {
        table.addEventListener('click', async function (event) {
            const button = event.target.closest('.btn-detail');
            if (!button) return;

            resetModal();
            orderDetailModal.show();

            const orderId = button.getAttribute('data-id');

            // set action form ke route yang benar
            formUpdateStatus.action = `/admin/orders/update/${orderId}`;

            try {
                const response = await fetch(`/admin/orders/json/${orderId}`);
                if (!response.ok) throw new Error('Gagal mengambil data pesanan.');

                const order = await response.json();

                modalOrderCode.innerText = order.order_code;
                modalCustomerName.innerText = order.customer_name;
                modalCustomerEmail.innerText = order.customer_email;
                modalCustomerPhone.innerText = order.customer_phone || '-';
                modalShippingAddress.innerText = order.shipping_address || '-';
                modalStatusSelect.value = order.status;

                modalTotalAmount.innerText = formatRupiah(order.total_amount);
                modalDiscountAmount.innerText = formatRupiah(order.discount_amount);
                modalShippingCost.innerText = formatRupiah(order.shipping_cost || 0);
                modalKodeUnik.innerText = order.kode_unik ? ('Rp ' + order.kode_unik) : 'Rp 0';
                modalFinalAmount.innerText = formatRupiah(order.final_amount);

                let itemsHtml = '';
                order.items.forEach(item => {
                    itemsHtml += `
                        <tr>
                            <td>${item.product_name}</td>
                            <td>${formatRupiah(item.product_price)}</td>
                            <td>${item.quantity}</td>
                            <td class="text-end">${formatRupiah(item.subtotal)}</td>
                        </tr>
                    `;
                });
                modalOrderItems.innerHTML = itemsHtml;

                modalLoading.style.display = 'none';
                modalContent.style.display = 'block';

            } catch (err) {
                console.error(err);
                modalLoading.innerHTML = `<p class="text-danger">${err.message}</p>`;
            }
        });
    } else {
        console.error("Tabel orders tidak ditemukan pada DOM.");
    }
} else {
    console.error("Modal orderDetailModal tidak ditemukan.");
}
</script>

<?= $this->endSection() ?>
