<!DOCTYPE html>
<html lang="en">

<head>
<title>Busfam Admin - Category</title>

<?php include 'header.php' ?>
<?php include 'leftpanel.php' ?>
<?php include 'topbar.php' ?>



<!-- Begin Page Content -->
<div class="page-content container">
	<div class="wrapper">
		
		<div class="row">
			<div class="col-md-5 col-lg-4">
			<h2><strong>Add Category</strong></h2>
				<div class="whitebox">
				<div class="item_name categ_div">
					<form action="category.php" method="post">
						<input type="text" class="form-control" name="post_title" id="post_title" placeholder="Enter Title Here">
						<div class="mb-3 ">
						<select class="form-select" aria-label="Default select example">
						  <option selected>Status:</option>
						  <option value="1">Active</option>
						  <option value="2">Disable</option>
						</select> 
						</div>
						
						<input type="submit" class="btn btn-primary" value="Publish"> 
					  
					</form>

				</div>
				</div>
			</div>
			
			
			<div class="col-md-7 col-lg-8">
			<h2><strong>All Categories</strong></h2>
				<div class="datatable mt-3">
			<table id="example" class="table table-striped nowrap" style="width:100%">
				<thead>
					<tr>
						<th>Sl No</th>
						<th>Title</th>
						<th>Category</th>
						<th>Published Date</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>1</td>
						<td><a href="#" class>Lorem Ipsum Dolor Iset</a></td>
						<td>Uncategorized</td>
						<td>05/08/2016</td>
						<td>Active</td>
						<td>
							<a href="#" class="link-primary"><i
									class="fa-regular fa-pen-to-square"></i></a>  
							<a href="#" class="link-danger"><i
									class="fa-solid fa-trash-can"></i></a>
						</td>
					</tr>
					<tr>
						<td>2</td>
						<td><a href="#">Lorem Ipsum Dolor Iset</a></td>
						<td>News, Sports</td>
						<td>04/08/2016</td>
						<td>Active</td>
						<td>
							<a href="#" class="link-primary"><i
									class="fa-regular fa-pen-to-square"></i></a>
							<a href="#" class="link-danger"><i
									class="fa-solid fa-trash-can"></i></a>
						</td>
					</tr>
					<tr>
						<td>3</td>
						<td><a href="#">Lorem Ipsum Dolor Iset</a></td>
						<td>Cinema, City, Country</td>
						<td>03/08/2016</td>
						<td>Active</td>
						<td>
							<a href="#" class="link-primary"><i
									class="fa-regular fa-pen-to-square"></i></a>
							<a href="#" class="link-danger"><i
									class="fa-solid fa-trash-can"></i></a>
						</td>
					</tr>
					<tr>
						<td>4</td>
						<td><a href="#" class>Lorem Ipsum Dolor Iset</a></td>
						<td>Uncategorized</td>
						<td>05/08/2016</td>
						<td>Inactive</td>
						<td>
							<a href="#" class="link-primary"><i
									class="fa-regular fa-pen-to-square"></i></a>  
							<a href="#" class="link-danger"><i
									class="fa-solid fa-trash-can"></i></a>
						</td>
					</tr>
					<tr>
						<td>5</td>
						<td><a href="#">Lorem Ipsum Dolor Iset</a></td>
						<td>News, Sports</td>
						<td>04/08/2016</td>
						<td>Active</td>
						<td>
							<a href="#" class="link-primary"><i
									class="fa-regular fa-pen-to-square"></i></a>
							<a href="#" class="link-danger"><i
									class="fa-solid fa-trash-can"></i></a>
						</td>
					</tr>
					<tr>
						<td>6</td>
						<td><a href="#">Lorem Ipsum Dolor Iset</a></td>
						<td>Cinema, City, Country</td>
						<td>03/08/2016</td>
						<td>Inactive</td>
						<td>
							<a href="#" class="link-primary"><i
									class="fa-regular fa-pen-to-square"></i></a>
							<a href="#" class="link-danger"><i
									class="fa-solid fa-trash-can"></i></a>
						</td>
					</tr>
					<tr>
						<td>7</td>
						<td><a href="#" class>Lorem Ipsum Dolor Iset</a></td>
						<td>Uncategorized</td>
						<td>05/08/2016</td>
						<td>Active</td>
						<td>
							<a href="#" class="link-primary"><i
									class="fa-regular fa-pen-to-square"></i></a>  
							<a href="#" class="link-danger"><i
									class="fa-solid fa-trash-can"></i></a>
						</td>
					</tr>
					<tr>
						<td>8</td>
						<td><a href="#">Lorem Ipsum Dolor Iset</a></td>
						<td>News, Sports</td>
						<td>04/08/2016</td>
						<td>Inactive</td>
						<td>
							<a href="#" class="link-primary"><i
									class="fa-regular fa-pen-to-square"></i></a>
							<a href="#" class="link-danger"><i
									class="fa-solid fa-trash-can"></i></a>
						</td>
					</tr>
					<tr>
						<td>9</td>
						<td><a href="#">Lorem Ipsum Dolor Iset</a></td>
						<td>Cinema, City, Country</td>
						<td>03/08/2016</td>
						<td>Active</td>
						<td>
							<a href="#" class="link-primary"><i
									class="fa-regular fa-pen-to-square"></i></a>
							<a href="#" class="link-danger"><i
									class="fa-solid fa-trash-can"></i></a>
						</td>
					</tr>
					<tr>
						<td>10</td>
						<td><a href="#" class>Lorem Ipsum Dolor Iset</a></td>
						<td>Uncategorized</td>
						<td>05/08/2016</td>
						<td>Active</td>
						<td>
							<a href="#" class="link-primary"><i
									class="fa-regular fa-pen-to-square"></i></a>  
							<a href="#" class="link-danger"><i
									class="fa-solid fa-trash-can"></i></a>
						</td>
					</tr>
					<tr>
						<td>11</td>
						<td><a href="#">Lorem Ipsum Dolor Iset</a></td>
						<td>News, Sports</td>
						<td>04/08/2016</td>
						<td>Inactive</td>
						<td>
							<a href="#" class="link-primary"><i
									class="fa-regular fa-pen-to-square"></i></a>
							<a href="#" class="link-danger"><i
									class="fa-solid fa-trash-can"></i></a>
						</td>
					</tr>
					<tr>
						<td>12</td>
						<td><a href="#">Lorem Ipsum Dolor Iset</a></td>
						<td>Cinema, City, Country</td>
						<td>03/08/2016</td>
						<td>Active</td>
						<td>
							<a href="#" class="link-primary"><i
									class="fa-regular fa-pen-to-square"></i></a>
							<a href="#" class="link-danger"><i
									class="fa-solid fa-trash-can"></i></a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
			</div>
		</div>
	</div>



</div>
<!-- End of Main Content -->

<?php include 'footer.php' ?>