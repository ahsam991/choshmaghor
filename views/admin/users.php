<div class="page-header">
    <div class="container">
        <h1><i class="fas fa-users"></i> ব্যবহারকারী পরিচালনা</h1>
    </div>
</div>

<div class="container" style="padding: 20px 0;">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2 style="color: var(--white); font-size: 1.4rem;">সব ব্যবহারকারী</h2>
    </div>
    
    <!-- Users Table -->
    <div class="admin-card">
        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>নাম</th>
                        <th>ইমেইল</th>
                        <th>ভূমিকা</th>
                        <th>রেজিস্ট্রেশন তারিখ</th>
                        <th>অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td style="color: var(--gold);">#<?= e($user['id']) ?></td>
                            <td style="font-weight: 600; color: var(--white);"><?= e($user['name']) ?></td>
                            <td style="color: var(--text-muted);"><?= e($user['email']) ?></td>
                            <td>
                                <?php if ($user['role'] === 'admin'): ?>
                                    <span class="badge badge-gold"><i class="fas fa-shield-alt me-1"></i> Admin</span>
                                <?php else: ?>
                                    <span class="badge" style="background: var(--border-dim); color: var(--text-muted);"><i class="fas fa-user me-1"></i> Customer</span>
                                <?php endif; ?>
                            </td>
                            <td style="color: var(--text-muted);"><?= date('d M Y', strtotime($user['created_at'])) ?></td>
                            <td>
                                <button class="btn btn-edit action-btn-sm" disabled title="Coming Soon">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                <i class="fas fa-users-slash" style="font-size: 3rem; margin-bottom: 16px; display: block;"></i>
                                কোনো ব্যবহারকারী পাওয়া যায়নি।
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
const SITE_URL = '<?= SITE_URL ?>';
</script>
