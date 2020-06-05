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
(@include_once("./connect_pdo.php")) OR die("Cannot connect to the database<BR>");

(@include_once("./frameworks/php_classes/PHPExcel.php")) OR die("Cannot read PHPExcel.php file<BR>");
(@include_once("./frameworks/php_classes/PHPExcel/IOFactory.php")) OR die("Cannot read IOFactory.php file<BR>");

function get_country_name($db, $country_code){
    $country_name = $country_code;
    $cpi_table_name = GetCACTUSCPITableName();

    $query = "SELECT * FROM $cpi_table_name WHERE country_code='$country_code' LIMIT 1";
    $results = perform_select_query($db, $query);

    if($results->rowCount() == 1){
        $rec = $results->fetch();
        $country_name = $rec['country'];
    }

    return $country_name;
}

function store_raw_data_row_in_db($db, $raw_data_table, $study_block_common_data, $raw_data_row_obj){
    // Take the raw data row object and stores it
    // Push to db
    $study_id = $study_block_common_data['study_id'];
    $country =  $study_block_common_data['country'];
    $city = $study_block_common_data['city'];
    $year = $study_block_common_data['year'];
    $php_date = $study_block_common_data['php_date'];

    //$study_id = $raw_data_row_obj['study_id'];
    $country = $raw_data_row_obj['country'];
    $city = $raw_data_row_obj['city'];
    $year = $raw_data_row_obj['year'];
    $date_str = $raw_data_row_obj['date'];
    $php_date = $raw_data_row_obj['php_date'];

    $study_block_index = $raw_data_row_obj['study_block_index'];
    $datapoint_id = $raw_data_row_obj['datapoint_id'];

    $country = $raw_data_row_obj['country'];
    $country_code = $raw_data_row_obj['country_code'];
    $city = $raw_data_row_obj['city'];
    $year = $raw_data_row_obj['year'];
    $date_str = $raw_data_row_obj['date'];
    $php_date = $raw_data_row_obj['php_date'];

    $system = $raw_data_row_obj['system'];
    $element = $raw_data_row_obj['element'];
    $component = $raw_data_row_obj['component'];
    $case_desc = $raw_data_row_obj['case_desc'];
    $data_source = $raw_data_row_obj['data_source'];
    $resource_service = $raw_data_row_obj['resource_service'];
    $cost_type_1 = $raw_data_row_obj['cost_type_1'];
    $cost_type_2 = $raw_data_row_obj['cost_type_2'];
    $category_1 = $raw_data_row_obj['category_1'];
    $category_2 = $raw_data_row_obj['category_2'];
    $category_3 = $raw_data_row_obj['category_3'];
    $item_desc = $raw_data_row_obj['item_desc'];
    $um = $raw_data_row_obj['um'];
    $um_desc = $raw_data_row_obj['um_desc'];
    $assumptions = $raw_data_row_obj['assumptions'];

    $service_category = $raw_data_row_obj['service_category'];
    $lifetime = $raw_data_row_obj['lifetime'];
    $year_cost = $raw_data_row_obj['year_cost'];
    $currency = $raw_data_row_obj['currency'];
    $source  = $raw_data_row_obj['source'];
    $one_value_cost = $raw_data_row_obj['one_value_cost'];
    $cost_adjusted = $raw_data_row_obj['cost_adjusted'];
    $annualised_value = $raw_data_row_obj['annualised_value'];
    $discount_rate  = $raw_data_row_obj['discount_rate'];

    //$date_for_db = date('Y-m-d', strtotime(str_replace('-', '/', $php_date)));
    $date_for_db = $date_str;//date( 'Y-m-d', $php_date );
    $query = "INSERT INTO $raw_data_table SET
            study_id= '$study_id',
            study_block_index= '$study_block_index',
            datapoint_id='$datapoint_id',
            country= '$country', 
            country_code= '$country_code', 
            city= '$city',
            date= '$date_str',
            php_date= '$date_for_db',
            system='$system',
            element='$element',
            component='$component',
            case_desc='$case_desc',
            data_source='$data_source',
            resource_service='$resource_service',
            cost_type_1='$cost_type_1',
            cost_type_2='$cost_type_2',
            category_1='$category_1',
            category_2='$category_2',
            category_3='$category_3',
            item_desc='$item_desc',
            um='$um',
            um_desc='$um_desc',
            assumptions='$assumptions',
            service_category='$service_category',
            lifetime='$lifetime',
            year_cost='$year_cost',
            currency='$currency',
            source='$source',
            one_value_cost='$one_value_cost',
            cost_adjusted='$cost_adjusted',
            annualised_value='$annualised_value',
            discount_rate='$discount_rate'
           ";
    //echo($query);
    perform_query($db, $query);

}

function get_raw_data_from_excel($db, $objPHPExcelModules, $study_sheets, $names_index, $study_common_data, &$datapoint_id ){
    $raw_sheet_name = null;
    // Get a non-null sheet name
    foreach( $study_sheets as $sheet_name){
        if(!is_null($sheet_name)){
            $raw_sheet_name = $sheet_name;
            break;
        }
    }

    $raw_data_table = GetCACTUSRawDataTableName();

    $num_study_cats = sizeof($study_sheets);
    // an arbritary high number
    $highestRow = 1000;
    $study_block_index = 0;
    if(is_null($raw_sheet_name)){
        // Set the return values to null
        $raw_data_obj = null;
    }else{
        // this is the expected response
        //var_dump($names_index);
        $index = $names_index[$raw_sheet_name];
        //echo("Raw sheet name: $raw_sheet_name index: <br/>\n");
        $study_worksheet = $objPHPExcelModules->getSheet($index);
        //var_dump($study_worksheet);
        // Get the data off the raw_study_sheet

        $row = 5;
        $last_row_flag = false;
        $last_block_row_flag = false;
        $end_of_resource_block = false;
        $end_of_servive_block = false;
        $data_rows_resources = array();
        $data_rows_services = array();
        for ($i = 0; $i < $highestRow ; $i++) {
            $row++;
            $col = 1;
            // System
            $col++;
            $system = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // Element
            $col++;
            $element = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // Component
            $col++;
            $component = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // Items common to a single study
            $study_block_common_data = array(
                'study_id'=>$study_common_data['study_id'],
                'country'=>$study_common_data['country'],
                'city'=>$study_common_data['city'],
                'year'=>$study_common_data['year'],
                'php_date'=>$study_common_data['php_date'],
                'element'=>$element,
                'system'=>$system,
                'component'=>$component
            );
            // Case description
            $col++;
            $case_desc = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // Data source
            $col++;
            $data_source = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // Resource or Service
            $col++;
            $resource_service = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();

            // Check the next row value and set some flags
            $next_resource_service = $study_worksheet->getCellByColumnAndRow($col - 1, $row+1)->getValue();
            if($resource_service != $next_resource_service){
                $last_block_row_flag = true;
                if($resource_service == "Resources and Costs"){
                    $end_of_resource_block = true;
                    $end_of_service_block = false;
                }else{
                    $end_of_resource_block = false;
                    $end_of_service_block = true;

                }

                if($next_resource_service == null){
                    $last_row_flag = true;
                }else{
                    $last_row_flag = false;
                }
            }else{
                $last_block_row_flag = false;
                $end_of_resource_block = false;
                $end_of_service_block = false;
                $last_row_flag = false;
            }

            // Cost type 1
            $col++;
            $cost_type_1 = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // Cost type 2
            $col++;
            $cost_type_2 = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // Cat1 description
            $col++;
            $category_1 = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // Cat2 description
            $col++;
            $category_2 = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // Cat3 description
            $col++;
            $category_3 = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // items and description
            $col++;
            $item_desc = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            $item_desc = addslashes($item_desc);
            // unit of measurement
            $col++;
            $um = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            $um = addslashes($um);
            // notes on unit of measurement
            $col++;
            $um_desc = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            $um_desc = addslashes($um_desc);
            // assumptions
            $col++;
            $assumptions = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            $assumptions = addslashes($assumptions);

            if($resource_service == "Resources and Costs"){
                // Service Category
                $col++;
                $service_category = "";
                // Source
                $col++;
                // $source get later
                // One value cost
                $col++;
                // $one_value_cost get later
                //------------------------------------------------------------------
                // Lifetime
                $col++;
                $lifetime = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                // Year of cost
                $col++;
                $year_cost = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                // Currency
                $col++;
                $currency = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                // Source
                $col++;
                $source = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                // one value cost
                $col++;
                $one_value_cost = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                // Cost adjusted
                $col++;
                $cost_adjusted = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                // annualised value
                $col++;
                $annualised_value = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                // Discount rate
                $col++;
                $discount_rate = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            }else{
                // Service Category
                $col++;
                $service_category = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                // Source
                $col++;
                $source = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                // one value cost
                $col++;
                $one_value_cost = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                // lifetime
                $col++;
                $lifetime = 0;
                // year of cost
                $col++;
                $year_cost = 0;
                // Currency
                $col++;
                $currency = "";
                // Source
                $col++;
                // $source already set for service
                // one value cosr
                $col++;
                // $one_cvalue_cost already set for service
                // $cost_adjusted
                $col++;
                $cost_adjusted = 0 ; // not required for service
                // $annualised_value
                $col++;
                $annualised_value = 0 ; // not required for service
                // $discount_rate
                $col++;
                $discount_rate = 0 ; // not required for service
            }

            $country = $study_common_data['country'];
            $country_code = $study_common_data['country_code'];
            $city = $study_common_data['city'];
            $year = $study_common_data['year'];
            $php_date = $study_common_data['php_date'];
            $php_date_str = $study_common_data['php_date_str'];

            // Store the row in an object
            $raw_data_row_obj = array(
                'study_block_index'=>$study_block_index,
                'datapoint_id'=>$datapoint_id,

                'country'=>$country,
                'country_code'=>$country_code,
                'city'=>$city,
                'year'=>$year,
                'date'=>$php_date_str,
                'php_date'=>$php_date,

                'system'=>$system,
                'element'=>$element,
                'component'=>$component,
                'case_desc'=>$case_desc,
                'data_source'=>$data_source,
                'resource_service'=>$resource_service,
                'cost_type_1'=>$cost_type_1,
                'cost_type_2'=>$cost_type_2,
                'category_1'=>$category_1,
                'category_2'=>$category_2,
                'category_3'=>$category_3,
                'item_desc'=>$item_desc,
                'um'=>$um,
                'um_desc'=>$um_desc,
                'assumptions'=>$assumptions,
                'service_category'=>$service_category,
                'lifetime'=>$lifetime,
                'year_cost'=>$year_cost,
                'currency'=>$currency,
                'source'=>$source,
                'one_value_cost'=>$one_value_cost,
                'cost_adjusted'=>$cost_adjusted,
                'annualised_value'=>$annualised_value,
                'discount_rate'=>$discount_rate
            );

            store_raw_data_row_in_db($db, $raw_data_table, $study_block_common_data, $raw_data_row_obj);

            // store the object on an array
            if($resource_service == "Resources and Costs"){
                $data_rows_resources[] = $raw_data_row_obj;
            }else{
                $data_rows_services[] = $raw_data_row_obj;
            }

            // At end of service store both resource and service data in an object in an object
            if($end_of_service_block){
                $study_cat_data = array(
                    'study_sheet_name'=>$raw_sheet_name,
                    'resources'=>$data_rows_resources,
                    'services'=>$data_rows_services
                );
                $study_data[] = $study_cat_data;

                // reset the arrays storing the rows.
                $data_rows_resources = array();
                $data_rows_services = array();
                $study_block_index++;
                $datapoint_id++;
            }

            // At end of all data break
            if($last_row_flag){
                break;
            }
        }

        $raw_data_obj = $study_data;
    };

    //echo("<pre>");
    //print_r($raw_data_obj);
    //echo("</pre>");

    return $raw_data_obj;
}// End of function for reading raw study data

{
    $file_info = "";
    //var_dump($_POST);

    $xls_file_name = $_FILES['master_data_xlsx_file']['name'];
    $xls_file_size = $_FILES['master_data_xlsx_file']['size'];
    $xls_file_tmp = $_FILES['master_data_xlsx_file']['tmp_name'];
    $xls_file_type = $_FILES['master_data_xlsx_file']['type'];
    $xls_file_error = $_FILES['master_data_xlsx_file']['error'];

    $file_info = "File name $xls_file_name<BR>";
    $file_info .= "File size $xls_file_size<BR>";
    $file_info .= "File name on server (tmp) $xls_file_tmp<BR>";
    $file_info .= "File type $xls_file_type<BR>";
    $file_info .= "File read earror message $xls_file_error<BR>";
    $PHP_EXCEL_filetype = PHPExcel_IOFactory::identify($xls_file_tmp);
    $file_info .= "PHPExcel file type: $PHP_EXCEL_filetype<BR>";

    $study_ids = array();
    $countries = array();
    $country_codes = array();
    $cities = array();
    $lats = array();
    $lons = array();
    $systems = array();
    $elements = array();
    $components = array();
    $num_components = array();
    $data_sources = array();
    $sources = array();
    $datapoint_names = array();
    $case_descs = array();
    $report_names = array();
    $data_collectors = array();
    $years = array();
    $date_strs = array();
    $php_dates = array();
    $populations = array();
    $pop_densities = array();
    $pop_data_years = array();
    $regions = array();
    $topgraphies = array();
    $num_hhs = array();
    $num_peoples = array();
    $num_people_per_hhs = array();
    $tachs = array();
    $taccs = array();
    $notes_s = array();
    $raw_sheets_names = array();

    $master_study_city_table = GetCACTUSMasterStudyCityDataTableName();
    // Empty the table and fill with new data
    clear_table($db, $master_study_city_table);

    $master_table = GetCACTUSMasterDataTableName();
    // Empty the table and fill with new data
    clear_table($db, $master_table);

    $raw_data_table = GetCACTUSRawDataTableName();
    // Empty the table and then we can fill with new data
    clear_table($db, $raw_data_table);

    if (!$_FILES['master_data_xlsx_file']['error']) {
        if ($xls_file_name != "") {
            $objPHPExcelModules = PHPExcel_IOFactory::load($xls_file_tmp);
            $num_sheets = $objPHPExcelModules->getSheetCount();
            foreach ($objPHPExcelModules->getWorksheetIterator() as $worksheet) {
                $worksheet_name = $worksheet->getTitle();
                $worksheet_index = $objPHPExcelModules->getIndex($worksheet);
                $names_index[$worksheet_name] = $worksheet_index;
            }
            //var_dump($names_index);
            foreach ($objPHPExcelModules->getWorksheetIterator() as $worksheet) {
                $worksheet_name = $worksheet->getTitle();
                $highestRow = $worksheet->getHighestRow();
                $highestCol = $worksheet->getHighestColumn();
                $highestColIndex = \PHPExcel_Cell::columnIndexFromString($highestCol);
                $nrColumns = ord($highestCol) - 64;

                // Get the date updated from row 1, col 2
                $row = 1;
                $col = 2 - 1; // columns are 0 based
                $myString = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                //$date_updated = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($myString));

                //Get the data
                $row = 6;
                $study_id = 0;
                $datapoint_id = 0;
                $this_id = 0;
                $first_study_row = $row;
                //$study_priorities = array(); // need this as only priority 2 are in the raw sheets
                $study_sheets = array();
                for ($i = 0; $i < $highestRow; $i++) {
                    $row++;
                    $last_row_flag = false;

                    // Index
                    $col = 1;
                    $index = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();

                    // Country
                    $col++;
                    $country_code = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    $country_code = addslashes($country_code);
                    if (trim($country_code) == "") {
                        break;
                    }
                    // Should lookup country name here
                    $country = get_country_name($db,$country_code);
                    // City
                    $col++;
                    $city = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // --- read a row ahead to see if the current row is the last for this study
                    $next_city = $worksheet->getCellByColumnAndRow($col - 1, $row + 1)->getValue();
                    if ($next_city != $city) {
                        // this is the last row of this city study
                        $study_id++;
                        $num_components_this_study = $row - $first_study_row;
                        $num_components[] = $num_components_this_study;
                        $first_study_row = $row;

                        $last_row_flag = true;
                    }

                    // Latitude
                    $lat = 0.0;
                    // Longitude
                    $lon = 0.0;
                    // system
                    $col++;
                    $system = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // element
                    $col++;
                    $element = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // Component
                    $col++;
                    $component = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // Data source
                    $col++;
                    $data_source = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // Source
                    $col++;
                    $source = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // Datapoint name
                    $col++;
                    $datapoint_name = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // Case description
                    $col++;
                    $case_desc = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // report name
                    //$col++;
                    //$report_name = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    $report_name = "";
                    // Data collector
                    $col++;
                    $data_collector = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // Date
                    $col++;
                    $date = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    //echo("Date $date\n");
                    // Check the dates are in the correct format 31/12/2019
                    // If is_numeric is true then it is probably an excel date e.g 44444
                    if (is_numeric($date)) {
                        $date = \PHPExcel_Style_NumberFormat::toFormattedString($date, 'DD/MM/YYYY');
                    }
                    //echo("Date str $date\n");
                    if ($date != "") {
                        $php_date = DateTime::createFromFormat('d/m/Y', $date);
                        $php_date_str = date_format($php_date, 'Y-m-d');
                    } else {
                        $php_date = NULL;
                        $php_date_str = '';
                    }
                    // extract the year
                    if(is_null($php_date)){
                        $year = 2019;
                    }else{
                        $year = $php_date->format("Y");
                    }
                    // Population
                    $col++;
                    $population = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // year of Population data
                    $col++;
                    $pop_data_year = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // Population density
                    $col++;
                    $pop_density = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // Region
                    $col++;
                    $region = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // topography
                    $col++;
                    $topography = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // Sheet name of data
                    $col++;
                    $raw_sheet_name = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // Store this in array for the study
                    $study_sheets[] = $raw_sheet_name;
                    // These are identified on teh master sheet but not entered
                    // They will come from the raw data
                    // num hh
                    $col +=53;
                    $num_hh = 0;//$worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // num people
                    $col++;
                    $num_people = 0;//$worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // num people per hh
                    $col++;
                    $num_people_per_hh = 0;//$worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // tach
                    $col++;
                    $tach = 0;//$worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // tacc
                    $col++;
                    $tacc = 0;//$worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // notes file
                    $col++;
                    $notes_file = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();

                    // store in the master table
                    if (trim($country) != "") {
                        // Push to db
                        $query = "INSERT INTO $master_table SET
                                            study_id='$study_id',
                                            datapoint_id='$this_id',
                                            country='$country',
                                            country_code='$country_code',
                                            city='$city',
                                            lat='$lat',
                                            lon='$lon',
                                            
                                            system='$system', 
                                            element='$element', 
                                            component='$component', 
                                            num_components='0', 
                                            data_source='$data_source', 
                                            source='$source', 
                                            datapoint_name='$datapoint_name', 
                                            case_desc='$case_desc', 
                                            report_name='$report_name',
                                            data_collector='$data_collector', 
                                            date='$php_date_str',                                              
                                            php_date='$php_date_str',
                                            city_population='$population', 
                                            city_population_density='$pop_density', 
                                            year_of_population='$pop_data_year', 

                                            region='$region', 
                                            topography='$topography', 
                                            num_hh_served='$num_hh',
                                            num_people_served='$num_people',                                            
                                            num_people_per_hh='$num_people_per_hh',
                                                                                        
                                            tach='$tach',
                                            tacc='$tacc',
                                            notes_file='$notes_file'
                                            ";
                        //echo($query);
                        perform_query($db, $query);
                    } else {
                        $base_value = 0.0;
                    }
                    $this_id++;

                    // Should we do processing of raw study data
                    // Only do this if got all of the components
                    if ($last_row_flag) {
                        // So only saving and storing the last row of study data from the master  excel sheet

                        // Get the data from the raw study sheet
                        // write a function to get the raw_sheet name from the $study_sheets array to avoid having no name
                        $study_worksheet = $objPHPExcelModules->getSheetByName($raw_sheet_name);
                        // Write a function to get the data
                        // will need to send the priorities array (which can be used to calc the num_components)
                        // actually it is not the priorities array  that indicates data, but if there is a sheet name
                        $study_common_data= array(
                            'study_id'=>$study_id,
                            'country'=>$country,
                            'country_code'=>$country_code,
                            'city'=>$city,
                            'year'=>$year,
                            'php_date'=>$php_date,
                            'php_date_str'=>$php_date_str
                        );
                        $study_raw_data_obj = get_raw_data_from_excel($db, $objPHPExcelModules, $study_sheets, $names_index, $study_common_data, $datapoint_id);

                        $ids[] = $index;
                        $study_ids[] = $study_id;
                        $countries[] = $country;
                        $country_codes[] = $country_code;
                        $cities[] = $city;
                        $lats[] = $lat;
                        $lons[] = $lon;

                        $systems[] = $system;
                        $elements[] = $element;
                        $components[] = $component;

                        $data_sources[] = $data_source;
                        $sources[] = $source;
                        $datapoint_names[] = $datapoint_name;
                        $case_descs[] = $case_desc;
                        $report_names[] = $report_name;
                        $data_collectors[] = $data_collector;
                        $years[] = $year;
                        $date_strs[] = $php_date_str;
                        $php_dates[] = $php_date;

                        $populations[] = $population;
                        $pop_data_years = $pop_data_year;
                        $pop_densities[] = $pop_density;
                        $regions[] = $region;
                        $topgraphies[] = $topography;

                        $num_hhs[] = $num_hh;
                        $num_peoples[] = $num_people;
                        $num_people_per_hhs = $num_people_per_hh;
                        $tachs[] = $tach;
                        $taccs[] = $tacc;
                        $notes_s[] = $notes_file;

                        $raw_sheets_names[] = $study_sheets;
                        $study_raw_data_objs[] = $study_raw_data_obj;

                        // re initialise the study_priorities list
                        //$study_priorities = array();
                        // re initialise the study_sheets list
                        $study_sheets = array();

                        if (trim($country) != "") {
                            // Push to db
                            $query = "INSERT INTO $master_study_city_table SET
                                            study_id='$study_id',
                                            datapoint_id='',
                                            country='$country',
                                            country_code='$country_code',
                                            city='$city',
                                            lat='$lat',
                                            lon='$lon',
                                            
                                            system='$system', 
                                            element='$element', 
                                            component='$component', 
                                            num_components='$num_components_this_study', 
                                            data_source='$data_source', 
                                            source='$source', 
                                            datapoint_name='$datapoint_name', 
                                            case_desc='$case_desc', 
                                            report_name='$report_name',
                                            data_collector='$data_collector', 
                                            date='$php_date_str',                                              
                                            php_date='$php_date_str',
                                            city_population='$population', 
                                            city_population_density='$pop_density', 
                                            year_of_population='$pop_data_year', 

                                            region='$region', 
                                            topography='$topography', 
                                            num_hh_served='$num_hh',
                                            num_people_served='$num_people',                                            
                                            num_people_per_hh='$num_people_per_hh',
                                                                                        
                                            tach='$tach',
                                            tacc='$tacc',
                                            notes_file='$notes_file'
                                            ";
                            //echo($query);
                            perform_query($db, $query);
                        } else {
                            $base_value = 0.0;
                        }
                    }

                }

                // only do one worksheet
                break;
            }

        }

    }

}

$all_xlsx_data = array(
    'study_ids'=>$study_ids,
    'countries'=>$countries,
    'country_codes'=>$country_codes,
    'cities'=>$cities,
    'lat'=>$lats,
    'lon'=>$lons,
    'elements'=>$elements,
    'systems'=>$systems,
    'components'=>$components,
    'num_components'=>$num_components,
    'datapoint_nmae'=>$datapoint_names,
    'case_descs'=>$case_descs,
    'report_names'=>$report_names,
    'data_collectors'=>$data_collectors,
    'years'=>$years,
    'dates'=>$date_strs,
    'php_dates'=>$php_dates,
    'populations'=>$populations,
    'pop_densities'=>$pop_densities,
    'topographies'=>$topgraphies,
    'num_hhs'=>$num_hhs,
    'num_peoples'=>$num_peoples,
    'tachs'=>$tachs,
    'taccs'=>$tachs,
    'notes_files'=>$notes_s,
    'sheet_names'=>$raw_sheets_names,
    'raw_data_obj'=>$study_raw_data_objs
);

echo json_encode($all_xlsx_data);
exit;