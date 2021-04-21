<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->

      <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo base_url('assets/images/avatar.png') ?>" class="img-circle" >
      </div>
      <div class="pull-left info">
        <p><?php echo $this->session->userdata('username');?></p>
        <!-- Status -->
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <br>

    
      <ul class="sidebar-menu" data-widget="tree">
        
        <li id="dashboardMainMenu">
          <a href="<?php echo base_url('dashboard') ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>

        <li id="NotificationsMenu">
          <a href="<?php echo base_url('notifications/') ?>">
            <i class="fa fa-bell-o"></i> <span>Notifications <span class="label label-danger"><?php echo $product_status;?></span></span>
          </a>
        </li>

        <?php if($user_permission): ?>
         
          <?php if(in_array('createOrder', $user_permission) || in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
            <li class="treeview" id="mainOrdersNav">
              <a href="#">
                <i class="fa fa-shopping-basket"></i>
                <span>Orders</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('createOrder', $user_permission)): ?>
                  <li id="addOrderNav"><a href="<?php echo base_url('orders/create') ?>"><i class="fa fa-circle-o"></i> Add Order</a></li>
                <?php endif; ?>
                <?php if(in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
                <li id="manageOrdersNav"><a href="<?php echo base_url('orders') ?>"><i class="fa fa-circle-o"></i> Manage Orders</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>

          <?php if(in_array('createProduct', $user_permission) || in_array('updateProduct', $user_permission) || in_array('viewProduct', $user_permission) || in_array('deleteProduct', $user_permission)): ?>
            <li class="treeview" id="mainProductNav">
              <a href="#">
                <i class="fa fa-cube"></i>
                <span>Products</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('createProduct', $user_permission)): ?>
                  <li id="addProductNav"><a href="<?php echo base_url('products/create') ?>"><i class="fa fa-circle-o"></i> Add Product</a></li>
                <?php endif; ?>
                <?php if(in_array('updateProduct', $user_permission) || in_array('viewProduct', $user_permission) || in_array('deleteProduct', $user_permission)): ?>
                <li id="manageProductNav"><a href="<?php echo base_url('products') ?>"><i class="fa fa-circle-o"></i> Manage Products</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>
          
          <li class="treeview" id="mainOrdersNav">
                <a href="#">
                  <i class="fa fa-dollar"></i>
                    <span>Manage Inventory</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
              <ul class="treeview-menu">
                  <?php if(in_array('createCategory', $user_permission) || in_array('updateCategory', $user_permission) || in_array('viewCategory', $user_permission) || in_array('deleteCategory', $user_permission)): ?>
                    <li id="categoryNav">
                      <a href="<?php echo base_url('category/') ?>">
                        <i class="fa fa-files-o"></i> <span>Category</span>
                      </a>
                    </li>
                <?php endif; ?>
              <?php if(in_array('createAttribute', $user_permission) || in_array('updateAttribute', $user_permission) || in_array('viewAttribute', $user_permission) || in_array('deleteAttribute', $user_permission)): ?>
                <li id="attributeNav">
                  <a href="<?php echo base_url('attributes/') ?>">
                    <i class="fa fa-files-o"></i> <span>Attributes</span>
                  </a>
                </li>
            <?php endif; ?>
              </ul>
          </li>

          <?php if(in_array('createSupplier', $user_permission) || in_array('updateStore', $user_permission) || in_array('viewStore', $user_permission) || in_array('deleteStore', $user_permission)): ?>
            <li class="treeview" id="mainSuppliesNav">
              <a href="#">
                <i class="fa fa-cube"></i>
                <span>Manage Supplies</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                    <?php if(in_array('createSupplier', $user_permission) || in_array('updateStore', $user_permission) || in_array('viewStore', $user_permission) || in_array('deleteStore', $user_permission)): ?>
                        <li id="supplierNav">
                          <a href="<?php echo base_url('supplier/') ?>">
                          <i class="fa fa-files-o"></i> <span>Manage Suppliers</span>
                          </a>
                        </li>
                    <?php endif; ?>
                    <?php if(in_array('createSupplier', $user_permission) || in_array('updateStore', $user_permission) || in_array('viewStore', $user_permission) || in_array('deleteStore', $user_permission)): ?>
                        <li id="addSupplies">
                          <a href="<?php echo base_url('receiving/create') ?>">
                          <i class="fa fa-files-o"></i> <span>Receive Supply</span>
                          </a>
                        </li>
                    <?php endif; ?>
                    <?php if(in_array('createSupplier', $user_permission) || in_array('updateStore', $user_permission) || in_array('viewStore', $user_permission) || in_array('deleteStore', $user_permission)): ?>
                        <li id="viewSupplies">
                          <a href="<?php echo base_url('receiving/') ?>">
                          <i class="fa fa-files-o"></i> <span>View Supplies</span>
                          </a>
                        </li>
                    <?php endif; ?>
                
              </ul>
            </li>
          <?php endif; ?>

          
          

          <li class="treeview" id="mainOrdersNav">
                <a href="#">
                  <i class="fa fa-users"></i>
                    <span>Manage User Accounts</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
              <ul class="treeview-menu">
              <?php if(in_array('createGroup', $user_permission) || in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)): ?>
            <li class="treeview" id="mainGroupNav">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Groups</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('createGroup', $user_permission)): ?>
                  <li id="addGroupNav"><a href="<?php echo base_url('groups/create') ?>"><i class="fa fa-circle-o"></i> Add Group</a></li>
                <?php endif; ?>
                <?php if(in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)): ?>
                <li id="manageGroupNav"><a href="<?php echo base_url('groups') ?>"><i class="fa fa-circle-o"></i> Manage Groups</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>
          <?php if(in_array('createUser', $user_permission) || in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
            <li class="treeview" id="mainUserNav">
            <a href="#">
              <i class="fa fa-users"></i>
              <span>Users</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <?php if(in_array('createUser', $user_permission)): ?>
              <li id="createUserNav"><a href="<?php echo base_url('users/create') ?>"><i class="fa fa-circle-o"></i> Add User</a></li>
              <?php endif; ?>

              <?php if(in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
              <li id="manageUserNav"><a href="<?php echo base_url('users') ?>"><i class="fa fa-circle-o"></i> Manage Users</a></li>
            <?php endif; ?>
            </ul>
          </li>
          <?php endif; ?>
             
              </ul>
          </li>

          <li class="treeview" id="reportNav">
                <a href="#">
                  <i class="glyphicon glyphicon-stats"></i>
                    <span>Reports</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
              <ul class="treeview-menu">
                  <?php if(in_array('viewReports', $user_permission)): ?>
                    <li id="DailyreportNav">
                      <a href="<?php echo base_url('reports/daily_products_reports') ?>">
                        <i class="glyphicon glyphicon-stats"></i> <span>Daily Reports</span>
                      </a>
                    </li>
                  <?php endif; ?>
                  
                  <?php if(in_array('viewReports', $user_permission)): ?>
                    <li id="ProductSalesNav">
                      <a href="<?php echo base_url('reports/sales_by_products_reports') ?>">
                        <i class="glyphicon glyphicon-stats"></i> <span>Sales by Product Reports</span>
                      </a>
                    </li>
                  <?php endif; ?>
                  <?php if(in_array('viewReports', $user_permission)): ?>
                    <li id="CategorySalesNav">
                      <a href="<?php echo base_url('reports/sales_by_category_reports') ?>">
                        <i class="glyphicon glyphicon-stats"></i> <span>Sales by Category Reports</span>
                      </a>
                    </li>
                  <?php endif; ?>
                  <?php if(in_array('viewReports', $user_permission)): ?>
                    <li id="YearlySalesNav">
                      <a href="<?php echo base_url('reports/') ?>">
                        <i class="glyphicon glyphicon-stats"></i> <span>Yearly & Monhtly Sales Reports</span>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if(in_array('viewProductReport', $user_permission)): ?>
                    <li id="ProductsReportsNav">
                      <a href="<?php echo base_url('reports/products_reports') ?>">
                        <i class="glyphicon glyphicon-stats"></i> <span>Product Reports</span>
                      </a>
                    </li>
                  <?php endif; ?>
              </ul>
          </li>

        

          <?php if(in_array('updateCompany', $user_permission)): ?>
            <li id="companyNav"><a href="<?php echo base_url('company/') ?>"><i class="fa fa-wrench"></i> <span>Configuration</span></a></li>
          <?php endif; ?>

          <?php if(in_array('createExpenses', $user_permission) || in_array('updateExpenses', $user_permission) || in_array('viewExpenses', $user_permission) || in_array('deleteExpenses', $user_permission)): ?>
                  <li id="expensesNav">
                    <a href="<?php echo base_url('expenses/') ?>">
                      <i class="fa fa-dollar"></i> <span>Expenses</span>
                    </a>
                  </li>
          <?php endif; ?>

            <li class="treeview" id="mainOrdersNav">
              <a href="#">
                <i class="fa fa-user-o"></i>
                <span>Profile</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('viewProfile', $user_permission)): ?>
                    <li><a href="<?php echo base_url('users/profile/') ?>"><i class="fa fa-user-o"></i> <span>View Profile</span></a></li>
                <?php endif; ?>
                <?php if(in_array('updateSetting', $user_permission)): ?>
                    <li><a href="<?php echo base_url('users/setting/') ?>"><i class="fa fa-wrench"></i> <span>Update Profile</span></a></li>
                <?php endif; ?>
              </ul>
            </li>


        <?php endif; ?>
        <!-- user permission info -->
        <li><a href="<?php echo base_url('auth/logout') ?>"><i class="glyphicon glyphicon-log-out"></i> <span>Logout</span></a></li>
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>


  