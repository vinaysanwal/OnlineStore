<?php include('includes/header.php');
    include('includes/config.php');

if(isset($_SESSION['user_logged_in'])){ 

    redirect('user-account.php'); 

}else{
    
    //Do nothing
    
}

?>


  <div class="row">
      <div class="col-md-6 col-md-offset-3">
    
         <?php display_msg(); ?> 
   
      </div>
      <div class="col-md-4 col-md-offset-4">
       <p class=""><a class="pull-right" href="register.php"> Register</a></p><br>
        <form class="form-horizontal" role="form" method="post" action="<?php login_user(); ?>">
          <div class="form-group">
            <label class="control-label col-sm-2" for="email"></label>
            <div class="col-sm-10">
              <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd"></label>
            <div class="col-sm-10"> 
              <input type="password" name="password" class="form-control" id="pwd" placeholder="Enter Password" required>
            </div>
          </div>

          <div class="form-group"> 
            <div class="col-sm-offset-2 col-sm-10 text-center">
              <button type="submit" class="btn btn-primary text-center" name="submit_login">Login</button><br><br>
              <a class="" href="admin/pages/login.php"> Admin Login</a>
            </div>
          </div>
        </form>
          
  </div>
</div>
  
  
<?php include('includes/footer.php'); ?>