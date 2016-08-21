<?php
    require('includes/application_top.php');
    require(DIR_WS_INCLUDES . 'template_top.php');
    /**
     * query user information with filter by ID (int)$_GET['info_id']
     **/
    $query = tep_db_query("
        SELECT
            company_name,
            customers_website,
            photo
        FROM
            customers
        WHERE
            user_type = 'agency'
              AND
            customers_id = ". (int)$_GET['info_id'] . "
        LIMIT 1
    ");
    $customer_info = tep_db_fetch_array($query);
    var_dump($customer_info);
?>

<?php
    require(DIR_WS_INCLUDES . 'template_bottom.php');
    require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
