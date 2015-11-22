<?php
session_start();

if(filter_input (INPUT_GET, 'cmd')){
    $cmd = $cmd_sanitize = '';
    $cmd_sanitize = sanitize_string( filter_input (INPUT_GET, 'cmd'));
    $cmd = intval($cmd_sanitize);
                                    
    switch ($cmd){
        case 1:
            user_signup_control();
            break;
        case 2:
            user_login_control();
            break;
        case 3:
            user_edit_control();
        default:
            echo '{"result":0, "message":"Invalid Command Entered"}';
            break;
    }
}

//signup admin user
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
        
        if ($obj->add_user($username, $password, $usertype)){
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
             elseif( strcmp($usertype, 'supervisor') == 0){
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
 * @param $admin_id
 */
function admin_signup($admin_id){
    $obj = $sname = $fname = $phone = '';
    if(filter_input (INPUT_GET, 'sname') && filter_input(INPUT_GET, 'fname')
        && filter_input(INPUT_GET, 'phone') && filter_input(INPUT_GET, 'district')){
        $obj = get_admin_model();
        $sname = filter_input (INPUT_GET, 'sname');
        $fname = filter_input (INPUT_GET, 'fname');
        $phone = filter_input (INPUT_GET, 'phone');
        $district = filter_input (INPUT_GET, 'district');
        
        if($obj->add_admin($admin_id, $sname, $fname,$district, $phone)){
            echo '{"result":1,"message": "signup successful"}';
        }
        else{
            echo '{"result":0,"message": "signup unsuccesful"}';
        }
    }
}

/**
 * @param $supervisor_id
 */
function supervisor_signup($supervisor_id){
    $obj = $sname = $fname = $district = $phone = '';
    if(filter_input (INPUT_GET, 'sname') && filter_input(INPUT_GET, 'fname')
        && filter_input(INPUT_GET, 'phone') && filter_input(INPUT_GET, 'district')){
        $obj = get_supervisor_model();
        $sname = filter_input (INPUT_GET, 'sname');
        $fname = filter_input (INPUT_GET, 'fname');
        $phone = filter_input (INPUT_GET, 'phone');
        $district = filter_input (INPUT_GET, 'district');
        
        if($obj->add_supervisors($supervisor_id,$fname,$sname,$district,$phone)){
            echo '{"result":1,"message": "signup successful"}';
        }
        else{
            echo '{"result":0,"message": "signup unsuccesful"}';
        }
    }
}


//add new teller
function nurse_signup($teller_id){
    $obj = $sname = $fname = $phone = $gender = $email = '';
    if(filter_input (INPUT_GET, 'sname') && filter_input(INPUT_GET, 'fname') && filter_input(INPUT_GET, 'phone') && filter_input(INPUT_GET, 'gender') && filter_input(INPUT_GET, 'email')){
        $obj = get_nurse_model();
        $sname = sanitize_string(filter_input (INPUT_GET, 'sname'));
        $fname = sanitize_string(filter_input (INPUT_GET, 'fname'));
        $phone = sanitize_string(filter_input (INPUT_GET, 'phone'));
        $gender = sanitize_string(filter_input (INPUT_GET, 'gender'));
        $email = sanitize_string(filter_input (INPUT_GET, 'email'));
        
        if($obj->add_nurses($teller_id, $sname, $fname, $phone, $gender, $email)){
            echo '{"result":1,"message": "signup successful"}';
        }
        else{
            echo '{"result":0,"message": "signup unsuccesful"}';
        }
    }
}



//login function
function user_login_control(){

    $obj = $username = $pass = '';

    if(filter_input (INPUT_GET, 'user') && filter_input(INPUT_GET, 'pass')){
        
        $obj = get_user_model();
        $username = sanitize_string(filter_input (INPUT_GET, 'user'));
        $pass = sanitize_string(filter_input (INPUT_GET, 'pass'));
        $pass = encrypt($pass);
        
        if($obj->get_user($username, $pass)){
            $row = $obj->fetch();
            
            $_SESSION['user'] = $row['username'];
            $_SESSION['id'] = $row['user_id'];
            $_SESSION['user_type'] = $user_type = $row['user_type'];

            echo '{"result":1,"user_type":"'.$user_type .'"}';
        }
        else{
            echo '{"result":0,"message": "Invalid User"}';
        }
    }else{
        echo '{"result":0,"message": "Invalid Credentials"}';
    }

}

function set_user_details(){
    
}

function user_edit_control(){

}

/**
 * @param $val
 * @return string
 */
function sanitize_string($val){
    $val = stripslashes($val);
    $val = strip_tags($val);
    $val = htmlentities($val);
    
    return $val;
}

/**
 * @param $pass
 * @return string
 */
function encrypt($pass){
    $salt1 = "qm&h*";
    $salt2 = "pg!@";
    $token = hash('ripemd128', "$salt1$pass$salt2");
    return $token;
}

/**
 * @return user
 */
function get_user_model(){
    require_once '../model/user.php';
    $obj = new user();
    return $obj;
}


/**
 * @return nurses
 */
function get_nurse_model(){
    require_once '../model/nurse.php';
    $obj = new nurses();
    return $obj;
}

/**
 * @return supervisors
 */
function get_supervisor_model(){
    require_once '../model/supervisor.php';
    $obj = new supervisors();
    return $obj;
}


/**
 * @return admin
 */
function get_admin_model(){
    require_once '../model/admin.php';
    $obj = new admin();
    return $obj;
}


?>