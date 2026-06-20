<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>عرض الملف</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-white p-4">
<div class="container">
    <h2 class="mb-4">📄 محتوى الملف</h2>

    <?php if (!empty($content) && is_object($content) && isset($content->content_html)): ?>
        <div class="border p-3 mb-3">
            <?= $content->content_html ?>
        </div>
        <div class="text-center">
            
            <a href="<?= base_url('c/list_file') ?>" class="btn btn-secondary">🔙 العودة للقائمة</a>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">⚠️ لا يوجد محتوى لعرضه.</div>
    <?php endif; ?>
</div>
</body>
</html>
