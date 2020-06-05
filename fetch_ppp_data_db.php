<?php
/**
 * Created by PhpStorm.
 * User: cenpas
 * Date: 03/04/2018
 * Time: 10:46
 */
(@include_once("./config.php")) OR die("Cannot find this file to include: config.php<BR>");
(@include_once("./utils.php")) OR die("Cannot find this file to include: utils.php<BR>");
(@include_once("./pdo_functions.php")) OR die("Cannot find this file to include: pdo_functions.php<BR>");
(@include_once("./table_functions.php")) OR die("Cannot find this file to include: table_functions.php<BR>");
(@include_once("./cactus_calcs.php")) OR die("Cannot find the file to include: cactus_calcs.php<BR>");
(@include_once("./connect_pdo.php")) OR die("Cannot connect to the database<BR>");


(@include_once("./frameworks/php_classes/PHPExcel.php")) OR die("Cannot read PHPExcel.php file<BR>");
(@include_once("./frameworks/php_classes/PHPExcel/IOFactory.php")) OR die("Cannot read IOFactory.php file<BR>");

{
    $file_info = "";

    $years = array();
    $countries = array();
    $country_codes = array();
    //$ppp_array = array(array());

    $ppp_table = GetCACTUSPPPTableName();
    $ppp_desc_table = GetCACTUSPPPDescsriptionTableName();

    // Get the beginning and end years
    $query = "SELECT * FROM $ppp_desc_table WHERE 1";
    $results = perform_select_query($db, $query);
    // Only one result

    $rows = $results->fetchAll();

    if($results->rowCount() == 1){
        foreach ($rows as $recs) {
            $year_begin = $recs['year_begin'];
            $year_end = $recs['year_end'];
        }
    }

    // Get a unique list of countries used in the current master
    //$master_table = GetCACTUSMasterDataTableName();
    $raw_data_table = GetCACTUSRawDataTableName();
    $query = "SELECT DISTINCT currency FROM $raw_data_table WHERE 1";
    $results = perform_select_query($db, $query);

    $rows = $results->fetchAll();

    $USA_flag = false;
    foreach ($rows as $recs) {
        $country_code = $recs['currency'];
        $country_codes[] = $country_code;
        if($country_code == "USA"){
            $USA_flag = true;
        }
    }

    // add USA if necessary
    if($USA_flag == false){
        $country_codes[] = "USA";
    }

    foreach ($country_codes as $country_code) {
        if(strlen($country_code) > 2) {
            for ($year = $year_begin; $year < $year_end; $year++) {
                $ppp = lookup_PPP($db, $country_code, $year);
                $ppp_array[$country_code][$year] = $ppp;
            }
        }
    }

}

$all_ppp_data = array(
    'ppp_array'=>$ppp_array
);
//print_r2($all_ppp_data);
echo json_encode($all_ppp_data);
exit;