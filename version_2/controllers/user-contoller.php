<?php
/**
    *@author Group 4
    *@version 2.0.0
    *@copyright Copyright (c) 2015, Group 4
    */

/**
*@method void session_start() Starts the session
*/
session_start();

if(filter_input (INPUT_GET, 'cmd')){
    $cmd = $cmd_sanitize = '';
    $cmd_sanitize = sanitize_string( filter_input (INPUT_GET, 'cmd'));
    $cmd = intval($cmd_sanitize);
                                    
    switch ($cmd){
        case 1:
            /*
            *sign up a user
            */
            user_signup_control();
            break;
        case 2:
            /*
            *log in a user
            */
            user_login_control();
            break;
        case 3:
            /*
            *edits a user
            */
            user_edit_control();
            break;
        case 4:
            /*
            *edits a password for a user
            */
            edit_password_control();
            break;
        case 5:
            /*
            *log out a user
            */
            user_logout_control();
            break;
        default:
            /*
            *Default value returns an error message
            */
            echo '{"result":0, "message":"Invalid Command Entered"}';
            break;
    }
}

/**
 *@method void user_signup_control() Signs a user into the system.
 */
function user_signup_control(){
    
    $obj  = $username = $password = $usertype = $row = '';
    
    if( filter_input (INPUT_GET, 'user') && filter_input(INPUT_GET, 'pass')
        && filter_input(INPUT_GET, 'type') && filter_input(INPUT_GET, 'email')){
    
        $obj = get_user_model();
        $username = sanitize_string(filter_input (INPUT_GET, 'user'));
        $password = sanitize_string(filter_input (INPUT_GET, 'pass'));
        $password = encrypt($password);
        $usertype = sanitize_string(filter_input (INPUT_GET, 'type'));
        $email = sanitize_string(filter_input(INPUT_GET, 'email'));
        
        if ($obj->add_user($username, $password, $usertype, $email)){
             if( strcmp($usertype, 'admin') == 0)
             {
                //if user type is admin
                admin_signup($obj->get_insert_id());
             }
             elseif( strcmp($usertype, 'nurse') == 0)
             {
                //if user is a nurse
                 nurse_signup($obj->get_insert_id());
             }
             elseif( strcmp($usertype, 'supervisor') == 0) {
                 //if user is a supervisor
                 supervisor_signup($obj->get_insert_id());
             }
        }
        else
        {
            echo '{"result":0,"message": "signup unsuccessful"}';
        }
        
    }
}

/**
 * @method void admin_signup() admin_signup($admin_id) Signs an administrater into the system 
 * @param int $admin_id Administrator ID
 */
function admin_signup($admin_id){
    $obj = $sname = $fname = $phone = '';
    if(filter_input (INPUT_GET, 'sname') && filter_input(INPUT_GET, 'fname')
        && filter_input(INPUT_GET, 'phone')
        && filter_input(INPUT_GET, 'district') && filter_input(INPUT_GET, 'gender')){
        $obj = get_admin_model();
        $sname = sanitize_string(filter_input (INPUT_GET, 'sname'));
        $fname = sanitize_string(filter_input (INPUT_GET, 'fname'));
        $phone = sanitize_string(filter_input (INPUT_GET, 'phone'));
        $district = sanitize_string(filter_input (INPUT_GET, 'district'));
        $gender = sanitize_string(filter_input (INPUT_GET, 'gender'));
        
        if($obj->add_admin($admin_id, $sname, $fname,$district, $phone, $gender)){

            echo '{"result":1,"message": "signup successful"}';
        }
        else{
            echo '{"result":0,"message": "signup unsuccesful"}';
        }
    }
}

<<<<<<< HEAD
/**
    *@method void setUserSessionDetails() setUserSessionDetails($username, $user_id, $user_type, $email) inputs data for user to start a session in the system.
    *@param string $username The username of user
    *@param int $user_id The ID of the user
    *@param string $user_type Specifies the type of user
    *@param string $email The email of the user
*/
function setUserSessionDetails($username, $user_id, $user_type, $email){
    $_SESSION['username'] = $username;
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_type'] = $user_type;
    $_SESSION['email'] = $email;
    $_SESSION['logged_in'] = 'true';
}

<<<<<<< HEAD
/**
    *@method void setUserSessionValues() setUserSessionValues($sname, $fname, $phone, $district, $gender) inputs data for user to start a session in the system.
    *@param string $sname The surname of user
    *@param string $fname The firstname of the user
    *@param string $phone The phone number of the user
    *@param string $district The district of the user
    *@param string $gender The gender of the user
*/
function setUserSessionValues($sname, $fname, $phone, $district, $gender){
    $_SESSION['sname'] = $sname;
    $_SESSION['fname'] = $fname;
    $_SESSION['phone'] = $phone;
    $_SESSION['district'] = $district;
    $_SESSION['gender'] = $gender;
}

/**
 * @method void supervisor_signup() supervisor_signup($supervisor_id) Controls supervisor sign up
 * @param int $supervisor_id The supervisor ID
 */
function supervisor_signup($supervisor_id){
    $obj = $sname = $fname = $district = $phone = '';
    if(filter_input (INPUT_GET, 'sname') && filter_input(INPUT_GET, 'fname')
        && filter_input(INPUT_GET, 'phone') && filter_input(INPUT_GET, 'district')
        && filter_input(INPUT_GET, 'gender')){
        $obj = get_supervisor_model();
        $sname = filter_input (INPUT_GET, 'sname');
        $fname = filter_input (INPUT_GET, 'fname');
        $phone = filter_input (INPUT_GET, 'phone');
        $district = filter_input (INPUT_GET, 'district');
        $gender = sanitize_string(filter_input (INPUT_GET, 'gender'));
        
        if($obj->add_supervisors($supervisor_id,$fname,$sname,$district,$phone,$gender)){
            echo '{"result":1,"message": "signup successful"}';
        }
        else{
            echo '{"result":0,"message": "signup unsuccesful"}';
        }
    }
}


/**
 * @method void nurse_signup() nurse_signup($nurse_id) Controls the nurse sign up
 * @param int $nurse_id The nurse ID
 */
function nurse_signup($nurse_id){
    $obj = $sname = $fname = $phone = $gender = $email = '';
    if(filter_input (INPUT_GET, 'sname') && filter_input(INPUT_GET, 'fname') && filter_input(INPUT_GET, 'phone')
        && filter_input(INPUT_GET, 'gender') && filter_input(INPUT_GET, 'district')){
        $obj = get_nurse_model();
        $sname = sanitize_string(filter_input (INPUT_GET, 'sname'));
        $fname = sanitize_string(filter_input (INPUT_GET, 'fname'));
        $phone = sanitize_string(filter_input (INPUT_GET, 'phone'));
        $gender = sanitize_string(filter_input (INPUT_GET, 'gender'));
        $district = sanitize_string(filter_input (INPUT_GET, 'district'));


        if($obj->add_nurses($nurse_id, $sname, $fname,$district, $phone,$gender)){
            echo '{"result":1,"message": "signup successful"}';
        }
        else{
            echo '{"result":0,"message": "signup unsuccesful"}';
        }
    }
}


/**
 *@method void user_login_control() Controls the user login
 */
function user_login_control(){

    $obj = $username = $pass = '';

    if(filter_input (INPUT_GET, 'user') && filter_input(INPUT_GET, 'pass')){
        
        $obj = get_user_model();
        $username = sanitize_string(filter_input (INPUT_GET, 'user'));
        $pass = sanitize_string(filter_input (INPUT_GET, 'pass'));
        $pass = encrypt($pass);
        
        if($obj->get_user($username, $pass)){
            $row = $obj->fetch();

            if($row == 0){
                echo "Invalid user";
            }else {
                $username = $row['username'];
                $user_id = $row['user_id'];
                $user_type = $row['user_type'];
                $email = $row['email'];

                setUserSessionDetails($username,$user_id, $user_type,$email);
                echo '{"result":1,"user_type":"' . $user_type . '"}';

                if(strcmp($user_type, 'admin') == 0){
                    $admin = get_admin_model();
                    if($admin->get_details($user_id)){
                        $row = $admin->fetch();
                        $sname = $row['sname'];
                        $fname = $row['fname'];
                        $district = $row['district'];
                        $phone = $row['phone'];
                        $gender = $row['gender'];
                        setUserSessionValues($sname,$fname,$phone, $district,$gender);
                        //echo "user_name ". $sname. " phone ". $phone;
                    }
                }elseif(strcmp($user_type, 'nurse') == 0){
                    $nurse = get_nurse_model();
                    if($nurse->get_details($user_id)){
                        $row = $nurse->fetch();
                        $sname = $row['sname'];
                        $fname = $row['fname'];
                        $district = $row['district_zone'];
                        $phone = $row['phone'];
                        $gender = $row['gender'];
                        setUserSessionValues($sname,$fname,$phone, $district,$gender);
                        //echo "user_name ". $sname. " phone ". $phone;
                    }
                }elseif(strcmp($user_type, 'supervisor') == 0){
                    $supervisor = get_admin_model();
                    if($supervisor->get_details($user_id)){
                        $row = $supervisor->fetch();
                        $sname = $row['sname'];
                        $fname = $row['fname'];
                        $district = $row['district_zone'];
                        $phone = $row['phone'];
                        $gender = $row['gender'];
                        setUserSessionValues($sname,$fname,$phone, $district,$gender);
                        //echo "user_name ". $sname. " phone ". $phone;
                    }
                }
            }
        }
        else{
            echo '{"result":0,"message": "Invalid User"}';
            $_SESSION['logged_in'] = false;
        }
    }else{
        echo '{"result":0,"message": "Invalid Credentials"}';
        $_SESSION['logged_in'] = false;
    }
}


function set_user_details(){
    
}

function user_edit_control(){

}

/**
 * @method void edit_password_control() Controls editing user password
 */
function edit_password_control(){
    $obj  = $username = $password = '';

    if( filter_input (INPUT_GET, 'id') && filter_input(INPUT_GET, 'pass')){

        $obj = get_user_model();
        $user_id = sanitize_string(filter_input (INPUT_GET, 'id'));
        $password = sanitize_string(filter_input (INPUT_GET, 'pass'));
        $password = encrypt($password);

        if ($obj->edit_password_byId($user_id,$password)){
            echo '{"result":1,"message": "password changed successfully"}';
        }
        else
        {
            echo '{"result":0,"message": "signup unsuccessful"}';
        }

    }
}

/**
 *@method void user_logout_control() Controls loging out
 */
function user_logout_control(){
    session_destroy();
    //redirect to logout screen
    header("Location: http://localhost/SE/software_engineering_project/version_2/view/login.html");
}

/**
 * @method string sanitize_string() sanitize_string($val) sanitize input from url
 * @param string $val A string value
 * @return string
 */
function sanitize_string($val){
    $val = stripslashes($val);
    $val = strip_tags($val);
    $val = htmlentities($val);
    
    return $val;
}

/**
 * @method string encrypt() encrypt($pass) Encrypts password
 * @param string $pass The password
 * @return string
 */
function encrypt($pass){
    $salt1 = "qm&h*";
    $salt2 = "pg!@";
    $token = hash('ripemd128', "$salt1$pass$salt2");
    return $token;
}

/**
 * @method user get_user_model() Instantiates an object for the user class
 * @return user
 */
function get_user_model(){
    require_once '../model/user.php';
    $obj = new user();
    return $obj;
}


/**
 * @method nurses get_nurse_model() Instantiates an object for the user class
 * @return nurses
 */
function get_nurse_model(){
    require_once '../model/nurse.php';
    $obj = new nurses();
    return $obj;
}

/**
 * @method supervisors get_supervisor_model() Instantiates an object for supervisors class
 * @return supervisors
 */
function get_supervisor_model(){
    require_once '../model/supervisor.php';
    $obj = new supervisors();
    return $obj;
}


/**
 * @method admin get_admin_model() Instantiates an object for admin class
 * @return admin
 */
function get_admin_model(){
    require_once '../model/admin.php';
    $obj = new admin();
    return $obj;
}


?>