<?php
include 'inc/header.php';
include 'inc/conn.php';

if (isset($_SESSION['role'])) {
	if ($_SESSION['role'] == "patient") {
		header('Location: ../patient/patient-dashboard.php');
	} elseif ($_SESSION['role'] == "doctor") {
		header('Location: doctor-dashboard.php');
	}
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	//get form data
	$userName = $_POST['userName'];
	$email = $_POST['email'];
	$pass = $_POST['pass'];


	//check if Email already exist
	$checkEmail = $conn->query("SELECT email FROM doctors WHERE email = '$email'");
	if ($checkEmail->num_rows >= 1) {
		$_SESSION['errormsg'] = '"Email is already exist"';
	} else {
		//check if User Name already exist
		$checkEmail = $conn->query("SELECT email FROM doctors WHERE userName = '$userName'");
		if ($checkEmail->num_rows >= 1) {
			$_SESSION['errormsg'] = '"User Name is already exist"';
		} else {

			//hashing Pass
			$hashPass = md5($pass);

			//insert data 
			$insertq = $conn->query("INSERT INTO doctors ( userName, email , password) VALUE ('$userName','$email','$hashPass')");
			if ($insertq === TRUE) {
				header('Location: doctorlogin.php');
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
	}
}



?>

<body class="account-page">

	<!-- Main Wrapper -->
	<div class="main-wrapper">

		<!-- Page Content -->
		<div class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-8 offset-md-2">

						<!-- Account Content -->
						<div class="account-content">
							<div class="row align-items-center justify-content-center">
								<div class="col-md-7 col-lg-6 login-left">
									<img src="../assets/img/login-banner.png" class="img-fluid" alt="Login Banner">
								</div>
								<div class="col-md-12 col-lg-6 login-right">
									<div class="login-header">
										<h3>Doctor Register <a href="../register.php">Not a Doctor?</a></h3>
									</div>

									<!-- Register Form -->
									<form action="doctor-register.php" method="post">
										<p style="color:red; text-align:center">
											<?php
											if (isset($_SESSION['errormsg'])) {
												echo $_SESSION['errormsg'];
											}
											?>
										</p>
										<div class="form-group form-focus">
											<input required type="text" name="userName" class="form-control floating">
											<label class="focus-label">User Name</label>
										</div>
										<div class="form-group form-focus">
											<input required type="email" name="email" class="form-control floating">
											<label class="focus-label">Email Address</label>
										</div>
										<div class="form-group form-focus">
											<input required type="password" name="pass" class="form-control floating">
											<label class="focus-label">Create Password</label>
										</div>
										<div class="text-right">
											<a class="forgot-link" href="doctorlogin.php">Already have an account?</a>
										</div>
										<button class="btn btn-primary btn-block btn-lg login-btn" type="submit">Signup</button>

									</form>
									<!-- /Register Form -->

								</div>
							</div>
						</div>
						<!-- /Account Content -->

					</div>
				</div>

			</div>

		</div>
		<!-- /Page Content -->



		<?php
		include 'inc/footer.php';
		session_unset();
		?>