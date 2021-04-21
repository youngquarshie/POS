

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Products</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Products</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

        <?php if($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif($this->session->flashdata('error')): ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>


        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Edit Product</h3>
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('users/update') ?>" method="post" enctype="multipart/form-data">
              <div class="box-body">

                <?php echo validation_errors(); ?>


                <div class="form-group">
                  <label for="product_name">Product name</label>
                  <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter product name" value="<?php echo $product_data['name']; ?>"  autocomplete="off"/>
                </div>

                <div class="form-group">
                  <label for="variation_name">Product name</label>
                  <input type="text" class="form-control" id="variation_name" name="variation_name" placeholder="Enter Variation" value="<?php echo $product_data['variation_name']; ?>"  autocomplete="off"/>
                </div>

                <div class="form-group">
                  <label for="wholesale_price">Wholesale Price</label>
                  <input type="number" class="form-control" id="wholesale_price" onchange="setTwoNumberDecimal()" step="0.10" name="wholesale_price" value="<?php echo $product_data['wholesale_price']; ?>" autocomplete="off" />
                </div>

                <div class="form-group">
                  <label for="alert_level">Alert Level</label>
                  <input type="number" class="form-control" id="alert_level" name="alert_level" value="<?php echo $product_data['alert_level']; ?>" autocomplete="off" />
                </div>

                <div class="form-group">
                  <label for="price">Unit Price</label>
                  <input type="number" class="form-control" id="price" name="price" placeholder="Enter price"  onchange="setTwoNumberDecimal()"  step="0.10" value="<?php echo $product_data['price']; ?>" autocomplete="off" />
                </div>

                <div class="form-group">
                  <label for="qty">Qty</label>
                  <input type="text" class="form-control" id="qty" name="qty" placeholder="Enter Qty" value="<?php echo $product_data['qty']; ?>" autocomplete="off" />
                </div>

                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea type="text" class="form-control" id="description" name="description" placeholder="Enter 
                  description" autocomplete="off">
                    <?php echo $product_data['description']; ?>
                  </textarea>
                </div>


                <div class="form-group">
                  <label for="category">Category</label>
                  <?php $category_data = $product_data['category_id']; ?>
       
                  <select class="form-control select_group" id="category" name="category" >
                    <?php foreach ($category as $k => $v): ?>
                      <option value="<?php echo $v['id'] ?>" <?php
                      if(!empty($category_data)){ 
                        if($v['id'] == $category_data) { 
                          echo 'selected="selected"'; 
                          }
                        } ?>
                        ><?php echo $v['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>

              
                <div class="form-group">
                  <label for="supplier">Supplier</label>
            
                  <?php $supplier_data = $product_data['supplier_id']; ?>
                  <select class="form-control select_group" id="supplier" name="supplier" >
                    <?php foreach ($supplier as $k => $v): ?>
                      <option value="<?php echo $v['supplier_id'] ?>" <?php
                        if(!empty($supplier_data)){
                          if($v['supplier_id'] == $supplier_data) { 
                            echo 'selected="selected"'; 
                          }
                        }   
                         ?>> <?php echo $v['supplier_name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="expiry_date">Expiry Date</label>
                  <input type="date" class="form-control" id="expiry_date" name="expiry_date"  value="<?php echo $product_data['expiry_date']; ?>" autocomplete="off" />
                </div>

                <div class="form-group">
                  <label for="store">Availability</label>
                  <select class="form-control" id="availability" name="availability">
                    <option value="1" <?php if($product_data['availability'] == 1) { echo "selected='selected'"; } ?>>Yes</option>
                    <option value="2" <?php if($product_data['availability'] != 1) { echo "selected='selected'"; } ?>>No</option>
                  </select>
                </div>



              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="<?php echo base_url('users/') ?>" class="btn btn-warning">Back</a>
              </div>
            </form>


            
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
    

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  
  $(document).ready(function() {

    function setTwoNumberDecimal(event) {
    this.value = parseFloat(this.value).toFixed(2);
    }
    $(".select_group").select2();
    $("#description").wysihtml5();

    $("#mainProductNav").addClass('active');
    $("#manageProductNav").addClass('active');
    
   

  });
</script>