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
            user_type,
            detail,
            customers_telephone,
            customers_email_address,
            customers_address,
            photo_thumbnail
        FROM
            customers
        WHERE
            customers_id = ". (int)$_GET['info_id'] . "
        LIMIT 1
    ");
    $customer_info = tep_db_fetch_array($query);
?>
<br>
<div class="container">
    <?php
        if($customer_info['user_type'] == 'normal')
        {
    ?>
    <div class="resume">
        <div class="resume-main">
            <div class="resume-main-image">
                <img src="assets/img/tmp/resume.jpg" alt="">

                <a href="#" class="resume-main-image-label">
                    <img src="assets/img/tmp/instagram.png" alt="">
                </a>
            </div><!-- /.resume-main-image -->

            <div class="resume-main-content">
                <h2>Elliot Sarah Scott
                    <span class="resume-main-verified"><i class="fa fa-check"></i></span>

        <span class="resume-main-rating">
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <span class="resume-main-rating-count">/ 32</span>
        </span><!-- /.resume-main-rating -->
                </h2>

                <h3>Senior Data Analytist</h3>

                <p class="resume-main-contacts">
                    Timothy Blvd, Silicon Valley, California<br>
                    Email: <a href="mailto:hello@example.com">hello@example.com</a> - Website: <a href="http://example.com">www.example.com</a>
                </p><!-- /.resume-main-contact -->

                <div class="resume-main-actions">
                    <a href="#" class="btn btn-secondary"><i class="fa fa-download"></i> Download</a>
                    <a href="#" class="btn btn-default">Contact</a>
                    <a href="#" class="btn btn-default">Save</a>
                </div><!-- /.resume-main-actions -->
            </div><!-- /.resume-main-content -->
        </div><!-- /.resume-main -->

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
                    <h2>Summary</h2>
                </div><!-- /.resume-chapter-title -->

                <div class="resume-chapter-content">
                    <p>
                        Curabitur sed tortor id elit elementum tincidunt eget a turpis. Pellentesque nibh felis, rhoncus ut sem vel, blandit viverra felis. Integer consequat volutpat lectus vel commodo.
                    </p>

                    <p>
                        Nam pellentesque ac orci at tempus. Nulla sed nunc scelerisque, rhoncus magna vitae, placerat nisi. Fusce convallis ex nec tellus vulputate vehicula. Duis venenatis turpis a varius lacinia. Fusce eu est lectus. Integer commodo fringilla libero, non sodales ipsum consectetur sit amet. Aenean non ligula ac est dapibus feugiat.
                    </p>
                </div><!-- /.resume-chapter-content -->
            </div><!-- /.resume-chapter-inner -->
        </div><!-- /.resume-chapter -->

        <div class="resume-chapter">
            <div class="resume-chapter-inner">
                <div class="resume-chapter-content">
                    <h2 class="mb40">Working History</h2>

                    <dl>
                        <dt>Current</dt>

                        <dd>
                            <h3>Project Manager</h3>

                            <p>
                                Fusce eu est lectus. Integer commodo fringilla libero, non sodales ipsum consectetur sit amet. Aenean non ligula ac est dapibus feugiat. Fusce convallis ex nec tellus vulputate.
                            </p>
                        </dd>

                        <dt>2011 - 2014</dt>

                        <dd>
                            <h3>Senior UX/UI designer</h3>

                            <p>
                                Fusce eu est lectus. Integer commodo fringilla libero, non sodales ipsum consectetur sit amet. Aenean non ligula ac est dapibus feugiat. Fusce convallis ex nec tellus vulputate.
                            </p>
                        </dd>

                        <dt>2010 - 2011</dt>

                        <dd>
                            <h3>Junior UX/UI designer</h3>

                            <p>
                                Fusce eu est lectus. Integer commodo fringilla libero, non sodales ipsum consectetur sit amet. Aenean non ligula ac est dapibus feugiat. Fusce convallis ex nec tellus vulputate.
                            </p>
                        </dd>

                        <dt>2009 - 2010</dt>

                        <dd>
                            <h3>UX Tester</h3>

                            <p>
                                Fusce eu est lectus. Integer commodo fringilla libero, non sodales ipsum consectetur sit amet. Aenean non ligula ac est dapibus feugiat. Fusce convallis ex nec tellus vulputate.
                            </p>
                        </dd>
                    </dl>
                </div><!-- /.resume-chapter-content -->
            </div><!-- /.resume-chapter-inner -->
        </div><!-- /.resume-chapter -->

        <div class="resume-chapter">
            <div class="resume-chapter-inner">
                <div class="resume-chapter-title">
                    <h2>Experience</h2>
                </div><!-- /.resume-chapter-title -->

                <div class="resume-chapter-content">
                    <div class="row">
                        <div class="col-sm-4">
                            <h4>Frameworks</h4>

                            <ul>
                                <li>Laravel, <span>4 years</span></li>
                                <li>Zend, <span>3 years</span></li>
                                <li>CakePHP, <span>1 year</span></li>
                                <li>Yii, <span>1 year</span></li>
                            </ul>
                        </div><!-- /.col-* -->

                        <div class="col-sm-4">
                            <h4>Operating Systems</h4>

                            <ul>
                                <li>Debian, <span>7 years</span></li>
                                <li>FreeBSD, <span>5 years</span></li>
                                <li>Ubuntu, <span>1 year</span></li>
                                <li>Gentoo, <span>1 year</span></li>
                            </ul>
                        </div><!-- /.col-* -->

                        <div class="col-sm-4">
                            <h4>Languages</h4>

                            <ul>
                                <li>English, <span>native</span></li>
                                <li>German, <span>intermediate</span></li>
                                <li>French, <span>beginner</span></li>
                                <li>Spanish, <span>beginner</span></li>
                            </ul>
                        </div><!-- /.col-* -->
                    </div><!-- /.row -->
                </div><!-- /.resume-chapter-content -->
            </div><!-- /.resume-chapter-inner -->
        </div><!-- /.resume-chapter -->
    </div>
    <?php
        }else{
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
        cu.customers_id = '".(int)$_GET['info_id']."'
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
    <div class="col-sm-4">
        <div class="company-card">
            <div class="company-card-image">
                <img src="<?php echo $customer_info['photo_thumbnail'];?>" alt="">
            </div>
            <!-- /.company-card-image -->
            <div class="company-card-data">
                <dl>
                    <dt>Website</dt>
                    <dd>
                        <a 
                            href="<?php echo $customer_info['customers_website'];?>"
                        >   
                            <?php echo $customer_info['customers_website'] ? $customer_info['customers_website'] : "N/A";?>
                        </a>
                    </dd>

                    <dt>E-mail</dt>
                    <dd>
                        <a href="mailto:<?php echo $customer_info['customers_email_address'];?>">
                            <?php echo $customer_info['customers_email_address'];?>
                        </a>
                    </dd>

                    <dt>Phone</dt>
                    <dd><?php echo $customer_info['customers_telephone'];?></dd>

                    <dt>Address</dt>
                    <dd>
                        <?php echo $customer_info['customers_address'];?>
                    </dd>
                </dl>
            </div><!-- /.company-card-data -->
        </div><!-- /.company-card -->


        <div class="widget">
            <ul class="social-links">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                <li><a href="#"><i class="fa fa-tumblr"></i></a></li>
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

    <div class="col-sm-8">
        <div class="company-header">
            <h1><?php echo $customer_info['company_name'];?></h1>
        </div>
        <!-- /.company-header -->
        <h3 class="page-header">Company Profile</h3>
        <?php echo $customer_info['detail'];?>

        <h3 class="page-header">Open Positions</h3>

        <div class="positions-list">
            <?php
                foreach ($product_array as $product) {
                    echo '
                        <div class="positions-list-item">
                            <h2>
                                <a href="'. tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $product['products_id']) .'">
                                    '. $product['products_name'] .'
                                </a>
                            </h2>
                            <h3>
                                <span>
                                    <img src="'. $product['photo_thumbnail'] .'" alt="">
                                </span>
                                '. $product['company_name'] .', '. $product['location'] .'
                                <br>
                            </h3>
                            <div class="position-list-item-date">
                                '. $product['products_close_date'] .'
                            </div>                            <div
                                class="position-list-item-action heart-icon"
                                data-product="'. $product['products_id']. '"
                                data-type="insert"
                            >
                                <a href="javascript:void(0)">Save Position</a>
                            </div>
                        </div>
                    ';
                }
            ?>
        </div><!-- /.positions-list -->
    </div><!-- /.col-sm-8 -->
    <?php
        }
    ?>
</div>
<?php
    require(DIR_WS_INCLUDES . 'template_bottom.php');
    require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
