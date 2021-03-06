<?php
/**
    *@author Group 4
    *@version 2.0.0
    *@copyright Copyright (c) 2015, Group 4
*/

include_once 'adb.php';

class clinic extends adb{

function clinic(){

    /*
    *@method boolean get_clinic() Gets all clinics from the database
    *@return boolean
    */
    function get_clinics()
    {
        $str_query = "select clinic_id, clinic_name, clinic_location from se_clinics";
        
        return $this->query($str_query);
    }

    /**
    *@methood boolean delete_clinic() get_clinic($id) Deletes the row storing data for a given clinic using its id
    *@param int $id this represents the unique identifier for each clinic
    *@return boolean
    */
    
    function delete_clinic($id)
    {
        $str_query = "delete from  se_clinics where clinic_id = $id";
        return $this->query($str_query);
    }
    
    /**
    *@method boolean search_clinic_by_name() search_clinic_by_name($sn) Searches for the rows with names of clinics that match the pattern
    *@param int $sn this represents the name of the clinic
    *@return boolean
    */
    
    function search_clinic_by_name($sn)
    {
        $str_query = "select clinic_id, clinicName, clinic_location where clinic_name like '%$sn%'";
        return $this->query($str_query);
    }
    
}
}

?>
     * @param $clinic_name
     * @param $clinic_location
     * @return bool
     */
    function add_clinic($clinic_name, $clinic_location){
        $str_query =  "INSERT into se_clinics SET
                   clinic_name = '$clinic_name',
                   clinic_location = '$clinic_location'";

        return $this->query($str_query);
    }

    /**
     * @return bool
     */
    function get_clinics(){
        $str_query = "SELECT * FROM se_clinics";

        return $this->query($str_query);
    }

    /**
     * @param $id
     * @return bool
     */
    function get_clinic($id){
        $str_query = "SELECT * FROM se_clinics where clinic_id = $id";

        return $this->query($str_query);
    }

    /**
     * @param $clinic_id
     * @param $clinic_name
     * @param $clinic_location
     * @return bool
     */
    function edit_details($clinic_id, $clinic_name, $clinic_location){
        $str_query = "UPDATE se_clinics SET
                      clinic_name = '$clinic_name',
                      clinic_location = '$clinic_location'";

        return $this->query($str_query);
    }


}

/**
 * Unit test and usage
 */

//$obj = new clinic();
//$obj->add_clinic('Kwashieman Community Clinic', 'Kwashieman');
//if($obj->get_clinic(1)){
//    $row = $obj->fetch();
//    echo "clinic name ". $row['clinic_name'];
//}else{
//    echo "query failed";
//}
//$obj->edit_details(1,'Bubuashie Community Clinic', 'Bubuashie');
