<?php $this->load->view('html/header'); ?>

<script>
window.onload = function () {
    colorProfitComparison();
    calculatePayTotal();
    calculateCostTotal();
    calculateActualPayTotal();
    calculateTotalExpected();
    calculateTotalActual();
    setupDeleteButtons();
    printInvoice();
};

function colorProfitComparison() {
    const rows = document.querySelectorAll("#dataTable tbody tr");

    rows.forEach(row => {
        const expectedCell = row.querySelector(".expected");
        const actualCell = row.querySelector(".actual");

        if (expectedCell && actualCell) {
            const expected = parseFloat(expectedCell.textContent) || 0;
            const actual = parseFloat(actualCell.textContent) || 0;

            if (expected > actual) {
                expectedCell.style.backgroundColor = "#d4edda";  // أخضر فاتح
                expectedCell.style.color = "#155724";

                actualCell.style.backgroundColor = "#f8d7da";    // أحمر فاتح
                actualCell.style.color = "#721c24";
            } else {
                expectedCell.style.backgroundColor = "#f8d7da";  // أحمر فاتح
                expectedCell.style.color = "#721c24";

                actualCell.style.backgroundColor = "#d4edda";    // أخضر فاتح
                actualCell.style.color = "#155724";
            }
        }
    });
}

function setupDeleteButtons() {
    const buttons = document.querySelectorAll('.delete-btn');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const url = this.getAttribute('data-url');
            const table = this.getAttribute('data-table');

            if (!confirm("Are you sure you want to delete this item?")) return;

            const xhr = new XMLHttpRequest();
            xhr.open("POST", url + '/' + table, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onload = function () {
                if (xhr.status === 200) {
                    const res = JSON.parse(xhr.responseText);
                    if (res.success) {
                        location.reload();
                    } else {
                        alert("Failed to delete: " + res.message);
                    }
                } else {
                    alert("Server error occurred");
                }
            };

            xhr.send("id=" + encodeURIComponent(id));
        });
    });
}

function calculatePayTotal() {
    let total = 0;
    document.querySelectorAll("#dataTable .pay").forEach(cell => {
        total += parseFloat(cell.textContent) || 0;
    });
    document.getElementById("totalpay").value = total.toFixed(2);
}

function calculateActualPayTotal() {
    let total = 0;
    document.querySelectorAll("#dataTable .epay").forEach(cell => {
        total += parseFloat(cell.textContent) || 0;
    });
    document.getElementById("totalepay").value = total.toFixed(2);
}

function calculateCostTotal() {
    let total = 0;
    document.querySelectorAll("#dataTable .cost").forEach(cell => {
        total += parseFloat(cell.textContent) || 0;
    });
    document.getElementById("totalcost").value = total.toFixed(2);
}

function calculateTotalExpected() {
    let total = 0;
    document.querySelectorAll("#dataTable .expected").forEach(cell => {
        total += parseFloat(cell.textContent) || 0;
    });
    document.getElementById("totalexpected").value = total.toFixed(2);
}

function calculateTotalActual() {
    let total = 0;
    document.querySelectorAll("#dataTable .actual").forEach(cell => {
        total += parseFloat(cell.textContent) || 0;
    });
    document.getElementById("totalactual").value = total.toFixed(2);
}

function filterTable() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    const rows = document.querySelectorAll("#dataTable tbody tr");

    rows.forEach(row => {
        const isFooterRow = row.querySelector("input"); // Skip total row
        if (isFooterRow) return;

        const rowText = row.textContent.toLowerCase();
        row.style.display = rowText.includes(input) ? "" : "none";
    });


function printInvoice(button) {
    const row = button.parentElement.parentElement;
    const cells = row.querySelectorAll('td');

    const product = cells[0].innerText;
    const client = cells[1].innerText;
    const pieces = cells[2].innerText;
    const pay = cells[3].innerText;
    const cost = cells[4].innerText;
    const actualPay = cells[5].innerText;
    const actualProfit = cells[7].innerText;
    const date = cells[8].innerText;

    const win = window.open('', '_blank');
    win.document.write(`
        <html>
        <head>
            <title>Invoice</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                h2 { text-align: center; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #000; padding: 10px; text-align: left; }
                th { background-color: #f2f2f2; width: 30%; }
            </style>
        </head>
        <body>
            <h2>فاتورة بيع</h2>
            <table>
                <tr><th>التاريخ</th><td>${date}</td></tr>
                <tr><th>العميل</th><td>${client}</td></tr>
                <tr><th>المنتج</th><td>${product}</td></tr>
                <tr><th>العدد</th><td>${pieces}</td></tr>
                <tr><th>سعر الشراء</th><td>${cost}</td></tr>
                <tr><th>سعر الدفع</th><td>${pay}</td></tr>
                <tr><th>الربح الفعلي</th><td>${actualProfit}</td></tr>
            </table>
            <p style="text-align:center; margin-top: 40px;">شكرًا لتعاملكم معنا!</p>
        </body>
        </html>
    `);
    win.document.close();
    win.print();
}
}
</script>




    <main class="nxl-container">
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Order</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item">Oreder</li>
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
                        



                        <a href="addorder" class="btn btn-primary">
                            <i class="feather-plus me-2"></i>
                            <span>Create Order</span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- [ page-header ] end -->
            <!-- [ Main Content ] start -->
            <div class="card stretch stretch-full shadow-lg border-0 mb-4">
                <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                    <h6 class="mb-0"><i class="feather-users me-2"></i>Order List</h6>
                    <span class="badge bg-light text-primary"><?php echo isset($orders) ? count($orders) : 0; ?> Orders</span>
                </div>
                <div class="card-body">
                              <input type="text" id="searchInput" class="form-control mb-3" placeholder="🔍 Search in table..." onkeyup="filterTable()">
                              <table class="table table-striped table-bordered" id="dataTable">
                                <thead>
                                    <tr>
                                        
                                        <th>product</th>
                                        <th>client</th>
                                        <th>piecs</th>
                                        <th>pay</th>
                                        <th>cost</th>
                                        <th>actual pay</th>
                                        <th>Expected profit</th>
                                        <th>actual profit</th>
                                        <th>Date(YYYY-MM-DD HH-MM-SS)</th>
                                        <th>delivery_location</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($orders)): ?>
                                        <?php foreach ($orders as $o): ?>
                                            <tr>
                                                
                                                <td><?php echo $this->model->get_model_where('products','id',$o->product,'product'); ?></td>
                                                <td><?php echo $o->client; ?></td>
                                                <td><?php echo $o->numofproduct; ?></td>
                                                <td class="pay"><?php echo $o->pay; ?></td>
                                                <td class="cost"><?php echo $o->cost; ?></td>
                                                <td class="epay"><?php echo $o->epay; ?></td>
                                                <td class="expected"><?php echo $o->total; ?></td>
                                                <td class="actual"><?php echo $o->actualprofit; ?></td>
                                                <td style="width:14%"><?php echo $o->date; ?></td>
                                                 <td>
                                                <?php 
                                                    if (!empty($o->delivery_location)) {
                                                        $deliveryLocation = $this->model->get_model_where('delivery', 'id', $o->delivery_location, 'address');
                                                        echo $deliveryLocation ? $deliveryLocation : '-'; 
                                                    } else {
                                                        echo '-';
                                                    }
                                                ?>
                                                </td>
                                                <td>
                                                <a href="editorder?id=<?php echo $o->id; ?>" class="btn btn-warning">Edit</a>
                                                <a href="javascript:void(0);" 
                                                        class="btn btn-danger delete-btn" 
                                                        data-id="<?php echo $o->id; ?>" 
                                                        data-table="orders" 
                                                        data-url="<?php echo site_url('../cont/delete'); ?>">Delete</a>
                                                <button class="btn btn-success" style="width:100%" onclick="printInvoice(this)">🖨️ Print Invoice</button>  
        
                                                 </td>
                                            </tr>
                                            
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center">No suppliers found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot>
                                            <tr>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td style="width: 7%;"><label class="fw-semibold">Total of Pay  </label>
                                                    <input type="text" id="totalpay" class="form-control"  readonly ></td>
                                                <td style="width: 7%;"><label class="fw-semibold">Total of cost  </label>
                                                    <input type="text" id="totalcost" class="form-control" readonly>
                                                <td style="width: 8%;"><label class="fw-semibold">Total of actual pay  </label>
                                                    <input type="text" id="totalepay" class="form-control" readonly>
                                                 <td style="width: 10%;"><label class="fw-semibold">Total of expected profit </label>
                                                    <input type="text" id="totalexpected" class="form-control" readonly>
                                                <td style="width: 10%;"><label class="fw-semibold">Total of expected profit </label>
                                                    <input type="text" id="totalactual" class="form-control" readonly>
                                                <td>-</td>
                                                <td>-</td>

                                            </tr>
                                            </tfoot>
                            </table>
                            

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!--! ================================================================ !-->
    <!--! [End] Main Content !-->
    <!--! ================================================================ !-->
   <?php $this->load->view('html/footer'); ?>
    <!--! ================================================================ !-->