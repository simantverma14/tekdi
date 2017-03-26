<?php
require_once('MysqliDb.php');

/**
 */
class Cl_Tbox {

    /**
     * it will initalize DBclass
     */
    public function __construct() {
        $db = new Mysqlidb(array('host' => DB_HOST,'username' => DB_USERNAME,'password' => DB_PASSWORD,'db' => DB_NAME));
        if (!$db) {
            die("Error connecting database");
        }
        $this->db = $db;
    }

    
    /*==================== Users Module ========================= */

    /**
     * This method will add a new user
     * @param array $data
     * @return array
     */
    public function add_user($data) {
        if (!empty($data)) {
            $name = $this->db->escape($data['name']);
            $email = $this->db->escape($data['email']);
            $country_id = $this->db->escape($data['country_id']);
            $mobile_number = $this->db->escape($data['mobile_number']);
            $birthday = $this->db->escape($data['birthday']);
            $about_you = $this->db->escape($data['about_you']);

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // check if email is already registered
                $this->db->where("email", $email);
                $check_email = $this->db->getOne("users");

                if ($check_email) {
                    $rArray = array('status' => 'fail', 'msg' => 'Email already exists');
                } else {
                    $data = array('name' => $name, 'email' => $email, 'country' => $country_id, 'mobile_number' => $mobile_number, 'about_you' => $about_you, 'birthday' => $birthday, 'created' => date("Y-m-d H:i:s"), 'modified' => date("Y-m-d H:i:s"));
                    $result = $this->db->insert('users', $data);

                    if($result){
                        $rArray = array('status' => 'success', 'msg' => 'User added successfully');
                    } else {
                        $rArray = array('status' => 'fail', 'msg' => 'Error adding user');
                    }
                }
            } else {
                $rArray = array('status' => 'fail', 'msg' => 'Invalid email address');
            }
        } else {
            $rArray = array('status' => 'fail', 'msg' => 'Error adding super user');
        }
        return $rArray;
    }
    
    /*
     * This method will list all the existing users
     * @param 
     * @return array
     */
    public function list_users() {
        $qry = "SELECT u.*, c.name as country FROM users u, countries c WHERE u.country = c.id";
        $users = $this->db->rawQuery($qry);
        return $users;
    }
    
    /**
     * This method will return all the info about user
     * @param int $user_id
     * @return array $result
     */
    public function get_user_info($user_id) {
        if ($user_id) {
            $this->db->where("id", $user_id);
            $result = $this->db->getOne("users");
            return $result;
        }
    }

    /**
     * This method will edit an existing user
     * @param array $data
     * @return array
     */
    public function edit_user($data) {
        if (!empty($data)) {
            $user_id = $this->db->escape($data['user_id']);
            $name = $this->db->escape($data['name']);
            $email = $this->db->escape($data['email']);
            $country_id = $this->db->escape($data['country_id']);
            $mobile_number = $this->db->escape($data['mobile_number']);
            $birthday = $this->db->escape($data['birthday']);
            $about_you = $this->db->escape($data['about_you']);

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // check if email is already registered
                $qry = "SELECT * FROM users WHERE email = '".$email."' AND id != '".$user_id."'";
                $check_email = $this->db->rawQuery($qry);

                if ($check_email) {
                    $rArray = array('status' => 'fail', 'msg' => 'Email already exists');
                } else {
                    $data = array('name' => $name, 'email' => $email, 'country' => $country_id, 'mobile_number' => $mobile_number, 'about_you' => $about_you, 'birthday' => $birthday,'modified' => date("Y-m-d H:i:s"));
                    $this->db->where('id', $user_id);
                    $result = $this->db->update('users', $data);

                    if($result){
                        $rArray = array('status' => 'success', 'msg' => 'User updated successfully');
                    } else {
                        $rArray = array('status' => 'fail', 'msg' => 'Error updating user');
                    }
                }
            } else {
                $rArray = array('status' => 'fail', 'msg' => 'Invalid email address');
            }
        } else {
            $rArray = array('status' => 'fail', 'msg' => 'Error adding super user');
        }
        return $rArray;
    }
    
    /*
     * This method will list all the existing countries
     * @param 
     * @return array
     */
    public function list_countries() {
        $countries = $this->db->get('countries');
        return $countries;
    }
    
    /**
     * Function to print output in <pre> format
     */
    public function pr($data = '') {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
}