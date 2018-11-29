<!DOCTYPE html>
<html>
	<title>Admin - Dashboard</title>
	<head>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<?php
			include('action.php');
			session_start();
		?>
		<style>
			.td-align{margin: 0px 10px 0px 10px !important; padding: 0px 0px 0px 10px !important; vertical-align: middle !important;}
		</style>
	</head>
	<body>
		<div class="container" style="margin-top:20px;">
			<div class="row">
				<div class="col-md-4 col-lg-4 col-xs-4">
	              <?php 
	               $where = ['id'=>$_SESSION['user_id']];
				   $admin = $obj->select_admin_name('user_tbl',$where);
				   foreach ($admin as $name) {
				   	echo '<span  class="btn btn-warning pull-right">WELCOME '.$name['name'].'</span>';
				   }
				?>
             </div>
				<div class="col-md-4">
					<div class="panel panel-warning">
						<div class="panel-heading" style="color:#fff;font-size:20px;padding: 0px 14px;margin: 0px;">Register From</div>
						<div class="panel-body">
							<?php
								if (isset($_GET['update'])) {
									$id =$_GET['id'] ?? null;
									$where = ['id'=>$id];
									$data = $obj->select_where('user_tbl',$where);
									foreach ($data as $row) {
										
										?>
										<form action="action.php" method="post" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group"><input type="text"  value="<?php echo $row['name'] ?>"placeholder="Name" required="required" name="name" class="form-control"></div>
										<div class="form-group"><input type="text" value="<?php echo $row['email'] ?>"placeholder="Email" name="email" required="required" class="form-control"></div>
										<div class="form-group"><input type="password" value="<?php echo $row['password'] ?>"placeholder="Password" required="required" name="password" class="form-control"></div>
										<div class="form-group"><input type="file"  name="photo" class="form-control"><input type="hidden" name="path" value="<?php echo $row['image']?>" class="form-control">
										</div>
										<a href="dashboard.php" class="btn btn-warning">Cancel</a>
										<input type="hidden" name="id" value="<?php echo $row['id']?>" class="form-control">
										<input type="submit" name="update"  value="Update" class="btn btn-warning pull-right">
									</div>
								</div>
							</form>
										<?php
									}
								}
								else{
							?>
							<form action="action.php" method="post" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group"><input type="text" value="<?php if(isset($_GET['name']))echo $_GET['name']?>" required="required" placeholder="Name" name="name" class="form-control"></div>
										<div class="form-group"><input type="text" value="<?php if(isset($_GET['email']))echo $_GET['email']?>" required="required" placeholder="Email" name="email" class="form-control"></div>
										<div class="form-group"><input type="password" required="required" placeholder="Password" name="password" class="form-control"></div>
										<div class="form-group"><input type="file" accept="image/gif, image/jpeg" name="photo" class="form-control">
										</div>
									<?php if (isset($_GET['msg'])) {
										echo '<div class="alert alert-dismissible alert-'.$_GET['class'].'" style="padding:6px 30px 6px 15px; ">
									  <button type="button" class="close" data-dismiss="alert">&times;</button>'.$_GET['msg'].'
										</div>';
									}?>	<input type="submit" name="submit" class="btn btn-warning pull-right">
									</div>
								</div>
							</form>
						<?php }?>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<a href="logout.php" class="btn btn-warning">Logout</a>
				</div>
			</div>

			<div class="container">
				<div class="row">
					<div class="co-md-12">
						<table class="table table-bordered" >
							<tr>
								<thead>
									<th>Id</th>
									<th>Name</th>
									<th>Email</th>
									<th>Password</th>
									<th>Edit</th>
									<th>Delete</th>
									<th>Profile</th>
								</thead>
							</tr>
							<?php
								$data = $obj->select_all('user_tbl');
								foreach ($data as $row):
									
							?>
							<tr >
								<td><?php echo $row['id'];?></td>
								<td><?php echo $row['name']?></td>
								<td><?php echo $row['email']?></td>
								<td><?php echo $row['password']?></td>
								<td class="td-align"><a href="dashboard.php?update=1&id=<?php echo $row['id']?>" class="btn btn-primary btn-xs">Edit</a></td>
								<td class="td-align"><a href="dashboard.php?delete=1&path=<?php echo $row['image']?>&id=<?php echo $row['id']?>" class="btn btn-danger btn-xs">Delete</a></td>
								<td class="td-align">
									<?php if ($row['image'] ?? null){?>
											<img src="<?php echo $row['image']?>" alt="" width="38px" style="border: 1px solid #ddd" height="38px">
											<a href="dashboard.php?del_image=1&path=<?php echo $row['image']?>&id=<?php echo $row['id']?>" class="btn btn-warning btn-xs">Remove</a>
									 <?php	} else{ 
									 	echo '<img src="upload/avatar.jpg" withd="38px" height="38px" style="border: 1px solid #ddd">';
									 }
									 	?>
									
								</td>
							</tr>
						<?php endforeach;?>
						</table>
					</div>
					
				</div>
			</div>
		</div>
	</body>
</html>