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

$block_base_list_html = "<div id='admin_list_base_div' style='display: block;'>";
$block_base_list_html .= "<table id='base_list' class='hover compact cell-border' cellspacing='0' width='100%'>\n";
$block_base_list_html .= "
                <thead>
                    <tr>
                        <th>Plot</th>
                        <th>Country</th>
                        <th>City</th>
                        <th>Date</th>
                        <th>Element</th>
                        <th>System</th>
                        <th>Component</th>
                        <th>TACH (US$ 2016)</th>
                    </tr>
                </thead>\n
                <tbody>
                \n";

// get the base table data
$base_table = GetCACTUSBaseTableName();
$query = "SELECT * FROM $base_table";
$res = perform_select_query($db, $query);

$rows = $res->fetchAll();

$all_cactus_base_data = get_cactus_base_data($rows);

foreach ($rows as $recs) {
    $id = $recs['id'];
    $country = $recs['country'];
    $city = $recs['city'];
    $date = $recs['date'];
    $php_date = $recs['php_date'];
    $component = $recs['component'];
    $element = $recs['element'];
    $system = $recs['system'];
    $tach = $recs['tach'];
    $tach = sprintf('%0.2f', $tach);

    $idname = "chk_$id";
    $chk = "<input type='checkbox' id='$idname' name='$idname' checked>";
    $block_base_list_html .= "<tr>";
    $block_base_list_html .= "<td>$chk</td>";
    $block_base_list_html .= "<td>$country</td>";
    $block_base_list_html .= "<td>$city</td>";
    $block_base_list_html .= "<td>$date</td>";
    $block_base_list_html .= "<td>$element</td>";
    $block_base_list_html .= "<td>$system</td>";
    $block_base_list_html .= "<td>$component</td>";
    $block_base_list_html .= "<td>$tach</td>";
    $block_base_list_html .= "</tr>\n";
}
$block_base_list_html .= "</tbody>\n</table>";
$block_base_list_html .= "</div>\n";
?>
<!DOCTYPE HTML>
<html>
<head>
<?php (@include_once("./$mobile_head_bs")) OR die("Cannot find this file to include: $mobile_head_bs<BR>"); ?>
    <link rel="Shortcut Icon" type="image/ico" href="./images/favicon_cactus.ico"/>
</head>
<body>
<?php (@include_once("./$mobile_nav_admin_bs")) OR die("Cannot find this file to include: $mobile_nav_bs<BR>"); ?>



<div class="container">
    <div class="jumbotron jumbotron-header">
        <h2><img src="<?php echo("./images/$header_image"); ?>" alt="Logo" width="320" height="87"/><br><?php echo("$group_title : $running_title"); ?></h2>
    </div>
    <hr class="style1">
    <div class="container-fluid">
        <?php echo("$greeting_block"); ?>
        <div class="well wellpm">
            <H2>Current data</H2>
            <p><input type="checkbox" id="show_base_data_table_chk" > Show/hide data table</p>
            <div id="base_data_table_div" style="display: block;">
                <?php echo("$block_base_list_html"); ?>
            </div>
            <button class="btn btn-success" id="btn_redraw_base_chart">Redraw the chart</button>
            <div class="row" id="base_summary_div" style="display: block">
                <div id="BaseSummaryChart"  style="min-width: 310px; max-width: 1200px; height: 450px;  margin: 0 auto; width: 100%; display: none"></div>
            </div>
            <div class="row" id="base_summary_split_div" style="display: block">
                <div id="BaseSummarySplitChart"  style="min-width: 310px; max-width: 1200px; height: 450px;  margin: 0 auto; width: 100%; display: none"></div>
            </div>
            <div class="row" id="base_summary_bubble_div" style="display: block">
                <div id="BubbleBaseSummaryChart"  style="min-width: 310px; max-width: 550px; height: 550px;  margin: 0 auto; width: 100%; display: none"></div>
            </div>
            <div class="row" id="base_summary_bubble_split_div" style="display: block">
                <div id="BubbleBaseSummarySplitChart"  style="min-width: 310px; max-width: 550px; height: 550px;  margin: 0 auto; width: 100%; display: none"></div>
            </div>
            <div class="row" id="base_summary_raw_div" style="display: block">
                <div id="BaseSummaryRawChart"  style="min-width: 310px; max-width: 1200px; height: 450px;  margin: 0 auto; width: 100%; display: none"></div>
            </div>
            <div class="btn-group-vertical btn-group-lg" role="group">
                <?php echo("$model_button"); ?>

            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="well wellfb text-center">
            <H2>Some background info</H2>
            <div class="btn-group-vertical  btn-group-lg" role="group">
                <?php echo("$background_buttons"); ?>

            </div>
        </div>
    </div>
</div>


<footer class="footer">
    <div class="container">
        <p class="text-muted">If you have any questions, contact Andy Sleigh: P.A.Sleigh@leeds.ac.uk</p>
    </div>
</footer>
</body>
<script src="./js/cactus_base_summary_chart.js"></script>
<script src="./js/cactus_base_summary_split_chart.js"></script>
<script src="./js/cactus_bubble_base_summary_chart.js"></script>
<script src="./js/cactus_display.js"></script>
<script>
    $(document).ready(function() {

        cactus_data_json = <?php echo json_encode($all_cactus_base_data); ?>;
        set_all_cactus_data(cactus_data_json);
        draw_base_summary_chart();
        draw_base_summary_split_chart();
        draw_bubble_base_summary_chart();
        draw_bubble_base_summary_split_chart();
        draw_base_summary_raw_chart();

        $('#base_data_table_div').toggle();
        $('#show_base_data_table_chk').on('click', function (e) {
            $('#base_data_table_div').toggle();
        });

        $('#btn_redraw_base_chart').on('click', function (e) {
            draw_base_summary_chart();
            draw_base_summary_split_chart();
            draw_bubble_base_summary_chart();
            draw_bubble_base_summary_split_chart();
            draw_base_summary_raw_chart();
        });

        $(function () {
            $("#base_list").dataTable(
                {
                    //"bSort":    false,
                    "paging": false,
                    //"ordering": false,
                    //"info":     false,
                    "searching": false,
                    columnDefs: [
                        {width: '3%', targets: 0},
                        {width: '10%', targets: 1},
                        {width: '10%', targets: 2},
                        {width: '10%', targets: 4},
                        {"className": "dt-center", targets: [0, 4]}
                    ]
                }
            );
        })
    });
</script>
</html>
