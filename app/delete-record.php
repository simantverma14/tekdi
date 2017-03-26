<?php
/*
 * Delete records
 */

session_start();
require_once '../config/variables.php';

$tbox_obj = new Cl_Tbox();

if(isset($_GET['post']) && $_GET['post'] != ""){
    $record_id = $_GET['post'];
    $type = $_GET['type'];

    switch ($type){
        case "user":
            $tbox_obj->db->where("id", $record_id);
            $result = $tbox_obj->db->delete("users");

            if($result){
                header('Location: '.SITE_URL.'index.php?page=users&action=list'); 
                exit();
            } else {
                echo "Error deleting user";
            }
            break;
    }
    exit;
}