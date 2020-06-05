<?php

?>
<nav class="navbar navbar-expand-md navbar-inverse" style="background-color: #669900; border: 0;">
    <div class="container">
    <a href="./index.php" class="navbar-brand">
        <img src="./images/favicon_cactus-32x32.png" height="32" alt="CACTU$ Costing"> <?php echo("$group_title $running_title"); ?>
    </a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>


        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" style="background-color: #669900;" id="navbarCollapse">
            <div class="nav navbar-nav">
                <!--<li><a href="./index.php" target="_top">back</a></li>-->
            </div>

            <div class="navbar-nav ml-auto nav-item dropdown"  >

                    <a data-toggle="dropdown" class="nav-link dropdown-toggle"  style="color: antiquewhite !important;" href="#">Admin<b class="caret"></b></a>
                    <div role="menu" class="dropdown-menu">
                        <a class="dropdown-item" href="./admin_index.php">Admin index</a>
                        <a class="dropdown-item" href="./admin_data_load.php">Admin data load</a>
                        <a class="dropdown-item" href="./admin_index_old.php">Admin view OLD data</a>
                        <a class="dropdown-item" href="./admin_chart_eg_old.php">Chart Example OLD data</a>
                        <a class="dropdown-item" href="./admin_country_test.php">Countries functions</a>
                        <a class="dropdown-item" href="./admin_delete.php">Admin delete</a>
                    </div>

            </div>

        </div>
    </div>
</nav>
