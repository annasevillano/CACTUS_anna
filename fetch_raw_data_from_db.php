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
$message = "Success";
$study_id = $_POST['study_id'];

$raw_data_table = GetCACTUSRawDataTableName();

// Get the
$query = "SELECT DISTINCT study_block_index FROM $raw_data_table WHERE study_id=$study_id ORDER BY study_block_index ASC";
$results = perform_select_query($db, $query);
$num_components = $results->rowCount();
//$rows = $results->fetchAll();

$study_data = array();
for($i = 0  ; $i < $num_components; $i++){
    $query = "SELECT * FROM $raw_data_table WHERE study_id=$study_id AND study_block_index=$i";
    $results = perform_select_query($db, $query);

    $rows = $results->fetchAll();

    $data_rows_services = array();
    $data_rows_resources = array();
    foreach ($rows as $recs) {
        $raw_data_row_obj= array(
            'study_block_index'=>$recs['study_block_index'],
            'datapoint_id'=>$recs['datapoint_id'],
            'country'=>$recs['country'],
            'country_code'=>$recs['country_code'],
            'city'=>$recs['city'],
            'date'=>$recs['date'],
            'php_date'=>$recs['php_date'],
            'system'=>$recs['system'],
            'element'=>$recs['element'],
            'component'=>$recs['component'],
            'datapoint_name'=>$recs['datapoint_name'],
            'case_desc'=>$recs['case_desc'],
            'data_source'=>$recs['data_source'],
            'resource_service'=>$recs['resource_service'],
            'cost_type_1'=>$recs['cost_type_1'],
            'cost_type_2'=>$recs['cost_type_2'],
            'category_1'=>$recs['category_1'],
            'category_2'=>$recs['category_2'],
            'category_3'=>$recs['category_3'],
            'item_desc'=>$recs['item_desc'],
            'um'=>$recs['um'],
            'um_desc'=>$recs['um_desc'],
            'service_category'=>$recs['service_category'],
            'lifetime'=>$recs['lifetime'],
            'year_cost'=>$recs['year_cost'],
            'currency'=>$recs['currency'],
            'source'=>$recs['source'],
            'one_value_cost'=>$recs['one_value_cost'],
            'cost_adjusted'=>$recs['cost_adjusted'],
            'annualised_value'=>$recs['annualised_value'],
            'discount_rate'=>$recs['discount_rate']
            );

        $country=$recs['country'];
        $city=$recs['city'];
        $year=$recs['date'];
        $study = "$city, $country, $year";

        $resource_service = $recs['resource_service'];
        if($resource_service == "Resources and Costs"){
            $data_rows_resources[] = $raw_data_row_obj;
        }else{
            $data_rows_services[] = $raw_data_row_obj;
        }
    }
    $study_data[] = array(
        'resources'=>$data_rows_resources,
        'services'=>$data_rows_services
    );
}

$all_data = array(
    'message'=>$message,
    'study_id'=>$study_id,
    'study'=>$study,
    'study_data'=>$study_data
);

echo json_encode($all_data);
exit;