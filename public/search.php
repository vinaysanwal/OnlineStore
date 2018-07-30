<?php

include("includes/config.php");


$db = new dbase;

if(isset($_POST['getInput'])){
    

    
   $profession     = $_POST['getInput'];
   $location       = $_POST['getlocation'];
   $reason         = $_POST['getreason'];
    
$db->query('SELECT * FROM users WHERE location = :location AND reason = :reason AND profession LIKE :profession ');

$db->bind(':location', $location, PDO::PARAM_STR);
$db->bind(':profession', '%' . $profession . '%', PDO::PARAM_STR);
$db->bind(':reason', $reason, PDO::PARAM_STR);

$results = $db->fetchMultiple();
    
if(!$results){
    
    echo '<br><br>';
    echo '<div class="bg-danger text-center"> Client Could Not Be Found</div>';
    
}else{
    
    foreach($results as $user){
    
    
      echo   '<div class="widget col-md-12 to_animate">

               <table class="table table-bordered table-hover" style="background-color: #fff">

                    <tr class="info">
                    <td class="text-center"><strong>Full Name</strong></td>
                    <td class="text-center"><strong>Email</strong></td>
                    <td class="text-center"><strong>Location</strong></td>
                    <td class="text-center"><strong>Image</strong></td>
                    <td class="text-center"><strong>Profession</strong></td>
                    <td class="text-center"><strong>Profile</strong></td>
                    </tr>

                    <tr>
                    <td class="text-center"><br>' . $user['fullname'] . '</td>
                    <td class="text-center"><br>' . $user['email'] . '</td>
                    <td class="text-center"><br>' . $user['location'] . '</td>
                    <td class="text-center"><img src="uploaded_image/' . $user['image'] . '" class="img-rounded" alt="Image" width="50" height="60"></td>
                    <td class="text-center"><br>' . $user['profession'] . '</td>
                    <td class="text-center"><br><a href="user.php?user_id=' . $user['id'] . ' ">View Profile</a></td>
                    </tr>
                  <?php } ?>
                </table>

        </div>';
  
    
    }
    
    
    
}    
    
    

}    
    
?>