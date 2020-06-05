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
//$study_id = $_POST['study_id'];

$raw_data_table = GetCACTUSRawDataTableName();
$master_table = GetCACTUSMasterDataTableName();

// Get all the datapoints the
// Get a list of all the datapoint_id
$query = "SELECT DISTINCT datapoint_id FROM $raw_data_table WHERE 1 ORDER BY datapoint_id ASC";
$results = perform_select_query($db, $query);
$dp_ids = array();
$rows = $results->fetchAll();
foreach ($rows as $recs) {
    $dp_ids[] = $recs['datapoint_id'];
}
//print_r2($dp_ids);
//exit();
$num_datapoints = sizeof($dp_ids);

//$query = "SELECT DISTINCT study_block_index FROM $raw_data_table WHERE study_id=$study_id ORDER BY study_block_index ASC";
$query = "SELECT * FROM $raw_data_table WHERE 1";
$results = perform_select_query($db, $query);
//$rows = $results->fetchAll();

$study_data = array();
for($i = 0  ; $i < $num_datapoints; $i++){
    $datapoint_id = $dp_ids[$i];

    $query = "SELECT * FROM $raw_data_table WHERE datapoint_id=$datapoint_id ORDER BY id ASC";
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


        $resource_service = $recs['resource_service'];
        if($resource_service == "Resources and Costs"){
            $data_rows_resources[] = $raw_data_row_obj;
        }else{
            $data_rows_services[] = $raw_data_row_obj;
        }
    }
    $studies[] = "$city, $country, $year, datapoint: $datapoint_id";

    // Get the general master data for this data point
    $query = "SELECT * FROM $master_table WHERE datapoint_id='$datapoint_id' LIMIT 1";
    $results = perform_select_query($db, $query);
    $data_row_general = array();

    if($results->rowCount() == 1){
        $rec = $results->fetch();
        //print_r2($rec);
        $data_row_general = array(
            'datapoint_id'=>$rec['datapoint_id'],
            'country'=>$rec['country'],
            'country_code'=>$rec['country_code'],
            'city'=>$rec['city'],
            'lat'=>$rec['lat'],
            'lon'=>$rec['lon'],
            'system'=>$rec['system'],
            'element'=>$rec['element'],
            'component'=>$rec['component'],
            'data_source'=>$rec['data_source'],
            'source'=>$rec['source'],
            'datapoint_name'=>$rec['datapoint_name'],
            'case_description'=>$rec['case_desc'],
            'report_name'=>$rec['report_name'],
            'data_collector'=>$rec['data_collector'],
            'date'=>$rec['date'],
            'city_population'=>$rec['city_population'],
            'city_population_density'=>$rec['city_population_density'],
            'year_of_population'=>$rec['year_of_population'],
            'region'=>$rec['region'],
            'topography'=>$rec['topography'],
            'num_hh_served'=>$rec['num_hh_served'],
            'num_people_served'=>$rec['num_people_served'],
            'num_people_per_hh'=>$rec['num_people_per_hh'],
            'tach'=>$rec['tach'],
            'tacc'=>$rec['tacc']
        );
    }else{
        $data_row_general = array(
            'datapoint_id'=>'-1'
        );
    }

    // Get the Total cost data
    $total_cost_table = GetCACTUSTotalCostDataTableName();
    // Get the general master data for this data point
    $query = "SELECT * FROM $total_cost_table WHERE datapoint_id='$datapoint_id'";
    $results = perform_select_query($db, $query);
    $data_total_cost = array();
    if($results->rowCount() == 1){
        $data_total_cost = array(
            'no_data_flag'=>1,
            'datapoint_id'=>$recs['datapoint_id'],
            'capex_land'=>$recs['capex_land'],
            'capex_infrastructure'=>$recs['capex_infrastructure'],
            'capex_equipment'=>$recs['capex_equipment'],
            'capex_extraordinary'=>$recs['capex_extraordinary'],
            'capex_staff_develop'=>$recs['capex_staff_develop'],
            'capex_other'=>$recs['capex_other'],
            'capex_administration'=>$recs['capex_administration'],
            'capex_finance'=>$recs['capex_finance'],
            'capex_taxes'=>$recs['capex_taxes'],
            'opex_land'=>$recs['opex_land'],
            'opex_infrastructure'=>$recs['opex_infrastructure'],
            'opex_equipment'=>$recs['opex_equipment'],
            'opex_staff'=>$recs['opex_staff'],
            'opex_staff_develop'=>$recs['opex_staff_develop'],
            'opex_consumables_utilities'=>$recs['opex_consumables_utilities'],
            'opex_consumables_fuel'=>$recs['opex_consumables_fuel'],
            'opex_consumables_chemicals'=>$recs['opex_consumables_chemicals'],
            'opex_consumables_other'=>$recs['opex_consumables_other'],
            'opex_consumables_service_consultant'=>$recs['opex_consumables_service_consultant'],
            'opex_consumables_service_legal'=>$recs['opex_consumables_service_legal'],
            'opex_consumables_service_insurance'=>$recs['opex_consumables_service_insurance'],
            'opex_consumables_service_maint'=>$recs['opex_consumables_service_maint'],
            'opex_consumables_service_other'=>$recs['opex_consumables_service_other'],
            'opex_other'=>$recs['opex_other'],
            'opex_administration'=>$recs['opex_administration'],
            'opex_finance'=>$recs['opex_finance'],
            'opex_taxes'=>$recs['opex_taxes']
        );
    }else{
        $data_total_cost = array(
            'no_data_flag'=>1,
            'datapoint_id'=>0,
            'capex_land'=>0,
            'capex_infrastructure'=>0,
            'capex_equipment'=>0,
            'capex_extraordinary'=>0,
            'capex_staff_develop'=>0,
            'capex_other'=>0,
            'capex_administration'=>0,
            'capex_finance'=>0,
            'capex_taxes'=>0,
            'opex_land'=>0,
            'opex_infrastructure'=>0,
            'opex_equipment'=>0,
            'opex_staff'=>0,
            'opex_staff_develop'=>0,
            'opex_consumables_utilities'=>0,
            'opex_consumables_fuel'=>0,
            'opex_consumables_chemicals'=>0,
            'opex_consumables_other'=>0,
            'opex_consumables_service_consultant'=>0,
            'opex_consumables_service_legal'=>0,
            'opex_consumables_service_insurance'=>0,
            'opex_consumables_service_maint'=>0,
            'opex_consumables_service_other'=>0,
            'opex_other'=>0,
            'opex_administration'=>0,
            'opex_finance'=>0,
            'opex_taxes'=>0
        );
    }

    // Get the annulaised data
    $annualised_cost_table = GetCACTUSAnnualisedCostDataTableName();
    $query = "SELECT * FROM $annualised_cost_table WHERE datapoint_id='$datapoint_id'";
    $results = perform_select_query($db, $query);
    $data_annualised_cost = array();
    if($results->rowCount() == 1){
        $data_annualised_cost = array(
            'no_data_flag'=>0,
            'datapoint_id'=>$recs['datapoint_id'],
            'capex_land'=>$recs['capex_land'],
            'capex_infrastructure'=>$recs['capex_infrastructure'],
            'capex_equipment'=>$recs['capex_equipment'],
            'capex_extraordinary'=>$recs['capex_extraordinary'],
            'capex_staff_develop'=>$recs['capex_staff_develop'],
            'capex_other'=>$recs['capex_other'],
            'capex_administration'=>$recs['capex_administration'],
            'capex_finance'=>$recs['capex_finance'],
            'capex_taxes'=>$recs['capex_taxes'],
            'opex_land'=>$recs['opex_land'],
            'opex_infrastructure'=>$recs['opex_infrastructure'],
            'opex_equipment'=>$recs['opex_equipment'],
            'opex_staff'=>$recs['opex_staff'],
            'opex_staff_develop'=>$recs['opex_staff_develop'],
            'opex_consumables_utilities'=>$recs['opex_consumables_utilities'],
            'opex_consumables_fuel'=>$recs['opex_consumables_fuel'],
            'opex_consumables_chemicals'=>$recs['opex_consumables_chemicals'],
            'opex_consumables_other'=>$recs['opex_consumables_other'],
            'opex_consumables_service_consultant'=>$recs['opex_consumables_service_consultant'],
            'opex_consumables_service_legal'=>$recs['opex_consumables_service_legal'],
            'opex_consumables_service_insurance'=>$recs['opex_consumables_service_insurance'],
            'opex_consumables_service_maint'=>$recs['opex_consumables_service_maint'],
            'opex_consumables_service_other'=>$recs['opex_consumables_service_other'],
            'opex_other'=>$recs['opex_other'],
            'opex_administration'=>$recs['opex_administration'],
            'opex_finance'=>$recs['opex_finance'],
            'opex_taxes'=>$recs['opex_taxes']
        );
    }else{
        $data_annualised_cost = array(
            'no_data_flag'=>1,
            'datapoint_id'=>0,
            'capex_land'=>0,
            'capex_infrastructure'=>0,
            'capex_equipment'=>0,
            'capex_extraordinary'=>0,
            'capex_staff_develop'=>0,
            'capex_other'=>0,
            'capex_administration'=>0,
            'capex_finance'=>0,
            'capex_taxes'=>0,
            'opex_land'=>0,
            'opex_infrastructure'=>0,
            'opex_equipment'=>0,
            'opex_staff'=>0,
            'opex_staff_develop'=>0,
            'opex_consumables_utilities'=>0,
            'opex_consumables_fuel'=>0,
            'opex_consumables_chemicals'=>0,
            'opex_consumables_other'=>0,
            'opex_consumables_service_consultant'=>0,
            'opex_consumables_service_legal'=>0,
            'opex_consumables_service_insurance'=>0,
            'opex_consumables_service_maint'=>0,
            'opex_consumables_service_other'=>0,
            'opex_other'=>0,
            'opex_administration'=>0,
            'opex_finance'=>0,
            'opex_taxes'=>0
        );
    }

    // Get the Cost Type data
    $cost_type_table = GetCACTUSCostTypeDataTableName();
    $query = "SELECT * FROM $cost_type_table WHERE datapoint_id='$datapoint_id'";
    $results = perform_select_query($db, $query);
    $data_cost_type_cost = array();
    if($results->rowCount() == 1){
        $data_cost_type_cost = array(
            'no_data_flag'=>0,
            'datapoint_id'=>$recs['datapoint_id'],
            'capex_direct_variable'=>$recs['capex_direct_variable'],
            'capex_direct_fixed'=>$recs['capex_direct_fixed'],
            'capex_indirect_variable'=>$recs['capex_indirect_variable'],
            'capex_indirect_fixed'=>$recs['capex_indirect_fixed'],
            'capex_infrastructure'=>$recs['capex_infrastructure'],
            'opex_direct_variable'=>$recs['opex_direct_variable'],
            'opex_direct_fixed'=>$recs['opex_direct_fixed'],
            'opex_indirect_variable'=>$recs['opex_indirect_variable'],
            'opex_indirect_fixed'=>$recs['opex_indirect_fixed'],
            'total_direct_variable'=>$recs['total_direct_variable'],
            'total_direct_fixed'=>$recs['total_direct_fixed'],
            'total_indirect_variable'=>$recs['total_indirect_variable'],
            'total_indirect_fixed'=>$recs['total_indirect_fixed'],
            'total'=>$recs['total']
        );
    }else{
        $data_cost_type_cost = array(
            'no_data_flag'=>1,
            'datapoint_id'=>0,
            'capex_direct_variable'=>0,
            'capex_direct_fixed'=>0,
            'capex_indirect_variable'=>0,
            'capex_indirect_fixed'=>0,
            'capex_infrastructure'=>0,
            'opex_direct_variable'=>0,
            'opex_direct_fixed'=>0,
            'opex_indirect_variable'=>0,
            'opex_indirect_fixed'=>0,
            'total_direct_variable'=>0,
            'total_direct_fixed'=>0,
            'total_indirect_variable'=>0,
            'total_indirect_fixed'=>0,
            'total'=>0
        );
    }

    $data_results = array(
        'total_cost'=> $data_total_cost,
        'annualised_cost'=> $data_annualised_cost,
        'cost_type_cost'=>$data_cost_type_cost
    );

    $study_data[] = array(
        'resources'=>$data_rows_resources,
        'services'=>$data_rows_services,
        'master'=>$data_row_general,
        'results'=>$data_results
    );


}

$all_data = array(
    'message'=>$message,
    'studies'=>$studies,
    'study_data'=>$study_data
);

echo json_encode($all_data);
exit;