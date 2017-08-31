<?php
    $candidate_query = tep_db_query("
        select
            customers_id,
            company_name,
            photo,
            skill_title
        from
            customers
        where
            status = 1
              and
            user_type = 'normal'
              and 
            is_publish = 1
        order by rand()
            limit 12"
    );
    $num_candidate = tep_db_num_rows($candidate_query);
    $array_candidate = array();
    if($num_candidate > 0) {
        while ($candidates = tep_db_fetch_array($candidate_query)) {
            $array_candidate[] = $candidates;
        }
    }

    // query featured company
    $feature_query = tep_db_query("
        select
            customers_id,
            photo
        from
            customers
        where
            status = 1
              and
            user_type = 'agency'
              and
            is_agency = 1
              and
            is_publish = 1       
    ");
    $num_featured = tep_db_num_rows($feature_query);
    $array_featured_company = [];
    if($num_featured > 0) {
        while ($featured = tep_db_fetch_array($feature_query)) {
            $array_featured_company[] = $featured;
        }
    }

    // query job
    $new_products_query = tep_db_query("
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
        p.is_publish = 1
            and
        l.id = p.province_id
            and
        p.products_id = pd.products_id
            and
        cu.customers_id = p.customers_id
            and
        pd.language_id = '" . (int)$languages_id . "'
            order by
        p.products_id desc, p.products_close_date desc
        limit " . MAX_DISPLAY_NEW_PRODUCTS
    );
    $num_new_products = tep_db_num_rows($new_products_query);
    $product_array = array();
    if ($num_new_products > 0) {
        while ($new_products = tep_db_fetch_array($new_products_query)) {
            $product_array[] = $new_products;
        }
    }
?>
    <!-- /.filter -->
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-12">
                <h4 class="page-header">Recent Job Offers</h4>

                <div class="positions-list">
                    <!-- position-list-item -->
                    <?php
                        foreach ($product_array as $product) {
                            echo '
                                <div class="positions-list-item">
                                    <h2>
                                        <b><a href="'. tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $product['products_id']) .'">
                                            '. $product['products_name'] .'
                                        </a></b>
                                    </h2>
                                    <h3>
                                        <span>
                                            <img src="images/'. $product['photo'] .'" alt="">
                                        </span>
                                        '. $product['company_name'] .'
                                        <br>
                                    </h3>
                                    <div class="position-list-item-date">
                                        '. $product['products_close_date'] .'
                                    </div>
                                    <!-- /.position-list-item-date -->
                                    <div
                                        class="position-list-item-action heart-icon"
                                        data-product="'. $product['products_id']. '"
                                        data-type="insert"
                                    >
                                        <i class="fa fa-map-marker"></i>
                                        '. $product['location'] .'
                                    </div>
                                    <!-- /.position-list-item-action -->
                                </div>
                            ';
                        }
                    ?>
                    <!-- /.position-list-item -->
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">        
        <div class="" style="margin-top: 30px;">
            <div class="fb-page"
                    data-href="https://www.facebook.com/Aseanhr-1827357880910799/"
                    data-small-header="false" data-adapt-container-width="true"
                    data-hide-cover="false" data-show-facepile="true">
                <blockquote cite="https://www.facebook.com/Aseanhr-1827357880910799/"
                            class="fb-xfbml-parse-ignore">
                    <a href="https://www.facebook.com/Aseanhr-1827357880910799/">
                        AseanHR
                    </a>
                </blockquote>
            </div>
        </div>
        <div class="features-company">
            <h4>
                FEATURED RECRUITERS
            </h4>
            <div class="features-img">
                <div class="space m0">
                <?php 
                    foreach($array_featured_company as $feature) {
                        echo '<a href="'. tep_href_link(FILENAME_INFORMATION, 
                                'info_id=' . $feature['customers_id'] ) .'">
                                <img src="images/'. $feature['photo'] .'" 
                                    class="feature_logo">
                            </a>';
                    }
                ?>
                </div>
            </div>
        </div>
        <div class="features-company">
            <h4>Find Your Best Candidate</h4>
            <div class="row mt-60">
                <div class="candidate-boxes">
                    <?php
                        foreach($array_candidate as $candidate) {
                            echo '
                                <div class="col-sm-3 col-md-6 col-xs-6">
                                    <div class="candidate-box">
                                        <div class="candidate-box-image">
                                            <a href="' . tep_href_link(FILENAME_INFORMATION, 'info_id=' . $candidate['customers_id']) . '">
                                                <img
                                                    src="images/' . $candidate['photo'] . '"
                                                    alt="' . $candidate['company_name'] . '"
                                                    class="img-responsive"
                                                />
                                            </a>
                                        </div>
                                        <!-- /.candidate-box-image -->

                                        <div class="candidate-box-content">
                                            <h2>' . $candidate['company_name'] . '</h2>
                                            <h3>' . $candidate['skill_title'] . '</h3>
                                        </div><!-- /.candidate-box-content -->
                                    </div><!-- /.candidate-box -->
                                </div><!-- /.col-* -->
                            ';
                        }
                    ?>
                </div>
                <!-- /.candidate-boxes -->
            </div>
        </div>
    <!-- /.row -->
    </div>
