<?php include ('includes/header.php'); 

include("includes/config.php");


if($_SESSION['emp_logged_in'] = true){
    
    //Do Nothing
}else{
    
    redirect('logout');
}

$user_id = $_GET['user_id'];

?>
<?php 
        
        require_once('includes/pdo.php');
        //Instatiating Database class
        $db= new dbase;
    
            //$email = $_SESSION['user_data']['email'];
    
            $db->query('SELECT * FROM users WHERE id = :user_id');
            
            $db->bind(':user_id', $user_id , PDO::PARAM_INT);
            
            $get_user = $db->fetchSingle();
    
            $profile_value      =   $get_user['profile_status'];
            $profile_profession =   $get_user['profession'];
            $profile_summary    =   $get_user['summary'];
            $profile_image      =   $get_user['image'];
            $profile_file       =   $get_user['file'];
            $profile_reason     =   $get_user['reason'];
    
            $_SESSION['user_fullname']       =   $get_user['fullname'];

            $fullname                        =   $get_user['fullname'];

            $_SESSION['user_email']          =   $get_user['email'];
 
?>
   

<div class="container">
 
    <div class="col-sm-12" style="padding: 10px; background-color: white; border: 1px solid #ddd;"><i class="fa fa-user" style="font-size:28px"> Profile of <?php echo $fullname ?> </i> <button class="btn btn-danger pull-right" id="delete" data-toggle="modal" data-target="#deletemesage<?php echo $user_id ?>">Delete Client</button></div> <hr> <br><br>
    <?php display_msg() ?>
    
    <a href="admin/pages/tables.php"><button class="btn btn-default pull-right">Back to Admin</button></a>
    <br><br><br>
    
     <div class="alert alert-info text-center"><br>
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&nbsp;&nbsp; &times;</a>

       
       
       <?php if($profile_value < 1){ ?>
  
        <div class="progress">
          <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="50"
          aria-valuemin="0" aria-valuemax="100" style="width:50%; background-color: #6c1f74;">
          <p style="color:white; font-size=14px;">50% Profile Completed (update profile) </p>
          </div>
        </div>
         <?php }else{ ?>
        <div class="progress" style="">
          <div class="progress-bar progress-bar-success progress-bar-success" role="progressbar" aria-valuenow="100"
          aria-valuemin="0" aria-valuemax="100" style="width:100%; background-color: #6c1f74;">
          <p style="color:white; font-size=14px;">100% Profile Completed (success)</p>
          </div>
        </div> 

        <?php } //Ending else statement ?> 
    </div>



    <div style="padding: 20px; background-color: white; border: 1px solid #ddd;" id="page-content">
       
       
       <?php 
        
        //$client_email = $_SESSION['user_data']['email'];
        
        $db->query('SELECT * FROM users WHERE id = :user_id');
        $db->bind(':user_id', $user_id , PDO::PARAM_INT);
        
        $run_membership = $db->fetchSingle();
        
        $member_value = $run_membership['membership'];
        
        $transact_id  = $run_membership['transaction_id'];
        
        $id           = $run_membership['id'];
        
        ?>
        
        <?php if($member_value > 1){
    
        echo '<button type="button" class="btn btn-default">Premium Account ID:<span class="badge">' . substr($transact_id, 0,5) .  '</span></button>';
        }else{
            echo '<button type="button" class="btn btn-default">Basic Account ID: <span class="badge">BS'. $id.'</span></button>';
        }
      
        ?>
        
    <?php     
        
        $client_email = $_SESSION['user_email'];
        
        $db->query('SELECT COUNT(*) FROM msgs WHERE  client_email = :email');
        $db->bind(':email', $client_email, PDO::PARAM_STR);
        
        $total_msgs = $db->fetchColumn();
        
        
    echo '<button type="button" class="btn btn-default" data-toggle="modal" data-target="#showmessage' . $user_id . ' ">Messages <span class="badge">'. $total_msgs . '</span></button>';
         
    ?>
    
    <?php 
        
        //$email    =   $_SESSION['user_data']['email'];

        $db->query('SELECT * FROM saved_orders WHERE id = :user_id');
        $db->bind(':user_id', $user_id , PDO::PARAM_INT);

        $result_order = $db->fetchSingle();
 
        $_SESSION['item_price']  =   $result_order['item_price'];
        
        $tx_id                   =   $result_order['transaction_id'];
        
        $db_email                =   $result_order['email'];
    ?>
    
    <?php
        if($db_email && strlen($tx_id) < 1 ){
            
           echo '<a href="upgrade.php?page=4"><button type="button" class="btn btn-default">Saved Order <span class="badge"> $ ' . $_SESSION['item_price'] . '</span></button>Checkout</a>';
            
        }
        
    ?>    
    
    
          
           <br><br>
          
           
            
            <div class="row" style=" padding: 2px; border-bottom: 4px solid #841990;">
              <div class="col-md-3 col-sm-4 text-center"><br><br>
              <a href="updateprofile.php"><img src="uploaded_image/<?php echo $profile_image ; ?> " class="img-rounded pull-left img-responsive" alt="Upload a Profile Image and complete your Profile" width="100%" height="180" style="border: 1px solid #841990;"></a>
              
              </div><br>
              
              <div class="col-md-6 col-sm-12" >
                <h1><?php echo $_SESSION['user_fullname'] ?></h1>
                 
                 <h4 style="color: #ccc"><?php echo $profile_profession ; ?> </h4>
                 
                  <p><?php echo $profile_summary ; ?> </p><br>
              </div>
              
              <div class="col-md-3 col-sm-12" style="border-left: 1px solid #ddd;">
                 
                 <h5 style="color: #841990"><a href="user_files/<?php echo $profile_file ?>" target="_blank" style="color: #841990"><i class="fa fa-eye"></i> View Certification</a></h5><hr>
                 <h5 data-toggle="modal" data-target="#msg_client<?php echo $user_id ?> " style="color: #841990"><i class="fa fa-envelope btn btn-default"></i> Message <?php echo $fullname ?></h5><br>
                 
                 <h5 style="color: #841990">Membership Reason: <br><br> <?php echo $profile_reason ; ?></h5><hr>
   
              </div>
              <br>
              
        </div><br>
        
        
         <!-- Modal -->
                    <div id="msg_client<?php echo $user_id ?>" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                        
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Messaging <?php echo $fullname ?></h4>
                          </div>
                          <div class="modal-body">
                        
                            <form class="" role="form" method="post" action="">

                                <div class="form-group">
                                    <label for="receiver_email">Email <span class="required">*</span></label>
                                    <input type="text" aria-required="true" size="30" name="receiver_email" value="<?php echo $_SESSION['user_email'] ?>" class="form-control" placeholder="" disabled>
                                </div>
                                
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea aria-required="true" rows="8" cols="45" name="message" id="message" class="form-control" placeholder="Type Message Here "></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="checkbox-inline"><span class="required"></span><input type="checkbox" value="2" name="notify">Notify by Email</label>
                                </div>

                                <div class="form-group">
                                    <!-- <input type="submit" value="Send" id="contact_form_submit" name="contact_submit" class="theme_button"> -->
                                    <button type="submit" id="contact_form_submit" name="msg_client" class="btn btn-default">Submit</button>
                                </div>
                            </form>
                        
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                          </div>
                        </div>
                      

                      </div>
                    </div>
                    
                <!-- Modal Deleting Messages-->
                        <div id="deletemesage<?php echo $user_id ?>" class="modal fade" role="dialog">
                          <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Confirm Delete</h4>
                              </div>
                              <div class="modal-body">
                                <form role="form" method="post" action="">
                                   <span>Are you sure you want to Delete this Client ? </span> <br><br>
                                    <input type="hidden" value="<?php echo $user_id ?>" name="deleteid">
                                  <button type="submit" name="yesdelete" class="btn btn-danger">Yes Delete</button>
<!--                                  <button type="submit" class="btn btn-default">No Thanks</button>-->
                                </form>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>
                            </div>

                          </div>
                        </div>
                        
                <!-- Modal Shows Messages-->
                    <div id="showmessage<?php echo $user_id ?>" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Messages</h4>
                          </div>
                          <div class="modal-body">
                           <?php
                                
                                $client_email   =   $_SESSION['user_email'];
                                //$reply_id       =   $msg['id'];
                                                    
                                $db->query('SELECT * FROM msgs WHERE  client_email = :email ORDER BY date DESC LIMIT 1 ');
                                $db->bind(':email', $client_email, PDO::PARAM_STR);
                                                 

                                $recent_msgs = $db->fetchSingle();
                         
                                $msg        =   $recent_msgs['msg'];
                                $msg_id     =   $recent_msgs['reply_id'];
                            ?>
                            <span>Message Body</span>
                            <div class="well well-sm"><?php echo $msg ?> <span class="pull-right"> - <?php echo $recent_msgs['notify']; ?></span></div>
                        
                            <form class="form-group" action="" method="post">
                                <div class="form-group">
                                   <div>
                                    <span>Reply Message</span>
                                    <textarea name="reply_msg" class="form-control" rows="7" required ></textarea>
                                    </div>
                                    <div>
                                        <input type="hidden" name="client_name" value="<?php echo $_SESSION['user_fullname']; ?> ">
                                    </div>
                                    <div>
                                        <input type="hidden" name="msg_id" value="<?php echo $msg_id; ?> ">
                                    </div>
                                    <br>
                                    <button class="btn btn-primary" name="reply">Reply</button>    
                                    
                                </div>
                           
                            </form>
                            
                            
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>

                      </div>
                    </div>
                       
                    <?php
                        if(isset($_POST['reply'])){
                            
                            $msg        =   addslashes($_POST['reply_msg']);
                            $name       =   'Admin';
                            $msg_id     =   $_POST['msg_id'];
                            $c_email    =   $_SESSION['user_email'];
                            
                            $db->query('INSERT INTO msgs(id, client_email, client_name, msg, notify, reply_id) VALUES(NULL, :clientemail, :clientname, :msg, :notify, :replyid) ');
                            
                            $db->bind(':clientemail', $c_email, PDO::PARAM_STR);
                            $db->bind(':clientname', $name, PDO::PARAM_STR);
                            $db->bind(':msg', $msg, PDO::PARAM_STR);
                            $db->bind(':notify', $name , PDO::PARAM_STR);
                            $db->bind(':replyid', $msg_id, PDO::PARAM_INT);
                            
                            $run = $db->execute();
                            
                            if($run){
                                
                                redirect('user.php?user_id=' . $user_id . ' ');
                                
                                set_msg('<div class="alert alert-success text-center">
                                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                  <strong>Success!</strong> Message Successfully Sent. 
                                </div>');
                                
                            }

                        }
                
                
                
                
                  ?>   
                       
                        
                    
                    <?php
                
                        if(isset($_POST['yesdelete'])){

                            $delete_id  =   $_POST['deleteid'];

                            $db->query('DELETE FROM users WHERE id= :id');

                            $db->bind(':id', $delete_id, PDO::PARAM_INT);


                            $run = $db->execute();

                                if($run){

                                    redirect('admin/pages/tables.php');
                                    
                                    set_msg('<div class="alert alert-success text-center">
                                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                  <strong>Success!</strong> Client has been successfully Deleted. 
                                </div>');
                                    
                                }


                        }

                    ?>
                    
<?php     
    
    if(isset($_POST['msg_client'])){
        
       
        $message            =   addslashes($_POST['message']);

        $client_email       =   $_SESSION['user_email'];
        $client_name        =   $_SESSION['user_fullname'];
        
        if(strlen($message) > 20){
        
     
            $db->query('INSERT INTO msgs(id, admin_email, client_email, client_name, msg) VALUES(NULL, :admin_email, :client_email, :client_name, :msg) ');
            
            $admin_email = 'contact@paulamissah.xyz';
            
            $db->bind('admin_email', $admin_email , PDO::PARAM_STR);
            $db->bind(':client_email', $client_email, PDO::PARAM_STR);
            $db->bind(':client_name', $client_name , PDO::PARAM_STR);
            $db->bind(':msg', $message , PDO::PARAM_STR);
            
            $run_msg = $db->execute();
            
            if($run_msg){
                
                redirect('user.php?user_id=' . $user_id . ' ');
            
                set_msg('<div class="alert alert-success text-center">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Success!</strong> Message has been Sent. 
                </div>');
                
            }else{
            
            redirect('user.php?user_id=' . $user_id . ' ');
            
            set_msg('<div class="alert alert-danger text-center">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Sorry!</strong> Message was not sent, Message should be more than 20 Characters. 
            </div>');
            
        }
        
      
    }
        
        $notify_email       =   $_POST['notify'];
        
        if($notify_email == 2){

            send_email($client_email, $client_name, $messsage);


        }    
         
    
}
    
                        
                                        
?>            

  
</div><!--page content-->

<?php include ('includes/footer.php'); ?>