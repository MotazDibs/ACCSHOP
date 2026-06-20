<?php $this->load->view('html/header'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('adminAddForm').addEventListener('input', function () {
        validateForm();
    });
    validateForm(); // Initial validation
});

// function validateForm() {
//     const name = document.getElementById('name').value.trim();
//     const password = document.getElementById('password').value;
//     const confirmPassword = document.getElementById('confirmPassword').value;
//     const address = document.getElementById('address').value.trim();
//     const submitBtn = document.getElementById('submitBtn');
//     const errorElement = document.getElementById('passwordError');

//     let isValid = true;

//     if (!name || !password || !confirmPassword || !address) {
//         isValid = false;
//     }

//     if (!password || !confirmPassword) {
//         errorElement.textContent = '';
//         errorElement.classList.remove('error', 'success');
//     } else if (password !== confirmPassword) {
//         errorElement.textContent = 'Passwords do not match';
//         errorElement.classList.remove('success');
//         errorElement.classList.add('error');
//         isValid = false;
//     } else {
//         errorElement.textContent = 'Passwords match';
//         errorElement.classList.remove('error');
//         errorElement.classList.add('success');
//     }

//     submitBtn.disabled = !isValid;
// }
</script>
<main class="nxl-container">
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">AddFile</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">file_add</li>
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
                        <a href="admin_view" class="btn btn-primary ">
                            <i class="feather-users"></i>
                            <span>View file</span>
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
                        <div class="row">
                            <form class="col-lg-12"  method="post" action="../Excel_reader/upload" enctype="multipart/form-data" id="adminAddForm">
                                <h5 class="mb-4">Add File</h5>
                                <div class="form-group col-md-12">
                                    <label for="example-text-input"   class="col-form-label">UploadExcelfile</label>

                                    <!--col No-->
                                    <input type="file" name="excel_file" class="form-control" required
                                          accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                              </div>
                                <div class="col-lg-12 text-center">
                                                                    <div class="submit-group">
                                    <div class="submit-group-text"><i class="submit-group-icon button"></i></div>
                                    <button type="submit" class="btn btn-primary" id="submitBtn" >Add Admin</button>
                                </div>

                                <?php if($this->session->flashdata('msg')): ?>
                                    <script>alert("<?php echo $this->session->flashdata('msg'); ?>");</script>
                                <?php endif; ?>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</main>
<?php $this->load->view('html/footer'); ?>
