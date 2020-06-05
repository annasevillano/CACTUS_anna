<?php
/**
 * Created by PhpStorm.
 * User: cenpas
 * Date: 31/03/2018ffav###
 * Time: 14:38
 */?>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- <link rel="stylesheet" type="text/css" href="./frameworks/Bootstrap-3.3.7/css/bootstrap.min.css"/>-->
    <link rel="stylesheet" type="text/css" href="./frameworks/Bootstrap-4.3.1/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="./frameworks/DataTables-1.10.16/css/dataTables.bootstrap.min.css"/>

    <link rel="stylesheet" type="text/css" href="./frameworks/DataTables-1.10.16/css/jquery.dataTables.css" />

    <script type="text/javascript" src="./frameworks/jQuery-3.2.1/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="./frameworks/popper.min.js"></script>
    <!--<script type="text/javascript" src="./frameworks/Bootstrap-3.3.7/js/bootstrap.min.js"></script>-->
    <script type="text/javascript" src="./frameworks/Bootstrap-4.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./frameworks/DataTables-1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="./frameworks/DataTables-1.10.16/js/dataTables.bootstrap.min.js"></script>

    <!--
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.3/css/jquery.dataTables.css" type="text/css" rel="stylesheet" />

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
-->
    <script type="text/javascript" charset="utf8" src="./frameworks/datatables-plugins/1.10.16/date-uk.js"></script>
    <!--
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/plug-ins/1.10.16/sorting/date-uk.js"></script>
-->
    <style>
        /* This causes the bootstrap button to wrap text and thus fit in the width*/
        .btn{
            white-space:normal !important;
            max-width:400px;
            margin-bottom:4px;
            word-wrap:break-word;"
        }

        /* dynamic tabs css
            @import url('http://getbootstrap.com/2.3.2/assets/css/bootstrap.css');
         */

        .container {
           /* margin-top: 10px;*/
        }

        .nav-tabs > li {
            position:relative;
        }

        .nav-tabs > li > a {
            display:inline-block;
        }

        .nav-tabs > li > span {
            display:none;
            cursor:pointer;
            position:absolute;
            right: 6px;
            top: 8px;
            color: red;
        }

        .nav-tabs > li:hover > span {
            display: inline-block;
        }

        .navbar .navbar-brand{
            color: antiquewhite;
        }
        nav .navbar-nav li a{
            color: antiquewhite !important;
        }
        ul.nav a:hover { color: #fff !important; }


        .navbar-nav > li > .dropdown-menu { background-color: #669900;}


    </style>

    <link rel="stylesheet" type="text/css" href="./frameworks/jqueryui/1.12.1/jquery-ui.css"/>
    <script type="text/javascript" src="./frameworks/jqueryui/1.12.1/jquery-ui.js"></script>

    <!--
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css"/>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
-->
    <!-- Custom styles for this template -->
   <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">


    <script src="./frameworks/bowser.min.js"></script>

    <script src="./frameworks/js.cookie.js"></script>

    <link rel="stylesheet" type="text/css" href="./frameworks/jsonview/jsonview.css">
    <script type="text/javascript" src="./frameworks/jsonview/jsonview.js"></script>

    <!--
    <link href="css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" type="text/css" media="all">
    <script src="js/jquery.bootstrap-touchspin.min.js"></script>
-->
    <link rel="stylesheet" type="text/css" href="./frameworks/bootstrap-plugins/jquery.bootstrap-touchspin.min.css"/>
    <script type="text/javascript" charset="utf8" src="./frameworks/bootstrap-plugins/jquery.bootstrap-touchspin.min.js"></script>
    <!--
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-touchspin/3.1.2/jquery.bootstrap-touchspin.min.css"/>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-touchspin/3.1.2/jquery.bootstrap-touchspin.min.js"></script>
-->

    <link rel="stylesheet" type="text/css" href="./frameworks/bootstrap-plugins/bootstrap-treeview.min.css"/>
    <script type="text/javascript" charset="utf8" src="./frameworks/bootstrap-plugins/bootstrap-treeview.min.js"></script>
<!--
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.css"/>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.js"></script>
-->
    <script src="./frameworks/highcharts/7.1.3/highcharts.js"></script>
    <script src="./frameworks/highcharts/7.1.3/exporting.js"></script>
    <script src="./frameworks/highcharts/7.1.3/highcharts-more.js"></script>
    <script src="./frameworks/highcharts/grouped-categories.js"></script>


<!--
<script type="text/javascript" charset="utf8" src="https://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript" charset="utf8" src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript" charset="utf8" src="https://code.highcharts.com/highcharts-more.js"></script>

<script type="text/javascript" charset="utf8" src="https://code.highcharts.com/highcharts-3d.js"></script>
<script type="text/javascript" charset="utf8" src="https://code.highcharts.com/modules/heatmap.js"></script>
<script type="text/javascript" charset="utf8" src="https://code.highcharts.com/modules/histogram-bellcurve.js"></script>
-->
    <link rel="stylesheet" href="./css/site-bootstrap.css">