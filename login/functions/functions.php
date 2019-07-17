<?php
function set_message($message){
	if(!empty($message)){
		$_SESSION['message'] = $message;
	}else{
		$message ="";
	}
}
function display_message(){
	if(isset($_SESSION['message'])){
		echo $_SESSION['message'];
		unset($_SESSION['message']);
	}
}

function token_generator(){
	
	$token =$_SESSION['token'] = md5(uniqid(mt_rand(), true));
	return $token;
}


function validate_user_registration(){
	$errors=[];
	$min = 3;
	$max = 6;
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$firstname = clean($_POST['firstname']);
		$lastname = clean($_POST['lastname']);
		$username = clean($_POST['username']);
		$email = clean($_POST['email']);
		$password = clean($_POST['password']);
		$confirmpassword = clean($_POST['confirm_password']);
		
		if(strlen($firstname) < $min){
			$errors[] = "The first name cannot be less than {$min} <br />";				
		}
		if(strlen($lastname) < $min){
			$errors[] = "The last name cannot be less than {$min} <br />";				
		}
		if(strlen($username) < $min){
			$errors[] = "The username cannot be less than {$min} <br />";				
		}
		if(strlen($password) < $min){
			$errors[] = "The password cannot be less than {$min} <br />";				
		}
		if($password !== $confirmpassword){
			$errors[] = "The password must match <br /> ";		
		}
		
		if(email_exists($email)){
			$errors [] ="Email  already exists";
		}
		if(username_exists($username)){
			$errors [] ="Username already taken";
		}
		if(!empty($errors)){
			foreach($errors as $error){
				echo error_message($error);
				
			}
		}else{
			if(register_users($firstname, $lastname, $username, $email, $password)){
				set_message("<p class='bg-success text-center'>Please check your email inbox or spam folder for activation link</p>");
				
				redirect("index.php");
			}
		}
		
		
	}
	
	
}
function clean($string){
	return htmlentities($string);
}
function email_exists($email){
	
	$sql ="SELECT user_id FROM users WHERE email ='$email' ";
	$results = query($sql);
	$count = row_count($results);
	if($count ==1){
		return true;
	}else{
		return false;
	}
}
function username_exists($usernamel){
	
	$sql ="SELECT user_id FROM users WHERE username ='$usernamel' ";
	$results = query($sql);
	$count = row_count($results);
	if($count ==1){
		return true;
	}else{
		return false;
	}
}
function send_email($email, $subject, $msg, $header){
	return mail($email, $subject, $msg, $header);
}

// Register users
function register_users($firstname, $lastname, $username, $email, $password){
	
	$firstname	 = clean($firstname);
	$lastname	 = clean($lastname);
	$username	 = clean($username);
	$email		 = clean($email);
	$password	 = clean($password);
	
	if(email_exists($email)){
		return false;
	}
	elseif(username_exists($username)){
		return false;
	}
	else{
		// encryption
		$password	 = md5($password);
		$validation	 = md5($username + microtime());
		
		
		$insert_query ="INSERT INTO users(first_name, last_name, username, email, password, validation_code, active)";
		$insert_query .=" VALUES('{$firstname}','{$lastname}','{$username}','{$email}','{$password}', '{$validation}', '0')";
		$results = query($insert_query);
		confirm($results);
		
		$subject = "Activate";
		$msg = "Please click the link to activate you account http://safaridevs.com/login_app/activate.php?email=$email&code=$validation";
			
		$header = "noreply@safaridevs.com";
		 send_email($email, $subject, $msg, $header);
		
		
		return true;
						   
						   
						   }
	
		
	
}
/*****************************************Activate User Function*******************************/
function activate_user(){
		if(isset($_GET['email']) && isset($_GET['code'])){
			$email = $_GET['email'];
			$validation = $_GET['code'];
			
			$sql = "SELECT user_Id FROM users WHERE email = '".escape($email)."' AND validation_code ='$validation'";
			$results = query($sql);
			confirm($results);
			if(row_count($results)==1){
			
				
			$sql_update = "UPDATE users SET Active = 1 WHERE email = '".escape($email)."' and validation_code = '".escape($validation)."' ";
			$update_results = query($sql_update);
			confirm($update_results);
			set_message("<p class='bg-success'>Your account has been activated.</p>");
			redirect("login.php");
			
			}
		}else{
				set_message("<p class='bg-danger'>Sorry, Your account could  not be activated.</p>");
				redirect("login.php");

		}
} //End of activate user

/*****************************************Validate User Login Function*******************************/

function validate_user_login(){
	$errors=[];
	$min = 3;
	$max = 6;
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$email = clean($_POST['email']);		
		$password = clean($_POST['password']);
		$remember =isset($_POST['remember']);
		
		if(empty($email)){
			$errors[] = "Email fields cannot be empty";
		}
		if(empty($password)){
			$errors[] = "Password fields cannot be empty";
		}
	
		
		if(!empty($errors)){
			foreach($errors as $error){
				echo error_message($error);
				
			}
		}else{
			if(login_user($email, $password, $remember)){
				
				logged_in();
				redirect("admin.php");
				
			}else{
				//$error ="Incorrect email or password. Try again.";
				$sql = "SELECT user_id, password FROM users WHERE email ='".escape($email)."' AND active = 0";
					$result = query($sql);
	
					confirm($result);
					$count = row_count($result);
					if($count===1){						
							echo  error_message("Your account has not been activated yet");
					}else{	
						echo  error_message("Incorrect credentials. Try again");
				
					}
			}
		
		}
	
	}
} //End Function

/*****************************************User Login Function*******************************/
function login_user($email, $password, $remember){
	
	$sql = "SELECT user_id, password FROM users WHERE email ='".escape($email)."' AND active = 1";
	$result = query($sql);
	
	confirm($result);
	$count = row_count($result);
	if($count===1){
		
		$row = fetch_array($result);
		$db_password = $row['password'];
		if(md5($password) === $db_password){
			if($remember == "on"){
				setcookie('email', $email, time()+84600);				
			}
			$_SESSION['email'] = $email;
			return true;
		}else{
			return false;
		}
		
	}else{
			return false;
			
		
	}
	
} //end of function

/*****************************************Logged in Function*******************************/
function logged_in(){
	if(isset($_SESSION['email']) || isset($_COOKIE['email'])){
		return true;
	}else{
		return false;
	}
}

/*****************************************Recover Password Function*******************************/

function recover_password(){
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']){
			
			$email = clean($_POST['email']);
			$validation_code = md5($email + microtime());
			$sql = "UPDATE users SET validation_code ='".escape($validation_code)."' WHERE email ='".escape($email)."' ";
			$results = query($sql);
			confirm($results);			
			
		if(email_exists($email)){
			setcookie('temp_access_code', $validation_code, time()+900);
			
			$message ="Please Reset Your Password";
			$subject ="Here is your password reset code {$validation_code}
			Click  here to reset your password http://localhost/login/code.php?email=$email&code=$validation_code";
			$headers ="noreply@safaridevs.com";
			
			if(!send_email($email, $message, $subject, $headers)){
			
				echo error_message("Email could not be send");
			}
				set_message("<p class='bg-success'> Please Check your email for the activation code </p>");
				redirect("index.php");
			
			
		}else{
			echo error_message("This email doesn't exist");
		}
	}else{
			
		redirect("index.php");
	}
		
	if(isset($_POST['cancel_submit'])){
		redirect('login.php');
		
	}
	}
}

/*****************************************code validation Function*******************************/
function validation_code(){
	if(isset($_COOKIE['temp_access_code'])){
		
			if(!isset($_GET['email']) && !isset($_GET['code'])){
				redirect("index.php");
				
			}else if(empty($_GET['email']) || empty($_GET['code'])){
				redirect("index.php");
			}else{
				$email = $_GET['email'];
				if(isset($_POST['code'])){
					$validation_code = $_POST['code'];
					
					$sql = "SELECT user_id FROM users WHERE email = '".escape($email)."' AND validation_code ='".escape($validation_code)."' ";
					$results = query($sql);
					if(row_count($results) == 1){
						setcookie('temp_access_code', $validation_code, time()+ 900);
						redirect("reset.php?email=$email&code=$validation_code");
					}else{
						echo error_message("Sorry wrong validation code");
					}
					
				
				}
			}
		
		
	}else{
		set_message("<p class='bg-danger'>Your validation code has expired </p>");
		redirect("recover.php");
	}
}

/*****************************************password reset  Function*******************************/

function password_reset(){
	if(isset($_COOKIE['temp_access_code'])){
		
	if(isset($_GET['email']) && isset($_GET['code'])){
		
			if(isset($_SESSION['token']) && isset($_POST['token'])){
				if($_POST['token'] === $_SESSION['token']){
					$email = clean($_GET['email']);
					$password = md5($_POST['password']);
					$confirm_password = md5($_POST['confirm_password']);
					if($password === $confirm_password){
					$sql ="UPDATE users SET password ='".escape($password)."', validation_code = 0  WHERE email='".escape($email)."'";
					query($sql);
					set_message("<p class='bg-success'>Your password has been reset  </p>");
					redirect("login.php");
					}else{
						echo error_message("Your password must match");
					}
					
					
				}
			} 
				
			}
		
	}else{
		set_message("<p class='bg-danger'>Sorry your code has expired  </p>");
		redirect('recover.php');
	}

}


function error_message($error_message){
	$message = <<<DELIMITER

					<div class="alert alert-danger alert-dismissible" role="alert">
  					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  					<strong>Warning!</strong> $error_message
				</div>
				
DELIMITER;
	return $message;
}

?>