<?php

/*
 * Ajax request page
 */
ob_start();
session_start();
require_once '../config/variables.php';

//initalize user class
$tbox_obj = new Cl_Tbox();

$result = array();

if (isset($_POST) && $_POST) {
    $form_type = $_POST['form_type'];

    switch ($form_type) {
        case "add_user":
            $post_data = array_map('trim', $_POST);
            
            $res = $tbox_obj->add_user($post_data);
            if (isset($res['status']) && $res['status'] == "success") {
                $result = array("status" => true, "messsage" => $res['msg']);
            } elseif(isset($res['status']) && $res['status'] == "fail") {
                $result = array("status" => false, "messsage" => $res['msg']);
            }
            break;
            
        case "edit_user":
            $post_data = array_map('trim', $_POST);
            
            $res = $tbox_obj->edit_user($post_data);
            if (isset($res['status']) && $res['status'] == "success") {
                $result = array("status" => true, "messsage" => $res['msg']);
            } elseif(isset($res['status']) && $res['status'] == "fail") {
                $result = array("status" => false, "messsage" => $res['msg']);
            }
            break;
    }
}

echo json_encode($result);
exit;
?>

