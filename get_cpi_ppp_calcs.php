<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 18/06/2019
 * Time: 22:43
 */

(@include_once("./config.php")) OR die("Cannot find this file to include: config.php<BR>");
(@include_once("./utils.php")) OR die("Cannot find this file to include: utils.php<BR>");
(@include_once("./pdo_functions.php")) OR die("Cannot find this file to include: pdo_functions.php<BR>");
(@include_once("./table_functions.php")) OR die("Cannot find this file to include: table_functions.php<BR>");
(@include_once("./connect_pdo.php")) OR die("Cannot connect to the database<BR>");

(@include_once("./cactus_calcs.php")) OR die("Cannot find this file to include: cactus_calcs.php<BR>");

//var_dump($_POST);
$message = "";
$country_code = $_POST['country_code'];
$year = $_POST['year'];
$which_calc = $_POST['which_calc'];

$value = -1;
$source_value = -1;

if($which_calc == "cpi"){
    $message = "CPI calc performed";
    $value = lookup_CPI($db, $country_code, $year);
}elseif ($which_calc == "ppp"){
    $message = "PPP calc performed";
    $value = lookup_PPP($db, $country_code, $year);
}elseif ($which_calc == "value_adjust"){
    $message = "value adjustment calc performed";
    $source_year = $year;
    $source_value = $_POST['source_value'];
    $target_year = $_POST['target_year'];
    $value = get_value_adjusted($db, $source_value, $country_code, $source_year, $target_year);
}else{
    $message = "This calculation is not supported: $which_calc";
}
$all_data = array(
    'message'=>$message,
    'country_code'=>$country_code,
    'year'=>$year,
    'which_calc'=>$which_calc,
    'source_value'=>$source_value,
    'value'=>$value
);

echo json_encode($all_data);
exit;