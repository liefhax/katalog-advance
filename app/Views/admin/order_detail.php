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
                <a href="/admin/orders" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Kembali</a>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Order Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Order Items -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold mb-4">Items Pesanan</h3>
                        <div class="space-y-4">
                            <?php foreach ($order->items as $item): ?>
                                <div class="flex items-center border-b pb-4">
                                    <img src="<?= $item->image_url ?>" alt="<?= $item->product_name ?>" 
                                        class="w-16 h-16 object-cover rounded">
                                    <div class="ml-4 flex-1">
                                        <h4 class="font-medium"><?= $item->product_name ?></h4>
                                        <p class="text-gray-600">Rp <?= number_format($item->product_price, 0, ',', '.') ?> x <?= $item->quantity ?></p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold">Rp <?= number_format($item->subtotal, 0, ',', '.') ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold mb-4">Alamat Pengiriman</h3>
                        <p class="text-gray-700 whitespace-pre-line"><?= $order->shipping_address ?></p>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="space-y-6">
                    <!-- Status Update -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold mb-4">Update Status</h3>
                        <form method="POST" action="/admin/orders/update-status/<?= $order->id ?>">
                            <?= csrf_field() ?>
                            <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2 mb-3">
                                <option value="pending" <?= $order->status === 'pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="processing" <?= $order->status === 'processing' ? 'selected' : '' ?>>Processing</option>
                                <option value="shipped" <?= $order->status === 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                <option value="delivered" <?= $order->status === 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                <option value="cancelled" <?= $order->status === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                            </select>
                            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded">
                                Update Status
                            </button>
                        </form>
                    </div>

                    <!-- Order Total -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold mb-4">Ringkasan Pesanan</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span>Subtotal:</span>
                                <span>Rp <?= number_format($order->total_amount, 0, ',', '.') ?></span>
                            </div>
                            <?php if ($order->discount_amount > 0): ?>
                                <div class="flex justify-between text-green-600">
                                    <span>Diskon:</span>
                                    <span>- Rp <?= number_format($order->discount_amount, 0, ',', '.') ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="flex justify-between font-semibold text-lg border-t pt-2">
                                <span>Total:</span>
                                <span>Rp <?= number_format($order->final_amount, 0, ',', '.') ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Info -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold mb-4">Info Customer</h3>
                        <div class="space-y-2">
                            <p><strong>Nama:</strong> <?= $order->customer_name ?></p>
                            <p><strong>Email:</strong> <?= $order->customer_email ?></p>
                            <p><strong>Telepon:</strong> <?= $order->customer_phone ?></p>
                            <p><strong>Tanggal:</strong> <?= date('d M Y H:i', strtotime($order->created_at)) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>