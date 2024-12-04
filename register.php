<?php
include 'inc/header.php';
include 'inc/conn.php';
session_start();

if (isset($_SESSION['role'])) {
	if ($_SESSION['role'] == "patient") {
		header('Location: patient/patient-dashboard.php');
	} elseif ($_SESSION['role'] == "doctor") {
		header('Location: doctor-dashboard.php');
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	//get form data
	$firstName = $_POST['firstName'];
	$email = $_POST['email'];
	$pass = $_POST['pass'];

	//hashing Pass
	$hashPass = md5($pass);

	//check if Email already exist
	$checkEmail = $conn->query("SELECT email FROM patients WHERE email = '$email'");
	if ($checkEmail->num_rows >= 1) {
		$_SESSION['errormsg'] = '"Email is already exist"';	
	}else{
		//insert data 
		$insertq = $conn->query("INSERT INTO patients ( fristName, email , password) VALUE ('$firstName','$email','$hashPass')");
		if ($insertq === TRUE) {
			header('Location: patient/login.php');
		  } else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		  }
	
	}
}








?>

<!-- Page Content -->
<div class="content">
	<div class="container-fluid">

		<div class="row">
			<div class="col-md-8 offset-md-2">

				<!-- Register Content -->
				<div class="account-content">
					<div class="row align-items-center justify-content-center">
						<div class="col-md-7 col-lg-6 login-left">
							<img src="assets/img/login-banner.png" class="img-fluid" alt="Doccure Register">
						</div>
						<div class="col-md-12 col-lg-6 login-right">
							<div class="login-header">
								<h3>Patient Register <a href="doctor/doctor-register.php">Are you a Doctor?</a></h3>
							</div>

							<!-- Register Form -->
							<form action="register.php" method="post">
								<p style="color:red; text-align:center">
									<?php
										if(isset($_SESSION['errormsg'])){
											echo $_SESSION['errormsg'];
										}
									?>
								</p>
								<div class="form-group form-focus">
									<input required name="firstName" type="text" class="form-control floating">
									<label class="focus-label">Name</label>
								</div>
								<div class="form-group form-focus">
									<input required name="email" type="email" class="form-control floating">
									<label class="focus-label">Email Address</label>
								</div>
								<div class="form-group form-focus">
									<input required name="pass" type="password" class="form-control floating">
									<label class="focus-label">Create Password</label>
								</div>
								<div class="text-right">
									<a class="forgot-link" href="patient/login.php">Already have an account?</a>
								</div>
								<button class="btn btn-primary btn-block btn-lg login-btn" type="submit">Signup</button>

							</form>
							<!-- /Register Form -->

						</div>
					</div>
				</div>
				<!-- /Register Content -->

			</div>
		</div>

	</div>

</div>
<!-- /Page Content -->

<?php
include 'inc/footer.php';
session_unset();
?>