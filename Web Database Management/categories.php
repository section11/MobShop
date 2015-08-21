<?php
    $host="localhost";
    $username="dragomi1_eshop";
    $password="scoaladevalori1";
    $db_name="dragomi1_eshop";

    $con = mysql_connect($host, $username, $password) or die ("cannot connect");
    mysql_select_db($db_name, $con) or die ("cannot select DB");
    $sql = "SELECT categories.category_name,
                   categories.category_url,
                   subcategories.subcategory_name,
                   subcategories.subcategory_url

        FROM categories
        INNER JOIN subcategories
                        ON categories.categories_id=subcategories.categories_id";
                        
    $result = mysql_query($sql);
    $json = array();

    if(mysql_num_rows($result)){
        while( $row = mysql_fetch_assoc( $result ) ){

            $json[] = $row;
        }
    }

    mysql_close($con);
    echo json_encode($json);
?>
