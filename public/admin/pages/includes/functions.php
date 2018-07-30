<?php 

/********Start of Helper Functions***********/



//Function to trim values

function clean($value){        //$username  = clean($_POST['username']);
    
    return trim($value);
    
}



//Function to sanitize strings

function santize($raw_value){       //$username  = santize($_POST['username']);
    
    return filter_var($raw_value, FILTER_SANITIZE_STRING);
    
}



//Function to validate email
function val_email($raw_email){         //$clean_email  = val_email($_POST['email']);
    
    return filter_var($raw_email, FILTER_VALIDATE_EMAIL);
    
}



//function to validate int

function val_int($raw_int){      //$cl_age  = val_int($_POST['age']);
    
    return filter_var($raw_int, FILTER_VALIDATE_INT);
    
}



//Function to hash passwords

function hash_pwd($raw_password){   //$hashed_password  = hash_pwd($_POST['password']);
    
    return md5($raw_password);
    
}



//Function to redirect

function redirect($url){            //redirect(index.php);
    
    return header("Location: {$url}");
    
}




//Function to display session messages

function set_msg($msg){                 //"Welcome to your account"; 
    
    if(empty($msg)){
        
        $msg = "";
        
    }else{
        
        $_SESSION['setmsg'] = $msg;
        
    }
    
}


function display_msg(){
    
    if(isset($_SESSION['setmsg'])){
        
        echo $_SESSION['setmsg'];
        
        unset($_SESSION['setmsg']);
    }
    
    
}




function process_registration(){
    
    if(isset($_POST['submit_registration'])){
        
        $raw_name       =   clean($_POST['name']);
        $raw_sex        =   clean($_POST['sex']);
        $raw_email      =   clean($_POST['email']);
        $raw_password   =   clean($_POST['password']);
        
        
        $cl_name        =   santize($raw_name);
        $cl_sex         =   santize($raw_sex);
        $cl_email       =   val_email($raw_email);
        $cl_password    =   santize($raw_password);
        
        
        //Hashed Password
        $hashed_password = hash_pwd($cl_password);
        
        //Check for the right the image
        $allowed_image  =   array('png', 'jpg', 'jpeg');
   
        $raw_image      =   $_FILES['image']['name'];
        
        $image_ext      =   pathinfo($raw_image, PATHINFO_EXTENSION);
        
        if(!in_array($image_ext, $allowed_image)){
            
             redirect('register.php');
                    
            set_msg('<div class="alert alert-danger text-center">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Warning!</strong> Sorry, The file type is not allowed. Please Try again
            </div>');
            
        }else{
            //attache a random value betweeon 1000 to 100000 to the file
            $new_image      = rand(1000, 100000)."_".$_FILES['image']['name'];
            
            //Temporary folder for file
            $temp_folder    = $_FILES['image']['tmp_name'];
            
            //Will change the filename to lower cases
            $new_image_name = strtolower($new_image);
            
            $cl_image       = str_replace('','_', $new_image_name);
            
            $folder         = "uploaded_image/";
            
            require_once('pdo.php');
                
            //Instatiating our object from the dbase class
            $db = new dbase;
            
            $db->query('SELECT * FROM users WHERE email = :email');
            
            $db->bind(':email', $cl_email , PDO::PARAM_STR);
            
            $get_user = $db->fetchSingle();
            
            if($get_user > 0){
                
                redirect('login.php');
                
                set_msg('<div class="alert alert-danger text-center">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Hi !</strong> You have already registered, Please Login.
                    </div>');
                
            }elseif(move_uploaded_file($temp_folder, $folder.$cl_image)){
                
                $db->query('INSERT INTO users(id, fullname, sex, password, image, email) VALUES(NULL, :fullname, :sex, :password, :image, :email) ');
                
                $db->bind(':fullname', $cl_name , PDO::PARAM_STR);
                $db->bind(':sex', $cl_sex , PDO::PARAM_STR);
                $db->bind(':password', $hashed_password , PDO::PARAM_STR);
                $db->bind(':image', $cl_image , PDO::PARAM_STR);
                $db->bind(':email', $cl_email , PDO::PARAM_STR);
                
                $run = $db->execute();
                
                if($run){
                    
                    redirect('login.php');
                    
                    set_msg('<div class="alert alert-success text-center">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Success!</strong> Registration successfull. Please Login.
                    </div>');
                    
                }else{
                    
                    echo '<div class="alert alert-danger text-center">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Sorry!</strong> Registration not successfull. Please Try again.
                    </div>';
                    
                }
                
                
            }
            
            
        }
            
        
        
    }
    
    
    
}


function login_admin(){
    
    if(isset($_POST['login_admin'])){
        
        $raw_email      =   clean($_POST['email']);
        $raw_password   =   clean($_POST['password']);
        
        $cl_email       =   val_email($raw_email);
        $cl_password    =   santize($raw_password);
        
        $hashed_password = hash_pwd($cl_password);
        
        require_once('pdo.php');
                
        //Instatiating our object from the dbase class
        $db = new dbase;
        
        $db->query('SELECT * FROM admin WHERE email = :email AND password= :password');
            
        $db->bind(':email', $cl_email , PDO::PARAM_STR);
        $db->bind(':password', $hashed_password , PDO::PARAM_STR);
        
        $get_user   = $db->fetchSingle();
        
        $privilege  = $get_user['privilege'];
        
        if($get_user > 0){
            
            
            if($privilege == 1 ){
                
                redirect('index.php');
            
                $_SESSION['admin_logged_in'] = true;

                $_SESSION['admin_data']  =   array(

                    'fullname'  =>  $get_user['fullname'],
                    'id'        =>  $get_user['id'],
                    'email'     =>  $get_user['email'],
                   

                );
                
            }elseif($privilege == 2){
                
                redirect('tables.php');
            
                $_SESSION['emp_logged_in'] = true;

                $_SESSION['emp_data']  =   array(

                    'fullname'  =>  $get_user['fullname'],
                    'id'        =>  $get_user['id'],
                    'email'     =>  $get_user['email'],
                    

                );
                
            }else{
                
                //Do Nothing
            }
            
            

        }else{
            
            redirect('login.php');
                    
            set_msg('<div class="alert alert-danger text-center">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Sorry!</strong> Contact Admin for Login Details. 
            </div>');
            
        }
        
        
        
    }

    
}


?>




















