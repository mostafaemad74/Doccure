<?php
include 'inc/header.php';
include 'inc/conn.php';
include 'inc/functions.php';

if (!isset($_SESSION)) {
	session_start();
}

//check if user has role patient
isPatient();

//get patient id by SESSION 
if (isset($_SESSION['id'])) {
	$patientid = $_SESSION['id'];
	//get patient all data
	$selectData = $conn->query("SELECT patients.id AS patientid ,patients.fristName ,patients.lastName ,patients.email,patients.image,patients.dateOfBirth, patients.mobile,patients.address,patients.city,patients.state,patients.zipCode,patients.country,patients.bloodGroubid , blood_group.id AS blooldid,blood_group.blood  FROM patients JOIN blood_group on blood_group.id = patients.bloodGroubid WHERE patients.id = '$patientid'");
	$patientdata = $selectData->fetch_assoc();
	profileComplete($patientdata);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	// get data
	$lastName = $_POST['lastName'];
	$dateOfBirth = $_POST['dateOfBirth'];
	$blood = $_POST['blood'];
	$mobile = $_POST['mobile'];
	$address = $_POST['address'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zipCode = $_POST['zipCode'];
	$country = $_POST['country'];

	if (
		$lastName == "" ||
		$dateOfBirth == "" ||
		$blood == "" ||
		$mobile == "" ||
		$address == "" ||
		$city == "" ||
		$state == "" ||
		$zipCode == "" ||
		$country == ""
	) {
		$_SESSION['missingData'] = 'All Data Is Required';
	} else {

		//update patient data
		$updateq = $conn->query("UPDATE patients SET
			lastName ='$lastName',dateOfBirth='$dateOfBirth',bloodGroubid='$blood',
			mobile='$mobile',address='$address',city='$city',state='$state',zipCode='$zipCode',
			country='$country' WHERE id = '$patientid'");
		$_SESSION['profileUpdated'] = 'Profile Updated Successfully';
		header('Location: profile-settings.php');
		
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
						<li class="breadcrumb-item"><a href="../index.php">Home</a></li>
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

			<!-- Profile Sidebar -->
			<div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
				<div class="profile-sidebar">
					<div class="widget-profile pro-widget-content">
						<div class="profile-info-widget">
							<a href="#" class="booking-doc-img">
								<img src="<?= $patientdata['image'];?>" alt="User Image">
							</a>
							<div class="profile-det-info">
								<h3><?= $patientdata['fristName'] . " " . $patientdata['lastName'] ?></h3>
								<div class="patient-details">
									<h5><i class="fas fa-birthday-cake"></i><?= $patientdata['dateOfBirth'] ?></h5>
									<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i><?= $patientdata['city'] ?>,<?= $patientdata['country'] ?></h5>
								</div>
							</div>
						</div>
					</div>
					<div class="dashboard-widget">
						<nav class="dashboard-menu">
							<ul>
								<li>
									<a href="patient-dashboard.php">
										<i class="fas fa-columns"></i>
										<span>Dashboard</span>
									</a>
								</li>
								<li>
									<a href="doctors.php">
										<i class="fas fa-user-md"></i>
										<span>Doctors</span>
									</a>
								</li>
								<li>
									<a href="profile-settings.php">
										<i class="fas fa-user-cog"></i>
										<span>Profile Settings</span>
									</a>
								</li>
								<li>
									<a href="change-password.php">
										<i class="fas fa-lock"></i>
										<span>Change Password</span>
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
			</div>
			<!-- /Profile Sidebar -->

			<div class="col-md-7 col-lg-8 col-xl-9">
				<div class="card">
					<p style="color:green; text-align:center">
						<?php
						if (isset($_SESSION['profileUpdated'])) {
							echo $_SESSION['profileUpdated'];
						}
						?>
					</p>
					<div class="card-body">

						<!-- Upload Image Form -->
						<form action="updateImage.php" method="post" enctype="multipart/form-data">
							<div class="col-12 col-md-12">
								<div class="form-group">
									<div class="change-avatar">
										<div class="profile-img">
											<img id="output" src="<?= $patientdata['image']; ?>" alt="User Image">
										</div>
										<div class="upload-img">
											<div class="change-photo-btn">
												<span><i class="fa fa-upload"></i> Upload Photo</span>
												<input onchange="loadFile(event)" id="myfile" name="image" type="file" class="upload" value="<?= $patientdata['image'] ?>">
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
						<!-- Profile Settings Form -->
						<form action="profile-settings.php" method="post" enctype="multipart/form-data">
							<div class="row form-row">

								<div class="col-12 col-md-6">
									<div class="form-group">
										<label>First Name</label>
										<input required type="text" disabled class="form-control" name="name" value="<?= $patientdata['fristName'] ?> ">
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label>Last Name</label>
										<input required type="text" class="form-control" placeholder="Enter your Last Name" name="lastName" value="<?= $patientdata['lastName'] ?>">
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label>Date of Birth</label>
										<div class="cal-icon">
											<input required type="text" class="form-control datetimepicker" placeholder="Enter your Date of Birth" name="dateOfBirth" value="<?= $patientdata['dateOfBirth'] ?>">
										</div>
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label>Blood Group</label>
										<select required name="blood" class="form-control select">
											<?php
											$bloodGroup = $conn->query('SELECT * FROM blood_group');
											foreach ($bloodGroup as $b) {
											?>
												<option <?php if ($b['id'] == $patientdata['blooldid']) {
															echo 'selected';
														} ?> value="<?= $b['id'] ?>"><?= $b['blood'] ?></option>
											<?php } ?>
										</select>
									</div>
								</div>

								<div class="col-12 col-md-6">
									<div class="form-group">
										<label>Mobile</label>
										<input required type="text" placeholder="Enter your Mobile" name="mobile" value="<?= $patientdata['mobile'] ?>" class="form-control">
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label>Address</label>
										<input required type="text" class="form-control" placeholder="Enter your Address" name="address" value="<?= $patientdata['address'] ?>">
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label>City</label>
										<input required type="text" class="form-control" placeholder="Enter your City" name="city" value="<?= $patientdata['city'] ?>">
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label>State</label>
										<input required type="text" class="form-control" placeholder="Enter your State" name="state" value="<?= $patientdata['state'] ?>">
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label>Zip Code</label>
										<input required type="text" class="form-control" placeholder="Enter your Zip Code" name="zipCode" value="<?= $patientdata['zipCode'] ?>">
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label>Country</label>
										<input required type="text" class="form-control" placeholder="Enter your Country" name="country" value="<?= $patientdata['country'] ?>">
									</div>
								</div>
							</div>
							<div class="submit-section">
								<button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
							</div>
						</form>
						<!-- /Profile Settings Form -->

					</div>
				</div>
			</div>
		</div>
	</div>

</div>
<!-- /Page Content -->

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