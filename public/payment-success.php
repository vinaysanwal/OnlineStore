<?php include ('includes/header.php'); ?>

    
<?php include("includes/config.php"); 

if(isset($_SESSION['user_logged_in'])){ 

    //Do nothing

}else{
    
    redirect('logout.php');
    
}


$db = new dbase;


?>



<div class="container">
    <div class="row">
        
        <div class="col-md-2 col-sm-12"></div>
        
            <div class="col-md-8 col-sm-12">
                <section id="contact" class="grey_section" style="padding: 20px; border: 1px solid #ddd; background-color: #fff;">
                    <!--<div class="container"> container disabled-->
                        <div class="row">                    
                            <div>
                                <header class="section_header">
                                    <h5>THANK YOU FOR YOUR ORDER</h5><hr>
                                </header>
                            <div class="widget col-md-6 col-md-offset-3 to_animate">
<?php
    
    if(isset($_GET['tx'])){
        
        $transaction_id         = $_GET['tx'];
        $transaction_status     = strtolower($_GET['st']);
        $transaction_amt        = $_GET['amt'];
        
        $int_amt                = preg_replace('~\.0+$~','',$transaction_amt);
        
        $client_email           = $_SESSION['user_data']['email'];
        
        $admin_token            = "ADSGVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVE55115";
  
    }


    // Init cURL
    $paypal_request = curl_init();

    // Set request options
    curl_setopt_array($paypal_request, array
    (
      CURLOPT_URL => 'https://www.sandbox.paypal.com/cgi-bin/webscr',
      CURLOPT_POST => TRUE,
      CURLOPT_POSTFIELDS => http_build_query(array
        (
          'cmd' => '_notify-synch',
          'tx' => $transaction_id,
          'at' => $admin_token,
        )),
      CURLOPT_RETURNTRANSFER => TRUE,
      CURLOPT_HEADER => FALSE,
    ));

    // Execute request and get response and status code
    $response = curl_exec($paypal_request);
    $status   = curl_getinfo($paypal_request, CURLINFO_HTTP_CODE);

    // Close connection
    curl_close($paypal_request);                         


    if($status == 200 AND strpos($response, 'SUCCESS') === 0 ){
   
        //show the users that thier order was successful
        showUserSuccess();
        
        //insert detials in orders table
        insertOrderDetails();
        
        //delete record from the saved orders database using email of user session
        deleteSavedOrder();
        
        //update membership = 2, insert transaction id and update profile = 1
        updateUserProfile();
        
        //Email the user with transaction details and attached purchased file
        emailUser();
        
        
        
    }else{
        
        //show users that transaction was not successful
        
        echo '<div class="alert alert-danger text-center">
              <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
              <strong>Sorry!</strong> Your Transaction was not successful, <br> You will be redirected to your account in 10 seconds. Please try again.
            </div>';
        
        header('Refresh: 15; URL=http://paulamissah.xyz/demo/virtualines/public/user-account.php');
        
    }

   
    function showUserSuccess(){
        
        $client_email           = $_SESSION['user_data']['email'];
        
        echo '<div class="alert alert-success text-center">
              <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
              <strong>Success!</strong> Dear ' . $_SESSION['user_data']['fullname']  .  ' <br>Thank you for your purchase. <br>Your Order Details have been sent to your email (' . $client_email . ' ) Please Keed your Order ID for futur purposes. Your File has also been attached. <br> Note that your profile has been automatically updated.
              <br>
              You will be redirect to your account after 1 minute. 
            </div>';
        
        //Function to redirect pages after certain minute
       header('Refresh: 30; URL=http://paulamissah.xyz/demo/virtualines/public/user-account.php');
        
    }
    
    function insertOrderDetails(){
        
        $db = new dbase;
        
        $transaction_id         = $_GET['tx'];
        
        $transaction_amt        = $_GET['amt'];
        
        $int_amt                = preg_replace('~\.0+$~','',$transaction_amt);
        
        $client_email           = $_SESSION['user_data']['email'];
        
        $db->query('INSERT INTO orders(id, tx_id, amt, client_email) VALUES(NULL, :tx_id, :amt, :client_email)');
        
        $db->bind(':tx_id', $transaction_id, PDO::PARAM_STR);
        $db->bind(':amt', $int_amt, PDO::PARAM_INT);
        $db->bind(':client_email', $client_email, PDO::PARAM_STR);
        
        $db->execute();
    
    }
    
    
    function deleteSavedOrder(){
        
        $db = new dbase;
        
        $client_email           = $_SESSION['user_data']['email'];
        
        $db->query('DELETE FROM saved_orders WHERE email = :email');
        
        $db->bind(':email', $client_email, PDO::PARAM_STR);
        
        $db->execute();
 
    } 
                                
    
    function updateUserProfile(){
        
        $db = new dbase;
        
        $transaction_id         = $_GET['tx'];
        
        $membership         = 2;
        
        $profile_status     = 1;
        
        $client_email      = $_SESSION['user_data']['email'];
        
        $db->query('UPDATE users SET membership =:membership, transaction_id =:tx_id, profile_status =:profilestatus WHERE email = :email');
        
        $db->bind(':email', $client_email, PDO::PARAM_STR);
        $db->bind(':tx_id', $transaction_id, PDO::PARAM_STR);
        $db->bind(':membership', $membership, PDO::PARAM_INT);
        $db->bind(':profilestatus', $profile_status, PDO::PARAM_INT);
        
        $db->execute();
        
    }
    
    
    function emailUser(){
        
        $db = new dbase;
        
        
        $transaction_amt        = $_GET['amt'];
        
        $int_amt                = preg_replace('~\.0+$~','',$transaction_amt);
  
        $db->query('SELECT * FROM products WHERE item_price =:int_amt');
        
        $db->bind(':int_amt', $int_amt, PDO::PARAM_INT);
        
        $result            = $db->fetchSingle();
        
        $filename          = $result['file'];
        
        $package_name      = $result['item_name'];
        
        $client_email      = $_SESSION['user_data']['email'];
        $client_name       = $_SESSION['user_data']['fullname']; 
        
        $transaction_id    = $_GET['tx'];
        
         
        $messsage = '<div style="border:2px solid #ddd">
                    <h3>Order Details From Virtualines.Com<h3><br>
                    <p>Order ID:' . $transaction_id . ' </p><br>
                    <p>Package Name:' . $package_name . ' </p><br>
                    <p>Thank You for your Order</p>
                    </div>';
        
        email_user($client_email, $client_name, $filename, $messsage);
         
        
    }                             
                                
                                
                              
                                
                                
                                
                                
                                
                                
                                
?>    
                           
                                       
                            <br />

                                                
                        </div>

                        </div>

     
                      </div>
                    <!--<div"> container disabled-->
                </section>
        
            <div class="col-md-2 col-sm-12"></div>  
        
        </div><!--col 8 -->
    </div><!--main row-->
</div>    <br><br><br><br>
                                       


<?php include ('includes/footer.php'); ?>