<?php 
include "config.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title> Registration form</title>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Bootstrap JS -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	

	<?php 
	$error_message = "";$success_message = "";

	// Register user
	if(isset($_POST['btnsignup'])){
		$fname = trim($_POST['fname']);
		$lname = trim($_POST['lname']);
		$email = trim($_POST['email']);
		$phoneno = trim($_POST['phoneno']);
		$frndno = trim($_POST['frndno']);
		$mid = trim($_POST['mid']);

		$isValid = true;

		// Check fields are empty or not
		if($fname == '' || $lname == '' || $email == '' || $phoneno == '' || $frndno == '' || $mid == '' ){
			$isValid = false;
			$error_message = "Please fill all fields.";
		}
		
		if(!preg_match('/^[0-9]{10}+$/', $phoneno)) {
			$isValid = false;
		  	$error_message = "Invalid Phone-number.";
		}
		
		if(!preg_match('/^[0-9]{10}+$/', $frndno)) {
			$isValid = false;
		  	$error_message = "Invalid Phone-number.";
		}
		
		

		// Check if Email-ID is valid or not
		if ($isValid && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  	$isValid = false;
		  	$error_message = "Invalid Email-ID.";
		}

		if($isValid){

			// Check if Email-ID already exists
			$stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
			$stmt->bind_param("s", $email);
			$stmt->execute();
			$result = $stmt->get_result();
			$stmt->close();
			if($result->num_rows > 0){
				$isValid = false;
				$error_message = "Email-ID is already existed.";
			}
			
		}

		// Insert records
		if($isValid){
			$insertSQL = "INSERT INTO users(fname,lname,email,phoneno,frndno,mid ) values(?,?,?,?,?,?)";
			$stmt = $con->prepare($insertSQL);
			$stmt->bind_param("ssssss",$fname,$lname,$email,$phoneno,$frndno,$mid);
			$stmt->execute();
			$stmt->close();

			$success_message = "Account created successfully.";
		}
	}
	?>
</head>
<body>
	<div class='container'>
		<div class='row'>
			<div class='col-md-12'>
				<h2></h2>
			</div>

			<div class='col-md-6' >
					
				<form method='post' action=''>

					<h1>SignUp</h1>
					<?php 
					// Display Error message
					if(!empty($error_message)){
					?>
						<div class="alert alert-danger">
						  	<strong>Error!</strong> <?= $error_message ?>
						</div>

					<?php
					}
					?>

					<?php 
					// Display Success message
					if(!empty($success_message)){
					?>
						<div class="alert alert-success">
						  	<strong>Success!</strong> <?= $success_message ?>
						</div>

					<?php
					}
					?>
				
					<div class="form-group">
					    <label for="fname">First Name:</label>
					    <input type="text" class="form-control" name="fname" id="fname" required="required" maxlength="80">
					</div>
					<div class="form-group">
					    <label for="lname">Last Name:</label>
					    <input type="text" class="form-control" name="lname" id="lname" required="required" maxlength="80">
					</div>
					<div class="form-group">
					    <label for="email">Email address:</label>
					    <input type="email" class="form-control" name="email" id="email" required="required" maxlength="80">
					</div>
					<div class="form-group">
					    <label for="phonenum">Phone Number:</label>
					    <input type="text" class="form-control" name="phoneno" id="phoneno" required="required" maxlength="80">
					</div>
					<div class="form-group">
					    <label for="frndno">Emergency Number:</label>
					    <input type="text" class="form-control" name="frndno" id="frndno" required="required" maxlength="80">
					</div>
					<div class="form-group">
					    <label for="mid">Material ID:</label>
					    <input type="text" class="form-control" name="mid" id="mid" required="required" maxlength="80">
					</div>
					
					<button type="submit" name="btnsignup" class="btn btn-default">Submit</button>
				</form>
			</div>
			
			
		</div>
	</div>
</body>
</html>