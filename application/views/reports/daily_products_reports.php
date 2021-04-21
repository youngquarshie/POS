

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Daily Sales 
      <small>Reports</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Daily Sales</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">

    <div class="col-md-12 col-xs-12">
          <form class="form-inline" action="<?php echo base_url('reports/daily_reports') ?>" method="POST">
            <div class="form-group">
              <label for="date">Select Date</label>
              <input type="date" name="daily_date" id="daily_date" value="<?php echo $selected_day;?>">
            </div>
            <!-- <button type="submit" class="btn btn-default">Submit</button> -->
          </form>
        </div>

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
            <h3 class="box-title" id="data">Daily Sales Reports</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="daily-sales" class="table table-bordered table-striped display">
              <thead>
              <tr>
                <th>Product Name</th>
                <th>Qty</th>
                <th>Date Sold</th>
                <th>Price</th>
              </tr>
  
              </thead>

              <tfoot align="right">
		          <tr>
              <th>Total</th>
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
var selected_date =$("#daily_date").val();
$(document).ready(function() {


  $("#reportNav").addClass('active');
  $("#DailyreportNav").addClass('active');

  // initialize the datatable 
  manageTable = $('#daily-sales').DataTable({
    ajax: {
        url: base_url + 'reports/fetchOrderData/'+selected_date,
        type: 'get',
        },
    // 'ajax': base_url + 'reports/fetchOrderData/'+selected_date,
    drawCallback: function () {
      var api = this.api();
      $( "#total_sales" ).text(
        api.column( 3, {page:'current'} ).data().sum()
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


  // #myInput is a <input type="text"> element
  $('#daily_date').on( 'change', function () {
    var data= $(this).val();
    $('#daily-sales').DataTable().clear().destroy();

    manageTable = $('#daily-sales').DataTable({
    ajax: {
        url: base_url + 'reports/fetchOrderData/'+data,
        type: 'get',
        },
    // 'ajax': base_url + 'reports/fetchOrderData/'+selected_date,
    drawCallback: function () {
      var api = this.api();
      $( "#total_sales" ).text(
        api.column( 3, {page:'current'} ).data().sum()
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
        
  } );

});




</script>


 
