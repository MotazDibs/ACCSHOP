<?php $this->load->view('html/header'); ?>

<main class="nxl-container">
    <div class="nxl-content">

        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Add Word File</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= site_url('admin/index') ?>">Home</a></li>
                    <li class="breadcrumb-item active">file_add</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <div class="d-flex d-md-none">
                        <a href="javascript:void(0)" class="page-header-right-close-toggle">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Back</span>
                        </a>
                    </div>
                    <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                        <a href="<?= site_url('html/view_all_files') ?>" class="btn btn-primary">
                            <i class="feather-file-text"></i>
                            <span>View Files</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ page-header ] end -->

        <!-- [ Main Content ] start -->
        <div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
            <div class="main-content w-100" style="max-width: 600px;">
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <h3 class="mb-4 text-center">📄 رفع ملف Word</h3>

                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger"><?= $error ?></div>
                            <?php endif; ?>

                            <?php if (isset($success)): ?>
                                <div class="alert alert-success"><?= $success ?></div>
                                <?php if (isset($view_link)): ?>
                                    <div class="text-center mt-3">
                                        <a href="<?= $view_link ?>" class="btn btn-success">عرض المحتوى</a>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <form action="<?= site_url('../documents/upload') ?>" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label class="form-label">اختر ملف بصيغة DOCX:</label>
                                    <input type="file" name="word_file" class="form-control" accept=".docx" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">رفع وحفظ المحتوى</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->

    </div>
</main>

<?php $this->load->view('html/footer'); ?>
