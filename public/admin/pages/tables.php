<?php

include('includes/header.php');

include('includes/dashboard.php');

include('includes/config.php');

if(isset($_SESSION['admin_logged_in']) || (isset($_SESSION['emp_logged_in']) )){
    
    
}else{
    
    redirect('logout.php');
}


?>


        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Big Data</h1>
                        <a href="../../users.php" class="btn btn-primary pull-right">Refine Search</a><br><br>
                    <?php display_msg() ?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Members  
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Email</th>
                                            <th>Fullname</th>
                                            <th>Location</th>
                                            <th>Profession</th>
                                            <th>View Profile</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                <?php
                                        
                                    $db = new dbase;
    
                                    $db->query('SELECT * FROM users ORDER BY date DESC');
                                       
                                    $users  =   $db->fetchMultiple();
                                 
                                ?>     
                                      
                                 <?php foreach($users as $user){ ?>    
                                        <tr class="odd gradeX">
                                            <td><?php echo $user['email'] ?></td>
                                            <td><?php echo $user['fullname'] ?></td>
                                            <td><?php echo $user['location'] ?></td>
                                            <td class="center"><?php echo $user['profession'] ?></td>
                                            <td class="center"><a href="../../user.php?user_id=<?php echo $user['id'] ?> " class="btn btn-primary">View</a></td>
                                        </tr>
                                 <?php } ?>    
                                        
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Manage Products
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Item Name</th>
                                            <th>Item Desc</th>
                                            <th>Item Price</th>
                                            <th>Category</th>
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                <?php
                                        
                                    $db = new dbase;
    
                                    $db->query('SELECT * FROM products ORDER BY item_price DESC');
                                       
                                    $products  =   $db->fetchMultiple();
                                 
                                ?>     
                                      
                                 <?php foreach($products as $product){ ?>             
                                       
                                        <tr>
                                            <td><?php echo $product['id'] ?> </td>
                                            <td><?php echo $product['item_name'] ?></td>
                                            <td><?php echo $product['item_desc'] ?></td>
                                            <td>$ <?php echo $product['item_price'] ?></td>
                                            <td><?php echo $product['category'] ?></td>
                                            <td><button id="delete" class="btn btn-danger pull-left" style="color: #fff">Delete</button></td>
                                       
                                        </tr>
                                 <?php } ?>
    
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
       
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
            
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Manage Orders
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Transaction ID</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Client</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                <?php
                                        
                                    $db = new dbase;
    
                                    $db->query('SELECT * FROM orders ORDER BY date DESC');
                                       
                                    $recent_orders  =   $db->fetchMultiple();
                                 
                                ?>     
                                       
                                        <?php foreach($recent_orders as $order){ ?>       
                                               
                                                <tr>
                                                    <td><?php echo $order['id'] ?> </td>
                                                    <td><?php echo $order['tx_id'] ?> </td>
                                                    <td>$ <?php echo $order['amt'] ?> </td>
                                                    <td><?php echo $order['date'] ?> </td>
                                                    <td><?php echo $order['client_email'] ?> </td>
                                                </tr>
                                                
                                        <?php } ?>  
                               
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
    </script>

</body>

</html>
