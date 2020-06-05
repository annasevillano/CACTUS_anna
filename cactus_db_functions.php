<?php
/**
 * Created by PhpStorm.
 * User: test
 * Date: 07/06/2019
 * Time: 10:51
 */
(@include_once("./pdo_functions.php")) OR die("Cannot find this file to include: pdo_functions.php<BR>");
(@include_once("./table_functions.php")) OR die("Cannot find this file to include: table_functions.php<BR>");

// Some utility functions in cactus

function get_cactus_base_data($rows){
    // $rows = $results->fetchAll()

    // Returns an array of all the castus base table data
    $all_data = array();

    foreach ($rows as $recs) {
        $id = $recs['id'];
        $country = $recs['country'];
        $country_code = $recs['country_code'];
        $city = $recs['city'];
        $element = $recs['element'];
        $system = $recs['system'];
        $component = $recs['component'];
        $case_desc = $recs['case_desc'];
        $date = $recs['date'];
        $php_date = $recs['php_date'];
        $data_collector = $recs['data_collector'];
        $notes = $recs['notes'];
        $url = $recs['url'];
        $description = $recs['description'];
        $capex_opex = $recs['capex_opex'];
        $min = $recs['min'];
        $mean = $recs['mean'];
        $max = $recs['max'];
        $one_value = $recs['one_value'];
        $um = $recs['um'];
        $currency = $recs['currency'];
        $year = $recs['year'];
        $us_2016 = $recs['us_2016'];
        $tach_assumption = $recs['tach_assumption'];
        $lifetime = $recs['lifetime'];
        $tach = $recs['tach'];
        $tach = sprintf('%0.2f', $tach);
        
        $this_data = array('id'=>$id,
                           'country'=>$country,
                           'country_code'=>$country_code,
                           'city'=>$city,
                           'element'=>$element,
                           'system'=>$system,
                           'component'=>$component,
                           'case_desc'=>$case_desc,
                           'date'=>$date,
                           'php_date'=>$php_date,
                           'data_collector'=>$data_collector,
                           'notes'=>$notes,
                           'url'=>$url,
                           'description'=>$description,
                           'capex_opex'=>$capex_opex,
                           'min'=>$min,
                           'mean'=>$mean,
                           'max'=>$max,
                           'one_value'=>$one_value,
                           'um'=>$um,
                           'currency'=>$currency,
                           'year'=>$year,
                           'us_2016'=>$us_2016,
                           'tach_assumption'=>$tach_assumption,
                           'lifetime'=>$lifetime,
                           'tach'=>$tach
                        );
        $all_data[] = $this_data;
    }

    return $all_data;
}

function GetCountrySelectID($db, $NameKey, $MatchID)
{
    $cpi_table = GetCACTUSCPITableName();

    $country_select_block = "\n<select name='$NameKey' id='$NameKey' class='form-control'>\n";
    $country_select_block .= "<option value='-1'>--- Select Country ---</option>\n";
    $query = "SELECT DISTINCT country,country_code FROM $cpi_table ORDER BY country";
    $res = perform_select_query($db, $query);

    $rows = $res->fetchAll();

    foreach ($rows as $recs) {
        //$country_id = $recs['id'];
        $country = $recs['country'];
        $country_code = $recs['country_code'];

        if ($country_code == $MatchID) {
            $country_select_block .= "<option value='$country_code' selected='selected'>$country ($country_code)</option>\n";
        } else {
            $country_select_block .= "<option value='$country_code'>$country ($country_code)</option>\n";
        }

    }
    $country_select_block .= "</select> \n";

    return $country_select_block;
}

function GetYearSelectID($db, $NameKey, $MatchYear, $cpi_ppp){

    if($cpi_ppp == "cpi"){
        $data_table = GetCACTUSCPITableName();
        $def_table = GetCACTUSCPIDescsriptionTableName();
    }else{
        $date_table = GetCACTUSPPPTableName();
        $def_table = GetCACTUSPPPDescsriptionTableName();
    }

    $year_select_block = "\n<select name='$NameKey' id='$NameKey' class='form-control'>\n";
    $year_select_block .= "<option value='-1'>--- Select Year ---</option>\n";
    $query = "SELECT * FROM $def_table";
    $res = perform_select_query($db, $query);

    $row = $res->fetch();

    $year_begin = $row['year_begin'];
    $year_end = $row['year_end'];

    for($year = $year_begin; $year <= $year_end; $year++){
        if($MatchYear == $year){
            $year_select_block .= "<option value='$year' selected='selected'>$year </option>\n";
        }else{
            $year_select_block .= "<option value='$year'>$year</option>\n";
        }
    }

    $year_select_block .= "</select> \n";

    return $year_select_block;
}