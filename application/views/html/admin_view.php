<?php $this->load->view('html/header'); ?>
    <!--! ================================================================ !-->
    <!--! [Start] Main Content !-->
    <!--! ================================================================ !-->
    <script>
//delete script ajax
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
                        <h5 class="m-b-10">Admin</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item">admin_view</li>
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
                            
                            <a href="admin_add" class="btn btn-primary">
                                <i class="feather-plus me-2"></i>
                                <span>Add Admin</span>
                            </a>
                        </div>
                    </div>
                    <div class="d-md-none d-flex align-items-center">
                        <a href="javascript:void(0)" class="page-header-right-open-toggle">
                            <i class="feather-align-right fs-20"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- [ page-header ] end -->
            <!-- [ Main Content ] start -->
            
                               
                                
                       
                           
                        <div class="card stretch stretch-full shadow-lg border-0 rounded-4 bg-light">
                            <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between rounded-top-4">
                                <h6 class="mb-0">
                                    <i class="feather-users me-2"></i>
                                    Admin List
                                </h6>
                                <span class="badge bg-white text-primary fw-bold px-3 py-2">
                                    <?php echo isset($admins) ? count($admins) : 0; ?> Admins
                                </span>
                            </div>
                            <div class="card-body p-4">
                              <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Password</th>
                                        <th>Address</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr> 
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                    <?php foreach ($admins as $admin): ?>
                                    <tr>
                                        <td><?php echo $admin->name; ?></td>
                                        <td><?php echo $admin->password; ?></td>
                                        <td><?php echo $admin->address; ?></td>
                                        <td>
                                            <a href="editadmin?id=<?php echo $admin->id; ?>" class="btn btn-warning">Edit</a>
                                           <a href="javascript:void(0);" 
                                                class="btn btn-danger delete-btn" 
                                                data-id="<?php echo $admin->id; ?>" 
                                                data-table="admins" 
                                                data-url="<?php echo site_url('../cont/delete'); ?>">Delete</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                        
                           
                            </div>
                            
                        
        <!-- [ Footer ] end -->
    </main>
    <!--! ================================================================ !-->
    <!--! [End] Main Content !-->
    <!--! ================================================================ !-->
   <?php $this ->load->view('html/footer'); ?>
  