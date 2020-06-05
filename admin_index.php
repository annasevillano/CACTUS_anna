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

?>
<!DOCTYPE HTML>
<html>
<head>
    <?php (@include_once("./$mobile_head_bs")) OR die("Cannot find this file to include: $mobile_head_bs<BR>"); ?>
    <link rel="Shortcut Icon" type="image/ico" href="./images/favicon_cactus.ico"/>

</head>
<body>
<?php (@include_once("./$mobile_nav_admin_bs")) OR die("Cannot find this file to include: $mobile_nav_admin_bs<BR>"); ?>



<div class="container-fluid" id="main_body">

    <div class='container' style="margin-top: 50px">
        <h2><img src="./images/favicon_cactus-32x32.png"> CACTU$ Costing Data</h2>
        <h4>Hello,</h4>

        <H5>This page is the summary administration page for the CACTU$ tool data.</H5>

        <H5>If you are <strong>not an admin user</strong> you should <strong>not be on this page</strong>. Please return to where you came.</H5>


        <H3>This page enables viewing all datapoint raw data for CACTU$</H3>
    </div>
    <div class='container'>
        <div class="row">
            <h3>Load all Datapoint data</h3>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <button id="btn_load_all_datapoints" type="button" class="btn btn-primary">Load Data for All Datapoints</button>
            </div>
            <div class="col-sm-4">

            </div>
            <div class="col-sm-4">
                <button id="btn_download_all_datapoints" type="button" class="btn btn-primary">Download all data as JSON file</button>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <!--<h4>Table listing all datapoints</h4>-->
            </div>
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="datapoint_detail_table2_hide_chk">
                    <label class="custom-control-label" for="datapoint_detail_table2_hide_chk">hide datapoints table</label>
                </div>
            </div>
        </div>
        <div id="datapoints_data_div">
            <div id="datapoint_detail_table_div2">
                <table id='datapoint_detail_table2' class='table  hover compact cell-border'>
                    <thead>
                    <tr>
                        <th class='text-center'>Select</th>
                        <th class='text-center'>Data point id</th>
                        <th>Country</th>
                        <th>Country code</th>
                        <th>Date</th>
                        <th>City</th>
                        <th>System</th>
                        <th>Element</th>
                        <th>Component</th>
                        <th>Case description</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <h3>Summary for selected datapoint</h3>
        </div>

        <div id="datapoints_data_div_selected">
            <div id="datapoint_detail_table_div_selected">
                <table id='datapoint_detail_table_selected' class='table  hover compact cell-border'>
                    <thead>
                    <tr>
                        <th class='text-center'>Selected</th>
                        <th class='text-center'>Data point id</th>
                        <th>Country</th>
                        <th>Country code</th>
                        <th>Date</th>
                        <th>City</th>
                        <th>System</th>
                        <th>Element</th>
                        <th>Component</th>
                        <th>Case description</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div id="datapoint_selected_tree" >

            </div>

        </div>

        <div class="row">
            <div id="datapoint_selected_resources" >

            </div>

        </div>
        <div class="row">
            <div id="datapoint_selected_services" >

            </div>

        </div>

        <div class="row">
            <div id="datapoint_selected_res1" class="col-sm-4"></div>
            <div id="datapoint_selected_res2" class="col-sm-4"></div>
            <div id="datapoint_selected_res3" class="col-sm-4"></div>
        </div>
        <div class="row">
            <h3>Cost Type 2 Summary Costs</h3>
        </div>
        <div class="row">
            <div id="cost_type2_summary_table_div" class="table-responsive-md">
                <table id='cost_type2_summary_table' class='table hover compact cell-border' width="100%">
                    <thead>
                    <tr>
                        <th>Cost Type 2</th>
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
            <h3>Category 1 Summary Costs</h3>
        </div>
        <div class="row">
            <div id="category1_summary_table_div">
                <table id='category1_summary_table'  class='hover compact cell-border'>
                    <thead>
                    <tr>
                        <th>Category 1</th>
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
            <h3>Category 2 Summary Costs</h3>
        </div>
        <div class="row">
            <div id="category2_summary_table_div">
                <table id='category2_summary_table'  class='hover compact cell-border'>
                    <thead>
                    <tr>
                        <th>Category 2 - Consumables</th>
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
            <h3>Category 3 Summary Costs</h3>
        </div>
        <div class="row">
            <div id="category3_summary_table_div">
                <table id='category3_summary_table'  class='hover compact cell-border'>
                    <thead>
                    <tr>
                        <th>Category 3 - Services</th>
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
            <h3>Services Summary Costs</h3>
        </div>
        <div class="row">
            <div id="services2_summary_table_div">
                <table id='services2_summary_table'  class='hover compact cell-border'>
                    <thead>
                    <tr>
                        <th>Services</th>
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
        $("#datapoint_detail_table_selected").dataTable(datapoint_table_def);

        cats_table_def = {
            //"bSort":    false,
            "paging": false,
            "ordering": false,
            "info":     false, // switch off the "Showing 1 of N"
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
            "info":     false,
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
