<?php
include 'inc/header.php';
include 'inc/conn.php';
include 'inc/functions.php';

if(!isset($_SESSION)) 
{ 
	session_start(); 
} 

//check if user already Login
alreadyLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// get data
	$email = $_POST['email'];
	$pass = $_POST['password'];

	$hashPass = md5($pass);

	//check Email and password 
	$result = $conn->query("SELECT * FROM patients where email = '$email' AND password ='$hashPass'");

	if ($result->num_rows == 1) {
		$patientData = $result->fetch_assoc();
		//get patient ID 
		$patientid = $patientData['id'];
		$_SESSION['id'] = $patientid;
		$_SESSION['role'] = 'patient';

		header('Location: patient-dashboard.php');
	} else {
		$_SESSION['errormsg'] = '"Email or Password not Correct"';
	}
}






?>

<!-- Page Content -->
<div class="content">
	<div class="container-fluid">

		<div class="row">
			<div class="col-md-8 offset-md-2">

				<!-- Login Tab Content -->
				<div class="account-content">
					<div class="row align-items-center justify-content-center">
						<div class="col-md-7 col-lg-6 login-left">
							<img src="../assets/img/login-banner.png" class="img-fluid" alt="Doccure Login">
						</div>
						<div class="col-md-12 col-lg-6 login-right">
							<div class="login-header">
								<h3>Login <span>Doccure</span> PAITIENT</h3>
							</div>
							<form action="login.php" method="post">
								<p style="color:red; text-align:center">
									<?php
									if (isset($_SESSION['errormsg'])) {
										echo $_SESSION['errormsg'];
									}
									?>
								</p>
								<div class="form-group form-focus">
									<input required name="email" type="email" class="form-control floating">
									<label class="focus-label">Email</label>
								</div>
								<div class="form-group form-focus">
									<input required name="password" type="password" class="form-control floating">
									<label class="focus-label">Password</label>
								</div>

								<button class="btn btn-primary btn-block btn-lg login-btn" type="submit">Login</button>


								<div class="text-center dont-have">Don’t have an account? <a href="../register.php">Register</a></div>
							</form>
						</div>
					</div>
				</div>
				<!-- /Login Tab Content -->

			</div>
		</div>

	</div>

</div>
<!-- /Page Content -->

<?php
include 'inc/footer.php';
unset($_SESSION['errormsg']);
?>