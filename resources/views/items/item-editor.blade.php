<!DOCTYPE html>
<html lang="en">

<head>
<title>Busfam Admin - Item Editor</title>
<?php include 'header.php' ?>
<?php include 'leftpanel.php' ?>
<?php include 'topbar.php' ?>

   

<!-- Begin Page Content -->
<div class="page-content container">
	<div class="wrapper">
		<div class="row align-items-center mb-3">
			<div class="col-md-9">
			<a href="#" class="btn btn-primary">
			<i class="fa-solid fa-plus me-1"></i>Add New
			</a>
			</div>
			
			<div class="col-md-3">
			<a href="#" class="btn btn-primary float-end">
			<i class="fa-solid fa-plus me-1"></i>All List
			</a>
			</div>
			
		</div>
		
		
		
		<div class="row g-2">
			<div class="col-md-6 col-lg-8">
				<div class="item_name">
					<form action="item-editor.php" method="post">
					   <div class="whitebox mb-4">
					   <label>Enter Title Here</label>
						<input type="text" class="form-control" name="post_title" id="post_title">
						<div class="permalink_div">
							<strong class="me-2">Permalink:</strong>https://www.test.com/
							<div class="input-group">
								<input type="text" class="form-control"
									aria-label="Dollar amount (with dot and two decimal places)">
							   
							</div>
						</div>
						<div class="edit_permalink">
							<strong class="me-2">Permalink:</strong>https://www.test.com/<span
								class="link-primary">abc</span><a href="#"><i
									class="fa-solid fa-pencil ms-2"></i></a>
						</div>
						
						   <div class=" mb-4">
					   <label>Textarea</label>
						<textarea name="" id="textareass" rows="6" class="form-control ckeditor" placeholder="Tinymce will go here"></textarea>
					   </div>
					   </div>
					   
					

						
						
					   

						<div class="accordion" id="accordionAddNew">
							<div class="accordion-item">
								<h2 class="accordion-header" id="headingOne">
									<button class="accordion-button collapsed" type="button"
										data-bs-toggle="collapse" data-bs-target="#addOne"
										aria-expanded="true" aria-controls="addOne">
										Additional Fields
									</button>
								</h2>
								<div id="addOne" class="accordion-collapse collapse"
									aria-labelledby="headingOne" data-bs-parent="#accordionAddNew">
									<div class="accordion-body">
										<input type="text" class="form-control" name="" id=""
											placeholder="Enter Title Here">
										<textarea name="" id="textareass" rows="6" class="form-control ckeditor"
											placeholder="Tinymce will go here"></textarea>
									</div>
								</div>
							</div>
							<div class="accordion-item">
								<h2 class="accordion-header" id="headingTwo">
									<button class="accordion-button collapsed" type="button"
										data-bs-toggle="collapse" data-bs-target="#addTwo"
										aria-expanded="false" aria-controls="addTwo">
										Inner Page Banner
									</button>
								</h2>
								<div id="addTwo" class="accordion-collapse collapse"
									aria-labelledby="headingTwo" data-bs-parent="#accordionAddNew">
									<div class="accordion-body">
									
										<div class="inn_banner_row">
											<div class="row">
												<div class="col-md-6">
												<textarea name="" id="textareass" rows="6" class="form-control ckeditor"
												placeholder="Tinymce will go here"></textarea>
												</div>
												<div class="col-md-5">
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
												<div class="col-md-1">
												<div class="close_row float-end">
													<a href="#" class="link-success">
														<i class="fa-solid fa-minus"></i>
													</a>
													<a href="#" class="link-success">
														<i class="fa-solid fa-plus"></i>
													</a>
												</div>
												</div>
											</div>
										</div>
										<div class="inn_banner_row">
											<div class="row">
												<div class="col-md-6">
												<textarea name="" id="textareass" rows="6" class="form-control ckeditor"
												placeholder="Tinymce will go here"></textarea>
												</div>
												<div class="col-md-5">
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
												<div class="col-md-1">
												<div class="close_row float-end">
													<a href="#" class="link-success">
														<i class="fa-solid fa-minus"></i>
													</a>
													<a href="#" class="link-success">
														<i class="fa-solid fa-plus"></i>
													</a>
												</div>
												</div>
											</div>
										</div>
										
									</div>
								</div>
							</div>
							<div class="accordion-item">
								<h2 class="accordion-header" id="headingThree">
									<button class="accordion-button collapsed" type="button"
										data-bs-toggle="collapse" data-bs-target="#addThree"
										aria-expanded="false" aria-controls="addThree">
										SEO Details
									</button>
								</h2>
								<div id="addThree" class="accordion-collapse collapse"
									aria-labelledby="headingThree" data-bs-parent="#accordionAddNew">
									<div class="accordion-body">
										<input type="text" class="form-control" name="" id=""
											placeholder="Meta Title">
										<input type="text" class="form-control" name="" id=""
											placeholder="Meta Keyword">
										<textarea name="" id="" rows="6" class="form-control"
											placeholder="Meta Description"></textarea>
									</div>
								</div>
							</div>
						</div>

					</form>
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

