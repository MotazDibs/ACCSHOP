<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>رفع ملف Word</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light p-4">
<div class="container">
    <h2 class="mb-4">📄 رفع ملف Word</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form action="<?= site_url('documents/upload') ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="doc_file" class="form-label">اختر ملف DOCX أو DOC:</label>
            <input type="file" name="doc_file" class="form-control" accept=".doc,.docx" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">رفع الملف</button>
    </form>
</div>
</body>
</html>
