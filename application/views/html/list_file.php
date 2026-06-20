<?php $this->load->view('html/header'); ?>

<style>
    body {
        background-color: #f8f9fa;
        font-size: 1.2rem;
    }

    h2, h5 {
        font-weight: 700;
        font-size: 2rem;
    }

    .table thead th {
        background: linear-gradient(to right, #0d6efd, #0a58ca);
        color: white;
        font-size: 1.15rem;
    }

    .table td, .table th {
        vertical-align: middle !important;
        font-size: 1.1rem;
        padding: 1rem;
    }

    .btn-custom {
        background: linear-gradient(to right, #198754, #0f5132);
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 1rem;
        border-radius: 0.5rem;
        margin: 0 3px;
        text-decoration: none;
        display: inline-block;
    }

    .btn-custom:hover {
        opacity: 0.9;
    }

    .breadcrumb-item a {
        text-decoration: none;
        color: #0d6efd;
        font-weight: 500;
    }

    .no-data {
        font-size: 1.2rem;
        color: #6c757d;
    }

    .full-center {
        min-height: calc(100vh - 150px); /* مساحة كافية للهيدر */
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .card {
        width: 100%;
        max-width: 1200px;
        padding: 20px;
        border-radius: 1rem;
        border: 1px solid #dee2e6;
    }

    .card-body {
        padding: 1.5rem;
    }

    .page-header {
        padding: 20px 0;
        border-bottom: 2px solid #dee2e6;
        background-color: white;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    @media (max-width: 768px) {
        .table thead {
            font-size: 1rem;
        }
        .table td, .table th {
            font-size: 0.95rem;
        }
        h2, h5 {
            font-size: 1.5rem;
        }
    }
</style>

<main class="container py-4">
    <!-- مركز المحتوى في منتصف الصفحة -->
    <div class="full-center">
        <div class="card shadow-sm bg-white">
            <div class="card-body">
                <h5 class="mb-4 text-center">🗂 قائمة ملفات الوورد المرفوعة</h5>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered text-center align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>📎 الاسم الأصلي</th>
                                <th>📂 اسم الجدول</th>
                                <th>🕓 تاريخ الرفع</th>
                                <th>⚙ الإجراءات</th>
                            </tr>
                        </thead>  
                        <tbody>
                            <?php if (!empty($tables)): ?>
                                <?php foreach ($tables as $index => $file): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= htmlspecialchars($file->filename) ?></td>
                                        <td><?= htmlspecialchars($file->table_name) ?></td>
                                         <td><?= htmlspecialchars($file->uploaded_at) ?></td>

                                        <td>
                                            <a href="<?php echo ('../documents/view_file/' . $file->table_name) ?>" class="btn-custom">👁 عرض</a>
                                            <a href="<?php echo ('../documents/download_file/' . $file->table_name) ?>" class="btn-custom"> تنزيل</a>
                                            <a href="<?php echo base_url('documents/edit_file/' . $file->table_name); ?>" class="btn-custom" style="background: linear-gradient(to right, #0d6efd, #0a58ca);">✏️ تعديل</a>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center no-data">لا توجد ملفات وورد مرفوعة بعد.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <br>
                <a href="<?= base_url('c/addword') ?>" class="btn-custom" style="background: linear-gradient(to right, #ffc107, #e0a800);">
                    📤 رفع ملف وورد جديد
                </a>
            </div>
        </div>
    </div>
</main>

<?php $this->load->view('html/footer'); ?>