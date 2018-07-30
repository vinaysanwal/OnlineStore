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
                    <h1 class="page-header">Adding Product</h1>
                    <?php display_msg() ; ?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
             
                <div class="col-md-10 col-md-offset-1 ">
                <div class="row">
                  <div class="col-sm-6 col-sm-offset-3">
                  <div class="col-lg-12">
                    <h4 class="page-header text-center">Add Product</h4>
                  </div>
                  <div class="col-md-12">
                    <form action="<?php $_SERVER["PHP_SELF"];?>" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">

                        <div class="form-group">
                            <label class="" for="type">Select Category </label>
                             <div class="">
                                 <select class="form-control" id="" name="type" required>

                                    <option value="2">Downloadable</option>
                                    <option value="1">Not Downloadable</option>

                                 </select>
                              </div>
                        </div>

                         <div class="form-group">
                          <label class="" for="name">Name</label>
                          <div class="">
                            <input type="name" class="form-control" name="item_name" placeholder="Enter Name" value="">
                          </div>
                        </div>
                         <div class="form-group">
                          <label class="" for="prof">Price</label>
                          <div class="">
                            <input type="text" class="form-control" name="item_price" placeholder="Enter Price" value="">
                          </div>
                        </div>

<!--
                         <div class="form-group">
                          <label class="" for="country">Code</label>
                          <div class="">
                            <input type="text" class="form-control" name="code" placeholder="Enter Code" value="">
                          </div>
                        </div>
-->
                         <div class="form-group">
                          <label class="" for="text">Description</label>
                          <div class="">
                              <textarea type="text" class="form-control" name="item_desc" value="" placeholder="Description" required></textarea>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="">
                            <button type="submit" class="btn btn-primary" name="add_product">Add Product</button><hr>
                          </div>
                        </div>


                        </form>
    <?php
              
        if(isset($_POST['add_product'])){
        
        $raw_name       =   clean($_POST['item_name']);
        $raw_type       =   clean($_POST['type']);
        $raw_price      =   clean($_POST['item_price']);
        $raw_desc       =   clean($_POST['item_desc']);
        
        
        $cl_name        =   santize($raw_name);
        $cl_type        =   santize($raw_type);
        $cl_price       =   val_int($raw_price);
        $cl_desc        =   santize($raw_desc);
             
        $db =  new dbase;
             
        $db->query('INSERT INTO products(id, item_name, item_desc, item_price, category) VALUES(NULL, :item_name, :item_desc, :item_price, :category )');
             
        $db->bind(':item_name', $cl_name, PDO::PARAM_STR);
        $db->bind(':item_desc', $cl_desc, PDO::PARAM_STR);
        $db->bind(':item_price', $cl_price, PDO::PARAM_INT);
        $db->bind(':category', $cl_type, PDO::PARAM_STR);
             
        $run_addproduct = $db->execute();
                      
        if($run_addproduct){
            
            redirect('addproduct.php');
            
            set_msg('<div class="alert alert-success text-center">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Success! </strong> Package Added Successfully.
                    </div>');
        }else{
            
            redirect('addproduct.php');
            
            set_msg('<div class="alert alert-danger text-center">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Sorry</strong> Package could not be Added.
                    </div>');
            
        }              
            
            
    }
 ?>

                            <br />


                    </div>
                  </div>
                  
                </div>
                 
              </div>
                <!-- /.col-lg-12 -->
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

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
