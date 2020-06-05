<?php
/**
 * Created by PhpStorm.
 * User: cenpas
 * Date: 02/04/2018
 * Time: 14:49
 */
function check_cactus_default_tables($db){
    // This function creates the default tables as necessary

    $definition_table_name = GetCACTUSDefinitionTableName();

    $query = "DESCRIBE $definition_table_name";
    if(DoesTableExist($db,$definition_table_name)){
        //echo("$definition_table_name exists<BR>");
    }else {
        //echo "$definition_table_name doesn't exist in database $dbName\n";
        //
        // Create it
        $create_table_query = "
                --
                -- Table structure for table `$definition_table_name`
                --

                CREATE TABLE IF NOT EXISTS `$definition_table_name` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `group_short_name` varchar(10) NOT NULL,
                  `group_title` varchar(50) NOT NULL,
                  `default_module_prefix` varchar(5) NOT NULL,
                  `header_image_name` varchar(50) NOT NULL,
                  `running_title` varchar(50) NOT NULL,
                  `running_subtitle` varchar(50) NOT NULL,
                  `min_school_fte` float DEFAULT 0.1,
                  `manager_fullname` varchar(250) NOT NULL,
                  `show_core_themes` INT DEFAULT 1,
                  `show_contact_hours` INT DEFAULT 1,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
            ";

        $initial_data_query = "INSERT INTO `$definition_table_name` (`id`, `group_short_name`, `group_title`, `default_module_prefix`, `header_image_name`, `running_title`, `running_subtitle`, `manager_fullname`) VALUES
            (1, 'cactus', 'CACTU$', 'CIVE', 'cactus01_header.png', 'CACTUS', 'Costing Urban Sanitation', 'SET ME IN ADMIN');";

        try {
            $setup = $db->prepare($create_table_query);
            $setup->execute();

            $setup = $db->prepare($initial_data_query);
            $setup->execute();
        } catch (\PDOException $ex) {
            $this_function = __FUNCTION__;
            echo("An Error occured accessing the database in function: $this_function <BR>\n");
            echo("Unable to update data to the table $definition_table_name<BR>\n");
            echo(" Query = $query<BR> \n");
            echo(" Err message: " . $ex->getMessage() . "<BR>\n");
            exit();
        }
    }

    // Probably the staff table does not exist
    // The cactus_staff_names table is not currently used

    // Probably the cpi table does not exist
    $table_name = GetCACTUSCPITableName();
    if(DoesTableExist($db,$table_name)){
        //echo("$table_name exists<BR>");
    }else {
        create_cactus_cpi_table_structure($db,$table_name);
    }

    $table_name = GetCACTUSCPIDescsriptionTableName();
    if(DoesTableExist($db,$table_name)){
        //echo("$table_name exists<BR>");
    }else {
        create_cactus_cpi_desc_table_structure($db,$table_name);
    }

    $table_name = GetCACTUSPPPTableName();
    if(DoesTableExist($db,$table_name)){
        //echo("$table_name exists<BR>");
    }else {
        create_cactus_ppp_table_structure($db,$table_name);
    }

    $table_name = GetCACTUSPPPDescsriptionTableName();
    if(DoesTableExist($db,$table_name)){
        //echo("$table_name exists<BR>");
    }else {
        create_cactus_ppp_desc_table_structure($db,$table_name);
    }

    // The old base table
    $table_name = GetCACTUSBaseTableName();
    if(DoesTableExist($db,$table_name)){
        //echo("$table_name exists<BR>");
    }else {
        create_cactus_base_table_structure($db,$table_name);
    }


    // Master table OLD
    $table_name = GetCACTUSMasterDataOldTableName();
    if(DoesTableExist($db,$table_name)){
        //echo("$table_name exists<BR>");
    }else {
        create_cactus_master_data_old_table_structure($db,$table_name);
    }
    // Raw data table OLD
    $table_name = GetCACTUSRawDataOldTableName();
    if(DoesTableExist($db,$table_name)){
        //echo("$table_name exists<BR>");
    }else {
        create_cactus_raw_data_old_table_structure($db,$table_name);
    }

    // Master table NEW
    $table_name = GetCACTUSMasterStudyCityDataTableName();
    if(DoesTableExist($db,$table_name)){
        //echo("$table_name exists<BR>");
    }else {
        create_cactus_master_study_city_data_table_structure($db,$table_name);
    }
    $table_name = GetCACTUSMasterDataTableName();
    if(DoesTableExist($db,$table_name)){
        //echo("$table_name exists<BR>");
    }else {
        create_cactus_master_data_table_structure($db,$table_name);
    }
    // Raw data table OLD
    $table_name = GetCACTUSRawDataTableName();
    if(DoesTableExist($db,$table_name)){
        //echo("$table_name exists<BR>");
    }else {
        create_cactus_raw_data_table_structure($db,$table_name);
    }

    // Total cost data table
    $table_name = GetCACTUSTotalCostDataTableName();
    if(DoesTableExist($db,$table_name)){
        //echo("$table_name exists<BR>");
    }else {
        create_cactus_total_cost_data_table_structure($db,$table_name);
    }
    // Annualised cost data table
    $table_name = GetCACTUSAnnualisedCostDataTableName();
    if(DoesTableExist($db,$table_name)){
        //echo("$table_name exists<BR>");
    }else {
        create_cactus_annualised_cost_data_table_structure($db,$table_name);
    }
    // Raw data table
    $table_name = GetCACTUSRawDataOldTableName();
    if(DoesTableExist($db,$table_name)){
        //echo("$table_name exists<BR>");
    }else {
        create_cactus_raw_data_old_table_structure($db,$table_name);
    }
    // Cost type data table
    $table_name = GetCACTUSCostTypeDataTableName();
    if(DoesTableExist($db,$table_name)){
        //echo("$table_name exists<BR>");
    }else {
        create_cactus_cost_type_data_table_structure($db,$table_name);
    }
}

function GetCACTUSDefinitionTableName(){

    $table_name = "cactus_definition";

    return $table_name;
}

function delete_all_cactus_tables($db){
    $tables_list = "";
    $query = "SHOW TABLES LIKE 'cactus_%'";
    $res = perform_select_query($db, $query);

    $rows = $res->fetchAll();

    $count = 0;
    foreach($rows as $row){
        if($count > 0){
            $tables_list .= ", " . $row[0];
        }else{
            $tables_list .= " " . $row[0];
        }
        $count++;
    }

    $query = "DROP TABLE IF EXISTS $tables_list";
    //echo($query);
    try{
        $db->query($query);
    }catch (PDOException $ex) {
        //echo("Unable to create table. Query: $query <BR>\n");
        $err_msg = $ex->getMessage();
        echo($err_msg . "<BR>\n");
    }
}

function create_cactus_base_table_structure($db, &$table_name){

    $table_name = GetCACTUSBaseTableName();


    // All the basic data from which to draw extract and draaw charts

    $query = <<<SQL
    CREATE TABLE IF NOT EXISTS `$table_name` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `country` char(100) NOT NULL,
      `country_code` char(5) NOT NULL,
      `city` char(100) NOT NULL,
      `element` char(100) NOT NULL,
      `system` char(100) NOT NULL,
      `component` char(100) NOT NULL,
      `case_desc` char(100) NOT NULL,
      `date` char(100) DEFAULT NULL,
      `php_date` DATE DEFAULT NULL,
      `data_collector` char(100) DEFAULT NULL,
      `notes` char(255) DEFAULT NULL,
      `url` char(100) DEFAULT NULL,
      `description` char(100) DEFAULT NULL,
      `capex_opex` char(100) NOT NULL,
      `min` float DEFAULT NULL,
      `mean` float DEFAULT NULL,
      `max` float DEFAULT NULL,
      `one_value` float DEFAULT NULL,
      `um` char(100) DEFAULT NULL,
      `currency` char(5) DEFAULT NULL,
      `year` int(11) NOT NULL,
      `us_2016` float DEFAULT NULL,
      `tach_assumption` char(100) DEFAULT NULL,
      `lifetime` float DEFAULT NULL,
      `tach` float DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
SQL;

    //echo("table name: $table_name<BR>");
    //echo("query: $query<BR>");
    try{
        $db->query($query);
    }catch (PDOException $ex) {
        echo("Unable to create table. Query: $query <BR>\n");
        $err_msg = $ex->getMessage();
        echo($err_msg . "<BR>\n");
    }
}
function GetCACTUSBaseTableName(){

    $table_name = "cactus_base_summary";

    return $table_name;
}


function create_cactus_cpi_table_structure($db, &$table_name){

    $table_name = GetCACTUSCPITableName();


    // Similar to the modules table

    $query = <<<SQL
    CREATE TABLE IF NOT EXISTS `$table_name` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `country` char(100) NOT NULL,
      `country_code` char(5) NOT NULL,
      `year` int(11) NOT NULL,
      `cpi` float DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
SQL;

    //echo("table name: $table_name<BR>");
    //echo("query: $query<BR>");
    try{
        $db->query($query);
    }catch (PDOException $ex) {
        echo("Unable to create table. Query: $query <BR>\n");
        $err_msg = $ex->getMessage();
        echo($err_msg . "<BR>\n");
    }
}
function GetCACTUSCPITableName(){

    $table_name = "cactus_cpi";

    return $table_name;
}

function create_cactus_cpi_desc_table_structure($db, &$table_name){

    $table_name = GetCACTUSCPIDescsriptionTableName();

    //

    $query = <<<SQL
    CREATE TABLE IF NOT EXISTS `$table_name` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `source_url` char(255) DEFAULT NULL,
      `source_filename` char(255) DEFAULT NULL,
      `year_begin` int(11) NOT NULL,
      `year_end` int(11) NOT NULL,
      `hundred_year` int(11) DEFAULT NULL,
      `notes` TEXT, 
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
SQL;

    try{
        $db->query($query);
    }catch (PDOException $ex) {
        echo("Unable to create table. Query: $query <BR>\n");
        $err_msg = $ex->getMessage();
        echo($err_msg . "<BR>\n");
    }
}
function GetCACTUSCPIDescsriptionTableName(){

    $table_name = "cactus_cpi_description";

    return $table_name;
}

function create_cactus_ppp_table_structure($db, &$table_name){

    $table_name = GetCACTUSPPPTableName();

    // Similar to the modules table

    $query = <<<SQL
    CREATE TABLE IF NOT EXISTS `$table_name` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `country` char(100) NOT NULL,
      `country_code` char(5) NOT NULL,
      `year` int(11) NOT NULL,
      `ppp` float DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
SQL;

    //echo("table name: $table_name<BR>");
    //echo("query: $query<BR>");
    try{
        $db->query($query);
    }catch (PDOException $ex) {
        echo("Unable to create table. Query: $query <BR>\n");
        $err_msg = $ex->getMessage();
        echo($err_msg . "<BR>\n");
    }
}
function GetCACTUSPPPTableName(){

    $table_name = "cactus_ppp";

    return $table_name;
}

function create_cactus_ppp_desc_table_structure($db, &$table_name){

    $table_name = GetCACTUSPPPDescsriptionTableName();

    // Similar to the modules table

    $query = <<<SQL
    CREATE TABLE IF NOT EXISTS `$table_name` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `source_url` char(255) DEFAULT NULL,
      `source_filename` char(255) DEFAULT NULL,
      `year_begin` int(11) NOT NULL,
      `year_end` int(11) NOT NULL,
      `notes` TEXT, 
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
SQL;

    //echo("table name: $table_name<BR>");
    //echo("query: $query<BR>");
    try{
        $db->query($query);
    }catch (PDOException $ex) {
        echo("Unable to create table. Query: $query <BR>\n");
        $err_msg = $ex->getMessage();
        echo($err_msg . "<BR>\n");
    }
}
function GetCACTUSPPPDescsriptionTableName(){

    $table_name = "cactus_ppp_description";

    return $table_name;
}

function create_cactus_master_data_old_table_structure($db, &$table_name){

    $table_name = GetCACTUSMasterDataOldTableName();

    // Similar to the otehr tables

    $query = <<<SQL
        CREATE TABLE IF NOT EXISTS `$table_name` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `study_id` INT DEFAULT NULL,
        `country` CHAR(255) DEFAULT NULL,
        `country_code` CHAR(255) DEFAULT NULL,
        `city` CHAR(255) DEFAULT NULL,
        `lat` FLOAT DEFAULT 0,
        `lon` FLOAT DEFAULT 0,
        `element` CHAR(255) DEFAULT NULL,
        `system` CHAR(255) DEFAULT NULL,
        `component` CHAR(255) DEFAULT NULL,
        `num_components` INT DEFAULT 0,
        `case_desc` CHAR(255) DEFAULT NULL,
        `report_name` CHAR(255) DEFAULT NULL,
        `data_collector` CHAR(255) DEFAULT NULL,
        `year` INT DEFAULT NULL,
        `php_date` DATE DEFAULT NULL,
        `date` CHAR(255) DEFAULT NULL,
        `population` INT DEFAULT NULL,
        `region` CHAR(255) DEFAULT NULL,
        `pop_density` FLOAT DEFAULT 0,
        `topography` CHAR(255) DEFAULT NULL,
        `num_hh` INT DEFAULT 0,
        `num_people` INT DEFAULT 0,
        `tach` FLOAT DEFAULT 0,
        `tacc` FLOAT DEFAULT 0,
        `notes_file` CHAR(255) DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
SQL;

    //echo("table name: $table_name<BR>");
    //echo("query: $query<BR>");
    try{
        $db->query($query);
    }catch (PDOException $ex) {
        echo("Unable to create table. Query: $query <BR>\n");
        $err_msg = $ex->getMessage();
        echo($err_msg . "<BR>\n");
    }
}
function GetCACTUSMasterDataOldTableName(){

    $table_name = "cactus_master_data_old";

    return $table_name;
}

function create_cactus_raw_data_old_table_structure($db, &$table_name){

    $table_name = GetCACTUSRawDataOldTableName();

    // Similar to the otehr tables

    $query = <<<SQL
    CREATE TABLE IF NOT EXISTS `$table_name` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `study_id` INT DEFAULT NULL,
        `study_block_index` INT DEFAULT NULL,
        `datapoint_id` INT DEFAULT NULL,
        `country` CHAR(255) DEFAULT NULL,
        `city` CHAR(255) DEFAULT NULL,
        `year` INT DEFAULT NULL,
        `date` DATE DEFAULT NULL,
        `element` CHAR(255) DEFAULT NULL,
        `system` CHAR(255) DEFAULT NULL,
        `component` CHAR(255) DEFAULT NULL,
        `data_source` CHAR(255) DEFAULT NULL,
        `case_desc` CHAR(255) DEFAULT NULL,
        `resource_service` CHAR(255) DEFAULT NULL,
        `category_1` CHAR(255) DEFAULT NULL,
        `category_2` CHAR(255) DEFAULT NULL,
        `category_3` CHAR(255) DEFAULT NULL,
        `item_desc` CHAR(255) DEFAULT NULL,
        `um` CHAR(255) DEFAULT NULL,
        `um_desc` CHAR(255) DEFAULT NULL,
        `assumptions` TEXT DEFAULT NULL,
        `min_count` FLOAT DEFAULT 0,
        `avg_count` FLOAT DEFAULT 0,
        `max_count` FLOAT DEFAULT 0,
        `source_count_desc` CHAR(255) DEFAULT NULL,
        `one_value_count` FLOAT DEFAULT 0,
        `emptying_pc` FLOAT DEFAULT 0,
        `transport_pc` FLOAT DEFAULT 0,
        `interim_storage_pc` FLOAT DEFAULT NULL,
        `source_pc_desc` CHAR(255) DEFAULT NULL,
        `cost_type` CHAR(255) DEFAULT NULL,
        `lifetime` FLOAT DEFAULT 0,
        `min_cost` FLOAT DEFAULT 0,
        `avg_cost` FLOAT DEFAULT 0,
        `max_cost` FLOAT DEFAULT 0,
        `year_cost` FLOAT DEFAULT 0,
        `currency` CHAR(255) DEFAULT NULL,
        `source_cost_desc` CHAR(255) DEFAULT NULL,
        `one_value_cost` FLOAT DEFAULT 0,
        `cost_adjusted` FLOAT DEFAULT 0,
        `annualised_value` FLOAT DEFAULT 0, 
        `discount_rate` FLOAT DEFAULT 0, 
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
SQL;

    //echo("table name: $table_name<BR>");
    //echo("query: $query<BR>");
    try{
        $db->query($query);
    }catch (PDOException $ex) {
        echo("Unable to create table. Query: $query <BR>\n");
        $err_msg = $ex->getMessage();
        echo($err_msg . "<BR>\n");
    }
}
function GetCACTUSRawDataOldTableName(){

    $table_name = "cactus_raw_data_old";

    return $table_name;
}

function create_cactus_master_study_city_data_table_structure($db, &$table_name){

    $table_name = GetCACTUSMasterStudyCityDataTableName();

    // Similar to the otehr tables

    $query = <<<SQL
    CREATE TABLE IF NOT EXISTS `$table_name` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `study_id` INT DEFAULT NULL,
        `datapoint_id` INT DEFAULT NULL,

        `country` CHAR(255) DEFAULT NULL,
        `country_code` CHAR(255) DEFAULT NULL,
        `city` CHAR(255) DEFAULT NULL,
        `lat` FLOAT DEFAULT 0,
        `lon` FLOAT DEFAULT 0,
        `system` CHAR(255) DEFAULT NULL,
        `element` CHAR(255) DEFAULT NULL,
        `component` CHAR(255) DEFAULT NULL,
        `num_components` INT DEFAULT 0,
        
        `data_source` CHAR(255) DEFAULT NULL,
        `source` CHAR(255) DEFAULT NULL,
        `datapoint_name` CHAR(255) DEFAULT NULL,
        `case_desc` CHAR(255) DEFAULT NULL,
        `report_name` CHAR(255) DEFAULT NULL,
        `data_collector` CHAR(255) DEFAULT NULL,
        `date` CHAR(255) DEFAULT NULL,
        `php_date` DATE DEFAULT NULL,
        
        `city_population` INT DEFAULT 0,
        `city_population_density` FLOAT DEFAULT 0,
        `year_of_population` INT DEFAULT 0,
        `region` CHAR(255) DEFAULT NULL,
        `topography` CHAR(255) DEFAULT NULL,
        
        `num_hh_served` FLOAT DEFAULT 0,
        `num_people_served` FLOAT DEFAULT 0,
        `num_people_per_hh` FLOAT DEFAULT 0,
        `tach` FLOAT DEFAULT 0,
        `tacc` FLOAT DEFAULT 0,
        `notes_file` CHAR(255) DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
SQL;

    //echo("table name: $table_name<BR>");
    //echo("query: $query<BR>");
    try{
        $db->query($query);
    }catch (PDOException $ex) {
        echo("Unable to create table. Query: $query <BR>\n");
        $err_msg = $ex->getMessage();
        echo($err_msg . "<BR>\n");
    }
}
function GetCACTUSMasterStudyCityDataTableName(){

    $table_name = "cactus_master_study_city_data";

    return $table_name;
}

function create_cactus_master_data_table_structure($db, &$table_name){

    $table_name = GetCACTUSMasterDataTableName();

    // Similar to the otehr tables

    $query = <<<SQL
    CREATE TABLE IF NOT EXISTS `$table_name` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `study_id` INT DEFAULT NULL,
        `datapoint_id` INT DEFAULT NULL,

        `country` CHAR(255) DEFAULT NULL,
        `country_code` CHAR(255) DEFAULT NULL,
        `city` CHAR(255) DEFAULT NULL,
        `lat` FLOAT DEFAULT 0,
        `lon` FLOAT DEFAULT 0,
        `system` CHAR(255) DEFAULT NULL,
        `element` CHAR(255) DEFAULT NULL,
        `component` CHAR(255) DEFAULT NULL,
        `num_components` INT DEFAULT 0,
        
        `data_source` CHAR(255) DEFAULT NULL,
        `source` CHAR(255) DEFAULT NULL,
        `datapoint_name` CHAR(255) DEFAULT NULL,
        `case_desc` CHAR(255) DEFAULT NULL,
        `report_name` CHAR(255) DEFAULT NULL,
        `data_collector` CHAR(255) DEFAULT NULL,
        `date` CHAR(255) DEFAULT NULL,
        `php_date` DATE DEFAULT NULL,
        
        `city_population` INT DEFAULT 0,
        `city_population_density` FLOAT DEFAULT 0,
        `year_of_population` INT DEFAULT 0,
        `region` CHAR(255) DEFAULT NULL,
        `topography` CHAR(255) DEFAULT NULL,
        
        `num_hh_served` FLOAT DEFAULT 0,
        `num_people_served` FLOAT DEFAULT 0,
        `num_people_per_hh` FLOAT DEFAULT 0,
        `tach` FLOAT DEFAULT 0,
        `tacc` FLOAT DEFAULT 0,
        `notes_file` CHAR(255) DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
SQL;

    //echo("table name: $table_name<BR>");
    //echo("query: $query<BR>");
    try{
        $db->query($query);
    }catch (PDOException $ex) {
        echo("Unable to create table. Query: $query <BR>\n");
        $err_msg = $ex->getMessage();
        echo($err_msg . "<BR>\n");
    }
}
function GetCACTUSMasterDataTableName(){

    $table_name = "cactus_master_data";

    return $table_name;
}

function create_cactus_raw_data_table_structure($db, &$table_name){

    $table_name = GetCACTUSRawDataTableName();

    // Similar to the otehr tables

    $query = <<<SQL
    CREATE TABLE IF NOT EXISTS `$table_name` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `study_id` INT DEFAULT NULL,
        `study_block_index` INT DEFAULT NULL,
        `datapoint_id` INT DEFAULT NULL,
        
        `country` CHAR(255) DEFAULT NULL,
        `country_code` CHAR(255) DEFAULT NULL,
        `city` CHAR(255) DEFAULT NULL,
        `date` CHAR(255) DEFAULT NULL,
        `php_date` DATE DEFAULT NULL,
        
        `system` CHAR(255) DEFAULT NULL,
        `element` CHAR(255) DEFAULT NULL,
        `component` CHAR(255) DEFAULT NULL,
        `case_desc` CHAR(255) DEFAULT NULL,
        `data_source` CHAR(255) DEFAULT NULL,
        
        `resource_service` CHAR(255) DEFAULT NULL,
        `cost_type_1` CHAR(255) DEFAULT NULL,
        `cost_type_2` CHAR(255) DEFAULT NULL,
        `category_1` CHAR(255) DEFAULT NULL,
        `category_2` CHAR(255) DEFAULT NULL,
        `category_3` CHAR(255) DEFAULT NULL,
        `item_desc` CHAR(255) DEFAULT NULL,
        `um` CHAR(255) DEFAULT NULL,
        `um_desc` CHAR(255) DEFAULT NULL,
        `assumptions` TEXT DEFAULT NULL,
        
        `service_category` CHAR(255) DEFAULT NULL,
    
        `lifetime` FLOAT DEFAULT 0,
        `year_cost` INT DEFAULT NULL,
        `currency` CHAR(255) DEFAULT NULL,

        `source` CHAR(255) DEFAULT NULL,

        `one_value_cost` FLOAT DEFAULT 0,
        `cost_adjusted` FLOAT DEFAULT 0,
        `annualised_value` FLOAT DEFAULT 0, 
        `discount_rate` FLOAT DEFAULT 0, 
        
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
SQL;

    //echo("table name: $table_name<BR>");
    //echo("query: $query<BR>");
    try{
        $db->query($query);
    }catch (PDOException $ex) {
        echo("Unable to create table. Query: $query <BR>\n");
        $err_msg = $ex->getMessage();
        echo($err_msg . "<BR>\n");
    }
}
function GetCACTUSRawDataTableName(){

    $table_name = "cactus_raw_data";

    return $table_name;
}

function create_cactus_total_cost_data_table_structure($db, &$table_name){

    $table_name = GetCACTUSTotalCostDataTableName();

    // Similar to the other tables

    $query = <<<SQL
    CREATE TABLE IF NOT EXISTS `$table_name` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `study_id` INT DEFAULT NULL,
        `datapoint_id` INT DEFAULT NULL,
        `capex_land` FLOAT DEFAULT 0,
        `capex_infrastructure` FLOAT DEFAULT 0,
        `capex_equipment` FLOAT DEFAULT 0,
        `capex_extraordinary` FLOAT DEFAULT 0,
        `capex_staff_develop` FLOAT DEFAULT 0,
        `capex_other` FLOAT DEFAULT 0,
        `capex_administration` FLOAT DEFAULT 0,
        `capex_finance` FLOAT DEFAULT 0,
        `capex_taxes` FLOAT DEFAULT 0,
        `opex_land` FLOAT DEFAULT 0,
        `opex_infrastructure` FLOAT DEFAULT 0,
        `opex_equipment` FLOAT DEFAULT 0,
        `opex_staff` FLOAT DEFAULT 0,
        `opex_staff_develop` FLOAT DEFAULT 0,
        `opex_consumables_utilities` FLOAT DEFAULT 0,
        `opex_consumables_fuel` FLOAT DEFAULT 0,
        `opex_consumables_chemicals` FLOAT DEFAULT 0,
        `opex_consumables_other` FLOAT DEFAULT 0,
        `opex_consumables_service_consultant` FLOAT DEFAULT 0,
        `opex_consumables_service_legal` FLOAT DEFAULT 0,
        `opex_consumables_service_insurance` FLOAT DEFAULT 0,
        `opex_consumables_service_maint` FLOAT DEFAULT 0,
        `opex_consumables_service_other` FLOAT DEFAULT 0,
        `opex_other` FLOAT DEFAULT 0,
        `opex_administration` FLOAT DEFAULT 0,
        `opex_finance` FLOAT DEFAULT 0,
        `opex_taxes` FLOAT DEFAULT 0,
        PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
SQL;

    //echo("table name: $table_name<BR>");
    //echo("query: $query<BR>");
    try{
        $db->query($query);
    }catch (PDOException $ex) {
        echo("Unable to create table. Query: $query <BR>\n");
        $err_msg = $ex->getMessage();
        echo($err_msg . "<BR>\n");
    }
}
function GetCACTUSTotalCostDataTableName(){

    $table_name = "cactus_total_cost_data";

    return $table_name;
}

function create_cactus_annualised_cost_data_table_structure($db, &$table_name){

    $table_name = GetCACTUSAnnualisedCostDataTableName();

    // Similar to the other tables

    $query = <<<SQL
    CREATE TABLE IF NOT EXISTS `$table_name` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `study_id` INT DEFAULT NULL,
        `datapoint_id` INT DEFAULT NULL,
        `capex_land` FLOAT DEFAULT 0,
        `capex_infrastructure` FLOAT DEFAULT 0,
        `capex_equipment` FLOAT DEFAULT 0,
        `capex_extraordinary` FLOAT DEFAULT 0,
        `capex_staff_develop` FLOAT DEFAULT 0,
        `capex_other` FLOAT DEFAULT 0,
        `capex_administration` FLOAT DEFAULT 0,
        `capex_finance` FLOAT DEFAULT 0,
        `capex_taxes` FLOAT DEFAULT 0,
        `opex_land` FLOAT DEFAULT 0,
        `opex_infrastructure` FLOAT DEFAULT 0,
        `opex_equipment` FLOAT DEFAULT 0,
        `opex_staff` FLOAT DEFAULT 0,
        `opex_staff_develop` FLOAT DEFAULT 0,
        `opex_consumables_utilities` FLOAT DEFAULT 0,
        `opex_consumables_fuel` FLOAT DEFAULT 0,
        `opex_consumables_chemicals` FLOAT DEFAULT 0,
        `opex_consumables_other` FLOAT DEFAULT 0,
        `opex_consumables_service_consultant` FLOAT DEFAULT 0,
        `opex_consumables_service_legal` FLOAT DEFAULT 0,
        `opex_consumables_service_insurance` FLOAT DEFAULT 0,
        `opex_consumables_service_maint` FLOAT DEFAULT 0,
        `opex_consumables_service_other` FLOAT DEFAULT 0,
        `opex_other` FLOAT DEFAULT 0,
        `opex_administration` FLOAT DEFAULT 0,
        `opex_finance` FLOAT DEFAULT 0,
        `opex_taxes` FLOAT DEFAULT 0,
        PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
SQL;

    //echo("table name: $table_name<BR>");
    //echo("query: $query<BR>");
    try{
        $db->query($query);
    }catch (PDOException $ex) {
        echo("Unable to create table. Query: $query <BR>\n");
        $err_msg = $ex->getMessage();
        echo($err_msg . "<BR>\n");
    }
}
function GetCACTUSAnnualisedCostDataTableName(){

    $table_name = "cactus_annualised_cost_data";

    return $table_name;
}

function create_cactus_cost_type_data_table_structure($db, &$table_name){

    $table_name = GetCACTUSCostTypeDataTableName();

    // Similar to the other tables

    $query = <<<SQL
    CREATE TABLE IF NOT EXISTS `$table_name` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `datapoint_id` INT DEFAULT NULL,
        `capex_direct_variable` FLOAT DEFAULT 0,
        `capex_direct_fixed` FLOAT DEFAULT 0,
        `capex_indirect_variable` FLOAT DEFAULT 0,
        `capex_indirect_fixed` FLOAT DEFAULT 0,
        `capex_infrastructure` FLOAT DEFAULT 0,
        `opex_direct_variable` FLOAT DEFAULT 0,
        `opex_direct_fixed` FLOAT DEFAULT 0,
        `opex_indirect_variable` FLOAT DEFAULT 0,
        `opex_indirect_fixed` FLOAT DEFAULT 0,
        `total_direct_variable` FLOAT DEFAULT 0,
        `total_direct_fixed` FLOAT DEFAULT 0,
        `total_indirect_variable` FLOAT DEFAULT 0,
        `total_indirect_fixed` FLOAT DEFAULT 0,
        `total` FLOAT DEFAULT 0,
        PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
SQL;

    //echo("table name: $table_name<BR>");
    //echo("query: $query<BR>");
    try{
        $db->query($query);
    }catch (PDOException $ex) {
        echo("Unable to create table. Query: $query <BR>\n");
        $err_msg = $ex->getMessage();
        echo($err_msg . "<BR>\n");
    }
}
function GetCACTUSCostTypeDataTableName(){

    $table_name = "cactus_cost_type_data";

    return $table_name;
}