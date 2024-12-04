<?php
include 'inc/header.php';
include 'inc/conn.php';
include 'inc/functions.php';

if (!isset($_SESSION)) {
	session_start();
}

//check if user has role doctor
isDoctor();

if (isset($_SESSION['id'])) {
	//get doctor id by SESSION 
	$doctorid = $_SESSION['id'];
	//get doctor all data
	$selectData = $conn->query("SELECT * FROM doctors WHERE id = '$doctorid'");
	$doctordata = $selectData->fetch_assoc();

	profileComplete($doctordata);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// get data
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$mobile = $_POST['mobile'];
	$country = $_POST['country'];
	$biography = $_POST['biography'];
	$pricing = $_POST['pricing'];

	if (
		$firstName == "" ||
		$lastName == "" ||
		$mobile == "" ||
		$country == "" ||
		$biography == "" ||
		$pricing == ""
	) {
		$_SESSION['missingData'] = 'All Data Is Required';
	} else {

		//update patient data
		$updateq = $conn->query("UPDATE doctors SET
			lastName ='$lastName',firstName='$firstName', mobile='$mobile',biography='$biography',pricing='$pricing',country='$country' WHERE id = '$doctorid'");
		$_SESSION['profileUpdated'] = 'Profile Updated Successfully';
		header('Location: doctor-profile-settings.php');
		
	}
}

?>
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-md-12 col-12">
				<nav aria-label="breadcrumb" class="page-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="index.html">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">Profile Settings</li>
					</ol>
				</nav>
				<h2 class="breadcrumb-title">Profile Settings</h2>
				<p style="color:red;">
					<?php
					if (isset($_SESSION['profileCompleted'])) {
						echo $_SESSION['profileCompleted'];
					}
					?>
				</p>
			</div>
		</div>
	</div>
</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content">
	<div class="container-fluid">

		<div class="row">
			<div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">

				<!-- Profile Sidebar -->
				<div class="profile-sidebar">
					<div class="widget-profile pro-widget-content">
						<div class="profile-info-widget">
							<a href="#" class="booking-doc-img">
								<img src="<?= $doctordata['image']; ?>" alt="User Image">
							</a>
							<div class="profile-det-info">
								<h3>Dr. <?= $doctordata['userName']; ?></h3>

								<div class="patient-details">
									<h5 class="mb-0"><?= $doctordata['biography']; ?></h5>
								</div>
							</div>
						</div>
					</div>
					<div class="dashboard-widget">
						<nav class="dashboard-menu">
							<ul>
								<li>
									<a href="doctor-dashboard.php">
										<i class="fas fa-columns"></i>
										<span>Dashboard</span>
									</a>
								</li>
								<li>
									<a href="appointments.html">
										<i class="fas fa-calendar-check"></i>
										<span>Appointments</span>
									</a>
								</li>


								<li>
									<a href="doctor-profile-settings.php">
										<i class="fas fa-user-cog"></i>
										<span>Profile Settings</span>
									</a>
								</li>

								<li>
									<a href="../logout.php">
										<i class="fas fa-sign-out-alt"></i>
										<span>Logout</span>
									</a>
								</li>
							</ul>
						</nav>
					</div>
				</div>
				<!-- /Profile Sidebar -->

			</div>
			<div class="col-md-7 col-lg-8 col-xl-9">

				<div class="card">
					<p style="color:green; text-align:center">
						<?php
						if (isset($_SESSION['profileUpdated'])) {
							echo $_SESSION['profileUpdated'];
						}
						?>
					</p>

					<!-- Upload Image Form -->
					<form style="margin-top: 15px;" action="updateImage.php" method="post" enctype="multipart/form-data">
						<div class="col-12 col-md-12">
							<div class="form-group">
								<div class="change-avatar">
									<div class="profile-img">
										<img id="output" src="<?= $doctordata['image']; ?>" alt="User Image">
									</div>
									<div class="upload-img">
										<div class="change-photo-btn">
											<span><i class="fa fa-upload"></i> Upload Photo</span>
											<input onchange="loadFile(event)" id="myfile" name="image" type="file" class="upload" value="<?= $doctordata['image'] ?>">
										</div>
										<button style="background-color: #09e5ab;" type="submit" class="change-photo-btn">Change Image</button>
									</div>
									<p style="color:red; text-align:center">
										<?php
										if (isset($_SESSION['uploaderror'])) {
											echo $_SESSION['uploaderror'];
										}
										?>
									</p>
								</div>
							</div>
						</div>
					</form>
					<hr>
					<p style="color:red; text-align: center;">
						<?php
						if (isset($_SESSION['missingData'])) {
							echo $_SESSION['missingData'];
						}
						?>
					</p>
					<form action="doctor-profile-settings.php" method="post" enctype="multipart/form-data">

						<!-- Basic Information -->
						<div class="card-body">
							<h4 class="card-title">Basic Information</h4>
							<div class="row form-row">

								<div class="col-md-6">
									<div class="form-group">
										<label>Username <span class="text-danger">*</span></label>
										<input type="text" class="form-control" value="<?= $doctordata['userName']; ?>" readonly>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Email <span class="text-danger">*</span></label>
										<input type="email" class="form-control" value="<?= $doctordata['email']; ?>" readonly>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>First Name <span class="text-danger">*</span></label>
										<input required type="text" name="firstName" value="<?= $doctordata['firstName']; ?>" class="form-control">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Last Name <span class="text-danger">*</span></label>
										<input required type="text" name="lastName" value="<?= $doctordata['lastName']; ?>" class="form-control">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Phone Number</label>
										<input required type="text" name="mobile" value="<?= $doctordata['mobile']; ?>" class="form-control">
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Country</label>
										<input required type="text" name="country" value="<?= $doctordata['country'];	 ?>" class="form-control">
									</div>
								</div>

							</div>
						</div>
				</div>
				<!-- /Basic Information -->

				<!-- About Me -->
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">About Me</h4>
						<div class="form-group mb-0">
							<label>Biography</label>
							<textarea required name="biography" class="form-control"  rows="5"><?= $doctordata['biography']; ?></textarea>
						</div>
					</div>
				</div>
				<!-- /About Me -->

				<!-- Pricing -->
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Pricing</h4>

						<div class="form-group mb-0">
							<div id="pricing_select">
								<input required name="pricing" type="text" class="form-control" id="custom_rating_input" name="custom_rating_count" value="<?= $doctordata['pricing']; ?>" placeholder="EGP">
							</div>

						</div>



					</div>
				</div>
				<!-- /Pricing -->





				<div class="submit-section submit-btn-bottom">
					<button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
				</div>
				</form>
			</div>
		</div>

	</div>

</div>
<!-- /Page Content -->



</div>
<!-- /Main Wrapper -->

<script>
	var loadFile = function(event) {
		var output = document.getElementById('output');
		output.src = URL.createObjectURL(event.target.files[0]);
		output.onload = function() {
			URL.revokeObjectURL(output.src) // free memory
		}
	};
</script>


<?php
include 'inc/footer.php';
unset($_SESSION['uploaderror']);
unset($_SESSION['profileUpdated']);
unset($_SESSION['missingData']);
?>