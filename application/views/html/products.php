<?php $this->load->view('html/header'); ?>
    <!--! ================================================================ !-->
    <!--! [Start] Main Content !-->
    <!--! ================================================================ !-->
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
                        <li class="breadcrumb-item">products_view</li>
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
                            
                            <a href="addproducts" class="btn btn-primary">
                                <i class="feather-plus me-2"></i>
                                <span>Add Product</span>
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
                                    Products List
                                </h6>
                                <span class="badge bg-white text-primary fw-bold px-3 py-2">
                                    <?php echo isset($products) ? count($products) : 0; ?> Products
                                </span>
                            </div>
                            <div class="card-body p-4">
                              <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>product</th>
                                        <th>num</th>
                                        <th>suplierid</th>
                                        <th>pay</th>
                                        <th>cost</th>
                                        <th>Image</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        
                                        
                                    </tr>
                                    <?php foreach ($products as $product): ?>
                                    <tr>
                                        
                                        <td><?php echo $product->product; ?></td>
                                        <td><?php echo $product->num; ?></td>
                                        <td><?php echo  $this->model->get_model_where('suppliers','id',$product->supplierid,'supplier'); ?></td>
                                        <td><?php echo $product->pay; ?></td>
                                        <td><?php echo $product->cost; ?></td>
                                        
                                        <td>
                                            <div class="fs-12 fw-medium text-muted pt-2 pb-1"><?php echo $product->file;?></div>
                                                <div class="fs-18 fw-bolder text-dark">
                                                    <?php
                                                        
                                                        $img = !empty($product->file) ? $product->file : 'user.jpeg';
                                                        $img_path = base_url('assest/uploads/' . $img); 
                                                    ?>
                                                    <img src="<?= $img_path ?>" alt="image" style="max-width:120px;max-height:120px;border-radius:8px;" onclick="alert('hi')">
                                                </div>
                                            </div>
                                        </div>
                                       
                                        
                                        <td>
                                            <a href="editaddproducts?id=<?php echo $product->id; ?>" class="btn btn-warning">Edit</a>
                                            <form method="POST" action="../cont/deleteproducts" style="width:100%">
                                                <input type="hidden" name="id" value="<?php echo $product->id; ?>">
                                                <button type="submit" class="btn btn-danger" style="width:100%" name="delete" onclick="return confirm('Are you sure you want to delete this product?');">DELETE</button>
                                            </form>

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
  