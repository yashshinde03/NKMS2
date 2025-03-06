<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		extract($_POST);
			$qry = $this->db->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where email = '".$email."' and password = '".md5($password)."'  ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 2;
		}
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function logout_admin(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:admin/login.php");
	}
	function login_admin(){
		extract($_POST);
			$qry = $this->db->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where email = '".$email."' and password = '".md5($password)."' and type = 1  ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['admin_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function save_user(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cpass','password')) && !is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if(!empty($password)){
					$data .= ", password=md5('$password') ";

		}
		$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
			$data .= ", avatar = '$fname' ";

		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set $data");
		}else{
			$save = $this->db->query("UPDATE users set $data where id = $id");
		}

		if($save){
			return 1;
		}
	}
	function signup(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cpass','password')) && !is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if(!empty($password)){
					$data .= ", password=md5('$password') ";

		}
		$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
			$data .= ", avatar = '$fname' ";

		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set $data");

		}else{
			$save = $this->db->query("UPDATE users set $data where id = $id");
		}

		if($save){
			if(empty($id))
				$id = $this->db->insert_id;
			foreach ($_POST as $key => $value) {
				if(!in_array($key, array('id','cpass','password')) && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
					$_SESSION['login_id'] = $id;
				if(isset($fname))
					$_SESSION['login_avatar'] = $fname;
			return 1;
		}
	}

	function update_user(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cpass','table','password')) && !is_numeric($k)){
				
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
			$data .= ", avatar = '$fname' ";

		}
		if(!empty($password))
			$data .= " ,password=md5('$password') ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set $data");
		}else{
			$save = $this->db->query("UPDATE users set $data where id = $id");
		}

		if($save){
			foreach ($_POST as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['admin_'.$key] = $value;
			}
			if(isset($_FILES['img']) && !empty($_FILES['img']['tmp_name']))
					$_SESSION['admin_avatar'] = $fname;
			return 1;
		}
	}
	function update_user2(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cpass','table','password')) && !is_numeric($k)){
				
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
			$data .= ", avatar = '$fname' ";

		}
		if(!empty($password))
			$data .= " ,password=md5('$password') ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set $data");
		}else{
			$save = $this->db->query("UPDATE users set $data where id = $id");
		}

		if($save){
			foreach ($_POST as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
			if(isset($_FILES['img']) && !empty($_FILES['img']['tmp_name']))
					$_SESSION['login_avatar'] = $fname;
			return 1;
		}
	}
	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = ".$id);
		if($delete)
			return 1;
	}
	function save_system_settings(){
		extract($_POST);
		$data = '';
		foreach($_POST as $k => $v){
			if(!is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if($_FILES['cover']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['cover']['name'];
			$move = move_uploaded_file($_FILES['cover']['tmp_name'],'../assets/uploads/'. $fname);
			$data .= ", cover_img = '$fname' ";

		}
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set $data where id =".$chk->fetch_array()['id']);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set $data");
		}
		if($save){
			foreach($_POST as $k => $v){
				if(!is_numeric($k)){
					$_SESSION['system'][$k] = $v;
				}
			}
			if($_FILES['cover']['tmp_name'] != ''){
				$_SESSION['system']['cover_img'] = $fname;
			}
			return 1;
		}
	}
	function save_image(){
		extract($_FILES['file']);
		if(!empty($tmp_name)){
			$fname = strtotime(date("Y-m-d H:i"))."_".(str_replace(" ","-",$name));
			$move = move_uploaded_file($tmp_name,'assets/uploads/'. $fname);
			$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
			$hostName = $_SERVER['HTTP_HOST'];
			$path =explode('/',$_SERVER['PHP_SELF']);
			$currentPath = '/'.$path[1]; 
			if($move){
				return $protocol.'://'.$hostName.$currentPath.'/assets/uploads/'.$fname;
			}
		}
	}
	function save_category(){
		extract($_POST);
		$data = " category='$category' ";
		$chk = $this->db->query("SELECT * FROM categories where category = '$category' and id != '{$id}' ")->num_rows;
		if($chk > 0){
			return 2;
		}
		$last_cat = $this->db->query("SELECT * FROM categories order by order_by desc limit 1");
		$order_by = $last_cat->num_rows > 0 ? $last_cat->fetch_array()['order_by'] + 1 : 0;
		if(isset($is_root) && $parent_id <= 0){
			$data .= ", is_root='1' ";
			$data .= ", parent_id='0' ";
		}else{
			$data .= ", parent_id='$parent_id' ";
			$data .= ", is_root='0' ";
		}
		
		if(empty($id)){
		$data .= ", order_by='$order_by' ";
			$save = $this->db->query("INSERT INTO categories set $data");
			$id = $this->db->insert_id;
			if($save){
				$link = strtolower(str_replace(array('.',' '), '_', $category));
				$data = "link='index.php?page=list&c={$link}&cid=".md5($id)."' ";
				$save = $this->db->query("UPDATE categories set $data where id = $id");
			}
		}else{
			$link = strtolower(str_replace(array('.',' '), '_', $category));
			$data = "link='index.php?page=list&c={$link}&cid=".md5($id)."' ";
			$save = $this->db->query("UPDATE categories set $data where id = $id");
		}
		if($save){
			
			return 1;
		}
	}
	function save_category_order(){
		extract($_POST);
		foreach ($ids as $k => $v) {
			$update = $this->db->query("UPDATE categories set order_by = $k where id = $v");
		}
		return 1;
	}
	function delete_category(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM categories where id = $id");
		if($delete){
			return 1;
		}
	}
	function save_home(){
		extract($_POST);
		if(!empty($content)){
			$save = file_put_contents('home.html', $content);
			if($save)
				return 1;
		}else{
			$fh = fopen('home.html', 'w' );
			fclose($fh);
				return 1;
		}
	}
	function save_about(){
		extract($_POST);
		if(!empty($content)){
			$save = file_put_contents('about.html', $content);
			if($save)
				return 1;
		}else{
			$fh = fopen('about.html', 'w' );
			fclose($fh);
				return 1;
		}
	}
	function save_content(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','user_ids','tags',"content")) && !is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
					
		$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
		unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
		$desc = strtr(html_entity_decode($content),$trans);
		$desc=str_replace(array("<li>","</li>"), array("",", "), $desc);
		$meta_description = substr(strip_tags($desc), 0,300);
		$meta_description = str_replace("'","&#x2019;",$meta_description);

		$data .= ", meta_description='$meta_description' ";
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
			$data .= ", banner_img = '$fname' ";

		}
		if(isset($tags)){
			$data .= ", meta_keywords='".implode(',',$tags)."' ";
		}
		if(empty($id)){
			$author = $_SESSION['admin_id'] || $_SESSION['login_id'];
			$data .= ", author_id='$author' ";
			// echo "INSERT INTO contents set $data";exit;
			$save = $this->db->query("INSERT INTO contents set $data");
		}else{
			$save = $this->db->query("UPDATE contents set $data where id = $id");
		}
		if($save){
			if(empty($id))
				$id = $this->db->insert_id;
			$fname = $id."_".(str_replace(" ",'-',$title)).'.html';
			$data = " link='$fname' ";
			$save = $this->db->query("UPDATE contents set $data where id = $id");

			if(!empty($content)){
				$put = file_put_contents($fname, $content);
			}else{
				$fh = fopen($fname, 'w' );
				fclose($fh);
			}
			return 1;
		}
	}
	function delete_content(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM contents where id = $id");
		if($delete){
			return 1;
		}
	}
	function save_comment(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id')) && !is_numeric($k)){
				if($k == 'comment')
				$v = htmlentities(str_replace("'","&#x2019;",$v));
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
					
		if(empty($id)){
			$author = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : $_SESSION['login_id'];
			$data .= ", user_id='$author'";
			$save = $this->db->query("INSERT INTO comments set $data");
		}else{
			$save = $this->db->query("UPDATE comments set $data where id = $id");
		}
		if($save){
			return 1;
		}
	}
	function delete_comment(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM comments where id = $id");
		if($delete){
			return 1;
		}
	}
	function load_list(){
		extract($_POST);
		$start = $start * 10;
		$qry = $this->db->query("SELECT * FROM contents where md5(category_id) = '$id' or category_id in (SELECT id from categories where md5(parent_id) = '$id') order by unix_timestamp(date_created) desc ");
		$data = array();
		while($row=$qry->fetch_assoc()){
		$row['comments'] = $this->db->query("SELECT * FROM comments where content_id = {$row['id']}")->num_rows;
		$row['comments'] = number_format($row['comments']);
			$row['description'] = is_file($row['link']) ? file_get_contents($row['link']) : '';
			$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
			unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
			$desc = strtr($row['description'],$trans);
			$desc=str_replace(array("<li>","</li>"), array("",", "), $desc);
			$row['description'] = strip_tags($desc);
			$row['eid'] = md5($row['id']);
			$data[] = $row;
		}
		echo json_encode($data);
	}
}