<?php $this->load->view('html/header'); ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const productSelect = document.getElementById("products");
    const quantityInput = document.getElementById("numofproduct");
    const costInput = document.getElementById("cost");
    const apayInput = document.getElementById("apay");
    const profitInput = document.getElementById("actualprofit");
    const expectedProfitInput = document.getElementById("total");
    const payInput = document.getElementById("pay");

    const enableDeliveryCheckbox = document.getElementById("enableDelivery");
    const deliverySection = document.getElementById("deliverySection");
    const deliveryLocationSelect = document.getElementById("delivery_location");
    const deliveryCostInput = document.getElementById("delivery_cost");

    let unitCost = 0;
    let unitPay = 0;
    let deliveryCost = 0;

    function updateCalculations() {
        const qty = parseFloat(quantityInput.value) || 0;
        const baseCost = unitCost * qty;
        const totalCost = baseCost + deliveryCost;
        const totalPay = unitPay * qty;
        const actualProfit = totalPay - totalCost;

        costInput.value = totalCost.toFixed(2);
        apayInput.value = totalPay.toFixed(2);
        profitInput.value = actualProfit.toFixed(2);

        updateExpectedProfit();
    }

    function updateExpectedProfit() {
        const pay = parseFloat(payInput.value) || 0;
        const cost = parseFloat(costInput.value) || 0;
        const expectedProfit = pay - cost;

        expectedProfitInput.value = expectedProfit.toFixed(2);

        updateProfitColors();
        updateExpectedColors();
    }

    function updateProfitColors() {
        const actual = parseFloat(profitInput.value) || 0;
        const expected = parseFloat(expectedProfitInput.value) || 0;

        if (actual >= expected) {
            profitInput.style.backgroundColor = "#d4edda";
            profitInput.style.color = "#155724";
        } else {
            profitInput.style.backgroundColor = "#f8d7da";
            profitInput.style.color = "#721c24";
        }
    }

    function updateExpectedColors() {
        const actual = parseFloat(profitInput.value) || 0;
        const expected = parseFloat(expectedProfitInput.value) || 0;

        if (expected > actual) {
            expectedProfitInput.style.backgroundColor = "#d4edda";
            expectedProfitInput.style.color = "#155724";
        } else if (expected < actual) {
            expectedProfitInput.style.backgroundColor = "#f8d7da";
            expectedProfitInput.style.color = "#721c24";
        } else {
            expectedProfitInput.style.backgroundColor = "";
            expectedProfitInput.style.color = "";
        }
    }

    productSelect.addEventListener("change", function () {
        const selectedOption = this.options[this.selectedIndex];
        unitCost = parseFloat(selectedOption.getAttribute("data-cost")) || 0;
        unitPay = parseFloat(selectedOption.getAttribute("data-pay")) || 0;
        updateCalculations();
    });

    quantityInput.addEventListener("input", updateCalculations);
    payInput.addEventListener("input", updateExpectedProfit);

    enableDeliveryCheckbox.addEventListener("change", function () {
        if (this.checked) {
            deliverySection.style.display = "flex";
            if (deliveryLocationSelect.value === "") {
                deliveryLocationSelect.selectedIndex = 1;
                updateDeliveryCost();
            }
        } else {
            deliverySection.style.display = "none";
            deliveryCost = 0;
            deliveryCostInput.value = "0";
            updateCalculations();
        }
    });

    deliveryLocationSelect.addEventListener("change", function () {
        updateDeliveryCost();
    });

    function updateDeliveryCost() {
        const selectedOption = deliveryLocationSelect.options[deliveryLocationSelect.selectedIndex];
        deliveryCost = parseFloat(selectedOption.getAttribute("data-price")) || 0;
        deliveryCostInput.value = deliveryCost.toFixed(2);
        updateCalculations();
    }

    updateCalculations();
});
</script>

<main class="nxl-container">
    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Orders</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">order_add</li>
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

        <div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
            <div class="main-content w-100" style="max-width: 900px;">
                <div class="card" style="font-size: 1.3rem; padding: 2rem;">
                    <div class="card-body">
                        <form class="col-lg-12" method="post" action="../Cont/addorder" enctype="multipart/form-data" id="supplierAddForm">
                            <h5 class="mb-4">Add order</h5>

                            <div class="row mb-4 align-items-center">
                                <div class="col-lg-4">
                                    <label for="products" class="fw-semibold">Product Name: </label>
                                </div>
                                <div class="col-lg-8">
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="feather-shopping-cart"></i></div>
                                        <select class="form-select" id="products" name="products" required style="font-size:1.2rem; min-height:48px;">
                                            <option value="0" selected disabled>Select Product</option>
                                            <?php foreach ($products as $k): ?>
                                                <option value="<?= $k->id ?>" data-cost="<?= $k->cost ?>" data-pay="<?= $k->pay ?>">
                                                    <?= $k->product ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4 align-items-center">
                                <div class="col-lg-4">
                                    <label class="fw-semibold">Add Delivery?</label>
                                </div>
                                <div class="col-lg-8">
                                    <input type="checkbox" id="enableDelivery" class="form-check-input">
                                </div>
                            </div>

                            <div class="row mb-4 align-items-center" id="deliverySection" style="display:none; flex-wrap: nowrap;">
                                <div class="col-lg-4">
                                    <label for="delivery_location" class="fw-semibold">Delivery Location:</label>
                                </div>
                                <div class="col-lg-8">
                                    <select class="form-select" id="delivery_location" name="delivery_location" style="font-size:1.2rem; min-height:48px;">
                                        <option value="" disabled selected>Select Location</option>
                                        <?php foreach ($address as $d): ?>
                                            <option value="<?= $d->id ?>" data-price="<?= $d->cost ?>">
                                                <?= $d->address ?> (<?= $d->cost ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <input type="hidden" id="delivery_cost" name="delivery_cost" value="0">

                            <div class="row mb-4 align-items-center">
                                <div class="col-lg-4">
                                    <label for="client" class="fw-semibold">Client Name: </label>
                                </div>
                                <div class="col-lg-8">
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="feather-user"></i></div>
                                        <input type="text" class="form-control" id="client" name="client" placeholder="client name" required style="font-size:1.2rem; min-height:48px;">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4 align-items-center">
                                <div class="col-lg-4">
                                    <label for="numofproduct" class="fw-semibold">Number of Products: </label>
                                </div>
                                <div class="col-lg-8">
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="feather-hash"></i></div>
                                        <input type="number" class="form-control mt-2" id="numofproduct" name="numofproduct" placeholder="Number of Products" required style="font-size:1.2rem; min-height:48px;">
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
                                        <input type="text" class="form-control" id="pay" name="pay" placeholder="pay" required style="font-size:1.2rem; min-height:48px;">
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
                                        <input type="text" class="form-control mt-2" id="cost" name="cost" placeholder="Total Cost" readonly required style="font-size:1.2rem; min-height:48px;">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4 align-items-center">
                                <div class="col-lg-4">
                                    <label for="apay" class="fw-semibold">Actual Pay: </label>
                                </div>
                                <div class="col-lg-8">
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="feather-framer"></i></div>
                                        <input type="text" class="form-control mt-2" id="apay" name="apay" placeholder="Total Selling Price" readonly required style="font-size:1.2rem; min-height:48px;">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4 align-items-center">
                                <div class="col-lg-4">
                                    <label for="total" class="fw-semibold">Expected Profit: </label>
                                </div>
                                <div class="col-lg-8">
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="feather-stop-circle"></i></div>
                                        <input type="text" class="form-control" id="total" name="total" placeholder="Expected profit" required style="font-size:1.2rem; min-height:48px;">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4 align-items-center">
                                <div class="col-lg-4">
                                    <label for="actualprofit" class="fw-semibold">The Actual Profit: </label>
                                </div>
                                <div class="col-lg-8">
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="feather-shopping-bag"></i></div>
                                        <input type="text" class="form-control mt-2" id="actualprofit" name="actualprofit" placeholder="Actual Profit" readonly required style="font-size:1.2rem; min-height:48px;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 text-center">
                                <button type="submit" class="btn btn-primary" id="submitBtn" style="font-size:1.2rem; min-width:180px; min-height:48px;">Add Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $this->load->view('html/footer'); ?>
