<?php
$current_page = basename($_SERVER['PHP_SELF']);
$current_url = $_SERVER['REQUEST_URI'];
$LAVA = lava_instance();
$LAVA->call->library('auth');
$user = $LAVA->auth->get_user();
?>
<header class="main-header">
    <div class="container">
        <div class="header-content">
            <a href="<?php echo site_url('students'); ?>" class="brand-title">Student Management System</a>
            <nav class="main-nav">
                <ul class="nav-links">
                    <li><a href="<?php echo site_url('students'); ?>" class="nav-link <?php echo (strpos($current_url, 'students') !== false && strpos($current_url, 'deleted') === false) ? 'active' : ''; ?>">Students</a></li>
                    <?php if ($user && $user['role'] === 'admin'): ?>
                        <li><a href="<?php echo site_url('students/deleted'); ?>" class="nav-link <?php echo (strpos($current_url, 'deleted') !== false) ? 'active' : ''; ?>">Deleted Students</a></li>
                    <?php endif; ?>
                    <?php if ($user): ?>
                        <li>
                            <span class="user-info">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <?php echo htmlspecialchars($user['username']); ?>
                                <?php if ($user['role'] === 'admin'): ?>
                                    <span class="admin-badge">ADMIN</span>
                                <?php endif; ?>
                            </span>
                        </li>
                        <li>
                            <a href="<?php echo site_url('logout'); ?>" class="nav-link" onclick="return confirm('Are you sure you want to logout?');">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                Logout
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</header>
