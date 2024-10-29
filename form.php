<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
	$nameErr = $emailErr = "";
	$reg_name = $reg_email= "";
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reg_submit'])) {
		$page_url=filter_var($_POST['page_url'], FILTER_SANITIZE_URL);
		$page_title = filter_var($_POST['page_title'], FILTER_SANITIZE_STRING);
		
		if (empty($_POST["reg_name"])) {
   			 $nameErr = "Name is required";
			  } else {
				$reg_name = filter_var($_POST['reg_name'], FILTER_SANITIZE_STRING);
				// check if name only contains letters and whitespace
					if (!preg_match("/^[a-zA-Z ]*$/",$reg_name)) {
					  $nameErr = "Only letters and white space allowed"; 
					}
			  }
	 if (empty($_POST["reg_email"])) {
			$emailErr = "Email is required";
		  } else {
			$reg_email =  filter_var($_POST['reg_email'], FILTER_VALIDATE_EMAIL);
			// check if e-mail address is well-formed
				if (!filter_var($reg_email, FILTER_VALIDATE_EMAIL)) {
				  $emailErr = "Invalid email format"; 
				}
		  }	

	if(!empty($_POST['reg_name'] ) && $_POST['reg_email']) { 
	global $wpdb;
	$res=$wpdb->insert($wpdb->prefix.'reg_form', array('page_title'=>$page_title, 'page_url'=>$page_url, 'reg_name'=>$reg_name, 'reg_email'=>$reg_email));
	
	if ($res){
		$sucess_message="Thankyou Your Message has been sent"; 
		
		}
	
	}
 }

?>

<div class="register-info"> 
    <h4 class="register-title">Register Form</h4>
      <div class="row reg-from">        
          <form id="reg-form" method="POST">
              <div class="form-group col-md-4 col-sm-4">
              
                  <input type="text" class="form-control"  id="reg_name"  name="reg_name" placeholder="Enter Name">
                  <span class="reg-error"><?php echo $nameErr;?></span>
              </div>
              <div class="form-group col-md-4 col-sm-4">
                  <input type="email" class="form-control"  id="reg_email" name="reg_email" placeholder="Enter Email Address">
                   <span class="reg-error"> <?php echo $emailErr;?></span>
				  
              </div>
              <div class="form-group col-md-4 col-sm-4">
              <input type="hidden" id="page_title" name="page_title" value="<?php echo get_the_title(); ?>">
					<input type="hidden" id="page_url" name="page_url" value="<?php echo get_permalink(); ?>">
                  <input type="submit" class="btn btn-join-reg" name="reg_submit" value="Join">
				  
				  <div class="sucess-message"><?php echo $sucess_message; ?> </div>
              </div>
			   
          </form>
      </div>
 </div>