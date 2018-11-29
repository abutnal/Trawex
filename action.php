<?php
include('database.php');
class curdOperation extends Database{
//INSERT function
      public function insert($table,$data){
      		$sql="";
      		$sql.="INSERT INTO ".$table;
      		$sql.=" (".implode(", ", array_keys($data)).") VALUES";
      		$sql.="('".implode("', '",array_values($data))."')";
      		$query = mysqli_query($this->con,$sql);
      		if($query){
      			return true;
      		}
      }

 //SELECT ALL FUNCTION
 		public function select_all($table){
 			$sql="";
 			$sql .="SELECT * FROM ".$table;
 			$query = mysqli_query($this->con,$sql);
 			while($row = mysqli_fetch_assoc($query)):
 				$array[]=$row;
 			endwhile;
 			return $array;
 		}

 //SELECT WHERE FUNCTION
 		public function select_where($table,$where){
 			$sql="";
 			$condition="";
 			foreach ($where as $key => $value) {
 				$condition.= $key."='".$value."'";
 			}
 			$sql = "SELECT * FROM ".$table." WHERE ".$condition;
 			$query = mysqli_query($this->con,$sql);
 			while($row = mysqli_fetch_array($query)):
 				$array[] = $row;
 			endwhile;
 			return $array;
 		}

//ADMIN NAME
	public function select_admin_name($table, $where){
		$sql="";
		$conditon="";
		foreach ($where as $key => $value) {
			$conditon .= $key."='".$value."'";
		}
		$sql = "SELECT * FROM ".$table." WHERE ".$conditon;
		$query = mysqli_query($this->con,$sql);
		while($row = mysqli_fetch_array($query)):
			$array[]=$row;
		endwhile;
		return $array;
	}
	
 //UPDATE FUNCTION
 		public function update($table,$data,$where){
 			$sql="";
 			$condition="";
 			foreach ($where as $key => $value) {
 				$condition.= $key."='".$value."'";
 			}
 			foreach ($data as $key => $value) {
 				$sql.= $key."='".$value."', ";
 			}
 			$sql = substr($sql, 0,-2);
 			$sql = "UPDATE ".$table." SET ".$sql." WHERE ".$condition;
 			$query = mysqli_query($this->con,$sql);
 			if($query){
 				return true;
 			}
 		}	

 //DELETE FUNCTION
 		public function delete($table,$where,$path){
 			$sql="";
 			$condition="";
 			foreach ($where as $key => $value) {
 				$condition.= $key."='".$value."'";
 			}
 			$sql = "DELETE FROM ".$table." WHERE ".$condition;
 			if(mysqli_query($this->con,$sql)){
 				unlink($path);
 				return true;
 			}

 		}	

 //REMOVE IMAGE
 		public function remove_image($table,$data,$where,$path){
 			$sql="";
 			$condition="";
 			foreach ($where as $key => $value) {
 				$condition.= $key."='".$value."'";
 			}
 			foreach ($data as $key => $value) {
 				$sql.= $key."='".$value."', ";
 			}
 			$sql = substr($sql, 0,-2);
 			$sql = "UPDATE ".$table." SET ".$sql." WHERE ".$condition;
 			if(mysqli_query($this->con,$sql)){
 				unlink($path);
 				return true;
 			}
 		}
 //LOGIN FUNCTION
	public function login($table,$data){
		$sql="";
		$condition="";
		foreach ($data as $key => $value) {
			$condition .= $key."='".$value."' AND ";
		}
		$condition = substr($condition, 0,-5);
		$sql="SELECT * FROM ".$table." WHERE ".$condition;
		$query = mysqli_query($this->con,$sql);
		$result = mysqli_fetch_array($query);
		if($result[0]>0){
 			//$id = $row['id'];
			return $result['id'];
		}
		
	} 							     
}
$obj = new curdOperation;

//*****************************************************************************************//
//Register Form
if (isset($_POST['submit'])) {
	if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])){
		header('Location:dashboard.php?msg=Fill the mandatory fields&class=warning&name='.$_POST['name'].'&email='.$_POST['email'].'');
	}
		else{
			if(!empty($_FILES['photo']['name'])){
				$pic_name = rand();
				$path = 'upload/'.basename($pic_name.'_'.$_FILES['photo']['name']);
			}
	        else{
	        	$path='';
	        }
	move_uploaded_file($_FILES['photo']['tmp_name'], $path);
	$data = [
		'name'=>$_POST['name'],
		'email'=>$_POST['email'],
		'password'=>md5($_POST['password']),
		'image'=>$path
];

if($obj->insert('user_tbl',$data)){
	header('Location:dashboard.php?msg=Register succssfully&class=success');
}
}
}

//Update Form
if (isset($_POST['update'])) {
			if(!empty($_FILES['photo']['name'])){
				$pic_name = rand();
				$path = 'upload/'.basename($pic_name.'_'.$_FILES['photo']['name']);
			}
	        else{
	        	$path=$_POST['path'];
	        }
	move_uploaded_file($_FILES['photo']['tmp_name'], $path);
	$data = ['name'=>$_POST['name'],'email'=>$_POST['email'],'password'=>md5($_POST['password']), 'image'=>$path];
	$where = ['id'=>$_POST['id']];
	if($obj->update('user_tbl',$data,$where))
	{
		header('Location:dashboard.php?msg=Record Updated Successfully&class=success');
	}
	else
	{
		header('Location:dashboard.php?msg=Opps!, Something is wrong Try again');
	}
}

//Delete Records
if (isset($_GET['delete'])) {
	$where = ['id'=>$_GET['id']];
	$path = $_GET['path'];
	if($obj->delete('user_tbl',$where,$path)){
		header('Location:dashboard.php?msg=Record Deleted Succssfully&class=success');
	}
}

//Remove Imagedashboard
if (isset($_GET['del_image'])) {
	$where = ['id'=>$_GET['id']];
	$path = $_GET['path'];
	$data = ['image'=>''];
     if($obj->remove_image('user_tbl',$data,$where,$path)){
     	header('Location:dashboard.php?msg=Image removed succssfully&class=success');
     }

}

//Login Form
if (isset($_POST['login'])) {
	$data =[
		'email'=>$_POST['username'],
		'password'=>md5($_POST['password'])
	];
	$user_id = $obj->login('user_tbl',$data);
	if(isset($user_id))
	{
		session_start();
		header('Location:dashboard.php');
		$_SESSION['user_id']=$user_id;
	}
	else
	{
		
		header('Location:index.php?msg=Wrong username or password');
	}
}
?>