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


/*
(@include_once("./setup_titles.php")) OR die("Cannot find this file to include: setup_titles.php<BR>");
(@include_once("./markstore_functions.php")) OR die("Cannot include markstore_functions.php<BR>");
(@include_once("./setup_tables.php")) OR die("Cannot setup database tables<BR>");
(@include_once("./staff_functions.php")) OR die("Cannot open staff_functions.php<BR>");
(@include_once("./admin2/adminusers.php")) OR die("Cannot include adminusers<BR>");
(@include_once("./markstore_functions.php")) OR die("Cannot include markstore_functions.php<BR>");
(@include_once("./table_functions.php")) OR die("Cannot include table_functions.php<BR>");
*/
function GetRowInputHTML($description,$input,$w1,$w2,$hint){
    $myrow = "<div class='row form-group'>\n";
    $myrow .= "<div class='col-sm-$w1'>\n";
    $myrow .= "<strong>$description</strong></div>\n";
    $myrow .= "<div class='col-sm-$w2'>$input</div>\n";
    $rcol = 12 - $w1-$w2;
    if($rcol > 0){
        $myrow .= "<div class='col-sm-$rcol'>$hint</div>\n";
    }
    $myrow .= "</div>\n";
    return $myrow;
}

function db_date_to_date_selector_date($mydate) {
    // converts from dd/mm/yyyy to yyyy-mm-dd
    $new_date = "2099-12-31";
    if(is_numeric(substr($mydate,0,1)))
    {
        $split_date = explode("/",$mydate);
        $new_date = $split_date[2] . "-" . $split_date[1] . "-" . $split_date[0];
    }
    return $new_date;
}
function date_selector_date_db_date($mydate){
    // converts from yyyy-mm-dd to dd/mm/yyyy
    $new_date = "31/12/2099";
    if(is_numeric(substr($mydate,0,1)))
    {
        $split_date = explode("-",$mydate);
        $new_date = $split_date[2] . "/" . $split_date[1] . "/" . $split_date[0];
    }
    return $new_date;
}

if (array_key_exists('id', $_REQUEST) == false) {
    $_REQUEST['id'] = null;
}
$id = $_REQUEST['id'];

if (array_key_exists('edit_id', $_REQUEST) == false) {
    $_REQUEST['edit_id'] = null;
}
$edit_id = $_REQUEST['edit_id'];

$admin_link = "#hello";

//echo("id = $id<BR>\n");
//echo("edit id = $edit_id<BR>\n");
if($edit_id != null){
    // Save to the database
    $base_table = GetCACTUSBaseTableName();

    $country          = $_POST['id_country'];
    $city             = $_POST['id_city'];
    $element        = $_POST['id_element'];
    $system           = $_POST['id_system'];
    $component         = $_POST['id_component'];
    $case_desc      = $_POST['id_case_desc'];
    $date             = $_POST['id_date'];
    $data_collector   = $_POST['id_data_collector'];
    $notes            = $_POST['id_notes'];
    $url              = $_POST['id_url'];
    $description      = $_POST['id_description'];
    $capex_opex       = $_POST['id_capex_opex'];
    $min              = $_POST['id_min'];
    $mean             = $_POST['id_mean'];
    $max              = $_POST['id_max'];
    $one_value        = $_POST['id_one_value'];
    $um               = $_POST['id_um'];
    $currency         = $_POST['id_currency'];
    $year             = $_POST['id_year'];
    $us_2016          = $_POST['id_us_2016'];
    $tach_assumptions = $_POST['id_tach_assumptions'];
    $lifetime         = $_POST['id_lifetime'];
    $tach             = $_POST['id_tach'];
    $submit_btn       = $_POST['id_submit_btn'];

    $php_date_str = $date;
    $db_date = date_selector_date_db_date($date);

    $query = "UPDATE $base_table SET
                         country='$country',
                         city='$city',
                         element='$element', 
                         system='$system', 
                         component='$component', 
                         case_desc='$case_desc', 
                         date='$db_date', 
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
                         tach_assumption='$tach_assumptions', 
                         lifetime='$lifetime', 
                         tach='$tach'
                         WHERE id='$edit_id'
                         ";
    //echo("$query<BR>\n");
    perform_query($db, $query);
}

$greeting_block = "<h2>Hello,</h2>";
$model_button = "";
$background_buttons = "";


$block_base_list_html = "<div id='admin_list_base_div' style='display: block;'>";
$block_base_list_html .= "<table id='base_list' class='hover compact cell-border' cellspacing='0' width='100%'>\n";
$block_base_list_html .= "
                <thead>
                    <tr>
                        <th>DB Index</th>
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
                    </tr>
                </thead>\n
                <tbody>
                \n";

if($edit_id != null){
    $id = $edit_id;
}


$self_url = $_SERVER['PHP_SELF'];
$block_base_edit_html = "<form id='edit_form' method='POST' action='$self_url?id='$id'>";
$block_base_edit_html .= "<input type='hidden' id='edit_id' name='edit_id' value='$id'>\n";
$block_base_edit_html .= "<div class='well well-sm' id='edit_div'>";



// get the base table data for this id
if($id != null) {
    $base_table = GetCACTUSBaseTableName();
    $query = "SELECT * FROM $base_table WHERE id=$id";
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

        $date_selector_date = db_date_to_date_selector_date($date);
        $us_2016 = number_format($us_2016,2);
        $tach = number_format($tach,2);

        $url_link = "";
        if ($url != "") {
            $url_link = "<a href='$url'>source link</A>";
        }

        $block_base_list_html .= "<tr>";
        $block_base_list_html .= "<td>$id</td> ";
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
        $block_base_list_html .= "</tr>\n";

        $desc = "id";
        $id_name = "id_db";
        $input_str = "<input type='text' class='form-control input-sm' id='$id_name' name='$id_name' value='$id' disabled>";
        $hint = "";
        $block_base_edit_html .= GetRowInputHTML($desc,$input_str,2,2,$hint);

        $desc = "Country";
        $id_name = "id_country";
        $input_str = "<input type='text' class='form-control input-sm' id='$id_name' name='$id_name' value='$country'>";
        $hint = "";
        $block_base_edit_html .= GetRowInputHTML($desc,$input_str,2,2,$hint);
        $desc = "City";
        $id_name = "id_city";
        $input_str = "<input type='text' class='form-control input-sm' id='$id_name' name='$id_name' value='$city'>";
        $hint = "";
        $block_base_edit_html .= GetRowInputHTML($desc,$input_str,2,2,$hint);
        $desc = "Element";
        $id_name = "id_element";
        $input_str = "<input type='text' class='form-control input-sm' id='$id_name' name='$id_name' value='$element'>";
        $hint = "";
        $block_base_edit_html .= GetRowInputHTML($desc,$input_str,2,2,$hint);
        $desc = "System";
        $id_name = "id_system";
        $input_str = "<input type='text' class='form-control input-sm' id='$id_name' name='$id_name' value='$system'>";
        $hint = "";
        $block_base_edit_html .= GetRowInputHTML($desc,$input_str,2,2,$hint);
        $desc = "Component";
        $id_name = "id_component";
        $input_str = "<input type='text' class='form-control input-sm' id='$id_name' name='$id_name' value='$component'>";
        $hint = "";
        $block_base_edit_html .= GetRowInputHTML($desc,$input_str,2,2,$hint);
        $desc = "Case description";
        $id_name = "id_case_desc";
        $input_str = "<input type='text' class='form-control input-sm' id='$id_name' name='$id_name' value='$case_desc'>";
        $hint = "";
        $block_base_edit_html .= GetRowInputHTML($desc,$input_str,2,2,$hint);
        $desc = "Date";
        $id_name = "id_date";
        $input_str = "<input type='date' class='form-control input-sm' id='$id_name' name='$id_name' value='$date_selector_date'>";
        $hint = "";
        $block_base_edit_html .= GetRowInputHTML($desc,$input_str,2,2,$hint);
        $desc = "Data collector";
        $id_name = "id_data_collector";
        $input_str = "<input type='text' class='form-control input-sm' id='$id_name' name='$id_name' value='$data_collector'>";
        $hint = "";
        $block_base_edit_html .= GetRowInputHTML($desc,$input_str,2,2,$hint);
        $desc = "Notes";
        $id_name = "id_notes";
        $input_str = "<input type='text' class='form-control input-sm' id='$id_name' name='$id_name' value='$notes'>";
        $hint = "";
        $block_base_edit_html .= GetRowInputHTML($desc,$input_str,2,6,$hint);
        $desc = "URL";
        $id_name = "id_url";
        $input_str = "<input type='text' class='form-control input-sm' id='$id_name' name='$id_name' value='$url'>";
        $hint = "";
        $block_base_edit_html .= GetRowInputHTML($desc,$input_str,2,6,$hint);
        $desc = "Description";
        $id_name = "id_description";
        $input_str = "<input type='text' class='form-control input-sm' id='$id_name' name='$id_name' value='$description'>";
        $hint = "";
        $block_base_edit_html .= GetRowInputHTML($desc,$input_str,2,6,$hint);
        $desc = "CAPEX/OPEX";
        $id_name = "id_capex_opex";
        $input_str = "<input type='text' class='form-control input-sm' id='$id_name' name='$id_name' value='$capex_opex'>";
        $hint = "";
        $block_base_edit_html .= GetRowInputHTML($desc,$input_str,2,2,$hint);
        $desc = "Minimum";
        $id_name = "id_min";
        $input_str = "<input type='number' min='0' max='10000' step='0.01' class='form-control input-sm' id='$id_name' name='$id_name' value='$min'>";
        $hint = "";
        $block_base_edit_html .= GetRowInputHTML($desc,$input_str,2,2,$hint);
        $desc = "Mean";
        $id_name = "id_mean";
        $input_str = "<input type='number' min='0' max='10000' step='0.01'  class='form-control input-sm' id='$id_name' name='$id_name' value='$mean'>";
        $hint = "";
        $block_base_edit_html .= GetRowInputHTML($desc,$input_str,2,2,$hint);
        $desc = "Maximum";
        $id_name = "id_max";
        $input_str = "<input type='number' min='0' max='10000' step='0.01'  class='form-control input-sm' id='$id_name' name='$id_name' value='$max'>";
        $hint = "";
        $block_base_edit_html .= GetRowInputHTML($desc,$input_str,2,2,$hint);
        $desc = "One value";
        $id_name = "id_one_value";
        $input_str = "<input type='number' min='0' max='10000' step='0.01'  class='form-control input-sm' id='$id_name' name='$id_name' value='$one_value'>";
        $hint = "";
        $block_base_edit_html .= GetRowInputHTML($desc,$input_str,2,2,$hint);
        $desc = "UM";
        $id_name = "id_um";
        $input_str = "<input type='text' class='form-control input-sm' id='$id_name' name='$id_name' value='$um'>";
        $hint = "";
        $block_base_edit_html .= GetRowInputHTML($desc,$input_str,2,2,$hint);
        $desc = "Currency";
        $id_name = "id_currency";
        $input_str = "<input type='text' class='form-control input-sm' id='$id_name' name='$id_name' value='$currency'>";
        $hint = "";
        $block_base_edit_html .= GetRowInputHTML($desc,$input_str,2,2,$hint);
        $desc = "Year";
        $id_name = "id_year";
        $input_str = "<input type='number' min='1900' max='2099' step='1'  class='form-control input-sm' id='$id_name' name='$id_name' value='$year'>";
        $hint = "";
        $block_base_edit_html .= GetRowInputHTML($desc,$input_str,2,2,$hint);
        $desc = "US$ 2016";
        $id_name = "id_us_2016";
        $input_str = "<input type='number' min='0' max='10000' step='0.01' class='form-control input-sm' id='$id_name' name='$id_name' value='$us_2016'>";
        $hint = "";
        $block_base_edit_html .= GetRowInputHTML($desc,$input_str,2,2,$hint);
        $desc = "TACH Assumptions";
        $id_name = "id_tach_assumptions";
        $input_str = "<input type='text' class='form-control input-sm' id='$id_name' name='$id_name' value='$tach_assumption'>";
        $hint = "";
        $block_base_edit_html .= GetRowInputHTML($desc,$input_str,2,6,$hint);
        $desc = "Lifetime (years)";
        $id_name = "id_lifetime";
        $input_str = "<input type='number' min='0' max='10000' step='0.01'  class='form-control input-sm' id='$id_name' name='$id_name' value='$lifetime'>";
        $hint = "";
        $block_base_edit_html .= GetRowInputHTML($desc,$input_str,2,2,$hint);
        $desc = "TACH (US$ 2016)";
        $id_name = "id_tach";
        $input_str = "<input type='number' min='0' max='10000' step='0.01'  class='form-control input-sm' id='$id_name' name='$id_name' value='$tach'>";
        $hint = "";
        $block_base_edit_html .= GetRowInputHTML($desc,$input_str,2,2,$hint);
        $desc = "Save Changes to database";
        $id_name = "id_submit_btn";
        $input_str = "<button type='submit' class='btn btn-success' id='$id_name' name='$id_name' value='$tach'>$desc</button>";
        $hint = "";
        $desc = "";
        $block_base_edit_html .= GetRowInputHTML($desc,$input_str,2,4,$hint);
    }
}

$block_base_list_html .= "</tbody>\n</table>";
$block_base_list_html .= "</div>\n";

$block_base_edit_html .= "</div>";
$block_base_edit_html .= "</form>";

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

        <H5>This page lets you edit a record in the base summary data</H5>

        <H5>If you are <strong>not an admin user</strong> you should <strong>not be on this page</strong>. Please return to where you came.</H5>


        <H3>This page enables editing of summary CACTU$ data</H3>

        <h3>Summary  Data Edit</h3>
        <input type="checkbox" id="show_base_data_table_chk" > Show/hide data table
    </div>
        <!--<div class="well well-sm" style="display: block">-->
        <div id="base_data_table_div" style="display: none">

            <?php echo("$block_base_list_html"); ?>

        </div>
        <!--</div>-->
    <div class='container'>
        <?php echo("$block_base_edit_html"); ?>
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
    $('#show_base_data_table_chk').on('click', function (e) {
        $('#base_data_table_div').toggle();
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
                    {width: '5%', targets: 12},
                    //{width: '20%', targets: 1},
                    //{width: '20%', targets: 2},
                    //{width: '10%', targets: 4},
                    {"className": "dt-center", targets: 4}
                ]
            }
        );
    })
</script>
<script src="js/cactus_admin_index.js"></script>
</body>
</body>
</html>
