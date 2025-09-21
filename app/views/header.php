<?php
$current_page = basename($_SERVER['PHP_SELF']);
$current_url = $_SERVER['REQUEST_URI'];
?>
<header class="main-header">
    <div class="container">
        <div class="header-content">
            <a href="<?php echo site_url('students'); ?>" class="brand-title">Student Management System</a>
            <nav class="main-nav">
                <ul class="nav-links">
                    <li><a href="<?php echo site_url('students'); ?>" class="nav-link <?php echo (strpos($current_url, 'students') !== false && strpos($current_url, 'deleted') === false) ? 'active' : ''; ?>">Students</a></li>
                    <li><a href="<?php echo site_url('students/deleted'); ?>" class="nav-link <?php echo (strpos($current_url, 'deleted') !== false) ? 'active' : ''; ?>">Deleted Students</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>
