<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 24/02/2019
 * Time: 17:40
 */

(@include_once("./config.php")) OR die("Cannot find this file to include: config.php<BR>");
/* maybe these ar needed later
(@include_once("./utils.php")) OR die("Cannot find this file to include: utils.php<BR>");
(@include_once("./pdo_functions.php")) OR die("Cannot find this file to include: pdo_functions.php<BR>");
(@include_once("./table_functions.php")) OR die("Cannot find this file to include: table_functions.php<BR>");
(@include_once("./connect_pdo.php")) OR die("Cannot connect to the database<BR>");

(@include_once("./cactus_db_functions.php")) OR die("Cannot find this file to include: cactus_db_functions.php<BR>");
*/
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

        <H5>If you are <strong>not an admin user</strong> you should <strong>not be on this page</strong>. Please return
            to where you came.</H5>


        <H3>This page enables reading in and viewing country and region data for CACTU$</H3>
    </div>

    <div class="container">
        <h1>Country and World Region Data</h1>

        <!-- Row for the dropdown selectors -->
        <div class='row'>
            <div class='col-sm-6'>
                <label for='region_select'>Select a region:</label>
                <select class='form-control' name='region_select' id='region_select'>

                </select>
            </div>
            <div class='col-sm-6'>
                <div id='country_select_div' style='display: none;'>
                    <label for='country_select'>Select a country:</label>
                    <select class='form-control' name='country_select' id='country_select'>

                    </select>
                </div>
            </div>
        </div>

        <!-- Row for message -->
        <div class='row'>
            <div class='col-sm-12' id="message_div">
                &nbsp;
            </div>
        </div>

        <!-- Row for the map -->
        <div class='row' id="top-of-map">
            <div class='col-sm-12'>
                <div id='container' style='height: 580px; border-style: solid; margin-top: 10px; margin-bottom: 10px; border-width: 1px; border-color: black; padding: 5px; display: block;'>

                </div>
                <div id='note' style='display: none;'>A placeholder for some notes ...</div>
            </div>
        </div>
        <BR>
    </div>


</div><!-- /.container -->


<BR/>
<footer class="footer">
    <div class="container">
        <p class="text-muted">If you have any questions, contact Andy Sleigh: P.A.Sleigh@leeds.ac.uk</p>
    </div>
</footer>

<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.3.6/proj4.js"></script>
<script src="http://code.highcharts.com/maps/modules/map.js"></script>
<script src="https://code.highcharts.com/mapdata/custom/world.js"></script>
-->
<script src="./frameworks/highcharts/maps/proj4.js"></script>
<script src="./frameworks/highcharts/7.1.3/map.js"></script>
<script src="./frameworks/highcharts/maps/world.js"></script>

<script src="js/cactus_countries_data.js"></script>
<script src="js/cactus_countries.js"></script>
</body>

</html>
