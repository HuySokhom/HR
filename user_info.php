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
            c.photo_thumbnail,
            c.experience,
            c.working_history,
            c.summary,
            DATE_FORMAT(c.create_date, '%d/%M/%Y') as create_date
        FROM
            customers c, location l
        WHERE
            c.customers_id = ". (int)$_GET['info_id'] . "
                and
            c.customers_location = l.id
                and 
            is_publish = 1
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
            <div class="col-md-3 col-sm-4">
                <div class="filter-stacked">
                    <?php include('advanced_search_box_right.php'); ?>
                </div>
            </div>
            <div class="col-md-9 col-sm-8">
                <div class="resume">
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <br/>
                            <img src="images/<?php echo $customer_info['photo_thumbnail']; ?>" alt=""
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
                            <!-- /.resume-main-contact -->

                            <div class="resume-main-actions">
                                <a href="#" class="btn btn-secondary"><i class="fa fa-download"></i> Download CV</a>
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
                            <div class="resume-chapter-content">
                                <div class="row">
                                    <div class="col-sm-3">
                        <span class="resume-chapter-social">
                            <span class="resume-chapter-social-icon"><i class="fa fa-facebook-square"></i></span>
                            <span class="resume-chapter-social-value">5 699 likes</span>
                        </span><!-- /.resume-chapter-social -->
                                    </div><!-- /.col-* -->

                                    <div class="col-sm-3">
                        <span class="resume-chapter-social">
                            <span class="resume-chapter-social-icon"><i class="fa fa-twitter-square"></i></span>
                            <span class="resume-chapter-social-value">800 tweets </span>
                        </span><!-- /.resume-chapter-social -->
                                    </div><!-- /.col-* -->

                                    <div class="col-sm-3">
                        <span class="resume-chapter-social">
                            <span class="resume-chapter-social-icon"><i class="fa fa-linkedin-square"></i></span>
                            <span class="resume-chapter-social-value">@elliot </span>
                        </span><!-- /.resume-chapter-social -->
                                    </div><!-- /.col-* -->

                                    <div class="col-sm-3">
                        <span class="resume-chapter-social">
                            <span class="resume-chapter-social-icon"><i class="fa fa-youtube-square"></i></span>
                            <span class="resume-chapter-social-value">@elliot</span>
                        </span><!-- /.resume-chapter-social -->
                                    </div><!-- /.col-* -->
                                </div><!-- /.row -->
                            </div><!-- /.recume-chapter-content -->
                        </div><!-- /.resume-chapter-inner -->
                    </div><!-- /.resume-chapter -->

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
        cu.photo_thumbnail,
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
            <div class="col-md-3 col-sm-4">
                <div class="company-card">
                    <div class="company-card-image">
                        <img src="images/<?php echo $customer_info['photo_thumbnail']; ?>" alt="">
                    </div>
                    <!-- /.company-card-image -->
                    <div class="company-card-data">
                        <table class="table table-company">
                            <tr>
                                <td>Website</td>
                                <td>
                                    <a
                                            href="<?php echo $customer_info['customers_website']; ?>"
                                    >
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
                    <ul class="social-links">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
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
            <?php
        }
    }else{
    ?>
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
    <?php
    }
    ?>

</div>
<?php
    require(DIR_WS_INCLUDES . 'template_bottom.php');
    require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
