<?php

include('includes/header.php');

include('includes/dashboard.php');

include('includes/config.php');

?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Adding User</h1>
                    
                 <?php display_msg() ?>
                 
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
            
               
                <div class="col-md-10 col-md-offset-1 ">
                <div class="row">
                  <div class="col-sm-6 col-sm-offset-3">
                  <div class="col-lg-12">
                    <h4 class="page-header text-center">Register Admin User</h4>
                  </div>
                  <div class="col-md-12">
                    <form action="<?php $_SERVER["PHP_SELF"];?>" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">

                        <div class="form-group">
                            <label class="" for="privilege">Select privilege </label>
                             <div class="">
                                 <select class="form-control" id="" name="privilege" required>

                                    <option value="1">Super Admin</option>
                                    <option value="2">Admin</option>

                                 </select>
                              </div>
                        </div>
                         
                         <div class="form-group">
                          <label class="" for="email">email</label>
                          <div class="">
                            <input type="email" class="form-control" name="email" placeholder="Enter Email" value="">
                          </div>
                        </div>
                         
                         <div class="form-group">
                          <label class="" for="password">Password</label>
                          <div class="">
                            <input type="password" class="form-control" name="password" placeholder="Enter Password" value="">
                          </div>
                        </div>

                         <div class="form-group">
                          <label class="" for="name">Full Name</label>
                          <div class="">
                            <input type="name" class="form-control" name="fullname" placeholder="Enter Full Name" value="">
                          </div>
                        </div>
                         <div class="form-group">
                          <label class="" for="prof">Designation</label>
                          <div class="">
                            <input type="text" class="form-control" name="designation" placeholder="Enter Designation" value="">
                          </div>
                        </div>

                         <div class="form-group">
                          <label class="" for="country">Location</label>
                          <div class="">
                            <input type="text" class="form-control" name="location" placeholder="Enter Location" value="">
                          </div>
                        </div>
                         <div class="form-group">
                          <label class="" for="text">Responsibility</label>
                          <div class="">
                              <textarea type="text" class="form-control" name="responsibility" value="" placeholder="Responsibility" required></textarea>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="">
                            <button type="submit" class="btn btn-primary" name="register_admin">Create Admin</button><hr>
                          </div>
                        </div>


                        </form>
                            
                            
    <?php
                      
        if(isset($_POST['register_admin'])){
        
        $raw_name               =   clean($_POST['fullname']);
        $raw_location           =   clean($_POST['location']); 
        $raw_designation        =   clean($_POST['designation']);
        $raw_responsibility     =   clean($_POST['responsibility']);
        $raw_email              =   clean($_POST['email']);
        $raw_password           =   clean($_POST['password']);
        
        
        $cl_name                =   santize($raw_name);
        $cl_email               =   val_email($raw_email);
        $cl_password            =   santize($raw_password);
        $cl_location            =   santize($raw_location);
        $cl_designation         =   santize($raw_designation);
        $cl_responsibility      =   santize($raw_responsibility);
        $cl_priv                =   clean($_POST['privilege']);
        
        
        //Hashed Password
        $hashed_password        = hash_pwd($cl_password);
        
         
                
        //Instatiating our object from the dbase class
        $db = new dbase;

        $db->query('SELECT * FROM admin WHERE email = :email');

        $db->bind(':email', $cl_email , PDO::PARAM_STR);

        $get_user = $db->fetchSingle();

        if($get_user > 0){

            set_msg('<div class="alert alert-danger text-center">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong></strong> The Admin User Already Exist.
                </div>');

            }else{
                
                $db->query('INSERT INTO admin(id, fullname, email, password, privilege, designation, responsibility, location) VALUES(NULL, :fullname, :email, :password, :privilege, :designation, :responsibility, :location) ');
                
                $db->bind(':fullname', $cl_name , PDO::PARAM_STR);
                $db->bind(':password', $hashed_password , PDO::PARAM_STR);
                $db->bind(':email', $cl_email, PDO::PARAM_INT);
                $db->bind(':privilege', $cl_priv, PDO::PARAM_INT);
                $db->bind(':designation', $cl_designation , PDO::PARAM_STR);
                $db->bind(':responsibility', $cl_responsibility , PDO::PARAM_STR);
                $db->bind(':location', $cl_location , PDO::PARAM_STR);
                
                $run = $db->execute();
                
                if($run){
                    
                    redirect('adduser.php');
                    
                    set_msg('<div class="alert alert-success text-center">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Success!</strong> Admin User has been Added
                    </div>');
                    
                }else{
                    
                    echo '<div class="alert alert-danger text-center">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Sorry!</strong> Admin User could not be Added.
                    </div>';
                    
                }
                
                
           
            
            
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
