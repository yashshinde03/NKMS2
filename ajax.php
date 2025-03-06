<?php
ob_start();
date_default_timezone_set("Asia/Manila");

$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'login_admin'){
	$login = $crud->login_admin();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'logout_admin'){
	$logout = $crud->logout_admin();
	if($logout)
		echo $logout;
}

if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'save_image'){
	$save = $crud->save_image();
	if($save)
		echo $save;
}
if($action == 'update_user'){
	$save = $crud->update_user();
	if($save)
		echo $save;
}
if($action == 'update_user2'){
	$save = $crud->update_user2();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'save_category'){
	$save = $crud->save_category();
	if($save)
		echo $save;
}
if($action == 'save_category_order'){
	$save = $crud->save_category_order();
	if($save)
		echo $save;
}
if($action == 'delete_category'){
	$save = $crud->delete_category();
	if($save)
		echo $save;
}
if($action == 'save_content'){
	$save = $crud->save_content();
	if($save)
		echo $save;
}
if($action == 'delete_content'){
	$save = $crud->delete_content();
	if($save)
		echo $save;
}
if($action == 'save_comment'){
	$save = $crud->save_comment();
	if($save)
		echo $save;
}
if($action == 'delete_comment'){
	$save = $crud->delete_comment();
	if($save)
		echo $save;
}
if($action == 'load_list'){
	$save = $crud->load_list();
	if($save)
		echo $save;
}
if($action == 'save_home'){
	$save = $crud->save_home();
	if($save)
		echo $save;
}
if($action == 'save_about'){
	$save = $crud->save_about();
	if($save)
		echo $save;
}
ob_end_flush();
?>
