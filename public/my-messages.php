<?php include ('includes/header.php');

  include 'includes/config.php';

?>
 


<div class="container-fluid">
    <div class="row">
        
        <div class="col-md-2 col-sm-12"></div>
        
            <div class="col-md-8 col-sm-12">
         
               <div class="text-center" style="padding: 5px; background-color: white; border: 1px solid #ddd;"><h3>Your Messages </h3>
             
               </div><br><a href="user-account.php" class="btn btn-default pull-right">Back To Account</a><hr style="border-color: #6c1f74"> 
        
                <?php 
                
                    $db = new dbase;
                
                    $client_email   =   $_SESSION['user_data']['email'];
                    $rep_id         =   0;
                    $db->query('SELECT * FROM msgs WHERE  client_email = :email  AND reply_id = :repid');
                    $db->bind(':email', $client_email, PDO::PARAM_STR);
                    $db->bind(':repid', $rep_id, PDO::PARAM_INT);
                    
                    $result_msgs = $db->fetchMultiple();
                ?>
                
                <?php foreach($result_msgs as $msg){ ?>
                <section id="contact" class="grey_section" style="padding: 20px; border: 1px solid #ddd; background-color: #fff;">
                    <!--<div class="container"> container disabled-->
                        <div class="row">                    
                       
                            <div class="widget col-md-12 to_animate">
                               <h5>From : <?php echo $msg['admin_email'] ?>  </h5> 
                               
                               <h5>Date: <?php echo $msg['date'] ?> </h5> 
                               
                               <h5>To: You  </h5><hr>
                               
                               <button class="btn btn-danger pull-left" id="delete" data-toggle="modal" data-target="#deletemesage<?php echo $msg['id'] ?>">Delete Message</button>
                               
                               <button class="btn btn-default pull-right" data-toggle="modal" data-target="#showmessage<?php echo $msg['id'] ?>" >Follow Update </button>
                               

                            </div>

                        </div>
                    <!--<div"> container disabled-->
                </section><br>
   
                <!-- Modal Shows Messages-->
                    <div id="showmessage<?php echo $msg['id'] ?>" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Messages</h4>
                          </div>
                          <div class="modal-body">
                            <span>Message Body</span>
                            <div class="well well-sm"><?php echo $msg['msg'] ?> </div>
                            <?php
                                
                                $client_email   =   $_SESSION['user_data']['email'];
                                $reply_id       =   $msg['id'];
                                                    
                                $db->query('SELECT * FROM msgs WHERE  client_email = :email AND reply_id = :replyid');
                                $db->bind(':email', $client_email, PDO::PARAM_STR);
                                $db->bind(':replyid', $reply_id, PDO::PARAM_INT);                    

                                $reply_msgs = $db->fetchMultiple();
                            ?>
                            <?php foreach($reply_msgs as $reply){ ?>
                            <span>Reply</span>
                            <div class="well well-sm"><?php echo $reply['msg']; ?> <span class="pull-right"> - <?php echo $reply['notify']; ?></span> </div>
                            <?php } ?>
                            <form class="form-group" action="" method="post">
                                <div class="form-group">
                                   <div>
                                    <span>Reply Message</span>
                                    <textarea name="reply_msg" class="form-control" rows="7" required ></textarea>
                                    </div>
                                    <div>
                                        <input type="hidden" name="client_name" value="<?php echo $_SESSION['user_data']['fullname'] ?> ">
                                    </div>
                                    <div>
                                        <input type="hidden" name="msg_id" value="<?php echo $msg['id']; ?> ">
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
                    
                    <!-- Modal Deleting Messages-->
                        <div id="deletemesage<?php echo $msg['id'] ?>" class="modal fade" role="dialog">
                          <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Confirm Delete</h4>
                              </div>
                              <div class="modal-body">
                                <form role="form" method="post" action="">
                                   <span>Are you sure you want to Delete All Messages ? </span> <br><br>
                                    <input type="hidden" value="<?php echo $msg['id'] ?>" name="deleteid">
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
                    
                    
                  <?php } ?>
                  
                  <?php
                        if(isset($_POST['reply'])){
                            
                            $msg        =   addslashes($_POST['reply_msg']);
                            $name       =   $_POST['client_name'];
                            $msg_id     =   $_POST['msg_id'];
                            $c_email    =   $_SESSION['user_data']['email'];
                            
                            $db->query('INSERT INTO msgs(id, client_email, client_name, msg, notify, reply_id) VALUES(NULL, :clientemail, :clientname, :msg, :notify, :replyid) ');
                            
                            $db->bind(':clientemail', $c_email, PDO::PARAM_STR);
                            $db->bind(':clientname', $name, PDO::PARAM_STR);
                            $db->bind(':msg', $msg, PDO::PARAM_STR);
                            $db->bind(':notify', $name , PDO::PARAM_STR);
                            $db->bind(':replyid', $msg_id, PDO::PARAM_INT);
                            
                            $run = $db->execute();
                            
                            if($run){
                                
                                redirect('my-messages.php');
                            }

                        }
                
                
                
                
                  ?>
                  
                  <?php
                
                    if(isset($_POST['yesdelete'])){
                        
                        $delete_id  =   $_POST['deleteid'];
                        
                        $db->query('DELETE FROM msgs WHERE id= :id');
                        
                        $db->bind(':id', $delete_id, PDO::PARAM_INT);
                        
                        
                        $run = $db->execute();
                            
                            if($run){
                                
                                redirect('my-messages.php');
                            }
                        
                        
                    }
                
                
                
                    ?>
                  
                  
        
            <div class="col-md-2 col-sm-12">
               
                
            </div>  
        
        </div><!--col 8 -->
    </div><!--main row-->
</div>    <br><br><br><br>


        <!-- libraries -->
        <script src="js/vendor/jquery-1.11.1.min.js"></script>
        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/vendor/jquery.appear.js"></script>

        <!-- superfish menu  -->
        <script src="js/vendor/jquery.hoverIntent.js"></script>
        <script src="js/vendor/superfish.js"></script>
        
        <!-- page scrolling -->
        <script src="js/vendor/jquery.easing.1.3.js"></script>
        <script src='js/vendor/jquery.nicescroll.min.js'></script>
        <script src="js/vendor/jquery.ui.totop.js"></script>
        <script src="js/vendor/jquery.localscroll-min.js"></script>
        <script src="js/vendor/jquery.scrollTo-min.js"></script>
        <script src='js/vendor/jquery.parallax-1.1.3.js'></script>

        <!-- widgets -->
        <script src="js/vendor/jquery.easypiechart.min.js"></script><!-- pie charts -->
        <script src='js/vendor/jquery.countTo.js'></script><!-- digits counting -->
        <script src="js/vendor/jquery.prettyPhoto.js"></script><!-- lightbox photos -->
        <script src='js/vendor/jflickrfeed.min.js'></script><!-- flickr -->
        <script src='twitter/jquery.tweet.min.js'></script><!-- twitter -->

        <!-- sliders, filters, carousels -->
        <script src="js/vendor/jquery.isotope.min.js"></script>
        <script src='js/vendor/owl.carousel.min.js'></script>
        <script src='js/vendor/jquery.fractionslider.min.js'></script>
        <script src='js/vendor/jquery.flexslider-min.js'></script>
        <script src='js/vendor/jquery.bxslider.min.js'></script>

        <!-- custom scripts -->
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>

<?php include ('includes/footer.php'); ?>