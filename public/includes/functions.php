<?php

/******** start of helper functions *******/

//function to trim values

function clean($value){   // way to use this  =>> $username = clean($_post['username']);
  return trim($value);
}

//function to santize a strings
function santize($raw_value){  // way to use this  =>> $username = santize($_post['username']);
  return filter_var($raw_value, FILTER_SANTIZE_STRING)
}

//functions to validate email

function val_email($raw_email){  // way to use this  =>> $clean_email = val_email($_post['email']);
  return filter_var($raw_email, FILTER_VALIDATE_EMAIL);
}

//functions to validate integers

function val_int($raw_int){   // way to use this  =>> $cl_age = val_int($_post['age']);
  return filter_var($raw_int , FILTER_VALIDATE_INT)
}


//function to hash passwords

function hash_pwd($raw_password){  // way to use this  =>> $hashed_password = hash_pwd($_Post['password']);
  return md5($raw_password);
}


//functions to redirects a pages

function redirect($url){   //redirect(index.php)
  return header("Location: {$url}" );
}


//function to session messages
function set_msg($msg){
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


?>
