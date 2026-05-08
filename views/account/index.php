<style>
    .acct-stats { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:24px; }
    .acct-stat-card { background:var(--dark-2); border:1px solid var(--border-dim); border-radius:var(--radius); padding:20px; display:flex; align-items:center; gap:14px; }
    .acct-stat-icon { width:48px; height:48px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.3rem; flex-shrink:0; }
    .acct-stat-num { font-size:1.6rem; font-weight:800; color:var(--white); }
    .acct-stat-label { font-size:0.78rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; }
    .acct-section { background:var(--dark-2); border:1px solid var(--border-dim); border-radius:var(--radius-lg); overflow:hidden; margin-bottom:24px; }
    .acct-section-header { display:flex; align-items:center; justify-content:space-between; padding:18px 24px; border-bottom:1px solid var(--border-dim); flex-wrap:wrap; gap:10px; }
    .acct-section-title { font-size:1.05rem; font-weight:700; color:var(--white); display:flex; align-items:center; gap:10px; }
    .acct-section-title i { color:var(--gold); }
    .acct-section-body { padding:24px; }
    .acct-table { width:100%; border-collapse:collapse; }
    .acct-table th { text-align:left; padding:14px 20px; font-size:0.76rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; border-bottom:1px solid var(--border-dim); white-space:nowrap; }
    .acct-table td { padding:14px 20px; color:var(--text); border-bottom:1px solid var(--border-dim); font-size:0.9rem; vertical-align:middle; }
    .acct-table tbody tr:hover { background:rgba(201,168,76,0.03); }
    .acct-form-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .acct-form-grid-3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; }
    .acct-input-group label { display:block; color:var(--text-muted); font-size:0.85rem; font-weight:600; margin-bottom:6px; }
    .acct-input { width:100%; background:rgba(255,255,255,0.05); border:1px solid var(--border-dim); color:var(--text); padding:12px 14px; border-radius:8px; font-size:0.92rem; font-family:inherit; transition:var(--trans); }
    .acct-input:focus { outline:none; border-color:var(--gold); box-shadow:0 0 0 3px rgba(201,168,76,0.1); }
    .acct-empty { text-align:center; padding:50px 20px; }
    .acct-empty-icon { font-size:3.5rem; opacity:0.3; margin-bottom:12px; }
    .acct-welcome { background:linear-gradient(135deg,var(--dark-3),var(--dark-2)); border:1px solid var(--border); border-radius:var(--radius-lg); padding:28px 32px; margin-bottom:24px; display:flex; align-items:center; justify-content:space-between; gap:20px; }
    .acct-welcome h2 { font-family:'Cormorant Garamond',serif; font-size:1.7rem; color:var(--white); margin-bottom:6px; }
    .acct-welcome p { color:var(--text-muted); font-size:0.92rem; }
    .acct-welcome-emoji { font-size:3.5rem; flex-shrink:0; }

    @media (max-width: 768px) {
        .acct-stats { grid-template-columns:1fr; }
        .acct-form-grid { grid-template-columns:1fr; }
        .acct-form-grid-3 { grid-template-columns:1fr; }
        .acct-welcome { flex-direction:column; text-align:center; padding:20px 16px; }
        .acct-welcome h2 { font-size:1.3rem; }
        .acct-section-header { padding:14px 16px; }
        .acct-section-body { padding:16px; }
        .acct-table th, .acct-table td { padding:10px 12px; font-size:0.82rem; }
    }
    @media (max-width: 480px) {
        .acct-stat-card { padding:14px; }
        .acct-stat-num { font-size:1.3rem; }
    }
</style>

<div class="page-header">
    <div class="container">
        <h1>আমার অ্যাকাউন্ট</h1>
        <div class="breadcrumb">
            <a href="<?= SITE_URL ?>">হোম</a>
            <span class="sep">/</span>
            <span>ড্যাশবোর্ড</span>
        </div>
    </div>
</div>

<div class="container">
    <div class="account-grid">
        <!-- Sidebar -->
        <aside class="account-sidebar">
            <div class="account-profile">
                <div class="account-avatar">
                    <?= strtoupper(mb_substr($user['name'] ?? 'U', 0, 1)) ?>
                </div>
                <div class="account-name"><?= e($user['name'] ?? $_SESSION['user_name'] ?? 'User') ?></div>
                <div class="account-email"><?= e($user['email'] ?? $_SESSION['user_email'] ?? '') ?></div>
            </div>

            <nav class="account-nav">
                <a href="<?= SITE_URL ?>/account" class="account-nav-link active">
                    <i class="fas fa-th-large"></i> ড্যাশবোর্ড
                </a>
                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                <a href="<?= SITE_URL ?>/admin" class="account-nav-link">
                    <i class="fas fa-cogs"></i> অ্যাডমিন প্যানেল
                </a>
                <?php endif; ?>
                <a href="<?= SITE_URL ?>/shop" class="account-nav-link">
                    <i class="fas fa-shopping-bag"></i> শপিং করুন
                </a>
                <a href="<?= SITE_URL ?>/auth/logout" class="account-nav-link" style="color:var(--red);">
                    <i class="fas fa-sign-out-alt"></i> লগআউট
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="account-content">
            <!-- Welcome -->
            <div class="acct-welcome">
                <div>
                    <h2>স্বাগতম, <?= e(explode(' ', $user['name'] ?? 'User')[0]) ?>! 👋</h2>
                    <p>আপনার ড্যাশবোর্ডে আপনি অর্ডার ট্র্যাক করতে ও প্রোফাইল পরিচালনা করতে পারবেন।</p>
                </div>
                <div class="acct-welcome-emoji">🕶️</div>
            </div>

            <!-- Stats -->
            <div class="acct-stats">
                <div class="acct-stat-card">
                    <div class="acct-stat-icon" style="background:rgba(201,168,76,0.12);color:var(--gold);"><i class="fas fa-box"></i></div>
                    <div>
                        <div class="acct-stat-num"><?= count($orders) ?></div>
                        <div class="acct-stat-label">মোট অর্ডার</div>
                    </div>
                </div>
                <div class="acct-stat-card">
                    <div class="acct-stat-icon" style="background:rgba(76,175,80,0.12);color:var(--green);"><i class="fas fa-check-double"></i></div>
                    <div>
                        <div class="acct-stat-num"><?= count(array_filter($orders, fn($o) => $o['status'] === 'delivered')) ?></div>
                        <div class="acct-stat-label">ডেলিভারি হয়েছে</div>
                    </div>
                </div>
                <div class="acct-stat-card">
                    <div class="acct-stat-icon" style="background:rgba(255,165,0,0.12);color:orange;"><i class="fas fa-clock"></i></div>
                    <div>
                        <div class="acct-stat-num"><?= count(array_filter($orders, fn($o) => in_array($o['status'], ['pending','confirmed','shipped']))) ?></div>
                        <div class="acct-stat-label">চলমান</div>
                    </div>
                </div>
            </div>

            <!-- Orders -->
            <div class="acct-section">
                <div class="acct-section-header">
                    <div class="acct-section-title"><i class="fas fa-receipt"></i> আমার অর্ডার</div>
                    <a href="<?= SITE_URL ?>/shop" class="btn btn-outline-gold btn-sm">আরো কিনুন</a>
                </div>

                <?php if (empty($orders)): ?>
                <div class="acct-empty">
                    <div class="acct-empty-icon">📦</div>
                    <p style="color:var(--text-muted);margin-bottom:16px;">আপনি এখনো কোনো অর্ডার দেননি।</p>
                    <a href="<?= SITE_URL ?>/shop" class="btn btn-gold">কেনাকাটা শুরু করুন</a>
                </div>
                <?php else: ?>
                <div style="overflow-x:auto;">
                    <table class="acct-table">
                        <thead>
                            <tr>
                                <th>অর্ডার</th>
                                <th>তারিখ</th>
                                <th>মোট</th>
                                <th>স্ট্যাটাস</th>
                                <th>অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                            <tr>
                                <td style="color:var(--gold);font-weight:700;">#<?= e($order['id']) ?></td>
                                <td style="color:var(--text-muted);"><?= date('d M Y', strtotime($order['created_at'])) ?></td>
                                <td style="font-weight:700;">৳<?= number_format($order['total_amount'], 0) ?></td>
                                <td>
                                    <?php
                                    $stColors = [
                                        'pending'   => ['rgba(255,165,0,0.15)','orange'],
                                        'confirmed' => ['rgba(33,150,243,0.15)','#64b5f6'],
                                        'shipped'   => ['rgba(156,39,176,0.15)','#ce93d8'],
                                        'delivered' => ['rgba(76,175,80,0.15)','var(--green)'],
                                        'cancelled' => ['rgba(224,84,84,0.15)','var(--red)'],
                                    ];
                                    $st = $stColors[$order['status']] ?? ['var(--border-dim)','var(--text-muted)'];
                                    $statusBn = ['pending'=>'অপেক্ষমাণ','confirmed'=>'নিশ্চিত','shipped'=>'শিপড','delivered'=>'ডেলিভারি','cancelled'=>'বাতিল'];
                                    ?>
                                    <span style="display:inline-block;padding:4px 12px;border-radius:6px;font-size:0.78rem;font-weight:700;background:<?= $st[0] ?>;color:<?= $st[1] ?>;white-space:nowrap;">
                                        <?= $statusBn[$order['status']] ?? ucfirst($order['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= SITE_URL ?>/account/order/<?= $order['id'] ?>" class="btn btn-sm btn-dark" style="font-size:0.82rem;padding:6px 14px;">
                                        <i class="fas fa-eye"></i> বিস্তারিত
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>

            <!-- Profile Update -->
            <div class="acct-section">
                <div class="acct-section-header">
                    <div class="acct-section-title"><i class="fas fa-user-edit"></i> প্রোফাইল সেটিংস</div>
                </div>
                <div class="acct-section-body">
                    <form id="profileForm" class="acct-form-grid">
                        <div class="acct-input-group">
                            <label>নাম</label>
                            <input type="text" name="name" class="acct-input" value="<?= e($user['name'] ?? '') ?>" required>
                        </div>
                        <div class="acct-input-group">
                            <label>ইমেইল</label>
                            <input type="email" name="email" class="acct-input" value="<?= e($user['email'] ?? '') ?>" required>
                        </div>
                        <div style="grid-column:1/-1;">
                            <button type="submit" class="btn btn-gold"><i class="fas fa-save"></i> প্রোফাইল আপডেট করুন</button>
                        </div>
                    </form>

                    <div style="border-top:1px solid var(--border-dim);margin-top:24px;padding-top:24px;">
                        <h4 style="font-size:0.95rem;color:var(--white);margin-bottom:16px;display:flex;align-items:center;gap:8px;">
                            <i class="fas fa-lock" style="color:var(--gold);"></i> পাসওয়ার্ড পরিবর্তন
                        </h4>
                        <form id="passwordForm" class="acct-form-grid-3">
                            <div class="acct-input-group">
                                <label>বর্তমান পাসওয়ার্ড</label>
                                <input type="password" name="current_password" class="acct-input" required>
                            </div>
                            <div class="acct-input-group">
                                <label>নতুন পাসওয়ার্ড</label>
                                <input type="password" name="new_password" class="acct-input" required>
                            </div>
                            <div class="acct-input-group">
                                <label>নিশ্চিত করুন</label>
                                <input type="password" name="confirm_password" class="acct-input" required>
                            </div>
                            <div style="grid-column:1/-1;">
                                <button type="submit" class="btn btn-dark"><i class="fas fa-key"></i> পাসওয়ার্ড পরিবর্তন করুন</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Notification -->
<div id="notification" style="position:fixed;top:20px;right:20px;z-index:9999;display:none;min-width:280px;max-width:90vw;padding:14px 20px;border-radius:10px;font-weight:600;font-size:0.9rem;box-shadow:0 8px 30px rgba(0,0,0,0.4);"></div>

<script>
const SITE_URL = '<?= SITE_URL ?>';

function showNotify(msg, type) {
    const el = document.getElementById('notification');
    el.textContent = msg;
    el.style.display = 'block';
    el.style.background = type === 'success' ? 'rgba(76,175,80,0.95)' : 'rgba(224,84,84,0.95)';
    el.style.color = '#fff';
    setTimeout(() => { el.style.display = 'none'; }, 3500);
}

document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    fetch(SITE_URL + '/account/update-profile', { method: 'POST', body: new FormData(this) })
        .then(r => r.json())
        .then(d => showNotify(d.message, d.success ? 'success' : 'error'))
        .catch(() => showNotify('সমস্যা হয়েছে।', 'error'));
});

document.getElementById('passwordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    fetch(SITE_URL + '/account/change-password', { method: 'POST', body: new FormData(this) })
        .then(r => r.json())
        .then(d => { showNotify(d.message, d.success ? 'success' : 'error'); if (d.success) this.reset(); })
        .catch(() => showNotify('সমস্যা হয়েছে।', 'error'));
});
</script>