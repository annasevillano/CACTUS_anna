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

// Master data import button
$block_master_table_import_html  = "<form method='post' id='post_master_data_xlsx'>\n";
$block_master_table_import_html .= "<label for='master_data_xlsx_file' class='custom-file-upload-green'>\n";
$block_master_table_import_html .= "Upload master CACTU$ data for cities (xlsx/xls/csv)</label>";
$block_master_table_import_html .= "<input type='file' id='master_data_xlsx_file'/>";
$block_master_table_import_html .= " <label id='master_data_filename'>&nbsp;</label>";
$block_master_table_import_html .= "</form>\n";


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
        <h4>Hello,</h4>

        <H5>This page is the summary administration page for the CACTU$ tool data.</H5>

        <H5>If you are <strong>not an admin user</strong> you should <strong>not be on this page</strong>. Please return to where you came.</H5>


        <H3>This page enables reading in of raw data for CACTU$</H3>
    </div>

    <div class='container'>
        <div class="well well-sm" style="display: block">
            <h3>Master Data</h3><BR>
            <?php echo("$block_master_table_import_html"); ?>
            <h4>Currently, any uploaded data <strong>deletes existing data</strong></h4>
        </div>
    </div>

    <div class='container'>
        <div class="well well-sm" style="display: block">
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

        $("#datapoint_detail_table2").dataTable(datapoint_table_def);

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

        $("#cost_type2_summary_table").dataTable(cats_table_def);
        $("#category1_summary_table").dataTable(cats_table_def);

        $("#category2_summary_table").dataTable(cats_table_def);
        $("#category3_summary_table").dataTable(cats_table_def);

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

        $("#services2_summary_table").dataTable(services_table_def);

    })
</script>
<script src="js/cactus_calcs.js"></script>
<script src="js/utils.js"></script>
<script src="js/cactus_admin_index.js"></script>
</body>

</html>
