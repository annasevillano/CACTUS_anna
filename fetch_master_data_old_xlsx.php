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

function store_raw_data_row_in_db($db, $raw_data_table, $study_block_common_data, $raw_data_row_obj){
    // Take the raw data row object and stores it
    // Push to db
    $study_id = $study_block_common_data['study_id'];
    $country =  $study_block_common_data['country'];
    $city = $study_block_common_data['city'];
    $year = $study_block_common_data['year'];
    $php_date = $study_block_common_data['php_date'];

    //$study_id = $raw_data_row_obj['study_id'];
    //$country = $raw_data_row_obj['country'];
    //$city = $raw_data_row_obj['city'];
    //$year = $raw_data_row_obj['year'];
    //$date = $raw_data_row_obj['date'];
    $study_block_index = $raw_data_row_obj['study_block_index'];
    $datapoint_id = $raw_data_row_obj['datapoint_id'];
    $element = $raw_data_row_obj['element'];
    $system = $raw_data_row_obj['system'];
    $component = $raw_data_row_obj['component'];
    $data_source = $raw_data_row_obj['data_source'];
    $case_desc = $raw_data_row_obj['case_desc'];
    $resource_service = $raw_data_row_obj['resource_service'];
    $category_1 = $raw_data_row_obj['category_1'];
    $category_2 = $raw_data_row_obj['category_2'];
    $category_3 = $raw_data_row_obj['category_3'];
    $item_desc = $raw_data_row_obj['item_desc'];
    $um = $raw_data_row_obj['um'];
    $um_desc = $raw_data_row_obj['um_desc'];
    $assumptions = $raw_data_row_obj['assumptions'];
    $min_count = $raw_data_row_obj['min_count'];
    $avg_count = $raw_data_row_obj['avg_count'];
    $max_count = $raw_data_row_obj['max_count'];
    $source_count_desc = $raw_data_row_obj['source_count_desc'];
    $one_value_count = $raw_data_row_obj['one_value_count'];
    $emptying_pc = $raw_data_row_obj['emptying_pc'];
    $transport_pc = $raw_data_row_obj['transport_pc'];
    $interim_storage_pc = $raw_data_row_obj['interim_storage_pc'];
    $source_pc_desc = $raw_data_row_obj['source_pc_desc'];
    $cost_type = $raw_data_row_obj['cost_type'];
    $lifetime = $raw_data_row_obj['lifetime'];
    $min_cost = $raw_data_row_obj['min_cost'];
    $avg_cost = $raw_data_row_obj['avg_cost'];
    $max_cost = $raw_data_row_obj['max_cost'];
    $year_cost = $raw_data_row_obj['year_cost'];
    $currency = $raw_data_row_obj['currency'];
    $source_cost_desc = $raw_data_row_obj['source_cost_desc'];
    $one_value_cost = $raw_data_row_obj['one_value_cost'];
    $cost_adjusted = $raw_data_row_obj['cost_adjusted'];
    $annualised_value = $raw_data_row_obj['annualised_value'];
    $discount_rate  = $raw_data_row_obj['discount_rate'];

    $query = "INSERT INTO $raw_data_table SET
            study_id= '$study_id',
            study_block_index= '$study_block_index',
            datapoint_id='$datapoint_id',
            country= '$country', 
            city= '$city',
            year= '$year',
            date= '$php_date',
            element='$element',
            system='$system',
            component='$component',
            data_source='$data_source',
            case_desc='$case_desc',
            resource_service='$resource_service',
            category_1='$category_1',
            category_2='$category_2',
            category_3='$category_3',
            item_desc='$item_desc',
            um='$um',
            um_desc='$um_desc',
            assumptions='$assumptions',
            min_count='$min_count',
            avg_count='$avg_count',
            max_count='$max_count',
            source_count_desc='$source_count_desc',
            one_value_count='$one_value_count',
            emptying_pc='$emptying_pc',
            transport_pc='$transport_pc',
            interim_storage_pc='$interim_storage_pc',
            source_pc_desc='$source_pc_desc',
            cost_type='$cost_type',
            lifetime='$lifetime',
            min_cost='$min_cost',
            avg_cost='$avg_cost',
            max_cost='$max_cost',
            year_cost='$year_cost',
            currency='$currency',
            source_cost_desc='$source_cost_desc',
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

    $raw_data_table = GetCACTUSRawDataOldTableName();

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
            // Element
            $col++;
            $element = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // System
            $col++;
            $system = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
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
                if($resource_service == "Resources & Costs"){
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

            // blank col
            $col++;
            // There as sometimes some characters in thic col, but I'm not sure what they are for

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
            // minimum count
            $col++;
            $min_count = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // average count
            $col++;
            $avg_count = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // max count
            $col++;
            $max_count = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // source_count_desc
            $col++;
            $source_count_desc = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // one_value_count
            $col++;
            $one_value_count = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // emptying_pc
            $col++;
            $emptying_pc = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // transport_pc
            $col++;
            $transport_pc = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // interim_storage_pc
            $col++;
            $interim_storage_pc = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // source_pc_desc
            $col++;
            $source_pc_desc = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // cost_type
            $col++;
            $cost_type = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // lifetime
            $col++;
            $lifetime = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // min_cost
            $col++;
            $min_cost = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // avg_cost
            $col++;
            $avg_cost = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // max_cost
            $col++;
            $max_cost = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // year_cost
            $col++;
            $year_cost = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // currency
            $col++;
            $currency = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // source_cost_desc
            $col++;
            $source_cost_desc = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // one_value_cost
            $col++;
            $one_value_cost = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // cost_adjusted
            $col++;
            $cost_adjusted = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // annualised_value
            $col++;
            $annualised_value = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
            // discount_rate
            $col++;
            $discount_rate = $study_worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();

            // Store the row in an object
            $raw_data_row_obj = array(
                'study_block_index'=>$study_block_index,
                'datapoint_id'=>$datapoint_id,
                'element'=>$element,
                'system'=>$system,
                'component'=>$component,
                'case_desc'=>$case_desc,
                'data_source'=>$data_source,
                'resource_service'=>$resource_service,
                'category_1'=>$category_1,
                'category_2'=>$category_2,
                'category_3'=>$category_3,
                'item_desc'=>$item_desc,
                'um'=>$um,
                'um_desc'=>$um_desc,
                'assumptions'=>$assumptions,
                'min_count'=>$min_count,
                'avg_count'=>$avg_count,
                'max_count'=>$max_count,
                'source_count_desc'=>$source_count_desc,
                'one_value_count'=>$one_value_count,
                'emptying_pc'=>$emptying_pc,
                'transport_pc'=>$transport_pc,
                'interim_storage_pc'=>$interim_storage_pc,
                'source_pc_desc'=>$source_pc_desc,
                'cost_type'=>$cost_type,
                'lifetime'=>$lifetime,
                'min_cost'=>$min_cost,
                'avg_cost'=>$avg_cost,
                'max_cost'=>$max_cost,
                'year_cost'=>$year_cost,
                'currency'=>$currency,
                'source_cost_desc'=>$source_cost_desc,
                'one_value_cost'=>$one_value_cost,
                'cost_adjusted'=>$cost_adjusted,
                'annualised_value'=>$annualised_value,
                'discount_rate'=>$discount_rate
            );

            store_raw_data_row_in_db($db, $raw_data_table, $study_block_common_data, $raw_data_row_obj);

            // store the object on an array
            if($resource_service == "Resources & Costs"){
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
}// End of function for reading raaw study data

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
    $elements = array();
    $systems = array();
    $components = array();
    $num_components = array();
    //$priorities = array();
    $case_descs = array();
    $report_names = array();
    $data_collectors = array();
    $years = array();
    $dates = array();
    $php_dates = array();
    $populations = array();
    $pop_densities = array();
    $regions = array();
    $topgraphies = array();
    $num_hhs = array();
    $num_peoples = array();
    $tachs = array();
    $taccs = array();
    $notes_s = array();
    $raw_sheets_names = array();

    $master_table = GetCACTUSMasterDataOldTableName();
    // Empty the table and fill with new data
    clear_table($db, $master_table);

    $raw_data_table = GetCACTUSRawDataOldTableName();
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
                $row = 5;
                $study_id = 0;
                $datapoint_id = 0;
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
                    $country = $country_code;
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
                    // element
                    $col++;
                    $element = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // system
                    $col++;
                    $system = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // Component
                    $col++;
                    $component = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // priority
                    //$col++;
                    //$priority = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // store this in the study array
                    //$study_priorities[] = $priority;
                    // Data source
                    $col++;
                    $case_desc = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // report name
                    $col++;
                    $report_name = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // Data collector
                    $col++;
                    $data_collector = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // Date
                    $col++;
                    $date = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // Check the dates are in the correct format 31/12/2019
                    // If is_numeric is true then it is probably an excel date e.g 44444
                    if (is_numeric($date)) {
                        $date = \PHPExcel_Style_NumberFormat::toFormattedString($date, 'DD/MM/YYYY');
                    }
                    if ($date != "") {
                        $php_date = DateTime::createFromFormat('d/m/Y', $date);
                        $php_date_str = date_format($php_date, 'Y-m-d');
                    } else {
                        $php_date = NULL;
                        $php_date_str = '';
                    }
                    // extract the year
                    $year = 2019;
                    // Population
                    $col++;
                    $population = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // Region
                    $col++;
                    $region = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // Population density
                    $col++;
                    $pop_density = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // topography
                    $col++;
                    $topography = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();

                    // Sheet name of data
                    $col += 39;
                    $raw_sheet_name = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // Store this in array for the study
                    $study_sheets[] = $raw_sheet_name;
                    // num hh
                    $col++;
                    $num_hh = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // num people
                    $col++;
                    $num_people = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // tach
                    $col++;
                    $tach = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // tacc
                    $col++;
                    $tacc = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // notes file
                    $col++;
                    $notes_file = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();

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
                            'city'=>$city,
                            'year'=>$year,
                            'php_date'=>$php_date,
                        );
                        $study_raw_data_obj = get_raw_data_from_excel($db, $objPHPExcelModules, $study_sheets, $names_index, $study_common_data, $datapoint_id);

                        $ids[] = $index;
                        $study_ids[] = $study_id;
                        $countries[] = $country_code;
                        $country_codes[] = $country_code;
                        $cities[] = $city;
                        $lats[] = $lat;
                        $lons[] = $lon;

                        $elements[] = $element;
                        $systems[] = $system;
                        $components[] = $component;
                        //$priorities[] = $study_priorities;
                        $case_descs[] = $case_desc;
                        $report_names[] = $report_name;
                        $data_collectors[] = $data_collector;
                        $years[] = $year;
                        $dates[] = $date;
                        $php_dates[] = $php_date;
                        $populations[] = $population;
                        $pop_densities[] = $pop_density;
                        $regions[] = $region;
                        $topgraphies[] = $topography;
                        $num_hhs[] = $num_hh;
                        $num_peoples[] = $num_people;
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
                            $query = "INSERT INTO $master_table SET
                                            study_id='$study_id',
                                            country='$country_code',
                                            country_code='$country_code',
                                            city='$city',
                                            lat='$lat',
                                            lon='$lon',
                                            element='$element', 
                                            system='$system', 
                                            component='$component', 
                                            num_components='$num_components_this_study', 
                                            case_desc='$case_desc', 
                                            report_name='$report_name',
                                            data_collector='$data_collector', 
                                            year='$year', 
                                            php_date='$php_date_str',
                                            date='$date',                                              
                                            population='$population', 
                                            region='$region', 
                                            pop_density='$pop_density', 
                                            topography='$topography', 
                                            num_hh='$num_hh',
                                            num_people='$num_people',                                            
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
    'case_descs'=>$case_descs,
    'report_names'=>$report_names,
    'data_collectors'=>$data_collectors,
    'years'=>$years,
    'dates'=>$dates,
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