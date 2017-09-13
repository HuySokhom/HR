<?php
    require('includes/application_top.php');
    require(DIR_WS_INCLUDES . 'template_top.php');
    /**
     * query user information with filter by ID (int)$_GET['info_id']
     **/
    $query = tep_db_query("
        SELECT
            c.company_name,
            c.customers_id,
            c.user_name,
            l.name as location_name,
            c.customers_gender,
            c.customers_website,
            c.user_type,
            c.skill_title,
            c.upload_cv,
            c.detail,
            c.customers_telephone,
            c.customers_email_address,
            c.customers_address,
            c.photo,
            c.experience,
            c.upload_cv,
            c.working_history,
            c.summary,
            DATE_FORMAT(c.create_date, '%d/%M/%Y') as create_date
        FROM
            customers c, location l
        WHERE
            c.customers_id = ". (int)$_GET['info_id'] . "
                and
            c.customers_location = l.id
                
        LIMIT 1
    ");
    $customer_info = tep_db_fetch_array($query);
    $countRow = tep_db_num_rows($query);
?>
<br>
<div class="container">
<?php
    if($countRow > 0) {

        if ($customer_info['user_type'] == 'normal') {
            ?>
            <div class="row">
                <div class="col-md-8 col-sm-7">
                    <div class="resume">
                        <div class="col-md-12">
                            <div class="col-md-3">
                                <br/>
                                <img src="<?php echo $customer_info['photo']; ?>" alt=""
                                    class="img-thumbnail"/>
                            </div>
                            <!-- /.resume-main-image -->
                            <div class="col-md-9">
                                <h2>
                                    <?php echo $customer_info['company_name']; ?>
                                    <span class="resume-main-verified">
                                <i class="fa fa-check"></i>
                            </span>
                                </h2>
                                <h3>
                                    <?php echo $customer_info['skill_title']; ?>
                                </h3>

                                <p class="resume-main-contacts">
                                    <?php echo $customer_info['customers_address']; ?>
                                    <br>
                                    Email: <a href="mailto:<?php echo $customer_info['customers_email_address']; ?>">
                                        <?php echo $customer_info['customers_email_address']; ?>
                                    </a>
                                    - Tel: <a href="tel:<?php echo $customer_info['customers_telephone']; ?>">
                                        <?php echo $customer_info['customers_telephone']; ?>
                                    </a>
                                </p>
                                <br/>
                                <!-- /.resume-main-contact -->
                                <!-- Go to www.addthis.com/dashboard to customize your tools -->
                                <div class="addthis_native_toolbox"></div>
                                <div class="resume-main-actions">
                                    <?php
                                        if (!tep_session_is_registered('customer_id')) {
                                            echo '
                                                <button disabled class="btn btn-secondary">
                                                    <i class="fa fa-download"></i>
                                                    <small>Login to download cv</small>
                                                </button>
                                            ';
                                        }else{
                                            echo '
                                            <a href="' . $customer_info['upload_cv'] . '" class="btn btn-secondary" download>
                                                <i class="fa fa-download"></i>
                                                Download CV
                                            </a>
                                        ';
                                        }
                                    ?>
                                </div>
                                <br/>
                                <!-- /.resume-main-actions -->
                            </div>

                            <!-- /.resume-main-content -->
                        </div>
                        <div class="clearfix"></div>
                        <!-- /.resume-main -->

                        <div class="resume-chapter">
                            <div class="resume-chapter-inner">
                                <div class="resume-chapter-title">
                                    <h2 class="mb40">Summary</h2>
                                    <?php echo $customer_info['summary']; ?>
                                </div><!-- /.resume-chapter-title -->
                            </div><!-- /.resume-chapter-inner -->
                        </div><!-- /.resume-chapter -->

                        <div class="resume-chapter">
                            <div class="resume-chapter-inner">
                                <div class="resume-chapter-content">
                                    <h2 class="mb40">Working History</h2>
                                    <?php echo $customer_info['working_history']; ?>
                                </div><!-- /.resume-chapter-content -->
                            </div><!-- /.resume-chapter-inner -->
                        </div><!-- /.resume-chapter -->

                        <div class="resume-chapter">
                            <div class="resume-chapter-inner">
                                <div class="resume-chapter-title">
                                    <h2 class="mb40">Experience</h2>
                                    <?php echo $customer_info['experience']; ?>
                                </div>
                                <!-- /.resume-chapter-title -->
                            </div><!-- /.resume-chapter-inner -->
                        </div><!-- /.resume-chapter -->
                    </div>
                </div>
                
                <div class="col-md-4 col-sm-5">
                    <div class="filter-stacked">
                        <?php include('advanced_search_box_right.php'); ?>
                    </div>
                    <?php
                        $query = tep_db_query("
                            select
                                a.title,
                                a.link,
                                a.image,
                                ad.name
                            from
                                advertising_banner a, advertising_detail ad
                            where
                                a.status = 1 
                                    and 
                                a.id = ad.advertising_banner_id
                                    and
                                ad.name = 'Cv or Company Description'
                        ");
                        while ($item = tep_db_fetch_array($query)) {
                            //var_dump($item);
                            echo "<div class='col-md-12 col-sm-6 col-xs-6'>
                                <img src='images/". $item['image']."' class='img-responsive'/>
                            </div>";
                        }
                    ?>
                </div>
            </div>
            <?php
        } else {
            /**
             * query product belong to user with filter by ID (int)$_GET['info_id']
             **/
            $queryProduct = tep_db_query("
        select
        p.products_id,
        p.create_date,
        pd.products_name,
        DATE_FORMAT(p.products_close_date, '%d/%m/%Y') as products_close_date,
        cu.photo,
        cu.company_name,
        l.name as location
      from
        " . TABLE_PRODUCTS . " p,
        customers cu,
        location l,
        " . TABLE_PRODUCTS_DESCRIPTION . " pd
      where
        p.products_status = 1
            and
        l.id = p.province_id
            and
        p.products_id = pd.products_id
            and
        cu.customers_id = p.customers_id
            and
        cu.customers_id = '" . (int)$_GET['info_id'] . "'
            and
        pd.language_id = '" . (int)$languages_id . "'
            order by
        p.products_promote desc, rand(), p.products_close_date desc
        limit " . MAX_DISPLAY_NEW_PRODUCTS
            );
            $num_new_products = tep_db_num_rows($queryProduct);
            $product_array = array();
            if ($num_new_products > 0) {
                while ($new_products = tep_db_fetch_array($queryProduct)) {
                    $product_array[] = $new_products;
                }
            }
            ?>
            <div class="row">
                <div class="col-md-3 col-sm-4">
                    <div class="company-card">
                        <div class="company-card-image">
                            <img src="<?php echo $customer_info['photo']; ?>" alt="">
                        </div>
                        <!-- /.company-card-image -->
                        <div class="company-card-data">
                            <table class="table table-company">
                                <tr>
                                    <td>Website</td>
                                    <td>
                                        <a href="<?php echo $customer_info['customers_website']; ?>">
                                            <?php echo $customer_info['customers_website'] ? $customer_info['customers_website'] : "N/A"; ?>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>E-mail</td>
                                    <td>
                                        <a href="mailto:<?php echo $customer_info['customers_email_address']; ?>">
                                            <?php echo $customer_info['customers_email_address']; ?>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Phone</td>
                                    <td><?php echo $customer_info['customers_telephone']; ?></td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>
                                        <?php echo $customer_info['customers_address']; ?>
                                    </td>
                                </tr>
                            </table>
                        </div><!-- /.company-card-data -->
                    </div><!-- /.company-card -->


                    <div class="widget">
                        <!-- Go to www.addthis.com/dashboard to customize your tools -->
                        <div class="addthis_native_toolbox"></div>
                    </div><!-- /.widget -->

                    <div class="widget">
                        <h2>Contact Company</h2>

                        <form method="get" action="?">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Subject">
                            </div><!-- /.form-group -->

                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Your E-mail">
                            </div><!-- /.form-group -->

                            <div class="form-group">
                                <textarea class="form-control" rows="5" placeholder="Your Message"></textarea>
                            </div><!-- /.form-group -->

                            <button class="btn btn-secondary" type="submit">Post Message</button>
                        </form>
                    </div><!-- /.widget -->
                </div><!-- /.col-* -->

                <div class="col-md-9 col-sm-8">
                    <div class="company-header">
                        <h2>
                            <?php echo $customer_info['company_name']; ?>
                            <span class="resume-main-verified">
                        <i class="fa fa-check"></i>
                    </span>
                        </h2>
                    </div>
                    <!-- /.company-header -->
                    <h3 class="page-header">Company Profile</h3>
                    <?php echo $customer_info['detail']; ?>

                    <h3 class="page-header">Open Positions</h3>

                    <div class="positions-list">
                        <?php
                        foreach ($product_array as $product) {
                            echo '
                            <div class="positions-list-item">
                                <h2>
                                    <a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $product['products_id']) . '">
                                        ' . $product['products_name'] . '
                                    </a>
                                </h2>
                                <h3>
                                    ' . $product['location'] . '
                                </h3>
                                <div class="position-list-item-action">
                                    ' . $product['products_close_date'] . '
                                </div>                            
                                <div
                                    class="position-list-item-date"
                                >
                                    Close Date
                                </div>
                            </div>
                        ';
                        }
                        ?>
                    </div><!-- /.positions-list -->
                </div><!-- /.col-sm-8 -->
            </div>
            <?php
        }
    }else{
    ?>
        <div class="row">
            <div class="col-md-3 col-sm-4">
                <div class="filter-stacked">
                    <?php include('advanced_search_box_right.php'); ?>
                </div>
            </div>
            <div class="col-md-9 col-sm-8">
                <div class="alert alert-info">
                    Record Not Found.
                </div>
            </div>
        </div>
    <?php
    }
    ?>

</div>
<?php
    require(DIR_WS_INCLUDES . 'template_bottom.php');
    require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
