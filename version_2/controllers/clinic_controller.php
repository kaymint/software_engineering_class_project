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
            *Adds Clinic to database
            */
            add_clinic_control();
            break;
        case 2:
            /*
            *Gets Clinics from database
            */
            get_clinics_control();
            break;
        case 3:
            /*
            *Get a Clinic from database
            */
            get_clinic_control();
            break;
        case 4:
            /*
            *Edits a Clinic in a database
            */
            edit_clinic_control();
            break;
        default:
            /*
            *Default value sends an error message
            */
            echo '{"result":0, "message":"Invalid Command Entered"}';
            break;
    }
}

/*
 *@method void add_clinic_control() Adds a clinic to database
 */
function add_clinic_control(){
    if( filter_input (INPUT_GET, 'name') && filter_input(INPUT_GET, 'loc')){

        $obj = get_clinic_model();

        $clinic_name = sanitize_string(filter_input (INPUT_GET, 'name'));
        $clinic_location = sanitize_string(filter_input (INPUT_GET, 'loc'));

        if ($obj->add_clinic($clinic_name,$clinic_location)){
            echo '{"result":1,"message": "clinic added successfully"}';
        }
        else
        {
            echo '{"result":0,"message": "unable to add clinic"}';
        }

    }
}

/*
*@method void get_clinics_control() Gets Clinics from database
*/
function get_clinics_control(){

    $obj = get_clinic_model();
    if ($obj->get_clinics()){
        echo '{"result":1, "clinics":[';
        $row = $obj->fetch();
        while($row){
            echo json_encode($row);
            if( $row = $obj->fetch()){
                echo ',';
            }
        }
        echo ']}';
    }else{
        echo '{"result":0,"message": "query unsuccessful"}';
    }

}

/*
*@method void get_clinic_control() Gets a Clinic from database
*/
function get_clinic_control(){

    if(filter_input (INPUT_GET, 'id')){

        $obj = get_clinic_model();

        $clinic_id = sanitize_string(filter_input (INPUT_GET, 'id'));

        if ($obj->get_clinic($clinic_id)){
            echo '{"result":1, "clinics":[';
            $row = $obj->fetch();
            while($row){
                echo json_encode($row);
                if( $row = $obj->fetch()){
                    echo ',';
                }
            }
            echo ']}';
        }else{
            echo '{"result":0,"message": "query unsuccessful"}';
        }
    }

}

/*
*@method void edit_clinic_control() Gets Clinics from database
*/
function edit_clinic_control(){
    if( filter_input (INPUT_GET, 'id') && filter_input (INPUT_GET, 'name') && filter_input(INPUT_GET, 'loc')){

        $obj = get_clinic_model();

        $clinic_id = sanitize_string(filter_input (INPUT_GET, 'id'));
        $clinic_name = sanitize_string(filter_input (INPUT_GET, 'name'));
        $clinic_location = sanitize_string(filter_input (INPUT_GET, 'loc'));

        if ($obj->edit_details($clinic_id,$clinic_name,$clinic_location)){
            echo '{"result":1,"message": "clinic edited successfully"}';
        }
        else
        {
            echo '{"result":0,"message": "unable to edit clinic details"}';
        }

    }
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
 * @return clinic
 */
function get_clinic_model(){
    require_once '../model/clinic.php';
    $obj = new clinic();
    return $obj;
}