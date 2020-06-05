<?php
/**
 * Created by PhpStorm.
 * User: test
 * Date: 18/06/2019
 * Time: 10:33
 */
(@include_once("./pdo_functions.php")) OR die("Cannot find this file to include: pdo_functions.php<BR>");
(@include_once("./table_functions.php")) OR die("Cannot find this file to include: table_functions.php<BR>");


function lookup_CPI($db, $country_code, $year){
    $cpi = -1;
    $cpi_table = GetCACTUSCPITableName();
    $query = "SELECT * FROM $cpi_table WHERE year='$year' AND country_code='$country_code'";
    $res = perform_select_query($db, $query);

    $rows = $res->fetchAll();

    if($res->rowCount() == 1){
        foreach ($rows as $recs) {
            $cpi = $recs['cpi'];
        }
    }

    return floatval($cpi);
}

function lookup_PPP($db, $country_code, $year){
    $ppp = -1;
    $ppp_table = GetCACTUSPPPTableName();
    $query = "SELECT * FROM $ppp_table WHERE year='$year' AND country_code='$country_code' ";
    $res = perform_select_query($db, $query);

    $rows = $res->fetchAll();

    if($res->rowCount() == 1){
        foreach ($rows as $recs) {
            $ppp = $recs['ppp'];
        }
    }

    return floatval($ppp);
}

function get_value_adjusted($db, $value, $country_code, $year_origin, $year_target){
    $value_adjusted = null;
    //echo("country code : $country_code<BR>\n");
    //echo("year origin : $year_origin<BR>\n");
    //echo("year target : $year_target<BR>\n");

    $ppp_target = lookup_ppp($db, $country_code, $year_target);
    $cpi_origin = lookup_cpi($db, $country_code, $year_origin);
    $cpi_target = lookup_cpi($db, $country_code, $year_target);

    //echo("ppp : $ppp_target<BR>\n");
    //echo("cpi origin : $cpi_origin<BR>\n");
    //echo("cpi target : $cpi_target<BR>\n");
    if($ppp_target < 0 || $cpi_origin < 0 || $cpi_target < 0){
        return $value_adjusted;
    }

    $denom = $ppp_target * $cpi_origin;
    if(abs($denom) > 0.00001){
        $value_adjusted = $value *$cpi_target / $denom;
    }

    return $value_adjusted;
}

