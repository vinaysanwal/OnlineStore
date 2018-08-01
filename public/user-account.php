<?php include ('includes/header.php');
 include ("includes/config.php");

 if(isset($_SESSION['user_logged_in'])){

 }else{
   redirect('logout.php');
 }

?>

<div class="container">

    <div class="col-sm-12" style="padding: 10px; background-color: white; border: 1px solid #ddd;"><i class="fa fa-dashboard" style="font-size:28px"> Dashboard</i> <a href="updateprofile.php" class="btn btn-default pull-right">Update Profile</a></div> <hr> <br><br>
    <?php display_msg(); ?>

     <div class="alert alert-info text-center"><br>
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&nbsp;&nbsp; &times;</a>

        <?php
           require_once('includes/pdo.php');

           //Instatiating database

           $db = new dbase;

           $email = $_SESSION['user_data']['email'];

           $db->query('SELECT * FROM users WHERE email = :email');

           $db->bind(':email', $email , PDO::PARAM_STR);

           $get_user = $db->fetchSingle();

           $profile_value = $get_user['profile_status'];
           $profile_profession = $get_user['profession'];
           $profile_summary = $get_user['summary'];
           $profile_image = $get_user['image'];
           $profile_file = $get_user['file'];
           $profile_reason = $get_user['reason'];

         ?>
         <?php if($profile_value < 1 ){?>


        <div class="progress">
          <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="50"
          aria-valuemin="0" aria-valuemax="100" style="width:50%; background-color: #6c1f74;">
          <p style="color:white; font-size=14px;">50% Profile Completed (update profile) </p>
          </div>
        </div>
     <?php } else{ ?>
        <div class="progress" style="">
          <div class="progress-bar progress-bar-success progress-bar-success" role="progressbar" aria-valuenow="100"
          aria-valuemin="0" aria-valuemax="100" style="width:100%; background-color: #6c1f74;">
          <p style="color:white; font-size=14px;">100% Profile Completed (success)</p>
          </div>
        </div>

<?php } ?>
    </div>



    <div style="padding: 20px; background-color: white; border: 1px solid #ddd;" id="page-content">

     <?php
     $client_email = $_SESSION['user_data']['email'];

     $db->query('SELECT * FROM users WHERE email = :email');
     $db->bind(':email', $client_email, PDO::PARAM_STR);

     $run_membership = $db->fetchSingle();

      $membership_value = $run_membership['membership'];
      $transaction_id =  $run_membership['transaction_id'];

      $id  = $run_membership['id'];
    ?>

     <?php
     if($membership_value > 1){
        echo '<button type="button" class="btn btn-default">Premium Account ID: <span class="badge">'. substr($transaction_id , 0 , 5) .'</span></button>';
     } else
       {
    echo '<button type="button" class="btn btn-default">Basic Account ID: <span class="badge">BS' . $id . '</span></button>';
   }
?>
     <?php

     $client_email = $_SESSION['user_data']['email'];

     $db->query('SELECT COUNT(*) FROM msgs WHERE client_email = :email');
     $db->bind(':email', $client_email, PDO::PARAM_STR);

     $total_msgs = $db->fetchColumn();

       echo '<a href="my-messages.php"><button type="button" class="btn btn-default">Messages <span class="badge">'. $total_msgs . '</span></button></a>'
      ?>
    <a href="complete-order.php?order=3"><button type="button" class="btn btn-default">Saved Order <span class="badge"> $ </span></button>Checkout</a>


           <br><br>



            <div class="row" style=" padding: 2px; border-bottom: 4px solid #841990;">
              <div class="col-md-3 col-sm-4 text-center"><br><br>
              <a href="updateprofile.php"><img src="uploaded_image/<?php echo $profile_image; ?>" class="img-rounded pull-left img-responsive" alt="Upload a Profile Image and complete your Profile" width="100%" height="180" style="border: 1px solid #841990;"></a>

              </div><br>

              <div class="col-md-6 col-sm-12" >
                <h1><?php echo $_SESSION['user_data']['fullname'] ?></h1>

                 <h4 style="color: #ccc"><?php echo $profile_profession; ?></h4>

                  <p><?php echo $profile_summary; ?></p><br>
              </div>

              <div class="col-md-3 col-sm-12" style="border-left: 1px solid #ddd;">

                 <h5 style="color: #841990"><a href="uploaded_files/<?php echo $profile_file; ?>" target="_blank" style="color: #841990"><i class="fa fa-eye"></i> View Certification</a></h5><hr>
                 <h5 data-toggle="modal" data-target="#adminmsg" style="color: #841990"><i class="fa fa-envelope btn btn-default"></i> Message Support</h5><br>

                 <a href="upgrade.php?page=1" style="color:#841990">Upgrade Membership</a><br><hr>

                 <h5 style="color: #841990">Membership Reason: <br><br><?php echo $profile_reason; ?><br> </h5><hr>

              </div>
              <br>

            </div><br>



        </div> <br>

              <!-- Modal -->
                    <div id="adminmsg" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">

                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Messaging Support</h4>
                          </div>
                          <div class="modal-body">

                            <form class="" role="form" method="post" action="">

                                <div class="form-group">
                                    <label for="receiver_email">Email <span class="required">*</span></label>
                                    <input type="text" aria-required="true" size="30" name="receiver_email" value="sanwalvinay@gmail.com" class="form-control" placeholder="" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea aria-required="true" rows="8" cols="45" name="message" id="message" class="form-control" placeholder="Type Message Here "></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="checkbox-inline"><span class="required"></span><input type="checkbox" name="attached" value="<?php echo $profile_file;?>"  >Attach Certification</label>
                                </div>

                                <div class="form-group">

                                    <button type="submit" id="contact_form_submit" name="msg_admin" class="btn btn-default">Submit</button>
                                </div>
                            </form>

                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                          </div>
                        </div>


                      </div>
                    </div>
          <?php

           if(isset($_POST['msg_admin'])){
             //$receiver_email = $_POST['receiver_email'];
             $messsage = addslashes( $_POST['message']);
             $file_attached = $_POST['attached'];

             if(strlen($file_attached) > 0){
               $file_attached = $_POST['attached'];
             }else{

               $file_attached = "";
             }
              $client_email   = $_SESSION['user_data']['email'];
              $client_name    = $_SESSION['user_data']['fullname'];
              $user_filename  = $file_attached;
              $messsage       = $messsage;


              if(strlen($message) > 20){

                send_email($client_email, $client_name, $user_filename, $messsage);

                $db->query('INSERT INTO msgs(id, admin_email , client_email , client_name, msg) VALUES(NULL, :admin_email, :client_email, :client_name , :msg)');

                $db->bind(':admin_email', $admin_email , PDO::PARAM_STR);
                $db->bind(':client_email', $client_email , PDO::PARAM_STR);
                $db->bind(':client_name', $client_name , PDO::PARAM_STR);
                $db->bind(':msg', $msg , PDO::PARAM_STR);

                  $run_msg = $db->execute();
                  if($run_msg){

                    redirect('user-account.php');

                    set_msg('<div class="alert alert-success text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success</strong> Message has been sent</div>');
                  }

              }else{

                redirect('user-account.php');

                set_msg('<div class="alert alert-danger text-center">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Sorry</strong> Message could not been sent.phpmailer error </div>');
              }
           }

        ?>


</div><!--page content-->

<?php include ('includes/footer.php'); ?>
