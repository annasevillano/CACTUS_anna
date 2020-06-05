<?php

/* Make connection to database */
try{
    $db = new PDO("mysql:host=$hostname; dbname=$dbName; charset=utf8", $dbusername, $password);
    //echo("host name: $hostname<BR>\n");
    //echo("database name: $dbName<BR>\n");
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    check_cactus_default_tables($db);
} catch (PDOException $ex) {
    $this_file = __FILE__;
    $this_line = __LINE__;
    echo("An Error occured connecting to the database in file: $this_file (near line $this_line)<BR>\n");
    echo("host name: $hostname<BR>\n");
    echo("database name: $dbName<BR>\n");
    echo(" Err message: " . $ex->getMessage() . "<BR>\n");
    exit();
}


?>
