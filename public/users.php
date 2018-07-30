<?php include ('includes/header.php'); 

include("includes/config.php");


if($_SESSION['emp_logged_in'] = true){
    
    //Do Nothing
}else{
    
    redirect('logout');
}

?>
  

<script>
    
$(document).ready(function(){
    
    $('#search').keyup(function(){
        
        var searchInput =$('#search').val();
        var location    =$('#location').val();
        var reason      =$('#reason').val(); 
        
        $.ajax({
            url:'search.php',
            data:{getInput:searchInput, getlocation:location, getreason:reason},
            type:'POST',
            success:function(result){
                
                if(!result.error){
                    
                    $('#result').html(result);
                }
                
            }
            
        });
        
        
    });
    
});
    
</script>

<div class="container">
    
       
              <h4 class="">Refine Search <a href="admin/pages/tables.php" class="btn btn-default pull-right">Back To Admin</a></h4> <br> 
                 <div style="padding: 20px; border: 1px solid #ddd; background-color: #fff;">
                    
                    <div class="row">
                      
                        <div class="col-md-3">
                           <p>Select Location</p>
                            <div class="form-group">
                              
                              <select class="form-control" id="location">
                                <option>Toggle Location</option>
                                 <?php
                                  
                                    $db = new dbase;
                                  
                                    $db->query('SELECT * FROM users');
                                       
                                    $users  =   $db->fetchMultiple();
                                  
                                  ?>
                                <?php foreach($users as $user){ ?>
                                <option><?php echo $user['location'] ?> </option>
                                <?php } ?> 
                              </select>
                            
                            </div>
                        </div>
                         <div class="col-md-3">
                           <p>Select Reason</p>
                            <div class="form-group">
                              
                              <select class="form-control" id="reason">
                                <option value="">Togle Reason</option>
                                <option value="Personal">Personal</option>
                                <option value="Family">Family</option>
                                <option value="Friend">Friend</option>
                                <option value="Contract">Contract</option>
                              </select>
                            
                            </div>
                        </div>
                         <div class="col-md-6">
                         <p>Which Profession ?</p>
                          <input class='form-control' type="text" name='search' id='search' placeholder='Start Typing..'>
                         </div>
                         
                          <br><br><br>
                             
                          <div id="result">
                          
                                 
                                  
                          </div>
                    </div>
                 </div><br>
               
                <section id="contact" class="grey_section" style="padding: 20px; border: 1px solid #ddd; background-color: #fff;">
                    <!--<div class="container"> container disabled-->
                        <div class="row">                    
                            <div>
                                <header class="section_header">
                                     <h5 class="">Veiwing Members</h5><hr>
                                   
                                    
                                </header>
                            <div class="widget col-md-12 to_animate">

                                   <table class="table table-bordered table-hover" style="background-color: #fff">
                                        
                                        <tr class="info">
                                        <td class="text-center"><strong>Full Name</strong></td>
                                        <td class="text-center"><strong>Email</strong></td>
                                        <td class="text-center"><strong>Location</strong></td>
                                        <td class="text-center"><strong>Image</strong></td>
                                        <td class="text-center"><strong>Profession</strong></td>
                                        <td class="text-center"><strong>Profile</strong></td>
                                        </tr>
                                 
                                       <?php 
                                            $db->query('SELECT * FROM users ORDER BY date DESC LIMIT 10');
                                       
                                            $results = $db->fetchMultiple();
                                       
                                       ?>
                                       
                                       <?php foreach($results as $user){ ?>
                                        <tr>
                                        <td class="text-center"><br><?php echo $user['fullname'] ?> </td>
                                        <td class="text-center"><br><?php echo $user['email'] ?></td>
                                        <td class="text-center"><br><?php echo $user['location'] ?></td>
                                        <td class="text-center"><img src="uploaded_image/<?php echo $user['image'] ?>" class="img-rounded" alt="Image" width="50" height="60"></td>
                                        <td class="text-center"><br><?php echo $user['profession'] ?></td>
                                        <td class="text-center"><br><a href="user.php?user_id=<?php echo $user['id'] ?>">View Profile</a></td>
                                        </tr>
                                      <?php } ?>
                                    </table>
                                
                            </div>
                                    
                            </div>

                        </div>
                        
                        
                        
                    <!--<div"> container disabled-->
                </section>
                
        
  
</div>



<?php //include ('includes/footer.php'); ?>