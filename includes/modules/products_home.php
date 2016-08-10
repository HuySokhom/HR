
<div class="filter">
    <h2>Search for a Job</h2>

    <?php
        echo
            tep_draw_form('advanced_search', tep_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false),
            'get',
            'class="form-horizontal" onsubmit="return check_form(this);"') . tep_hide_session_id();
    ?>
    <div class="row">
            <div class="form-group col-sm-3">
                <input type="text" class="form-control" placeholder="Search Job Title..." name="keywords" required/>
            </div><!-- /.form-group -->
            <div class="form-group col-sm-3">
                <?php
                    echo tep_draw_pull_down_menu(
                        'location',
                        tep_get_province(array(array('id' => '', 'text' => "Choose Location"))),
                        NULL,
                        'id="location" class="form-control"'
                    );
                ?>
            </div><!-- /.form-group -->

            <div class="form-group col-sm-3">
                <?php
                    echo tep_draw_pull_down_menu('categories_id', tep_get_categories(array(array('id' => '', 'text' => TEXT_ALL_CATEGORIES))), NULL, 'id="entryCategories"');
                ?>
            </div><!-- /.form-group -->

            <div class="form-group col-sm-3">
                <button type="submit" class="btn btn-block btn-secondary">Search</button>
            </div><!-- /.form-group -->
        </div><!-- /.row -->

        <ul class="filter-list">
            <?php echo tep_get_categories_list();?>
        </ul>

        <hr>

        <div class="filter-actions">
            <a href="candidates.html">All Candidates</a> <span class="filter-separator">/</span>
            <a href="positions.html">All Jobs</a> <span class="filter-separator">/</span>
            <a href="companies.html">All Companies</a>
        </div><!-- /.filter -->
    </form>
</div><!-- /.filter -->

<div class="row">
    <div class="col-sm-6">
        <h2 class="page-header">Popular Companies</h2>

        <div class="companies-list">

            <div class="companies-list-item">
                <div class="companies-list-item-image">
                    <a href="company-detail.html">

                        <img src="assets/img/tmp/airbnb.png" alt="">

                    </a>
                </div><!-- /.companies-list-item-image -->

                <div class="companies-list-item-heading">
                    <h2><a href="company-detail.html">Airbnb</a></h2>
                    <h3>New York City, New York</h3>
                </div><!-- /.companies-list-item-heading -->

                <div class="companies-list-item-count">
                    <a href="positions.html">3 open positions</a>
                </div><!-- /.positions-list-item-count -->

            </div><!-- /.companies-list-item -->



            <div class="companies-list-item">
                <div class="companies-list-item-image">
                    <a href="company-detail.html">

                        <img src="assets/img/tmp/instagram.png" alt="">

                    </a>
                </div><!-- /.companies-list-item-image -->

                <div class="companies-list-item-heading">
                    <h2><a href="company-detail.html">Instagram</a></h2>
                    <h3>Chicago, Michigan</h3>
                </div><!-- /.companies-list-item-heading -->

                <div class="companies-list-item-count">
                    <a href="positions.html">32 open positions</a>
                </div><!-- /.positions-list-item-count -->

            </div><!-- /.companies-list-item -->



            <div class="companies-list-item">
                <div class="companies-list-item-image">
                    <a href="company-detail.html">

                        <img src="assets/img/tmp/facebook.png" alt="">

                    </a>
                </div><!-- /.companies-list-item-image -->

                <div class="companies-list-item-heading">
                    <h2><a href="company-detail.html">Facebook</a></h2>
                    <h3>Philadelphia, Pennsylvania</h3>
                </div><!-- /.companies-list-item-heading -->

                <div class="companies-list-item-count">
                    <a href="positions.html">34 open positions</a>
                </div><!-- /.positions-list-item-count -->

            </div><!-- /.companies-list-item -->





        </div><!-- /.companies-list -->
    </div><!-- /.col-* -->

    <div class="col-sm-6">
        <h2 class="page-header">Recent Job Offers</h2>

        <div class="positions-list">



            <div class="positions-list-item">
                <h2>
                    <a href="position-detail.html">Junior Java Developer</a>

                </h2>
                <h3><span><img src="assets/img/tmp/instagram.png" alt=""></span> New York City, New York <br></h3>

                <div class="position-list-item-date">09/11/2015</div><!-- /.position-list-item-date -->
                <div class="position-list-item-action"><a href="index.html#">Save Position</a></div><!-- /.position-list-item-action -->
            </div><!-- /.position-list-item -->



            <div class="positions-list-item">
                <h2>
                    <a href="position-detail.html">PR Manager</a>

                    <span>Urgent</span>

                </h2>
                <h3><span><img src="assets/img/tmp/facebook.png" alt=""></span> Chicago, Michigan <br></h3>

                <div class="position-list-item-date">08/11/2015</div><!-- /.position-list-item-date -->
                <div class="position-list-item-action"><a href="index.html#">Save Position</a></div><!-- /.position-list-item-action -->
            </div><!-- /.position-list-item -->



            <div class="positions-list-item">
                <h2>
                    <a href="position-detail.html">Data Mining Specialist</a>

                </h2>
                <h3><span><img src="assets/img/tmp/twitter.png" alt=""></span> Philadelphia, Pennsylvania <br></h3>

                <div class="position-list-item-date">07/11/2015</div><!-- /.position-list-item-date -->
                <div class="position-list-item-action"><a href="index.html#">Save Position</a></div><!-- /.position-list-item-action -->
            </div><!-- /.position-list-item -->



            <div class="positions-list-item">
                <h2>
                    <a href="position-detail.html">Python Developer</a>

                    <span>Featured</span>

                </h2>
                <h3><span><img src="assets/img/tmp/airbnb.png" alt=""></span> Denver, Colorado <br></h3>

                <div class="position-list-item-date">06/11/2015</div><!-- /.position-list-item-date -->
                <div class="position-list-item-action"><a href="index.html#">Save Position</a></div><!-- /.position-list-item-action -->
            </div><!-- /.position-list-item -->



            <div class="positions-list-item">
                <h2>
                    <a href="position-detail.html">Senior Data</a>

                    <span>Featured</span>

                </h2>
                <h3><span><img src="assets/img/tmp/dropbox.png" alt=""></span> San Francisco, Dropbox <br></h3>

                <div class="position-list-item-date">05/11/2015</div><!-- /.position-list-item-date -->
                <div class="position-list-item-action"><a href="index.html#">Save Position</a></div><!-- /.position-list-item-action -->
            </div><!-- /.position-list-item -->

        </div><!-- /.positions-list -->
    </div><!-- /.col-* -->
</div>
<!-- /.row -->

<?php
    $new_products_query = tep_db_query("
      select
        p.products_id,
        pd.products_viewed,
        p.products_image_thumbnail,
        p.products_image,
        pd.products_name
      from
        " . TABLE_PRODUCTS . " p,
        " . TABLE_PRODUCTS_DESCRIPTION . " pd
    where
        p.products_status = 1
            and
        p.products_id = pd.products_id
            and
        pd.language_id = '" . (int)$languages_id . "'
            order by
        p.products_promote desc, rand(), p.products_date_added desc
        limit " . MAX_DISPLAY_NEW_PRODUCTS
    );
  $num_new_products = tep_db_num_rows($new_products_query);

  if ($num_new_products > 0) {

    $new_prods_content = NULL;

    while ($new_products = tep_db_fetch_array($new_products_query)) {
      if (strlen($new_products['products_name']) > 35) {
        $p_name = substr($new_products['products_name'], 0, 40) . '...';
      }else{
        $p_name = $new_products['products_name'];
      }
      $new_prods_content .= '

            <div class="positions-list-item">
                <h2>
                    <a
                        href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']) .'"
                    >
                    '. $new_products['products_name'] .'
                    </a>
                </h2>
                <h3>
                    <span>
                        '
                            . tep_image(DIR_WS_IMAGES . $new_products['products_image_thumbnail'],
                            $new_products['products_name'], SMALL_IMAGE_WIDTH,
                            SMALL_IMAGE_HEIGHT, 'style="width:100%; height: 170px;"') .
                        '
                    </span> New York City, New York <br>
                </h3>

                <div class="position-list-item-date">09/11/2015</div>
                <!-- /.position-list-item-date -->
                <div class="position-list-item-action"><a href="index.html#">Save Position</a></div>
                <!-- /.position-list-item-action -->
            </div>
          ';
    }
?>
    <!-- Rent Property -->
    <div class="rent-property">
    <div class="col-md-6 rent">
      <div class="section-header">
        <h2 class="page-header">Recent Job Offers</h2>
      </div>
    </div>
    <div class="col-md-12 p_r_z">
    <div id="rent-property-block" class="rent-property-block">
      <?php echo $new_prods_content; ?>
    </div>
    </div>
  </div><!-- Rent Property /- -->
<?php
  }

    $candidate_query = tep_db_query("
      select
        customers_id,
        user_name,
        photo_thumbnail
      from
        customers
      where
        status = 1
          and
        user_type = 'normal'
          order by rand()
        limit 6"
    );
    $num_candidate = tep_db_num_rows($candidate_query);
    if($num_candidate > 0){
?>
<div class="clearfix">

</div>
<h4>Find Your Best Candidate</h4>
<div class="row mt-60">
    <div class="candidate-boxes">
        <?php
            while ($candidate = tep_db_fetch_array($candidate_query)) {
                echo '
                    <div class="col-sm-3 col-md-2">
                        <div class="candidate-box">
                            <div class="candidate-box-image">
                                <a href="'. $candidate['customers_id'] .'">
                                    <img src="'. $candidate['photo_thumbnail'] .'" alt="'. $candidate['user_name'] .'">
                                </a>
                            </div>
                            <!-- /.candidate-box-image -->

                            <div class="candidate-box-content">
                                <h2>'. $candidate['user_name'] .'</h2>
                                <h3>Java Developer</h3>
                            </div><!-- /.candidate-box-content -->
                        </div><!-- /.candidate-box -->
                    </div><!-- /.col-* -->
                ';
            }
        ?>
    </div><!-- /.candidate-boxes -->
<?php
    }
?>
</div><!-- /.row -->
