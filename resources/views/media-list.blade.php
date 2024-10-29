<!DOCTYPE html>
<html lang="en">
<head>
 <title>Busfam Admin - Media List</title>
<?php include 'header.php' ?>
<?php include 'leftpanel.php' ?>
<?php include 'topbar.php' ?>

<!-- Begin Page Content -->
<div class="page-content container">
	<div class="wrapper">
	   <div class="row align-items-center">
			<div class="col-md-7">
			<div class="page-header">
			<h3>Media List Item</h3>
			</div>
			</div>
			
			<div class="col-md-5">
			<div class="upload_div">
				<form id="uploadImg" method="post" enctype="multipart/form-data">
					<input type="file" name="files[]" multiple="multiple">
					<input type="button" id="sub" name="submit" class="btn btn-primary" value="Upload" onclick="call('uploadImg')">
				</form>
				</div>
			</div>
		</div>
		
		
		
		
		
		
		
		
		
		
		<div class="whitebox media_list mt-3">
			<table id="example" class="table table-striped nowrap" style="width:100%">
			<thead>
					<tr>
						<th style="width: 200px;">Media</th>
						<th>Title</th>
						<th>Media URL</th>
						<th>Copy</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><img src="img/thumb-1.webp" alt class="img-fluid"></td>
						<td>thumb-1.webp</td>
						<td><a href="#">http://img/thumb-1.webp</a></td>
						<td><a href="#" class="btn btn-outline-primary"><i class="fa-regular fa-copy"></i> Copy</a></td>
						<td>
							<a href="#" class="link-primary">
								<i class="fa-regular fa-pen-to-square"></i>
							</a>  
							<a href="#" class="link-danger">
								<i class="fa-solid fa-trash-can"></i>
							</a>
							
						</td>
					</tr>
					<tr>
						<td><img src="img/thumb-1.webp" alt class="img-fluid"></td>
						<td>thumb-1.webp</td>
						<td><a href="#">http://img/thumb-1.webp</a></td>
						<td><a href="#" class="btn btn-outline-primary"><i class="fa-regular fa-copy"></i> Copy</a></td>
						<td>
							<a href="#" class="link-primary">
								<i class="fa-regular fa-pen-to-square"></i>
							</a>  
							<a href="#" class="link-danger">
								<i class="fa-solid fa-trash-can"></i>
							</a>
							
						</td>
					</tr>
					<tr>
						<td><img src="img/thumb-1.webp" alt class="img-fluid"></td>
						<td>thumb-1.webp</td>
						<td><a href="#">http://img/thumb-1.webp</a></td>
						<td><a href="#" class="btn btn-outline-primary"><i class="fa-regular fa-copy"></i> Copy</a></td>
						<td>
							<a href="#" class="link-primary">
								<i class="fa-regular fa-pen-to-square"></i>
							</a>  
							<a href="#" class="link-danger">
								<i class="fa-solid fa-trash-can"></i>
							</a>
							
						</td>
					</tr>
				 
				 
				</tbody>
       
			</table>
		</div>
	</div>
</div>
<!-- /.container-fluid -->

<?php include 'footer.php' ?>