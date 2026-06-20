<?php $this->load->view('html/header'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('adminAddForm').addEventListener('input', function () {
        validateForm();
    });
    validateForm(); // Initial validation
});

function validateForm() {
    const name = document.getElementById('name').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const address = document.getElementById('address').value.trim();
    const submitBtn = document.getElementById('submitBtn');
    const errorElement = document.getElementById('passwordError');

    let isValid = true;

    submitBtn.disabled = !isValid;
}
</script>
<main class="nxl-container">
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Supplier</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">supplier_add</li>
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
                        <a href="supplier" class="btn btn-primary ">
                            <i class="feather-users"></i>
                            <span>View Supplier</span>
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
                            <form class="col-lg-12"  method="post" action="../Cont/addsupplier" enctype="multipart/form-data" id="supplierAddForm">
                                <h5 class="mb-4">Add supplier</h5>
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label for="supplier" class="fw-semibold">Supplier Name: </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="feather-user"></i></div>
                                            <input type="text" class="form-control" id="supplier" name="supplier" placeholder="Supplier Name" required>
                                             <input type="text" class="form-control" id="id" name="id" placeholder="ID" required value="0" style="display: none;">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label for="phone" class="fw-semibold">Phone: </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="feather-lock"></i></div>
                                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" required>
                                        </div>
                                    </div>
                                </div>
                                
                                </div>
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label for="address" class="fw-semibold">Address: </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="feather-map-pin"></i></div>
                                            <input type="text" class="form-control" id="address" name="address" placeholder="address" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-center">
                                    <div class="submit-group">
                                        <div class="submit-group-text"><i class="submit-group-icon button"></i></div>
                                        <button type="submit" class="btn btn-primary" id="submitBtn" >Add Supplier</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</main>
<?php $this->load->view('html/footer'); ?>
