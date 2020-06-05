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

{
    $file_info = "";
    //var_dump($_POST);

    $xls_file_name = $_FILES['base_data_xlsx_file']['name'];
    $xls_file_size = $_FILES['base_data_xlsx_file']['size'];
    $xls_file_tmp = $_FILES['base_data_xlsx_file']['tmp_name'];
    $xls_file_type = $_FILES['base_data_xlsx_file']['type'];
    $xls_file_error = $_FILES['base_data_xlsx_file']['error'];

    $file_info = "File name $xls_file_name<BR>";
    $file_info .= "File size $xls_file_size<BR>";
    $file_info .= "File name on server (tmp) $xls_file_tmp<BR>";
    $file_info .= "File type $xls_file_type<BR>";
    $file_info .= "File read earror message $xls_file_error<BR>";
    $PHP_EXCEL_filetype = PHPExcel_IOFactory::identify($xls_file_tmp);
    $file_info .= "PHPExcel file type: $PHP_EXCEL_filetype<BR>";

    $countries = array();
    $cities = array();
    $elements = array();
    $systems = array();
    $components = array();
    $case_descs = array();
    $dates = array();
    $php_dates = array();
    $data_collectors = array();
    $notes_s = array();
    $urls = array();
    $descriptions = array();
    $capex_opexs = array();
    $mins = array();
    $means = array();
    $maxs = array();
    $one_values = array();
    $ums = array();
    $currencys = array();
    $years = array();
    $us_2016s = array();
    $tach_assumptions = array();
    $lifetimes = array();
    $tachs = array();

    $base_table = GetCACTUSBaseTableName();
    // Emptry the table and fill with new data
    clear_table($db, $base_table);

    if (!$_FILES['base_data_xlsx_file']['error']) {
        if ($xls_file_name != "") {
            $objPHPExcelModules = PHPExcel_IOFactory::load($xls_file_tmp);
            $num_modules = $objPHPExcelModules->getSheetCount();

            foreach ($objPHPExcelModules->getWorksheetIterator() as $worksheet) {
                $worksheet_name = $worksheet->getTitle();
                $highestRow = $worksheet->getHighestRow();
                $highestCol = $worksheet->getHighestColumn();
                $highestColIndex = \PHPExcel_Cell::columnIndexFromString($highestCol);
                $nrColumns = ord($highestCol) - 64;

                // Get the date updated from row 2, col 2
                $row = 2;
                $col = 2 - 1; // columns are 0 based
                $myString = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                // This should say "Country"
                //$date_updated = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($myString));

                //Get the data
                $row = 2;
                for ($i = 0; $i < $highestRow; $i++) {
                    $row++;
                    // Country
                    $col = 2;
                    $country = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    $country = addslashes($country);
                    if(trim($country) == "") {
                        break;
                    }

                    // City
                    $col++;
                    $city = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
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
                    $case_desc = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // Date
                    $col++;
                    $date = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // Check the dates are in the correct format 31/12/2019
                    // If is_numeric is true then it is probably an excel date e.g 44444
                    if(is_numeric($date)){
                        $date = \PHPExcel_Style_NumberFormat::toFormattedString($date, 'DD/MM/YYYY');
                    }
                    if($date != ""){
                        $php_date = DateTime::createFromFormat('d/m/Y', $date);
                        $php_date_str =  date_format($php_date, 'Y-m-d' );
                    }else{
                        $php_date = NULL;
                        $php_data_str = '';
                    }


                    // Data collector
                    $col++;
                    $data_collector = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // Notes
                    $col++;
                    $notes = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // url
                    $col++;
                    $url = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // Descriptions
                    $col++;
                    $description = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // CAPEX/OPEX/fee
                    $col++;
                    $capex_opex = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // Min
                    $col++;
                    $min = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // Average
                    $col++;
                    $mean = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // Max
                    $col++;
                    $max = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // One value
                    $col++;
                    $one_value = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // UM
                    $col++;
                    $um = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // Currency
                    $col++;
                    $currency = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // Year
                    $col++;
                    $year = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // US$ 2016
                    $col++;
                    $us_2016 = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // TACH assumption
                    $col++;
                    $tach_assumption = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // Lifetime
                    $col++;
                    $lifetime = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();
                    // TACH (US$ 2016)
                    $col++;
                    $tach = $worksheet->getCellByColumnAndRow($col - 1, $row)->getValue();

                    $countries[] = $country;
                    $cities[] = $city;
                    $elements[] = $element;
                    $systems[] = $system;
                    $components[] = $component;
                    $case_descs[] = $case_desc;
                    $dates[] = $date;
                    $php_dates[] = $php_date;
                    $data_collectors[] = $data_collector;
                    $notes_s[] = $notes;
                    $urls[] = $url;
                    $descriptions[] = $description;
                    $capex_opexs[] = $capex_opex;
                    $mins[] = $min;
                    $means[] = $mean;
                    $maxs[] = $max;
                    $one_values[] = $one_value;
                    $ums[] = $um;
                    $currencys[] = $currency;
                    $years[] = $year;
                    $us_2016s[] = $us_2016;
                    $tach_assumptions[] = $tach_assumption;
                    $lifetimes[] = $lifetime;
                    $tachs[] = $tach;

                    if (trim($country) != "") {
                        // Push to db
                        $query = "INSERT INTO $base_table SET
                                            country='$country',
                                            city='$city',
                                            element='$element', 
                                            system='$system', 
                                            component='$component', 
                                            case_desc='$case_desc', 
                                            date='$date', 
                                            php_date='$php_date_str', 
                                            data_collector='$data_collector', 
                                            notes='$notes', 
                                            url='$url', 
                                            description='$description', 
                                            capex_opex='$capex_opex', 
                                            min='$min', 
                                            mean='$mean', 
                                            max='$max', 
                                            one_value='$one_value', 
                                            um='$um', 
                                            currency='$currency', 
                                            year='$year', 
                                            us_2016='$us_2016', 
                                            tach_assumption='$tach_assumption', 
                                            lifetime='$lifetime', 
                                            tach='$tach'
                                            ";
                        //echo($query);
                        perform_query($db, $query);
                    } else {
                        $base_value = 0.0;
                    }

                }

                // only do one worksheet
                break;
            }

        }

    }

}

$all_xlsx_data = array(
    'cities'=>$cities,
    'countries'=>$countries,
    'elements'=>$elements,
    'systems'=>$systems,
    'components'=>$components,
    'case_descs'=>$case_descs,
    'dates'=>$dates,
    'php_dates'=>$php_dates,
    'data_collectors'=>$data_collectors,
    'notes_s'=>$notes_s,
    'urls'=>$urls,
    'descriptions'=>$descriptions,
    'capex_opexs'=>$capex_opexs,
    'mins'=>$mins,
    'means'=>$means,
    'maxs'=>$maxs,
    'one_values'=>$one_values,
    'ums'=>$ums,
    'currencys'=>$currencys,
    'years'=>$years,
    'us_2016s'=>$us_2016s,
    'tach_assumptions'=>$tach_assumptions,
    'lifetimes'=>$lifetimes,
    'tachs'=>$tachs
);

echo json_encode($all_xlsx_data);
exit;