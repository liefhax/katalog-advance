<h5>Info User</h5>
<table class="table table-sm">
    <tr><th>Nama</th><td><?= esc($user['name']) ?></td></tr>
    <tr><th>Email</th><td><?= esc($user['email']) ?></td></tr>
    <tr><th>Role</th><td><?= $user['is_admin'] ? 'Admin' : 'User' ?></td></tr>
</table>

<h5 class="mt-3">Alamat</h5>
<?php if(empty($addresses)): ?>
    <p>Tidak ada alamat.</p>
<?php else: ?>
<table class="table table-bordered table-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Label</th>
            <th>Penerima</th>
            <th>Telepon</th>
            <th>Alamat</th>
            <th>Kode Pos</th>
            <th>Default</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=1; foreach($addresses as $a): ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= esc($a['label']) ?></td>
            <td><?= esc($a['recipient_name']) ?></td>
            <td><?= esc($a['recipient_phone']) ?></td>
            <td><?= esc($a['street_address']) ?></td>
            <td><?= esc($a['postal_code']) ?></td>
            <td><?= $a['is_default'] ? 'Ya' : '-' ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
