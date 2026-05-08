<div class="admin-page-header">
    <div>
        <h1 class="admin-page-title"><i class="fas fa-users"></i> ব্যবহারকারী পরিচালনা</h1>
        <p class="admin-page-sub">নিবন্ধিত সকল ব্যবহারকারীর তালিকা</p>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <div class="admin-card-title"><i class="fas fa-user-friends"></i> সব ব্যবহারকারী (<?= count($users ?? []) ?>)</div>
    </div>
    <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>নাম</th>
                    <th>ইমেইল</th>
                    <th>ভূমিকা</th>
                    <th>রেজিস্ট্রেশন তারিখ</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td style="color:var(--gold);font-weight:700;">#<?= e($user['id']) ?></td>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:34px;height:34px;border-radius:50%;background:var(--gold-dark);display:flex;align-items:center;justify-content:center;font-weight:700;color:#000;font-size:0.85rem;flex-shrink:0;">
                                    <?= strtoupper(mb_substr($user['name'], 0, 1)) ?>
                                </div>
                                <span style="font-weight:600;"><?= e($user['name']) ?></span>
                            </div>
                        </td>
                        <td style="color:var(--text-muted);"><?= e($user['email']) ?></td>
                        <td>
                            <?php if ($user['role'] === 'admin'): ?>
                                <span class="badge badge-gold"><i class="fas fa-shield-alt me-1"></i>Admin</span>
                            <?php else: ?>
                                <span class="badge" style="background:var(--dark-4);color:var(--text-muted);">
                                    <i class="fas fa-user me-1"></i>Customer
                                </span>
                            <?php endif; ?>
                        </td>
                        <td style="color:var(--text-muted);"><?= date('d M Y', strtotime($user['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5">
                        <div class="admin-empty"><i class="fas fa-users-slash"></i><p>কোনো ব্যবহারকারী নেই।</p></div>
                    </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>const SITE_URL = '<?= SITE_URL ?>';</script>
