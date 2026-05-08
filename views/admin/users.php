<div class="admin-page-header">
    <div>
        <h1 class="admin-page-title"><i class="fas fa-users"></i> User Management</h1>
        <p class="admin-page-sub">View and manage all registered customers and administrators.</p>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <div class="admin-card-title"><i class="fas fa-user-friends"></i> Total Users (<?= count($users ?? []) ?>)</div>
    </div>
    <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email Address</th>
                    <th>System Role</th>
                    <th>Registered At</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td style="color:var(--gold);font-weight:700;">#<?= e($user['id']) ?></td>
                        <td>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg, var(--gold), #8e732d);display:flex;align-items:center;justify-content:center;font-weight:700;color:#000;font-size:0.9rem;flex-shrink:0;box-shadow:0 2px 4px rgba(0,0,0,0.2);">
                                    <?= strtoupper(mb_substr($user['name'] ?? 'U', 0, 1)) ?>
                                </div>
                                <span style="font-weight:600;"><?= e($user['name'] ?? 'Unknown') ?></span>
                            </div>
                        </td>
                        <td style="color:var(--text-muted);"><?= e($user['email']) ?></td>
                        <td>
                            <?php if ($user['role'] === 'admin'): ?>
                                <span class="badge badge-gold px-2 py-1"><i class="fas fa-shield-alt me-1"></i>Admin</span>
                            <?php else: ?>
                                <span class="badge" style="background:var(--dark-4);color:var(--text-muted);padding:4px 8px;">
                                    <i class="fas fa-user me-1"></i>Customer
                                </span>
                            <?php endif; ?>
                        </td>
                        <td style="color:var(--text-muted);"><?= date('d M Y, h:i A', strtotime($user['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5">
                        <div class="admin-empty"><i class="fas fa-users-slash"></i><p>No registered users found.</p></div>
                    </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>const SITE_URL = '<?= SITE_URL ?>';</script>
