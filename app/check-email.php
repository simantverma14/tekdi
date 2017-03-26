<?php
session_start();
require_once '../config/variables.php';

$tbox_obj = new Cl_Tbox();

if (isset($_POST['email']) && !empty($_POST['email'])) {
    $user_id = $_POST['user_id'];
    $email = $_POST['email'];
    
    if($user_id){
        $qry = "SELECT * FROM users WHERE email = '".$email."' AND id != '".$user_id."'";
        $result = $tbox_obj->db->rawQuery($qry);
    } else {
        $tbox_obj->db->where("email", $email);
        $result = $tbox_obj->db->getOne("users");
    }
    if($result){
        echo 'false';
    } else {
        echo "true";
    }
    exit;
}