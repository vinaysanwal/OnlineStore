<?php include ('includes/header.php'); 
    include("includes/config.php"); ?>
   

<div class="container">
 
        <div>
            <header class="section_header">
                <h4>Deleting Your Profile</h4><hr>
                <?php display_msg(); ?>
            </header>
        <div class="col-md-6 col-md-offset-3">
               
               <div class="alert alert-danger text-center">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong></strong> Your Profile will be Completely Deleted 
                    </div>
                    
                <form action="<?php $_SERVER["PHP_SELF"];?>" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
                     <div class="form-group">
                      
                      <div class="">
                        <input type="hidden" class="form-control" name="delete"  value="<?php echo $_SESSION['user_data']['email'] ?>">
                      </div>
                    </div>
                 
                 
                    <div class="form-group">
                      <div class="">
                        <button type="submit" class="btn btn-danger" name="delete_profile">Yes Delete</button><a href="user-account.php" class="btn btn-default pull-right">Cancel</a><hr>
                      </div>
                    </div>

                   
            </form>
                    
    <?php            
              
        if(isset($_POST['delete_profile'])){
            
            
        $email = $_POST['delete'];
            
        $db = new dbase;
            
        //Delete user from users table
        $db->query('DELETE FROM users WHERE email =:email');
            
        $db->bind(':email', $email, PDO::PARAM_STR);
            
        $run_delete = $db->execute();    
        
          
        //Destroy all sessions and call logout
        if($run_delete){
            
        //Delete messages from msgs table
        $db->query('DELETE FROM msgs WHERE client_email =:email');
            
        $db->bind(':email', $email, PDO::PARAM_STR);
            
        $db->execute(); 
        
        redirect('logout.php');    
        
            
        }
            
        }
    
    ?>

                    <br />

                                
            </div>
                                    
       </div>

  
</div><!--page content-->

<?php include ('includes/footer.php'); ?>