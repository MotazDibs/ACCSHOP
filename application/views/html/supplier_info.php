<?php $this->load->view('html/header'); ?>

<main class="nxl-container">
    <div class="nxl-content">

        <!-- Page Header -->
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="m-0 text-primary fw-bold">Suppliers and Product Statistics</h5>
                <ul class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Home</a></li>
                    <li class="breadcrumb-item active">Suppliers</li>
                </ul>
            </div>
            <span class="badge bg-primary text-white fs-6">
                <?= isset($suppliers_summary) ? count($suppliers_summary) : 0 ?> Suppliers
            </span>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <input type="text" id="searchInput" class="form-control mb-3" placeholder="🔍 Search suppliers..." onkeyup="filterTable()">

                <?php if (!empty($suppliers_summary)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle text-center" id="dataTable">
                            <thead class="table-primary">
                                <tr>
                                    <th>Supplier Name</th>
                                    <th>Product Count</th>
                                    <th>Total Cost</th>
                                    <th>Total Pay</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($suppliers_summary as $row): ?>
                                    <tr>
                                        <td>
                                            <a href="<?= base_url('c/sup_pro?id=' . $row->supplier_id) ?>" class="fw-semibold text-decoration-none text-primary">
                                                <?= $row->supplier_name ?>
                                            </a>
                                        </td>
                                        <td><?= $row->product_count ?></td>
                                        <td class="total-cost"><?= number_format($row->total_cost, 2) ?></td>
                                        <td class="total-pay"><?= number_format($row->total_price, 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning text-center">No data available to display.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<script>
function filterTable() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    const rows = document.querySelectorAll("#dataTable tbody tr");

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(input) ? "" : "none";
    });
}

// Color only the cost and pay cells
// Color only the pay cell based on comparison
window.onload = function () {
    const rows = document.querySelectorAll("#dataTable tbody tr");

    rows.forEach(row => {
        const costCell = row.querySelector(".total-cost");
        const payCell = row.querySelector(".total-pay");

        const cost = parseFloat(costCell?.textContent.replace(/,/g, '') || 0);
        const pay = parseFloat(payCell?.textContent.replace(/,/g, '') || 0);

        if (pay < cost) {
            payCell.style.backgroundColor = "#f8d7da"; // أحمر
            payCell.style.color = "#721c24";           // نص أحمر
        } else if (pay > cost) {
            payCell.style.backgroundColor = "#d4edda"; // أخضر
            payCell.style.color = "#155724";           // نص أخضر
        }
    });
};


</script>


<?php $this->load->view('html/footer'); ?>
