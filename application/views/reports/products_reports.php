

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Product
      <small>Reports</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Product Report</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">


        <br /> <br />

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
            <h3 class="box-title" id="data"> Product Reports</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="product-sales" class="table table-bordered table-striped display">
              <thead>
              <tr>
                <th>Product Name</th>
                <th>Wholesale Price</th>
                <th>Unit Price</th>
                <th>Qty</th>
                <th>Profit</th>
              </tr>
  
              </thead>

              <tfoot align="right">
		          <tr>
              <th>Total Profit</th>
              <th></th>
              <th></th>
              <th></th>
              <th >GH¢ <span id="total_sales"></span></th>
              </tr>
	            </tfoot>
          
   
            </table>
           
          </div>
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
var manageTable;
var base_url = "<?php echo base_url(); ?>";

$(document).ready(function() {


  $("#reportNav").addClass('active');
  $("#ProductsReportsNav").addClass('active');

  // #myInput is a <input type="text"> element

    //alert(product_id);
    $('#product-sales').DataTable().clear().destroy();

    manageTable = $('#product-sales').DataTable({
    ajax: {
        url: base_url + 'reports/fetchAllProducts/',
        type: 'get',
        },
    // 'ajax': base_url + 'reports/fetchOrderData/'+selected_date,
    drawCallback: function () {
      var api = this.api();
      $( "#total_sales" ).text(
        api.column( 4, {page:'current'} ).data().sum()
      );
    },
    
    
     responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'excel', title: 'Daily Sales Report'},
                    {extend: 'pdf', title: 'Daily Sales Report'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

      
  });
        


});

</script>


 
