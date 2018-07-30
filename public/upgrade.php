<?php include ('includes/header.php'); 
    include("includes/config.php"); 


if(isset($_SESSION['user_logged_in'])){ 

    //Do nothing

}else{
    
    redirect('logout.php');
    
}


$pages = $_GET['page'];


?>
   

<div class="container">
 
        <div>
            <header class="section_header">
                <h4>Purchasing Services</h4><hr>
                <?php display_msg(); ?>
            </header>
        <div class="col-md-6 col-md-offset-3">
               
               <?php 
                    
                if($pages == 1){ ?>
               
                <form action="upgrade.php?page=2" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="" for="reason">Select Package:</label>
                         <div class="">
                             <select class="form-control" id="" name="package" required>
                                <option value="Not Defined">Toggle List</option>
                                
                                <?php
                                
                                 $db = new dbase;
                                 
                                 $db->query('SELECT * FROM products');
                                 $result_products = $db->fetchMultiple();
                                 
                                 foreach($result_products as $package){
                                ?> 
                                <option value="<?php echo $package['item_name'] ?>"><?php echo $package['item_name'] ?> </option>
                                <?php } ?>
                             </select>
                          </div>
                    </div>

                    
                    <div class="form-group">
                      <div class="">
                        <button type="submit" class="btn btn-primary" name="make_purchase"> Proceed</button><a href="upgrade.php?page=1" class="btn btn-danger pull-right" style="color: #fff;">Start Over</a>
                      </div>
                    </div>

                   
            </form>
                    
            <?php } ?>
                    
                    
            <?php 
                    
                if($pages == 2){ ?>
                
                   <?php            
              
                        if(isset($_POST['make_purchase'])){

                         $selected_package = $_POST['package'];

                         $_SESSION['selected_package'] = $selected_package;

                        }


                    ?>

                <form action="upgrade.php?page=3" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
                   <span>Below is your Item Detials</span><hr>
                   <?php
                    
                    $db = new dbase;
                    
                    $package    =   $_SESSION['selected_package'];
                    
                    $db->query('SELECT * FROM products WHERE item_name = :package');
                    $db->bind(':package', $package, PDO::PARAM_STR);
                    
                    $result_product = $db->fetchSingle();
                    
                    $_SESSION['item_desc'] = $result_product['item_desc'];
                    
                    $_SESSION['item_price'] = $result_product['item_price']; 
                
                   ?>
                   
                    <div class="form-group">
                      <label class="" for="name">Item Name</label>
                      <div class="">
                        <input type="name" class="form-control" name="product_name" placeholder="<?php echo $result_product['item_name'] ?>" value="<?php echo $_SESSION['selected_package']; ?>" disabled>
                      </div>
                    </div>
                     <div class="form-group">
                      <label class="" for="prof">Item Description</label>
                      <div class="">
                        <input type="text" class="form-control" name="item_desc" placeholder="<?php echo $result_product['item_desc'] ?>" value="<?php echo $_SESSION['item_desc'];  ?>" disabled>
                      </div>
                    </div>
                     <div class="form-group">
                      <label class="" for="prof">Price</label>
                      <div class="">
                        <input type="text" class="form-control" name="price" placeholder="<?php echo $result_product['item_price'] ?>" value="<?php echo $_SESSION['item_price'] ?>" disabled>
                      </div>
                    </div>

                    
                    <div class="form-group">
                      <div class="">
                        <button type="submit" class="btn btn-primary" name="checkout"> Checkout</button><a href="upgrade.php?page=1" class="btn btn-danger pull-right" style="color: #fff;">Start Over</a>
                      </div>
                    </div>

                   
            </form>
                    
            <?php } ?>
                    
            <?php 
                    
                if($pages == 3){ ?>
                    
                    <?php 
                      
                        if(isset($_POST['checkout'])){
                            
                            $item_name  = $_SESSION['selected_package'];
                            $item_desc  = $_SESSION['item_desc'];
                            $item_price = $_SESSION['item_price'];
                       
                        }
                                
                    ?>
                
               
                 <h2>Order Summary</h2><br>
                 
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Item Name</th>
                        <th>Item Description</th>
                        <th>Price</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $_SESSION['selected_package'] ?></td>
                        <td><?php echo $_SESSION['item_desc'] ?></td>
                        <td><br>$ <?php echo $_SESSION['item_price'] ?></td>
                      </tr>
                    </tbody>
                  </table>
                    
                <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#save" >Save Your Order</button>
                   
                <?php include('includes/paymentform.php');   ?>
                   
                 <!-- Modal Deleting Messages-->
                    <div id="save" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Your Order Details will be Saved.</h4>
                          </div>
                          <div class="modal-body">
                            <form role="form" method="post" action="upgrade.php?page=3">
                               <input type="hidden" value="<?php echo $item_name ?>" name="name">
                               <input type="hidden" value="<?php echo $item_desc ?>" name="desc">
                               <input type="hidden" value="<?php echo $item_price ?>" name="price">
                               <input type="hidden" value="<?php echo $_SESSION['user_data']['email'] ?>" name="email">
                              <button type="submit" name="saveorder" class="btn btn-info">Yes Save Order</button>
<!--                                  <button type="submit" class="btn btn-default">No Thanks</button>-->
                            </form>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>

                      </div>
                    </div>
                    
                    <?php
                        
                      if(isset($_POST['saveorder'])){
                          
                          $i_name   =   $_POST['name'];
                          $i_desc   =   $_POST['desc'];
                          $i_price  =   $_POST['price'];
                          $email    =   $_POST['email'];
                          
                          
                          $db = new dbase;
                          
                          $db->query('INSERT INTO saved_orders(id, item_name, item_desc, email, item_price) VALUES(NULL, :iname, :idesc, :email , :iprice )');
                          
                          $db->bind(':iname', $i_name, PDO::PARAM_STR);
                          $db->bind(':idesc', $i_desc, PDO::PARAM_STR);
                          $db->bind(':iprice', $i_price, PDO::PARAM_INT);
                          $db->bind(':email', $email, PDO::PARAM_STR);
                          
                          $run = $db->execute();
                          
                          if($run){
                              
                              redirect('user-account.php');
                              
                              set_msg('<div class="alert alert-success text-center">
                              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                              <strong>Order Saved Successfully</strong>
                            </div>');
                              
                          }
                          
                      }  
                        
                    ?>
                             
                   
                    
            <?php } ?>
                    
            
            <?php       
            
            if($pages == 4){ ?>
                    
                    <?php 
                      
                    $db = new dbase;
                    
                    $email    =   $_SESSION['user_data']['email'];
                    
                    $db->query('SELECT * FROM saved_orders WHERE email = :email');
                    $db->bind(':email', $email, PDO::PARAM_STR);
                    
                    $result_order = $db->fetchSingle();
                
                    $_SESSION['selected_package']   = $result_order['item_name'];
                    $_SESSION['item_desc']          = $result_order['item_desc'];  
                    $_SESSION['item_price']         = $result_order['item_price'];              
                    ?>
                
               
                 <h2>Order Summary</h2>  <a href="user-account.php" class="btn btn-primary pull-right" style="color: #fff;">Back to Account</a> <br><br><br>
                 
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Item Name</th>
                        <th>Item Description</th>
                        <th>Price</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $_SESSION['selected_package'] ?></td>
                        <td><?php echo $_SESSION['item_desc'] ?></td>
                        <td><br>$ <?php echo $_SESSION['item_price'] ?></td>
                      </tr>
                    </tbody>
                  </table>  
                    
                     <?php include('includes/paymentform.php'); ?>          

                    <br />
                <?php } ?>
                                
            </div>
                                    
       </div>

  
</div><!--page content-->

<?php include ('includes/footer.php'); ?>