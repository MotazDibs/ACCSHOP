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
document.addEventListener('DOMContentLoaded', function () {
    var costInput = document.getElementById('cost');
    var priceInput = document.getElementById('pay');
    var submitBtn = document.getElementById('submitBtn');
    var priceError = document.getElementById('priceError');
    var form = document.getElementById('addProductForm');

    function validatePrice() {
        var cost = parseFloat(costInput.value) || 0;
        var price = parseFloat(priceInput.value) || 0;
        if (price < cost) {
            priceError.style.display = 'block';
            submitBtn.disabled = true;
        } else {
            priceError.style.display = 'none';
            submitBtn.disabled = false;
        }
    }

    costInput.addEventListener('input', validatePrice);
    priceInput.addEventListener('input', validatePrice);

    form.addEventListener('submit', function(e) {
        var cost = parseFloat(costInput.value) || 0;
        var price = parseFloat(priceInput.value) || 0;
        if (price < cost) {
            e.preventDefault();
            priceError.style.display = 'block';
            submitBtn.disabled = true;
        }
    });
});
</script>
<main class="nxl-container">
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Products</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">products_add</li>
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
                        <a href="products" class="btn btn-primary ">
                            <i class="feather-users"></i>
                            <span>View products</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ page-header ] end -->
        <!-- [ Main Content ] start -->
        <div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
            <div class="main-content w-100" style="max-width: 800px;">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <form class="col-lg-12"  method="post" action="../Cont/addproducts" enctype="multipart/form-data" id="productsAddForm">
                                <h5 class="mb-4">Add products</h5>
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label for="supplier" class="fw-semibold">Products Name: </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="feather-user"></i></div>
                                            <input type="text" class="form-control" id="products" name="products" placeholder="Products Name" required>
                                             <input type="text" class="form-control" id="id" name="id" placeholder="ID" required value="0" style="display: none;">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label for="num" class="fw-semibold">Product-Num: </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="feather-hash"></i></div>
                                            <input type="text" class="form-control" id="num" name="num" placeholder="num" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label for="pay" class="fw-semibold">Pay: </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="feather-credit-card"></i></div>
                                            <input type="text" class="form-control" id="pay" name="pay" placeholder="Pay" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label for="cost" class="fw-semibold">Cost: </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="feather-dollar-sign"></i></div>
                                            <input type="text" class="form-control" id="cost" name="cost" placeholder="Cost" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label for="suppliers" class="fw-semibold">Suppliers: </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="feather-truck"></i></div>
                                                <select class="form-select" id="suppliers" name="suppliers" required>
                                                    <option value="0" selected disabled>Select Supplier</option>
                                                    <?php foreach ($suppliers as $k): ?>
                                                        <option value="<?php echo $k->id; ?>"><?php echo $k->supplier; ?></option>
                                                    <?php endforeach; ?>
                                                </select>

                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label for="image" class="fw-semibold">Products Image: </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="feather-image"></i></div>
                                            <input type="file" class="form-control" id="image" name="image"  required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 text-center">
                                    <div class="submit-group">
                                        <div class="submit-group-text"><i class="submit-group-icon button"></i></div>
                                        <button type="submit" class="btn btn-primary" id="submitBtn" >Add Products</button>
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
