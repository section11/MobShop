<?php
    $host="localhost";
    $username="dragomi1_eshop";
    $password="scoaladevalori1";
    $db_name="dragomi1_eshop";

    $con = mysql_connect($host, $username, $password) or die ("cannot connect");
    mysql_select_db($db_name, $con) or die ("cannot select DB");
    $sql = "SELECT products.name,
                   products.description,
                   products.price,
                   products.sale,
                   products.discount,
                   products.quantity,

                   categories.category_name,

                   subcategories.subcategory_name,

                   photos.url

            FROM products

            INNER JOIN categories
                ON products.categories_id=categories.categories_id

            INNER JOIN subcategories
                ON products.subcategories_id=subcategories.subcategories_id

            INNER JOIN photos
                ON products.products_id=photos.products_id";

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

