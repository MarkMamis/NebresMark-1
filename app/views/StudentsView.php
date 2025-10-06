<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students - Student Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="<?php echo site_url('public/assets/css/style.css'); ?>" rel="stylesheet">
    <link href="<?php echo site_url('public/assets/css/pagination-fix.css'); ?>" rel="stylesheet">
</head>
<body>
    <?php
    $LAVA = lava_instance();
    $LAVA->call->library('auth');
    $user = $LAVA->auth->get_user();
    $is_admin = ($user && $user['role'] === 'admin');
    ?>
    <div class="dashboard-layout">
        <?php include('header.php'); ?>
        <main class="main">
            <h1 class="dashboard-title">STUDENTS
                <?php if ($is_admin): ?>
                    <a href="<?php echo site_url('students/add'); ?>" class="btn-add">Add Student</a>
                <?php endif; ?>
            </h1>
            
            <!-- Simple Search Bar -->
            <div class="search-container">
                <form action="<?php echo site_url('students/'); ?>" method="get" class="search-form">
                    <div class="search-input-container">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input type="text" name="search" placeholder="Search students by name..." class="search-input" value="<?php echo isset($search) ? htmlspecialchars($search) : ''; ?>">
                        <input type="hidden" name="show" value="10">
                    </div>
                    <button type="submit" class="btn-search">Search</button>
                </form>
            </div>
                <?php if (!empty($students) && is_array($students)): ?>
                    <div class="table-container">
                        <table class="students-table">
                            <thead>
                                <tr>
                                    <th class="id-column">ID</th>
                                    <th class="last-name-column">LAST NAME</th>
                                    <th class="first-name-column">FIRST NAME</th>
                                    <?php if ($is_admin): ?>
                                        <th class="action-column">ACTION</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($students as $student): ?>
                                    <tr>
                                        <td class="id-column"><?php echo htmlspecialchars($student['id']); ?></td>
                                        <td class="last-name-column"><?php echo htmlspecialchars($student['last_name']); ?></td>
                                        <td class="first-name-column"><?php echo htmlspecialchars($student['first_name']); ?></td>
                                        <?php if ($is_admin): ?>
                                            <td class="action-cell">
                                                <a href="<?php echo site_url('students/edit/' . $student['id']); ?>" class="btn-icon btn-edit" title="Edit Student">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                                    </svg>
                                                </a>
                                                <a href="javascript:void(0);" class="btn-icon btn-delete" title="Delete Student" onclick="if(confirm('Are you sure you want to delete this student?')) window.location.href='<?php echo site_url('students/delete/' . $student['id']); ?>'">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                    </svg>
                                                </a>
                                            </td>
                                        <?php endif; ?>
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
                            <p class="no-data">No students found. Click the "Add New Student" button to add your first student.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>