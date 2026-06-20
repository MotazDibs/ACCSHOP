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

document.addEventListener("DOMContentLoaded", function () {
    const payInput = document.getElementById("pay");
    const costInput = document.getElementById("cost");
    const totalInput = document.getElementById("total");

    function updateTotal() {
        // Convert values to floats, default to 0 if not a valid number
        const pay = parseFloat(payInput.value) || 0;
        const cost = parseFloat(costInput.value) || 0;
        const total = pay + cost;
        totalInput.value = total.toFixed(2); // show as 2 decimal places
    }

    // Listen for input on both fields
    payInput.addEventListener("input", updateTotal);
    costInput.addEventListener("input", updateTotal);
});


</script>
<main class="nxl-container">
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Orders</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">order_edit</li>
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
                        <a href="order" class="btn btn-primary ">
                            <i class="feather-users"></i>
                            <span>View order</span>
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
                             <?php foreach ($orders as $o): ?>
                            <form class="col-lg-12"  method="post" action="../Cont/editorder" enctype="multipart/form-data" id="supplierAddForm">
                                <h5 class="mb-4">Edit order</h5>
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label for="products" class="fw-semibold">Product Name: </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="feather-shopping-cart"></i></div>
                                                <select class="form-select" id="products" name="products" required>
                                                    <option value="0" selected disabled><?php echo $o->product;?></option>
                                                    <?php foreach ($products as $p): ?>
                                                    <option value="<?php echo $p->id; ?>" <?php if ($p->id == $o->product) echo 'selected'; ?>>
                                                        <?php echo htmlspecialchars($p->product); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                                </select>
                                            <input type="hidden" class="form-control" id="id" name="id" placeholder="ID" required value="<?php echo htmlspecialchars($o->id); ?>" style="display: none;">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label for="client" class="fw-semibold">Client Name: </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="feather-user"></i></div>
                                            <input type="text" class="form-control" id="client" name="client" placeholder="client name" value="<?php echo htmlspecialchars($o->client); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                
                                </div>
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label for="numofproduct" class="fw-semibold">numofproduct: </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="feather-hash"></i></div>
                                            <input type="text" class="form-control" id="numofproduct" name="numofproduct" placeholder="numofproduct" value="<?php echo htmlspecialchars($o->numofproduct); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label for="pay" class="fw-semibold">pay: </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="feather-credit-card"></i></div>
                                            <input type="text" class="form-control" id="pay" name="pay" placeholder="pay" value="<?php echo htmlspecialchars($o->pay); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label for="cost" class="fw-semibold">cost: </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="feather-dollar-sign"></i></div>
                                           <input type="text" class="form-control mt-2" id="cost" name="cost" placeholder="Total Cost" value="<?php echo htmlspecialchars($o->cost); ?>" readonly required style="font-size:1.2rem; min-height:48px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label for="pay" class="fw-semibold"> actual pay: </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="feather-framer"></i></div>
                                            <input type="text" class="form-control mt-2" id="apay" name="apay" placeholder="Total Selling Price" value="<?php echo htmlspecialchars($o->epay); ?>" readonly required style="font-size:1.2rem; min-height:48px;">
                                        </div>
                                    </div>
                                </div>
                                 <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label for="total" class="fw-semibold">Expected profit: </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="feather-stop-circle"></i></div>
                                            <input type="text" class="form-control" id="total" name="total" placeholder="Expected profit" value="<?php echo htmlspecialchars($o->total); ?>" required style="font-size:1.2rem; min-height:48px;">
                                        </div>
                                    </div>
                                </div>
                                 
                                 <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label for="pay" class="fw-semibold">The actual profit: </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="feather-shopping-bag"></i></div>
                                            <input type="text" class="form-control mt-2" id="actualprofit" name="actualprofit" placeholder="Actual Profit" value="<?php echo htmlspecialchars($o->actualprofit); ?>" readonly required style="font-size:1.2rem; min-height:48px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-center">
                                    <div class="submit-group">
                                        <div class="submit-group-text"><i class="submit-group-icon button"></i></div>
                                        <button type="submit" class="btn btn-primary" id="submitBtn" >edit Order</button>
                                    </div>
                                </div>
                            </form>
                             <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</main>
<?php $this->load->view('html/footer'); ?>
