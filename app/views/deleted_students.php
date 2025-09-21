<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deleted Students - Student Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="<?php echo site_url('public/assets/css/style.css'); ?>" rel="stylesheet">
    <link href="<?php echo site_url('public/assets/css/pagination-fix.css'); ?>" rel="stylesheet">
</head>
<body>
    <div class="dashboard-layout">
        <?php include('header.php'); ?>
        <main class="main">
            <h1 class="dashboard-title">
                DELETED ENTRIES
                <a href="<?php echo site_url('students'); ?>" class="add-icon" title="Back to Students">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                </a>
            </h1>
            
            <!-- Simple Search Bar -->
            <div class="search-container">
                <form action="<?php echo site_url('students/deleted'); ?>" method="get" class="search-form">
                    <div class="search-input-container">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input type="text" name="search" placeholder="Search deleted students..." class="search-input" value="<?php echo isset($search) ? htmlspecialchars($search) : ''; ?>">
                        <input type="hidden" name="show" value="10">
                    </div>
                    <button type="submit" class="btn-search">Search</button>
                </form>
            </div>
                <?php if (!empty($deleted_students) && is_array($deleted_students)): ?>
                    <div class="table-container">
                        <table class="students-table">
                            <thead>
                                <tr>
                                    <th class="id-column">ID</th>
                                    <th class="name-column">NAME</th>
                                    <th class="date-column">DELETED DATE</th>
                                    <th class="action-column">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($deleted_students as $student): ?>
                                    <tr>
                                        <td class="id-column"><?php echo htmlspecialchars($student['id']); ?></td>
                                        <td class="name-column"><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></td>
                                        <td class="date-column"><?php echo htmlspecialchars(date('Y-m-d', strtotime($student['deleted_at']))); ?></td>
                                        <td class="action-cell">
                                            <a href="<?php echo site_url('students/restore/' . $student['id']); ?>" class="btn-icon btn-restore" title="Restore Student">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                                    <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Enhanced Pagination Controls -->
                    <div class="pagination-container">
                        <div class="pagination-info">
                            Showing <strong><?php echo $showing_start; ?></strong> to <strong><?php echo $showing_end; ?></strong> of <strong><?php echo $total_rows; ?></strong> entries
                        </div>
                        <div class="pagination-controls">
                            <?php echo $pagination; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="students-list">
                        <div class="list-header">
                            <p class="no-data">No deleted students found.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>