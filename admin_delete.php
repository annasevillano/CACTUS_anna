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

if (array_key_exists('op', $_POST) == false) {
    $_POST['op'] = null;
}
if (array_key_exists('op', $_POST)) {
    $POST_OP = $_POST['op'];
} else {
    $POST_OP = "";
}



// Submit
if($POST_OP == "delete_cactus_tables"){
    /*
    $query = "SHOW TABLES LIKE 'cactus_%'";
    $res = perform_select_query($db, $query);

    $rows = $res->fetchAll();

    foreach($rows as $row){
        $tables_list .= $row[0] . "<BR>\n";
    }
    */
    delete_all_cactus_tables($db);
}

$tables_list = "";
$query = "SHOW TABLES LIKE 'cactus_%'";
$res = perform_select_query($db, $query);

$rows = $res->fetchAll();

foreach($rows as $row){
    $tables_list .= $row[0] . "<BR>\n";
}
$block_del_tables  = "";
$block_del_tables .= "\n<form method='post' action='".$_SERVER['PHP_SELF']."''>\n";
$block_del_tables .= "<h4>These tables will be deleted:</h4>";
$block_del_tables .= $tables_list . "<BR>";

//$block_del_tables .= "\n<input type='hidden'  name='op' value='delete_cactus_tables'>\n";
$block_del_tables .= "<p class='before'>   <button type='submit' id='submitbutton_del' name='op' value='delete_cactus_tables' class='btn btn-danger'>Delete All CACTU$ tables forever</button></p>";
$block_del_tables .= "</form>\n";


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

        <H3>This page allows you to DELETE all of the CACTU$ data! </H3>
        <H3><strong>BE VERY SURE YOU WANT TO DELETE IT BEFORE PRESSING THE BUTTON BELOW</strong></H3>


        <div class="well well-sm"  style="display: block">
            <h3>Delete CACTUS database tables</h3><BR>
            <?php echo("$block_del_tables"); ?>

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

<script src="js/cactus_admin_index.js"></script>
</body>
</body>
</html>
