<?php $this->load->view('html/header'); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
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
                        location.reload(); // Or remove row from DOM
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
});
</script>



    <main class="nxl-container">
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Delivery</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item">Delivery</li>
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
                        



                        <a href="addsupplier" class="btn btn-primary">
                            <i class="feather-plus me-2"></i>
                            <span>Create Delivery</span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- [ page-header ] end -->
            <!-- [ Main Content ] start -->
            <div class="card stretch stretch-full shadow-lg border-0 mb-4">
                <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                    <h6 class="mb-0"><i class="feather-users me-2"></i>Delivery List</h6>
                    <span class="badge bg-light text-primary"><?php echo isset($Delivery) ? count($Delivery) : 0; ?> Suppliers</span>
                </div>
                <div class="card-body">
                              <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        
                                        <th>Delivery Name</th>
                                        <th>Delivery Cost</th>
                                        <th>Address</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($delivery)): ?>
                                        <?php foreach ($delivery as $a): ?>
                                            <tr>
                                                
                                                <td><?php echo $a->name; ?></td>
                                                <td><?php echo $a->cost; ?></td>
                                                <td><?php echo $a->address; ?></td>
                                                <td>
                                                <a href="editsuppliers?id=<?php echo $a->id; ?>" class="btn btn-warning">Edit</a>
                                                <a href="javascript:void(0);" 
                                                        class="btn btn-danger delete-btn" 
                                                        data-id="<?php echo $a->id; ?>" 
                                                        data-table="suppliers" 
                                                        data-url="<?php echo site_url('../cont/delete'); ?>">Delete</a>
                                                 </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center">No delivery found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
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