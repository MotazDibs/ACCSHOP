<?php $this->load->view('html/header'); ?>

<main class="nxl-container">
    <div class="nxl-content">

        <!-- Page Header -->
        <div class="page-header mb-4">
            <h5 class="text-primary fw-bold">
                <i class="fa-solid fa-truck-field"></i> Supplier & Product Breakdown
            </h5>
            <span class="badge bg-primary text-white">
                <?= isset($grouped_suppliers) ? count($grouped_suppliers) : 0 ?> Suppliers
            </span>
        </div>

        <?php if (!empty($grouped_suppliers)): ?>
            <?php foreach ($grouped_suppliers as $supplier): ?>
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary text-white fw-bold">
                        <i class="fa-solid fa-user"></i> <?= $supplier['supplier_name'] ?>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($supplier['products'])): ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered align-middle text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Cost</th>
                                            <th>Pay</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($supplier['products'] as $product): ?>
                                            <tr>
                                                <td class="fw-semibold"><?= $product['product_name'] ?></td>
                                                <td class="text-danger"><?= number_format($product['cost'], 2) ?></td>
                                                <td class="text-success"><?= number_format($product['pay'], 2) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning text-center m-0">No products available for this supplier.</div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-warning text-center">No suppliers found.</div>
        <?php endif; ?>
    </div>
</main>

<?php $this->load->view('html/footer'); ?>
