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


$admin_link = "#hello";

$greeting_block = "<h2></h2>";


?>
<!DOCTYPE HTML>
<html>
<head>
    <?php (@include_once("./$mobile_head_bs")) OR die("Cannot find this file to include: $mobile_head_bs<BR>"); ?>
    <link rel="Shortcut Icon" type="image/ico" href="./images/favicon_cactus.ico"/>
</head>

<body class="d-flex flex-column h-100">
<?php (@include_once("./$mobile_nav_bs")) OR die("Cannot find this file to include: $mobile_nav_bs<BR>"); ?>

<div class="container">
    <!--
    <div class="jumbotron jumbotron-header">
        <h2><img src="<?php echo("./images/$header_image"); ?>" alt="Logo" width="320" height="87"/><br><?php echo("$group_title : $running_title"); ?></h2>
    </div>
    -->
    <hr class="style1">
    <div class="container-fluid">
        <?php echo("$greeting_block"); ?>



    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 ">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Total annualised costs by component</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Total annualised costs by data point</a>
                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Cost breakdown by data point</a>
                        <a class="nav-item nav-link" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-about" aria-selected="false">Benchmark complete system</a>
                    </div>
                </nav>

                <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">

                    <!-- First tab Total annualised costs by component -->
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <!-- New Card -->
                        <div class="card">
                            <div class="card-header">
                                <h3>1. Total Annualised Costs by Component (full data set)</h3>
                            </div>
                            <div class="card-body">
                                <div class='row justify-content-center'>
                                    <div style="margin-top: 5px">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <label class="radio-inline">
                                                <input type="radio" name="tac_radio_overall" checked value="TACH"> Total Annualised Cost per Household
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <label class="radio-inline">
                                                <input type="radio" name="tac_radio_overall" value="TACC"> Total Annualised Cost per Capita
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class='row'>
                                    <div id="overall_chart" style="min-width: 310px; max-width: 1200px; height: 950px;  margin: 0 auto; width: 100%; display: block">
                                    </div>
                                    <button type="button" id="download_overall_chart_data" class="btn btn-light btn-sm">Download chart data</button>
                                </div>
                            </div>
                        </div>
                        &nbsp;
                        <!-- New Card -->
                        <div class="card">

                            <div class="card-header">
                                <h3>2. Total Costs by Component (all positive data points)</h3>
                            </div>
                            <div class="card-body">
                                <div class='row justify-content-center'>
                                <table>
                                    <tr>
                                        <td style="padding-right: 40px">
                                            <label class="radio-inline">
                                                <input type="radio" name="tac_radio_overall_more" checked value="TACH"> TACH
                                            </label>
                                        <br>
                                            <label class="radio-inline">
                                                <input type="radio" name="tac_radio_overall_more" value="TACC"> TACC
                                            </label>
                                        </td>
                                        <td>
                                                <label class="radio-inline">
                                                    <input type="radio" name="overall_radio" value="OPEX"> OPEX
                                                </label>
                                            <br>
                                                <label class="radio-inline">
                                                    <input type="radio" name="overall_radio" value="CAPEX"> CAPEX
                                                </label>
                                            <br>
                                                <label class="radio-inline">
                                                    <input type="radio" name="overall_radio" checked value="BOTH"> CAPEX and OPEX
                                                </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-right: 40px">
                                                <label class="radio-inline">
                                                    <input type="radio" name="tac_radio_overall_more" value="TCH"> TCH
                                                </label>
                                            <br>
                                                <label class="radio-inline">
                                                    <input type="radio" name="tac_radio_overall_more" value="TCC"> TCC
                                                </label>
                                        </td>
                                        <td>

                                            <br>

                                        </td>
                                    </tr>
                                </table>
                                </div>
                                <hr width="50%">
<!--
                                <div class='row justify-content-center'>
                                    <div style="margin-top: 5px">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <label class="radio-inline">
                                                <input type="radio" name="tac_radio_overall_more" checked value="TACH"> TACH
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <label class="radio-inline">
                                                <input type="radio" name="tac_radio_overall_more" value="TACC"> TACC
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <label class="radio-inline">
                                                <input type="radio" name="tac_radio_overall_more" value="TCH"> TCH
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <label class="radio-inline">
                                                <input type="radio" name="tac_radio_overall_more" value="TCC"> TCC
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class='row justify-content-center'>
                                    <div style="margin-top: 5px">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <label class="radio-inline">
                                                <input type="radio" name="overall_radio" checked value="BOTH"> CAPEX and OPEX
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <label class="radio-inline">
                                                <input type="radio" name="overall_radio" value="CAPEX"> CAPEX
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <label class="radio-inline">
                                                <input type="radio" name="overall_radio" value="OPEX"> OPEX
                                            </label>
                                        </div>
                                    </div>
                                </div>
-->
                                <div class='row'>
                                    <div id="overall_more_chart" style="min-width: 310px; max-width: 1200px; height: 900px;  margin: 0 auto; width: 100%; display: block">
                                    </div>
                                    <button type="button" id="download_overall_more_chart_data" class="btn btn-light btn-sm">Download chart data</button>

                                </div>
                            </div>
                        </div>

                        &nbsp;
                        <!-- New Card -->
                        <div class="card">
                            <div class="card-header">
                                <h3>5. Total Annualised Costs Comparison by Region</h3>
                            </div>
                            <div class="card-body">
                                <div class='row'>
                                    <div class='col-sm-6'>
                                        <label for='component_bubble_select'>Select a Component:</label>
                                        <select class='form-control' name='component_bubble_select' id='component_bubble_select'>

                                        </select>
                                    </div>
                                    <div class='col-sm-4'>
                                        <div style="margin-top: 25px">
                                            <div class="custom-control custom-radio custom-control-inline" style="margin-top: 15px">
                                                <label class="radio-inline">
                                                    <input type="radio" name="tac_radio_bubble" checked value="TACH"> TACH
                                                </label>
                                            </div>

                                            <div class="custom-control custom-radio custom-control-inline">
                                                <label class="radio-inline">
                                                    <input type="radio" name="tac_radio_bubble" value="TACC"> TACC
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class='row'>
                                    <div id="bubble_chart" style="min-width: 310px; max-width: 2200px; height: 900px;  margin: 0 auto; width: 100%; display: block">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- New Card -->
                        <div class="card">
                            <div class="card-header">
                                <h3>6. Total Annualised Costs Comparison by Region</h3>
                            </div>
                            <div class="card-body">
                                <div class='row justify-content-center'>
                                    <div style="margin-top: 25px">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <label class="radio-inline">
                                                <input type="radio" name="tac_radio_bubble_split" checked value="TACH"> TACH
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <label class="radio-inline">
                                                <input type="radio" name="tac_radio_bubble_split" value="TACC"> TACC
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class='row'>
                                    <div id="bubble_split_chart" style="min-width: 310px; max-width: 600px; height: 800px;  margin: 0 auto; width: 100%; display: block">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> <!-- End of tab l -->

                    <!-- Second tab Total annualised costs by data point -->
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <!-- New Card -->
                        <div class="card">
                            <div class="card-header">
                                <h3>3. Total Annualised Cost for a Single Component</h3>
                            </div>
                            <div class="card-body">

                                <div class='row'>
                                    <div class='col-sm-6'>
                                        <label for='component_select'>Select an Element:</label>
                                        <select class='form-control' name='component_select' id='component_select'>

                                        </select>
                                    </div>
                                    <div class='col-sm-4'>

                                        <div style="margin-top: 25px">
                                            <div class="custom-control custom-radio custom-control-inline" style="margin-top: 15px">
                                                <label class="radio-inline">
                                                    <input type="radio" name="tac_radio" checked value="TACH"> TACH
                                                </label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <label class="radio-inline">
                                                    <input type="radio" name="tac_radio" value="TACC"> TACC
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class='row'>
                                    <div id="component_chart" style="min-width: 310px; max-width: 1200px; height: 450px;  margin: 0 auto; width: 100%; display: block">
                                    </div>
                                </div>
                            </div>
                        </div>
                        &nbsp;
                        <!-- New Card -->
                        <div class="card">
                            <div class="card-header">
                                <h3>4. Total Annualised Costs (selected city)</h3>
                            </div>
                            <div class="card-body">
                                <div class='row'>
                                    <div class='col-sm-6'>
                                        <label for='city_select'>Select a City:</label>
                                        <select class='form-control' name='city_select' id='city_select'>

                                        </select>
                                    </div>
                                    <div class='col-sm-4'>
                                        <div style="margin-top: 25px">
                                            <div class="custom-control custom-radio custom-control-inline" style="margin-top: 15px">
                                                <label class="radio-inline">
                                                    <input type="radio" name="tac_radio_city" checked value="TACH"> TACH
                                                </label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline" >
                                                <label class="radio-inline">
                                                    <input type="radio" name="tac_radio_city" value="TACC"> TACC
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class='row'>
                                    <div id="city_chart" style="min-width: 310px; max-width: 1200px; height: 450px;  margin: 0 auto; width: 100%; display: block">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- End of tab 2 -->

                    <!-- Third tab Cost breakdown by data point -->
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <!-- New Card -->
                        <div class="card">
                            <div class="card-header">
                                <h3>7. Cost Breakdown by Data Point</h3>
                            </div>
                            <div class="card-body">
                                <div class='row justify-content-center'>
                                    <table>
                                        <tr>
                                            <td style="padding-right: 40px">
                                                <label class="radio-inline">
                                                    <input type="radio" name="tac_radio_category_split" checked value="TACH"> TACH
                                                </label>
                                                <br>
                                                <label class="radio-inline">
                                                    <input type="radio" name="tac_radio_category_split" value="TACC"> TACC
                                                </label>
                                            </td>
                                            <td>
                                                <label class="radio-inline">
                                                    <input type="radio" name="capex_opex_radio" value="CAPEX"> CAPEX
                                                </label>
                                                <br>
                                                <label class="radio-inline">
                                                    <input type="radio" name="capex_opex_radio" value="OPEX"> OPEX
                                                </label>
                                                <br>
                                                <label class="radio-inline">
                                                    <input type="radio" name="capex_opex_radio" checked value="BOTH"> CAPEX and OPEX
                                                </label>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <hr width="50%">
<!--
                                <div class='row justify-content-center'>
                                    <div style="margin-top: 5px">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <label class="radio-inline">
                                                <input type="radio" name="tac_radio_category_split" checked value="TACH"> TACH
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <label class="radio-inline">
                                                <input type="radio" name="tac_radio_category_split" value="TACC"> TACC
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class='row justify-content-center'>
                                    <div style="margin-top: 5px">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <label class="radio-inline">
                                                <input type="radio" name="capex_opex_radio" checked value="BOTH"> CAPEX and OPEX
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <label class="radio-inline">
                                                <input type="radio" name="capex_opex_radio" value="CAPEX"> CAPEX
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <label class="radio-inline">
                                                <input type="radio" name="capex_opex_radio" value="OPEX"> OPEX
                                            </label>
                                        </div>
                                    </div>
                                </div>
-->
                                <div class='row'>
                                    <div id="category_split_chart" style="min-width: 310px; max-width: 1200px; height: 900px;  margin: 0 auto; width: 100%; display: block">
                                    </div>
                                </div>
                            </div>
                        </div>
                        &nbsp;
                        <!-- New Card -->
                        <div class="card">
                            <div class="card-header">
                                <h3>8.. Cost Breakdown by Data Point</h3>
                            </div>
                            <div class="card-body">
                                <div class='row justify-content-center'>
                                    <div style="margin-top: 5px">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <label class="radio-inline">
                                                <input type="radio" name="tac_radio_split_more" checked value="TACH"> TACH
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <label class="radio-inline">
                                                <input type="radio" name="tac_radio_split_more" value="TACC"> TACC
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class='row justify-content-center'>
                                    <div style="margin-top: 5px">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <label class="radio-inline">
                                                <input type="checkbox" name="element_tickboxes" id="chk_containment" checked> Containment
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <label class="radio-inline">
                                                <input type="checkbox" name="element_tickboxes" id="chk_emptying" checked>Emptying
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <label class="radio-inline">
                                                <input type="checkbox" name="element_tickboxes" id="chk_transport" checked>Transport
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <label class="radio-inline">
                                                <input type="checkbox" name="element_tickboxes" id="chk_emptying_transport" checked>Emptying and Transport
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <label class="radio-inline">
                                                <input type="checkbox" name="element_tickboxes" id="chk_treatment" checked>Treatment
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class='row'>
                                    <div id="category_split_more_chart" style="min-width: 310px; max-width: 1200px; height: 900px;  margin: 0 auto; width: 100%; display: block">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> <!-- End of tab 3 -->


                    <!-- Forth tab Benchmark complete system -->
                    <div class="tab-pane fade" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                        New charts to be inserted here
                    </div> <!-- End of tab 4 -->


                </div> <!-- End of tab group -->

            </div>
        </div>
        &nbsp;

        &nbsp;
        &nbsp;
        &nbsp;
        <!-- New Card -->
        <!--
        <div class="card">
            <div class="card-header">
                <h3>9. Compare costs of santiation at two different locations</h3>
            </div>
            <div class="card-body">
            <div class='row'>
                <div class='col-sm-6'>
                    <label for='datapoint1_select'>Select a Datapoint:</label>
                    <select class='form-control' name='datapoint1_select' id='datapoint1_select'>

                    </select>
                </div>
                <div class='col-sm-6'>
                    <label for='datapoint2_select'>Select a Datapoint:</label>
                    <select class='form-control' name='datapoint2_select' id='datapoint2_select'>

                    </select>
                </div>
            </div>

            <div class='row justify-content-center'>
                <div style="margin-top: 8px">
                    <div class="custom-control custom-radio custom-control-inline">
                    <label class="radio-inline">
                        <input type="radio" name="tac_radio_datapoint_split" checked value="TACH"> TACH
                    </label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <label class="radio-inline">
                        <input type="radio" name="tac_radio_datapoint_split" value="TACC"> TACC
                    </label>
                    </div>
                </div>
            </div>

            <div class='row'>
                <div id="datapoint_split_chart" style="min-width: 310px; max-width: 1200px; height: 900px;  margin: 0 auto; width: 100%; display: block">
                </div>
            </div>

        </div>
        </div>
        -->
    </div>
</div>


<footer class="footer">
    <div class="container">
        <p class="text-muted">If you have any questions, contact Andy Sleigh: P.A.Sleigh@leeds.ac.uk</p>
    </div>
</footer>

<script src="js/cactus_calcs.js"></script>
<script src="js/cactus_base_summary_chart.js"></script>
<script src="js/cactus_base_summary_split_chart.js"></script>
<script src="js/cactus_bubble_base_summary_chart.js"></script>
<script src="js/utils.js"></script>
<script src="js/cactus_index.js"></script>
</body>
</html>
