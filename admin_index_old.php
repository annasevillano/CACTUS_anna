<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 24/02/2019
 * Time: 17:40
 */

(@include_once("./config.php")) OR die("Cannot find this file to include: config.php<BR>");
(@include_once("./utils.php")) OR die("Cannot find this file to include: utils.php<BR>");
(@include_once("./pdo_functions.php")) OR die("Cannot find this file to include: pdo_functions.php<BR>");
(@include_once("./table_functions.php")) OR die("Cannot find this file to include: table_functions.php<BR>");
(@include_once("./connect_pdo.php")) OR die("Cannot connect to the database<BR>");

(@include_once("./cactus_db_functions.php")) OR die("Cannot find this file to include: cactus_db_functions.php<BR>");

/*
(@include_once("./setup_titles.php")) OR die("Cannot find this file to include: setup_titles.php<BR>");
(@include_once("./markstore_functions.php")) OR die("Cannot include markstore_functions.php<BR>");
(@include_once("./setup_tables.php")) OR die("Cannot setup database tables<BR>");
(@include_once("./staff_functions.php")) OR die("Cannot open staff_functions.php<BR>");
(@include_once("./admin2/adminusers.php")) OR die("Cannot include adminusers<BR>");
(@include_once("./markstore_functions.php")) OR die("Cannot include markstore_functions.php<BR>");
(@include_once("./table_functions.php")) OR die("Cannot include table_functions.php<BR>");
*/


$admin_link = "#hello";

$greeting_block = "<h2>Hello,</h2>";
$model_button = "";
$background_buttons = "";

$block_base_table_import_html  = "<form method='post' id='post_base_data_xlsx'>\n";
$block_base_table_import_html .= "<label for='base_data_xlsx_file' class='custom-file-upload'>\n";
$block_base_table_import_html .= "Upload basic summary CACTU$ data for cities (xlsx/xls/csv)</label>";
$block_base_table_import_html .= "<input type='file' id='base_data_xlsx_file'/>";
$block_base_table_import_html .= " <label id='base_data_filename'>&nbsp;</label>";
$block_base_table_import_html .= "</form>\n";

$block_base_list_html = "<div id='admin_list_base_div' style='display: block;'>";
$block_base_list_html .= "<table id='base_list' class='hover compact cell-border' cellspacing='0' width='100%'>\n";
$block_base_list_html .= "
                <thead>
                    <tr>
                        <th>DB Index</th>
                        <th>Edit</th>
                        <th>Country</th>
                        <th>Code</th>
                        <th>City</th>
                        <th>Element</th>
                        <th>System</th>
                        <th>Component</th>
                        <th>Source</th>
                        <th>Date</th>
                        <th>PHP Date</th>
                        <th>Data collector</th>
                        <th>Notes</th>
                        <th>URL</th>
                        <th>Description</th>
                        <th>CAPEX/OPEX</th>
                        <th>min</th>
                        <th>mean</th>
                        <th>max</th>
                        <th>One value</th>
                        <th>UM</th>
                        <th>Currency</th>
                        <th>Year</th>
                        <th>US$ 2016</th>
                        <th>TACH Assumptions</th>
                        <th>Lifetime</th>
                        <th>TACH (US$ 2016)</th>
                        <th>Edit</th>
                    </tr>
                </thead>\n
                <tbody>
                \n";

// get the base table data
$base_table = GetCACTUSBaseTableName();
$query = "SELECT * FROM $base_table";
$res = perform_select_query($db, $query);

$rows = $res->fetchAll();

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

    $self_url = $_SERVER['PHP_SELF'];
    $edit_url = "./admin_base_edit.php";
    $edit_link = "<a href='$edit_url?id=$id'>edit</A>";

    $url_link = "";
    if($url != ""){
        $url_link = "<a href='$url'>source link</A>";
    }

    $block_base_list_html .= "<tr>";
    $block_base_list_html .= "<td>$id</td> ";
    $block_base_list_html .= "<td>$edit_link</td> ";
    $block_base_list_html .= "<td>$country</td> ";
    $block_base_list_html .= "<td>$country_code</td> ";
    $block_base_list_html .= "<td>$city</td>";
    $block_base_list_html .= "<td>$element</td>";
    $block_base_list_html .= "<td>$system</td>";
    $block_base_list_html .= "<td>$component</td>";
    $block_base_list_html .= "<td>$case_desc</td>";
    $block_base_list_html .= "<td>$date</td>";
    $block_base_list_html .= "<td>$php_date</td>";
    $block_base_list_html .= "<td>$data_collector</td>";
    $block_base_list_html .= "<td>$notes</td>";
    $block_base_list_html .= "<td>$url_link</td>";
    $block_base_list_html .= "<td>$description</td>";
    $block_base_list_html .= "<td>$capex_opex</td>";
    $block_base_list_html .= "<td>$min</td>";
    $block_base_list_html .= "<td>$mean</td>";
    $block_base_list_html .= "<td>$max</td>";
    $block_base_list_html .= "<td>$one_value</td>";
    $block_base_list_html .= "<td>$um</td>";
    $block_base_list_html .= "<td>$currency</td>";
    $block_base_list_html .= "<td>$year</td>";
    $block_base_list_html .= "<td>$us_2016</td>";
    $block_base_list_html .= "<td>$tach_assumption</td>";
    $block_base_list_html .= "<td>$lifetime</td>";
    $block_base_list_html .= "<td>$tach</td>";
    $block_base_list_html .= "<td>$edit_link</td>";
    $block_base_list_html .= "</tr>\n";
}
$block_base_list_html .= "</tbody>\n</table>";
$block_base_list_html .= "</div>\n";


// Master data import button
$block_master_table_import_html  = "<form method='post' id='post_master_data_xlsx'>\n";
$block_master_table_import_html .= "<label for='master_data_xlsx_file' class='custom-file-upload-green'>\n";
$block_master_table_import_html .= "Upload master CACTU$ data for cities (xlsx/xls/csv)</label>";
$block_master_table_import_html .= "<input type='file' id='master_data_xlsx_file'/>";
$block_master_table_import_html .= " <label id='master_data_filename'>&nbsp;</label>";
$block_master_table_import_html .= "</form>\n";

// Master table
$block_master_list_html = "<div id='admin_master_base_div' style='display: block;'>";
$block_master_list_html .= "<table id='master_list' class='hover compact cell-border' cellspacing='0' width='100%'>\n";
$block_master_list_html .= "
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>DB Index</th>
                        <th>Study Index</th>
                        <th>Country</th>
                        <th>Code</th>
                        <th>City</th>
                        <th>Date</th>
                        <th>PHP Date</th>
                        <th>Element</th>
                        <th>System</th>
                        <th>Num components</th>
                        <th>Population</th>
                        <th>Region</th>
                        <th>Population density</th>
                        <th>Topography</th>
                        <th>Number of households</th>
                        <th>Number of people</th>
                        <th>TACH US$ 2016</th>
                        <th>TACC US$ 2016</th>
                        <th>TACH Assumptions file</th>
                    </tr>
                </thead>\n
                <tbody>
                \n";

// get the master table data
$master_table = GetCACTUSMasterDataOldTableName();
$query = "SELECT * FROM $master_table";
$res = perform_select_query($db, $query);

$rows = $res->fetchAll();

foreach ($rows as $recs) {
    $id = $recs['id'];
    $study_id = $recs['study_id'];
    $country = $recs['country'];
    $country_code = $recs['country_code'];
    $city = $recs['city'];
    $lat = $recs['lat'];
    $lon = $recs['lon'];
    $element = $recs['element'];
    $system = $recs['system'];
    $component = $recs['component'];
    $num_components = $recs['num_components'];
    // priority
    $case_desc = $recs['case_desc'];
    $report_name = $recs['report_name'];
    $data_collector = $recs['data_collector'];
    $year = $recs['year'];
    $date = $recs['date'];
    $php_date = $recs['php_date'];
    $population = $recs['population'];
    $region = $recs['region'];
    $pop_density = $recs['pop_density'];
    $topography = $recs['topography'];
    $num_hh = $recs['num_hh'];
    $num_people = $recs['num_people'];
    $tach = $recs['tach'];
    $tacc = $recs['tacc'];
    $notes_file = $recs['notes_file'];
    
    $tach = sprintf('%0.2f', $tach);
    $tacc = sprintf('%0.2f', $tacc);

    $radio_id = $study_id;
    $radio_btn = "<input type='radio' name='study_radio' value='$radio_id'>";
    $num_components_id = "num_components_$radio_id";
    $num_components_input = "<input type='hidden' name='num_components' id='$num_components_id' value='$num_components'>";

    $block_master_list_html .= "<tr>";
    $block_master_list_html .= "<td>$radio_btn</td> ";
    $block_master_list_html .= "<td>$id</td> ";
    $block_master_list_html .= "<td>$study_id</td> ";
    $block_master_list_html .= "<td>$country</td> ";
    $block_master_list_html .= "<td>$country_code</td> ";
    $block_master_list_html .= "<td>$city</td>";
    $block_master_list_html .= "<td>$date</td>";
    $block_master_list_html .= "<td>$php_date</td>";
    $block_master_list_html .= "<td>$element</td>";
    $block_master_list_html .= "<td>$system</td>";
    $block_master_list_html .= "<td>$num_components $num_components_input</td>";
    $block_master_list_html .= "<td>$population</td>";
    $block_master_list_html .= "<td>$region</td>";

    $block_master_list_html .= "<td>$pop_density</td>";
    $block_master_list_html .= "<td>$topography</td>";
    $block_master_list_html .= "<td>$num_hh</td>";
    $block_master_list_html .= "<td>$num_people</td>";
    $block_master_list_html .= "<td>$tach</td>";
    $block_master_list_html .= "<td>$tacc</td>";
    $block_master_list_html .= "<td>$notes_file</td>";
    $block_master_list_html .= "</tr>\n";
}
$block_master_list_html .= "</tbody>\n</table>";
$block_master_list_html .= "</div>\n";


$block_cpi_import_html  = "<form method='post' id='post_cpi_data_xlsx'>\n";

$block_cpi_import_html .= "<label for='cpi_data_xlsx_file' class='custom-file-upload'>\n";
$block_cpi_import_html .= "Upload CPI data (xlsx/xls/csv)</label>";
$block_cpi_import_html .= "<input type='file' id='cpi_data_xlsx_file'/>";
$block_cpi_import_html .= " <label id='cpi_data_filename'></label>";
$block_cpi_import_html .= "</form>\n";
$MatchID = "";
$MatchYear = "";
$block_cpi_country_select_html = "<h4>Lookup test for CPI data</h4>";
$block_cpi_country_select_html .=  "<div class='row'>";
$block_cpi_country_select_html .= "<div class='col-sm-4'>" . GetCountrySelectID($db, "CPICountyID", $MatchID) . "</div>";
$block_cpi_country_select_html .= "<div class='col-sm-2'>" . GetYearSelectID($db, "CPIYearID", $MatchYear, "cpi") . "</div>";
$block_cpi_country_select_html .= "<div class='col-sm-2'>" . "<button type='button' class='btn btn-info' id='cpi_button'>Get CPI</button>" . "</div>";
$block_cpi_country_select_html .= "<div class='col-sm-2'>" . "<input class='form-control' type='text' id='cpi_value' readonly>" .  "</div>";
$block_cpi_country_select_html .= "</div>";

$block_ppp_import_html  = "<form method='post' id='post_ppp_data_xlsx'>\n";
$block_ppp_import_html .= "<label for='ppp_data_xlsx_file' class='custom-file-upload'>\n";
$block_ppp_import_html .= "Upload PPP data (xlsx/xls/csv)</label>";
$block_ppp_import_html .= "<input type='file' id='ppp_data_xlsx_file'/>";
$block_ppp_import_html .= " <label id='ppp_data_filename'></label>";
$block_ppp_import_html .= "</form>\n";

$MatchID = "";

$block_ppp_country_select_html = "<h4>Lookup test for PPP data</h4>";
$block_ppp_country_select_html .=  "<div class='row'>";
$block_ppp_country_select_html .= "<div class='col-sm-4'>" . GetCountrySelectID($db, "PPPCountyID", $MatchID) . "</div>";
$block_ppp_country_select_html .= "<div class='col-sm-2'>" . GetYearSelectID($db, "PPPYearID", $MatchID, "ppp") . "</div>";
$block_ppp_country_select_html .= "<div class='col-sm-2'>" . "<button type='button' class='btn btn-info' id='ppp_button'>Get PPP</button>" .  "</div>";
$block_ppp_country_select_html .= "<div class='col-sm-2'>" . "<input class='form-control' type='text' id='ppp_value' readonly>" .  "</div>";
$block_ppp_country_select_html .= "<div class='col-sm-2'>" . "" .  "</div>";
$block_ppp_country_select_html .= "</div>";

$block_value_select_html = "";
$block_value_select_html .=  "<div class='row'>";
$block_value_select_html .= "<div class='col-sm-2'>" . "Value" . "</div>";
$block_value_select_html .= "<div class='col-sm-2'>" . "Source country currency" . "</div>";
$block_value_select_html .= "<div class='col-sm-2'>" . "Source Year" .  "</div>";
$block_value_select_html .= "<div class='col-sm-2'>" . "Target Year" .  "</div>";
$block_value_select_html .= "<div class='col-sm-2'>" . " " .  "</div>";
$block_value_select_html .= "<div class='col-sm-2'>" . "Adjusted value" .  "</div>";
$block_value_select_html .= "</div>";
$block_value_select_html .=  "<div class='row'>";
$block_value_select_html .= "<div class='col-sm-2'>" . "<input class='form-control' type='text' id='currency_value'>" .  "</div>";
$block_value_select_html .= "<div class='col-sm-2'>" . GetCountrySelectID($db, "ValueCountyID", $MatchID) . "</div>";
$block_value_select_html .= "<div class='col-sm-2'>" . GetYearSelectID($db, "SourceYearID", $MatchID, "ppp") . "</div>";
$block_value_select_html .= "<div class='col-sm-2'>" . GetYearSelectID($db, "TargetYearID", $MatchID, "ppp") . "</div>";
$block_value_select_html .= "<div class='col-sm-2'>" . "<button type='button' class='btn btn-info' id='adjust_button'>Adjust</button>" .  "</div>";
$block_value_select_html .= "<div class='col-sm-2'>" . "<input class='form-control' type='text' id='adjusted_value' readonly>" .  "</div>";
$block_value_select_html .= "</div>";


$block_merged_module_list_html = "";
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php (@include_once("./$mobile_head_bs")) OR die("Cannot find this file to include: $mobile_head_bs<BR>"); ?>
    <link rel="Shortcut Icon" type="image/ico" href="./images/favicon_cactus.ico"/>
<style>
    /* INput button */

    input[type="file"] {
        display: none;
    }

    .custom-file-upload {
        border: 0px solid #ccc;
        background-color: #5bc0de;
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
        border-radius: 2px;
    }

    .custom-file-upload-green {
        background-color: #5cb85c;
        border: 0px solid #ccc;
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
        border-radius: 2px;
    }

    .custom-file-download {
        border: 0px solid #ccc;
        background-color: #5cb85c; // green
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
        border-radius: 2px;
    }
</style>
</head>
<body>
<?php (@include_once("./$mobile_nav_admin_bs")) OR die("Cannot find this file to include: $mobile_nav_admin_bs<BR>"); ?>



<div class="container-fluid" id="main_body">

    <div class='container' style="margin-top: 50px">


        <h2><img src="./images/favicon_cactus-32x32.png"> CACTU$ Costing Data</h2>
        <h2 style='color: crimson'>This page is OUT OF DATE - it is kept only for reference</h2>
        <h4>Hello,</h4>


        <H5>If you are <strong>not an admin user</strong> you should <strong>not be on this page</strong>. Please return to where you came.</H5>


        <H3>This page enables reading in and viewing <strong>OLD</strong> raw data for CACTU$</H3>
    </div>
        <!--<div class="well well-sm" style="display: block">-->
            <h3>Summary City Data</h3><BR>

            <?php echo("$block_base_table_import_html"); ?>
            <h4>Currently any uploaded data <strong>deletes existing data</strong></h4>
            <input type="checkbox" id="base_data_table_chk" checked> Show/hide base data table
            <div id="base_data_table_div">
                    <?php echo("$block_base_list_html"); ?>
            </div>
        <!--</div>-->
        <!--<div class="well well-sm" style="display: block">-->
    <h3>Master Data <span style='color: crimson'>OLD FORMAT</span></h3><BR>

            <?php echo("$block_master_table_import_html"); ?>
            <h4>Currently any uploaded data <strong>deletes existing data</strong></h4>
            <input type="checkbox" id="master_data_table_chk" checked> Show/hide master data table
            <h3>Select a City / Study, then select a datapoint</h3>
            <div id="master_data_table_div">
                <?php echo("$block_master_list_html"); ?>
            </div>

        <!--</div>-->
    <div class='container'>
        <div class=""row>
            <div id="study_summary"></div>
        </div>
        <div class="row">
            <h3>Datapoint detail selection</h3>
            <div id="datapoint_detail_table_div">
                <table id='datapoint_detail_table' class='hover compact cell-border'>
                    <thead>
                    <tr>
                        <th class='text-center'>Select</th>
                        <th class='text-center'>Study:count</th>
                        <th class='text-center'>Data point id</th>
                        <th>Element</th>
                        <th>System</th>
                        <th>Component</th>
                        <th>Case description</th>
                        <th>Data Quality</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <h3>Category 1 summary costs</h3>
            <div id="cat1_summary_table_div">
                <table id='cat1_summary_table' class='hover compact cell-border'>
                    <thead>
                        <tr>
                            <th>Category 1 - Cost</th>
                            <th class='text-right'>CAPEX</th>
                            <th class='text-right'>OPEX</th>
                            <th class='text-right'>Total Annualised Cost ($2016)</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <h3>Category 2 summary costs</h3>
            <div id="cat2_summary_table_div">
                <table id='cat2_summary_table'  class='hover compact cell-border'>
                    <thead>
                    <tr>
                        <th>Category 2 - Cost</th>
                        <th class='text-right'>CAPEX</th>
                        <th class='text-right'>OPEX</th>
                        <th class='text-right'>Total Annualised Cost ($2016)</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <h3>Services summary costs</h3>
            <div id="services_summary_table_div">
                <table id='services_summary_table'  class='hover compact cell-border'>
                    <thead>
                    <tr>
                        <th>Service Driver</th>
                        <th class='text-right'>Value</th>
                        <th class='text-right'>Annualised Cost per unit of Service</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <div class='container'>
        <div class="well well-sm"  style="display: block">
            <h3>Consumer price index (CPI)</h3><BR>
            <?php echo("$block_cpi_import_html"); ?>
            <?php echo("$block_cpi_country_select_html"); ?>
            <div class="row">
                <div class="col-sm-4">

                </div>
                <div class="col-sm-8">

                </div>
            </div>

        </div>

        <div class="well well-sm"  style="display: block">
            <h3>Purchasing power parity (PPP) conversion factor</h3><BR>
            <?php echo("$block_ppp_import_html"); ?>
            <?php echo("$block_ppp_country_select_html");  ?>
            <div class="row">
                <div class="col-sm-4">

                </div>
                <div class="col-sm-8">

                    <!--<button type='button' class='btn btn-info' id='get_cpi_ppp_button'>Get CPI/PPP arrays</button>-->
                </div>
            </div>
        </div>

        <div class="well well-sm"  style="display: block">
            <h3>Adjust value example</h3><BR>

            <?php echo("$block_value_select_html");  ?>
            <div class="row">
                <div class="col-sm-4">

                </div>
                <div class="col-sm-8">

                </div>
            </div>
        </div>


    </div>

    <div id="result"></div>

</div><!-- /.container -->


<BR />
<footer class="footer">
    <div class="container">
        <p class="text-muted">If you have any questions, contact Andy Sleigh: P.A.Sleigh@leeds.ac.uk</p>
    </div>
</footer>

<script>
    $(function () {
        $("#base_list").dataTable(
            {
                //"bSort":    false,
                "paging": false,
                //"ordering": false,
                //"info":     false,
                "searching": false,
                columnDefs: [
                    {width: '5%', targets: 1},
                    //{width: '20%', targets: 1},
                    //{width: '20%', targets: 2},
                    //{width: '10%', targets: 4},
                    {"className": "dt-center", targets: 4}
                ]
            }
        );
        $("#master_list").dataTable(
            {
                //"bSort":    false,
                "paging": false,
                //"ordering": false,
                //"info":     false,
                "searching": false,
                columnDefs: [
                    {width: '25%', targets: [0, 1, 2]},
                    //{width: '20%', targets: 1},
                    //{width: '20%', targets: 2},
                    //{width: '10%', targets: 4},
                    {"className": "dt-center", targets: 0},
                    {"className": "dt-right", targets: [1, 2, 3]}
                ]
            }
        );

        datapoint_table_def = {
            //"bSort":    false,
            "paging": false,
            //"ordering": false,
            //"info":     false,
            "searching": false,
            columnDefs: [
                {width: '5%', targets: [0, 1, 2]},
                //{width: '20%', targets: 1},
                //{width: '20%', targets: 2},
                //{width: '10%', targets: 4},
                {"className": "dt-center", targets: [0, 1, 2]}
            ]
        };

        $("#datapoint_detail_table").dataTable(datapoint_table_def);

        cats_table_def = {
            //"bSort":    false,
            "paging": false,
            "ordering": false,
            //"info":     false,
            "searching": false,
            columnDefs: [
                {width: '25%', targets: [1, 2, 3]},
                //{width: '20%', targets: 1},
                //{width: '20%', targets: 2},
                //{width: '10%', targets: 4},
                {"className": "dt-left", targets: 0},
                {"className": "dt-right", targets: [1, 2, 3]}
            ]
        };

        $("#cat1_summary_table").dataTable(cats_table_def);

        $("#cat2_summary_table").dataTable(cats_table_def);

        services_table_def = {
            //"bSort":    false,
            "paging": false,
            "ordering": false,
            //"info":     false,
            "searching": false,
            columnDefs: [
                {width: '25%', targets: [1, 2]},
                //{width: '20%', targets: 1},
                //{width: '20%', targets: 2},
                //{width: '10%', targets: 4},
                {"className": "dt-left", targets: 0},
                {"className": "dt-right", targets: [1, 2]}
            ]
        };
        $("#services_summary_table").dataTable(services_table_def);

    })
</script>
<script src="js/cactus_admin_index_old.js"></script>
</body>

</html>
