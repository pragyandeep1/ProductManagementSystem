<!DOCTYPE html>
<html lang="en">

<head>
 <title>Busfam Admin - Settings</title>
<?php include 'header.php' ?>
<?php include 'leftpanel.php' ?>
<?php include 'topbar.php' ?>


<!-- Begin Page Content -->
<div class="page-content container">
	<div class="wrapper">
		<div class="row align-items-center">
			<div class="col-md-7">
			<div class="page-header">
			<h3>Profile</h3>
			</div>
			</div>
			
			<div class="col-md-5">
			
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-lg-8">
				<div class="whitebox">
				<div class="sticky">
					
					<div class="item_name mb-4">
						<form action="item-editor.php" method="post">
							<div class="row">
								<div class="col-md-6">
									<label>First Name</label>
									<input type="text" class="form-control" name="" id="">
								</div>
								<div class="col-md-6">
									<label>Last Name</label>
									<input type="text" class="form-control" name="" id="">
								</div>
								<div class="col-md-6">
									<label>Email</label>
									<input type="email" class="form-control" name="" id="">
								</div>
								<div class="col-md-6">
									<label>Username</label>
									<input type="text" class="form-control" name="" id="" disabled>
								</div>
								<div class="col-md-6">
									<label>New Password</label>
									<input type="password" class="form-control" name="" id="">
								</div>
								<div class="col-md-6">
									<label>Re-enter Password</label>
									<input type="password" class="form-control" name="" id="">
								</div>
							</div>
							
							
						   
						 
							
						</form>
					</div>
				   
					
				</div>
				</div>
			</div>
			<div class="col-md-6 col-lg-4">
			  
				<div class="additem">
					<h3>Publish</h3>
					<div class="additem_body">
						<div class="mb-3"><i class="fa-solid fa-calendar-days me-2"></i>7th October,
							2023 01:23 PM</div>
						<div class="mb-3 ">
						<select class="form-select" aria-label="Default select example">
						  <option selected>Status:</option>
						  <option value="1">Active</option>
						  <option value="2">Disable</option>
						</select> 
						</div>
						
						<input type="submit" class="btn btn-primary" value="Publish"> 
						
					   
					</div>
				</div>
				
				<div class="additem">
					<h3>Categories</h3>
					<div class="additem_body">
						<select class="form-control multiple-select" >
							<option value="CA">One</option>
							<option value="NV">Two</option>
							<option value="OR">Three</option>
							<option value="WA">Four</option>
						</select>
					</div>
				</div>
				
				
				<div class="additem">
					<h3>Featured Image</h3>
					<div class="additem_body"> 
					<div class="img_holder">
						<img src="img/thumb-1.webp" alt="" class="img-fluid">
					</div>
					<div class="remove_button">
						<a href="#" class="btn btn-danger btn-sm">
							<i class="fa-solid fa-xmark"></i>
						</a>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>



</div>
<!-- End of Main Content -->
<?php include 'footer.php' ?>