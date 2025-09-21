<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student - Student Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="<?php echo site_url('public/assets/css/style.css'); ?>" rel="stylesheet">
    <link href="<?php echo site_url('public/assets/css/pagination-fix.css'); ?>" rel="stylesheet">

</head>
<body>
    <div class="dashboard-layout">
        <?php include('header.php'); ?>
        <main class="main">
            <h1 class="dashboard-title">ADD STUDENT</h1>

            <div class="form-container">
                <?php flash_alert(); ?>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form action="<?php echo site_url('students/add'); ?>" method="post">
                    <div class="form-group">
                        <label class="form-label">Firstname</label>
                        <input type="text" name="first_name" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Lastname</label>
                        <input type="text" name="last_name" class="form-input" required>
                    </div>

                    <div class="buttons-container">
                        <button type="submit" class="btn btn-save">Save</button>
                        <a href="<?php echo site_url('students'); ?>" class="btn btn-cancel">Cancel</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>