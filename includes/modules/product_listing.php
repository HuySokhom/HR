<?php
  $listing_split = new splitPageResults($listing_sql, MAX_DISPLAY_SEARCH_RESULTS, 'p.products_id');
?>

<?php
  if ($messageStack->size('product_action') > 0) {
    echo $messageStack->output('product_action');
  }
?>
  <div class="container">
<?php
  if ($listing_split->number_of_rows > 0) {
  $listing_query = tep_db_query($listing_split->sql_query);
  $prod_list_contents = NULL;

  while ($listing = tep_db_fetch_array($listing_query)) {
    if (strlen(strip_tags($listing['products_description'], '<br>')) > 140){
       $str_description = substr(strip_tags($listing['products_description'], '<br>'), 0, 140) . '...';
   }else{
        $str_description = strip_tags($listing['products_description'], '<br>');
   }
   switch ($listing['products_promote']) {
        case 3:
            $text = 'Pro';
            $class = 'pro';
            break;
        case 2:
            $text = 'Premium';
            $class = 'pro';
            break;
        case 1:
            $text = 'Basic';
            $class = 'pro';
            break;
        default:
            $text = 'Free';
            $class = 'free';
    }
    $prod_list_contents .= '';
  }

    echo $prod_list_contents;
    ?>

    <!-- Pagination -->
      <div class="row">
        <div class="col-md-12" style="text-align: center;">
          <div>
              <?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS) ?>
          </div>
          <div class="pagenav">
            <ul class="pagination">
              <?php
                echo $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y')));
              ?>
            </ul>
          </div>
        </div>
    </div>
    <!-- Pagination /- -->
    </div>

    <!-- Property Listing Section /- -->';
<?php
}

else {
?>
<div class="property-left col-md-9 col-sm-6 p_l_z content-area">
  <div class="alert alert-info"><?php echo TEXT_NO_PRODUCTS; ?></div>
</div>
<?php
}
?>
<div class="container">
    <div class="row">
        <div class="col-sm-3">
            <div class="filter-stacked">
                <?php include('advanced_search_box_right.php');?>
            </div><!-- /.filter-stacked -->

        </div><!-- /.col-* -->

        <div class="col-sm-7">
            <div class="positions-list">

                <div class="positions-list-item">
                    <h2>
                        <a href="position-detail.html">Senior Data</a>

                        <span>Featured</span>

                    </h2>
                    <h3><span><img src="assets/img/tmp/dropbox.png" alt=""></span> San Francisco, Dropbox <br></h3>

                    <div class="position-list-item-date">10/11/2015</div><!-- /.position-list-item-date -->
                    <div class="position-list-item-action"><a href="positions.html#">Save Position</a></div><!-- /.position-list-item-action -->
                </div><!-- /.position-list-item -->

                <div class="positions-list-item">
                    <h2>
                        <a href="position-detail.html">Junior Java Developer</a>

                    </h2>
                    <h3><span><img src="assets/img/tmp/instagram.png" alt=""></span> New York City, New York <br></h3>

                    <div class="position-list-item-date">09/11/2015</div><!-- /.position-list-item-date -->
                    <div class="position-list-item-action"><a href="positions.html#">Save Position</a></div><!-- /.position-list-item-action -->
                </div><!-- /.position-list-item -->

                <div class="positions-list-item">
                    <h2>
                        <a href="position-detail.html">PR Manager</a>

                        <span>Urgent</span>

                    </h2>
                    <h3><span><img src="assets/img/tmp/facebook.png" alt=""></span> Chicago, Michigan <br></h3>

                    <div class="position-list-item-date">08/11/2015</div><!-- /.position-list-item-date -->
                    <div class="position-list-item-action"><a href="positions.html#">Save Position</a></div><!-- /.position-list-item-action -->
                </div><!-- /.position-list-item -->

                <div class="positions-list-item">
                    <h2>
                        <a href="position-detail.html">Data Mining Specialist</a>

                    </h2>
                    <h3><span><img src="assets/img/tmp/twitter.png" alt=""></span> Philadelphia, Pennsylvania <br></h3>

                    <div class="position-list-item-date">07/11/2015</div><!-- /.position-list-item-date -->
                    <div class="position-list-item-action"><a href="positions.html#">Save Position</a></div><!-- /.position-list-item-action -->
                </div><!-- /.position-list-item -->

                <div class="positions-list-item">
                    <h2>
                        <a href="position-detail.html">Python Developer</a>

                        <span>Featured</span>

                    </h2>
                    <h3><span><img src="assets/img/tmp/airbnb.png" alt=""></span> Denver, Colorado <br></h3>

                    <div class="position-list-item-date">06/11/2015</div><!-- /.position-list-item-date -->
                    <div class="position-list-item-action"><a href="positions.html#">Save Position</a></div><!-- /.position-list-item-action -->
                </div><!-- /.position-list-item -->

                <div class="positions-list-item">
                    <h2>
                        <a href="position-detail.html">Senior Data</a>

                        <span>Featured</span>

                    </h2>
                    <h3><span><img src="assets/img/tmp/dropbox.png" alt=""></span> San Francisco, Dropbox <br></h3>

                    <div class="position-list-item-date">05/11/2015</div><!-- /.position-list-item-date -->
                    <div class="position-list-item-action"><a href="positions.html#">Save Position</a></div><!-- /.position-list-item-action -->
                </div><!-- /.position-list-item -->

                <div class="positions-list-item">
                    <h2>
                        <a href="position-detail.html">Junior Java Developer</a>

                    </h2>
                    <h3><span><img src="assets/img/tmp/instagram.png" alt=""></span> New York City, New York <br></h3>

                    <div class="position-list-item-date">04/11/2015</div><!-- /.position-list-item-date -->
                    <div class="position-list-item-action"><a href="positions.html#">Save Position</a></div><!-- /.position-list-item-action -->
                </div><!-- /.position-list-item -->

                <div class="positions-list-item">
                    <h2>
                        <a href="position-detail.html">PR Manager</a>

                        <span>Urgent</span>

                    </h2>
                    <h3><span><img src="assets/img/tmp/facebook.png" alt=""></span> Chicago, Michigan <br></h3>

                    <div class="position-list-item-date">03/11/2015</div><!-- /.position-list-item-date -->
                    <div class="position-list-item-action"><a href="positions.html#">Save Position</a></div><!-- /.position-list-item-action -->
                </div><!-- /.position-list-item -->

                <div class="positions-list-item">
                    <h2>
                        <a href="position-detail.html">Data Mining Specialist</a>

                    </h2>
                    <h3><span><img src="assets/img/tmp/twitter.png" alt=""></span> Philadelphia, Pennsylvania <br></h3>

                    <div class="position-list-item-date">02/11/2015</div><!-- /.position-list-item-date -->
                    <div class="position-list-item-action"><a href="positions.html#">Save Position</a></div><!-- /.position-list-item-action -->
                </div><!-- /.position-list-item -->

                <div class="positions-list-item">
                    <h2>
                        <a href="position-detail.html">Python Developer</a>

                        <span>Featured</span>

                    </h2>
                    <h3><span><img src="assets/img/tmp/airbnb.png" alt=""></span> Denver, Colorado <br></h3>

                    <div class="position-list-item-date">01/11/2015</div><!-- /.position-list-item-date -->
                    <div class="position-list-item-action"><a href="positions.html#">Save Position</a></div><!-- /.position-list-item-action -->
                </div><!-- /.position-list-item -->

            </div><!-- /.positions-list -->

            <div class="center">
                <ul class="pagination">
                    <li>
                        <a href="positions.html#">
                            <i class="fa fa-chevron-left"></i>
                        </a>
                    </li>

                    <li><a href="positions.html#">1</a></li>
                    <li><a href="positions.html#">2</a></li>
                    <li class="active"><a href="positions.html#">3</a></li>
                    <li><a href="positions.html#">4</a></li>
                    <li><a href="positions.html#">5</a></li>
                    <li>
                        <a href="positions.html#">
                            <i class="fa fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </div><!-- /.center -->
        </div><!-- /.col-* -->

        <div class="col-sm-2">
            <div class="banner-wrapper">
                <a href="positions.html#">
                    <img src="assets/img/tmp/banner-120x600.png" alt="">
                </a>
            </div><!-- /.banner-wrapper -->
        </div><!-- /.col-* -->
    </div><!-- /.row -->
</div><!-- /.container -->
</div><!-- /.main -->
