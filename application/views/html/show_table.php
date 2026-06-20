<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>عرض محتوى الجدول: <?= $table_name ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 1.1rem;
        }

        h3 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 2rem;
            text-align: center;
            color: #212529;
        }

        .card {
            border-radius: 1rem;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .table th {
            background: linear-gradient(to right, #0d6efd, #0a58ca);
            color: white;
            font-size: 1.1rem;
        }

        .table td, .table th {
            vertical-align: middle !important;
            padding: 0.9rem;
        }

        .btn-back {
            background: linear-gradient(to right, #6c757d, #495057);
            color: white;
            padding: 10px 20px;
            font-size: 1rem;
            border: none;
            border-radius: 0.5rem;
            transition: 0.3s ease-in-out;
        }

        .btn-back:hover {
            opacity: 0.9;
        }

        .no-data {
            font-size: 1.1rem;
            color: #6c757d;
        }

        .table-container {
            max-height: 70vh;
            overflow-x: auto;
            border-radius: 0.5rem;
        }
    </style>
</head>
<body class="py-5 bg-light">

    <div class="container">
        <div class="card p-4">
            <h3>📊 عرض محتوى الجدول: <?php echo ($table_name) ?></h3>

            <div class="table-container mt-3">
                <table class="table table-hover table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <?php foreach ($fields as $field): ?>
                                <th><?php echo($field) ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($rows)): ?>
                            <?php foreach ($rows as $row): ?>
                                <tr>
                                    <?php foreach ($fields as $field): ?>
                                        <td><?php echo ($row[$field]) ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="<?= count($fields) ?>" class="text-center no-data">لا يوجد بيانات</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-4">
                <a href="<?= base_url('c/list_tables') ?>" class="btn btn-back">⬅️ رجوع إلى قائمة الجداول</a>
            </div>
        </div>
    </div>

</body>
</html>
