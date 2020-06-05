<?php

?>
<nav id="myNavbar" class="navbar navbar-default navbar-inverse navbar-fixed-top" style="background-color: #669900; border: 0;"  role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <A class="navbar-brand" href="./index.php"><?php echo("$group_title $running_title"); ?></A>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" style="background-color: #669900;" id="navbarCollapse">
            <ul class="nav navbar-nav">
                <!--<li><a href="./index.php" target="_top">back</a></li>-->
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a style="background-color: #669900;" href="admin_index.php"><span class="glyphicon glyphicon-cog"></span> Admin</a>
                    <!--
                    <ul role="menu" class="dropdown-menu">
                        <li><a href="./admin_index.php">Admin index</a></li>
                        <li><a href="./admin_delete.php">Admin delete</a></li>
                    </ul>
                    -->
                </li>
            </ul>

        </div>
    </div>
</nav>
<!--
<nav id="myNavbar" class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">

    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <A class="navbar-brand" href="./index.php"><?php echo("$group_title $running_title"); ?></A>
</div>

<div class="collapse navbar-collapse" id="navbarCollapse">

    <ul class="nav navbar-nav">

    </ul>

    <ul class="nav navbar-nav navbar-right">
        <li><a id="id_admin_index" href="admin_index.php" target="_top"><span
                    class="glyphicon glyphicon-cog"></span> Admin</a></li>
    </ul>
</div>
</div>
</nav>
-->
