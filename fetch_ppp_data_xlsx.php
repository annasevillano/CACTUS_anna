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

    $xls_file_name = $_FILES['ppp_data_xlsx_file']['name'];
    $xls_file_size = $_FILES['ppp_data_xlsx_file']['size'];
    $xls_file_tmp = $_FILES['ppp_data_xlsx_file']['tmp_name'];
    $xls_file_type = $_FILES['ppp_data_xlsx_file']['type'];
    $xls_file_error = $_FILES['ppp_data_xlsx_file']['error'];

    $file_info = "File name $xls_file_name<BR>";
    $file_info .= "File size $xls_file_size<BR>";
    $file_info .= "File name on server (tmp) $xls_file_tmp<BR>";
    $file_info .= "File type $xls_file_type<BR>";
    $file_info .= "File read earror message $xls_file_error<BR>";
    $PHP_EXCEL_filetype = PHPExcel_IOFactory::identify($xls_file_tmp);
    $file_info .= "PHPExcel file type: $PHP_EXCEL_filetype<BR>";

    $years = array();
    $countries = array();
    $country_codes = array();

    $ppp_table = GetCACTUSPPPTableName();
    // Emptry the table and fill with new data
    clear_table($db, $ppp_table);

    if (!$_FILES['ppp_data_xlsx_file']['error']) {
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
                $date_updated = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($myString));

                //Get the data
                $row = 4; // heading row

                $data_start_col = 5 - 1;

                for( $j = $data_start_col ; $j < $highestColIndex ; $j++){
                    $col = $j;
                    $myString = $worksheet->getCellByColumnAndRow($col, $row)->getValue();

                    if(trim($myString) != ""){
                        $year_value = intval($myString);
                        //echo("year str = $myString, year int = $year_value<BR>\n");
                        $years[] = $year_value;
                    }else{
                        break;
                    }
                }

                $num_years = sizeof($years);

                for ($i = 0; $i < $highestRow; $i++) {
                    $row++;
                    $country = $worksheet->getCellByColumnAndRow(1 - 1, $row)->getValue();
                    $country = addslashes($country);
                    $country_code = $worksheet->getCellByColumnAndRow(2 - 1, $row)->getValue();
                    if(trim($country) == "") {
                        break;
                    }

                    $countries[] = $country;
                    $country_codes[] = $country_code;

                    for($j = 0 ; $j < $num_years; $j++) {
                        $col = 5 - 1 + $j;
                        $myString = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                        if (trim($myString) != "") {
                            $ppp_value = floatval($myString);
                            $year = $years[$j];
                            // Push to db
                            $query = "INSERT INTO $ppp_table SET
                                                country='$country',
                                                country_code='$country_code',
                                                year='$year',
                                                ppp='$ppp_value'";
                            perform_query($db, $query);
                        } else {
                            $ppp_value = 0.0;
                        }
                    }
                }

                // only do one worksheet
                break;
            }

            // Put the year begin and end in the desc table
            $ppp_desc_table = GetCACTUSPPPDescsriptionTableName();
            // Emptry the table and fill with new data
            clear_table($db, $ppp_desc_table);

            $hundred_year = 2010;
            $year_begin = $years[0];
            $year_end = $years[$num_years-1];
            $query = "INSERT INTO $ppp_desc_table SET
                                                source_filename='$xls_file_name',
                                                year_begin='$year_begin',
                                                year_end='$year_end',
                                                notes='$date_updated'";
            perform_query($db, $query);

        }
    }

}

$all_xlsx_data = array(
    'years'=>$years,
    'country_codes'=>$country_codes,
    'countries'=>$countries
);

echo json_encode($all_xlsx_data);
exit;