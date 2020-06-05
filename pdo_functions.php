<?php
/**
 * Created by PhpStorm.
 * User: test
 * Date: 20/05/2019
 * Time: 13:16
 */


function DoesTableExist($db, $table)
{
    try {
        $query = "DESCRIBE $table";
        $db->query($query);

        $result = true;
    } catch (\PDOException $ex) {
        //$this_function = __FUNCTION__;
        //echo "An Error occured accessing the database in function: $this_function <BR>\n";
        //echo(" Query = $query<BR> \n");
        //echo(" Err message: " . $ex->getMessage() . "<BR>\n");
        //var_dump($db);
        //exit();
        $result = false;
    }

    //echo($result . '<BR>');
    return $result;
}

function clear_table($db, $table_name){
    $query = "TRUNCATE TABLE $table_name";
    try{
        $db->query($query);
    }catch (PDOException $ex) {
        echo("Unable to perform query: $query <BR>\n");
        $err_msg = $ex->getMessage();
        echo($err_msg . "<BR>\n");
    }
}
function perform_select_query($db, $query){
    try{
        $result = $db->query($query);
    }catch (PDOException $ex) {
        echo("Unable to perform query: $query <BR>\n");
        $err_msg = $ex->getMessage();
        echo($err_msg . "<BR>\n");
        $result = $err_msg;
    }
    return $result;
}
function perform_query($db, $query){
    try{
        $db->query($query);
    }catch (PDOException $ex) {
        echo("Unable to perform query: $query <BR>\n");
        $err_msg = $ex->getMessage();
        echo($err_msg . "<BR>\n");
    }
}
//-------------------------------------------------------------------------
// PDO prepared functions
// These build tehe query and prepare and execute it with the data provided
//-------------------------------------------------------------------------
function perform_update_prepared_query($db, $table, $data, $where_data){
    // $data is an associative array dbcolumn names and the data
    // [ 'my_col_name' => my_data ];
    // $where_data is the same for the WHERE clause. concatanated as AND
    /*e.g. Data abnd where_data arrays
     * $data =array(
                $CXtotal => $marktot,
                $Ctotal => $mark_total_all_cats,
                $CXFeedback => $feedback_text
            );
       $where_data =array(
                'sid' => $sid
            );
     */
    $setStr = "";
    foreach( $data as $col_name => $col_value)
    {
        $setStr .= "`$col_name` = :$col_name,";
    }
    $setStr = rtrim($setStr, ",");

    $all_data = $data;
    $where_keys = array_keys($where_data);
    $setWhereStr = "";
    for($i = 0; $i < sizeof($where_keys); $i++)
    {
        $col_name = $where_keys[$i];
        $col_value = $where_data[$col_name];
        if($i < sizeof($where_keys) - 1){
            $setWhereStr .= "`$col_name` = :$col_name AND ";
        }else{
            // The last one , none AND
            $setWhereStr .= "`$col_name` = :$col_name ";
        }
        $all_data[$col_name] = $col_value;
    }

    $query = "UPDATE $table SET $setStr WHERE  $setWhereStr";
    //echo($query ."<BR>\n");
    //print_r2($data);
    //print_r2($where_data);
    try{
        $results = $db->prepare($query);
        $results->execute($all_data);

    }catch (PDOException $ex) {
        echo("Unable to perform query: $query <BR>\n");
        $err_msg = $ex->getMessage();
        echo($err_msg . "<BR>\n");
        $results = $err_msg;
    }
    return $results;
}
function perform_insert_prepared_query($db, $table, $data){
    // $data is an associative array dbcolumn names and the data
    // [ 'my_col_name' => my_data ];
    // e.g. Data array:
    /*
     $data =array(
                $CXtotal => $marktot,
                $Ctotal => $mark_total_all_cats,
                $CXFeedback => $feedback_text,
                'sid' => $sid
            );
     */

    $setStr = "";
    foreach( $data as $col_name => $col_value)
    {
        $setStr .= "`$col_name` = :$col_name,";
    }
    $setStr = rtrim($setStr, ",");

    $query = "INSERT $table SET $setStr";
    //echo($query ."<BR>\n");
    //print_r2($data);
    try{
        $results = $db->prepare($query);
        $results->execute($data);
    }catch (PDOException $ex) {
        echo("Unable to perform query: $query <BR>\n");
        $err_msg = $ex->getMessage();
        echo($err_msg . "<BR>\n");
        $results = $err_msg;
    }
    return $results;
}

function perform_select_prepared_query($db, $table, $where_data, $extra){
    // $where_data is an associative array dbcolumn names and the data
    // [ 'my_col_name' => my_data ];
    // concatanated as AND
    // $extra is something tagged on the end , e..g ORDER BY , LIMIT etc

    $where_keys = array_keys($where_data);
    $setWhereStr = "";
    for($i = 0; $i < sizeof($where_keys); $i++)
    {
        $col_name = $where_keys[$i];
        $col_value = $where_data[$col_name];
        if($i < sizeof($where_keys) - 1){
            $setWhereStr .= "`$col_name` = :$col_name AND ";
        }else{
            // The last one , none AND
            $setWhereStr .= "`$col_name` = :$col_name ";
        }
        $all_data[$col_name] = $col_value;
    }

    $query = "SELECT * FROM $table WHERE $setWhereStr $extra";
    //echo($query ."<BR>\n");
    //print_r2($where_data);
    try{
        $results = $db->prepare($query);
        $results->execute($all_data);
    }catch (PDOException $ex) {
        echo("Unable to perform query: $query <BR>\n");
        $err_msg = $ex->getMessage();
        echo($err_msg . "<BR>\n");
        $results = $err_msg;
    }
    return $results;
}


