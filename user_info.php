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
?>
<br>
<div class="container">
    <?php
        if($customer_info['user_type'] == 'normal')
        {
    ?>
    <div class="col-md-3 col-sm-5 ">
        <div class="filter-stacked">
            <?php include('advanced_search_box_right.php');?>
        </div>
    </div>
    <div class="col-md-9 col-sm-7">
        <div class="col-md-3 col-lg-3 " align="center">
            <img alt="User Pic"
                 src="<?php echo $customer_info['photo_thumbnail'];?>"
                 class="img-responsive"/>
        </div>
        <div class="col-md-9 col-lg-9 ">
            <table class="table table-user-information">
                <tbody>
                <tr>
                    <td>Department:</td>
                    <td>Programming</td>
                </tr>
                <tr>
                    <td>Hire date:</td>
                    <td>06/23/2013</td>
                </tr>
                <tr>
                    <td>Date of Birth</td>
                    <td>01/24/1988</td>
                </tr>

                <tr>
                <tr>
                    <td>Gender</td>
                    <td>Male</td>
                </tr>
                <tr>
                    <td>Home Address</td>
                    <td>Metro Manila,Philippines</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><a href="mailto:info@support.com">info@support.com</a></td>
                </tr>
                <td>Phone Number</td>
                <td>123-4567-890(Landline)<br><br>555-4567-890(Mobile)
                </td>

                </tr>

                </tbody>
            </table>

            <a href="#" class="btn btn-primary">My Sales Performance</a>
            <a href="#" class="btn btn-primary">Team Sales Performance</a>
        </div>
        <h3>Resume details</h3>
        <table class="table table-striped">
            <tr>
                <td width="110px">
                    Name:
                </td>
                <td>
                    <?php echo $customer_info['user_name'];?>
                </td>
            </tr>
            <tr>
                <td>
                    Gender:
                </td>
                <td>
                    <?php echo $customer_info['customers_gender'];?>
                </td>
            </tr>
            <tr>
                <td>
                    Skill Title:
                </td>
                <td>
                    <?php echo $customer_info['skill_title'];?>
                </td>
            </tr>
            <tr>
                <td>
                    Photo:
                </td>
                <td>
                    <img src="<?php echo $customer_info['photo_thumbnail'];?>" width="130px"/>
                </td>
            </tr>
            <tr>
                <td>
                    Telephone:
                </td>
                <td>
                    <?php echo $customer_info['customers_telephone'];?>
                </td>
            </tr>
            <tr>
                <td>
                    Address:
                </td>
                <td>
                    <?php echo $customer_info['customers_address'];?>
                </td>
            </tr>
            <tr>
                <td>
                    Location:
                </td>
                <td>
                    <?php echo $customer_info['location_name'];?>
                </td>
            </tr>
            <tr>
                <td>
                    Description:
                </td>
                <td>
                    <?php echo $customer_info['detail'];?>
                </td>
            </tr>
            <tr>
                <td>
                    Created Date:
                </td>
                <td>
                    <?php echo $customer_info['create_date'];?>
                </td>
            </tr>
            <tr>
                <td>
                    ID:
                </td>
                <td>
                    #<?php echo $customer_info['customers_id'];?>
                </td>
            </tr>
            <tr>
                <td>
                    Download CV:
                </td>
                <td>
                    <a href="<?php echo $customer_info['upload_cv'];?>">
                        <button class="btn btn-default">Download CV</button>
                    </a>
                </td>
            </tr>
        </table>
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
