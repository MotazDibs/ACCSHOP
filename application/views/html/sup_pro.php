<?php $this->load->view('html/header'); ?>

<script>
function del(d, t) {
    $.ajax({
        url: "../cont/delete",
        type: "GET",
        data: { 'id': d, 't': t },
        success: function(data) {
            console.log('deleted');
            location.reload();
        }
    });
}
</script>

<main class="nxl-container">
    <div class="nxl-content">

        <div class="page-header mb-4">
            <h5>Supplier's Products: <?php echo $supplier_name[0]->supplier ?? 'Unknown'; ?></h5>
            <a href="<?= site_url('../c/supplier_info') ?>" class="btn btn-secondary mb-3">Back to All Products</a>
        </div>

        <?php if (!empty($products)): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>products-number</th>
                            <th>Cost</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <?php
                                $img = !empty($product->file) ? $product->file : 'user.jpeg';
                                $img_path = base_url('assest/uploads/' . $img);
                            ?>
                            <tr>
                                <td style="width:80px;">
                                    <img src="<?= $img_path ?>" alt="image" style="width:70px; height:70px; object-fit:cover; border-radius:6px;">
                                </td>
                                <td><?php echo $product->product ?></td>
                                <td><?php echo $product->num ?></td>
                                <td><?php echo $product->cost ?></td>
                                <td><?php echo $product->pay ?></td>
                                <td style="width:150px;">
                                    <a href="<?= 'edit_product?id=' . $product->id ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <button class="btn btn-sm btn-danger" onclick="del(<?= $product->id ?>, 'products')" style="width:100%">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">No products found for this supplier.</div>
        <?php endif; ?>

    </div>
</main>

<?php $this->load->view('html/footer'); ?>
