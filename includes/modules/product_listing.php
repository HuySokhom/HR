<?php
  $listing_split = new splitPageResults($listing_sql, MAX_DISPLAY_SEARCH_RESULTS, 'p.products_id');
?>

<?php
  if ($messageStack->size('product_action') > 0) {
    echo $messageStack->output('product_action');
  }
?>
<?php
  $row = $listing_split->number_of_rows;
  if ($row > 0) {
      $listing_query = tep_db_query($listing_split->sql_query);
      $prod_list_contents = array();
      while ($listing = tep_db_fetch_array($listing_query)) {
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
          $prod_list_contents[] = $listing;
      }
  }
?>
    <br>
    <div class="container">
          <div class="row">
              <div class="col-md-3 col-sm-4">
                  <div class="filter-stacked">
                      <?php include('advanced_search_box_right.php');?>
                  </div><!-- /.filter-stacked -->

              </div>
              <!-- /.col-* -->
              <div class="col-md-9 col-sm-8">
              <?php
              if($row > 0) {
                  foreach ($prod_list_contents as $product) {
                      echo '
                            <div class="">
                              <div class="positions-list-item">
                                  <h2>
                                      <a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $product['products_id']) . '">
                                        ' . $product['products_name'] . '
                                      </a>
                                  </h2>
                                  <h3>
                                    <span>
                                        <img src="images/' . $product['photo'] . '" alt="">
                                    </span>
                                    ' . $product['company_name'] . ', ' . $product['location'] . '
                                    <br>
                                  </h3>

                                  <!-- /.position-list-item-date -->
                                  <div 
                                    class="position-list-item-date"
                                  >
                                    Close Date
                                  </div><!-- /.position-list-item-action -->
                                  
                                  <div class="position-list-item-action">
                                    ' . $product['products_close_date'] . '
                                  </div>
                              </div><!-- /.position-list-item -->

                          </div>
                        ';
                  }
              ?>
                  <!-- /.positions-list -->
                  <div class="center">
                      <br>
                      <ul class="pagination">
                          <?php
                          echo $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS,
                              tep_get_all_get_params(array('page', 'info', 'x', 'y'))
                          );
                          ?>
                      </ul>
                  </div><!-- /.center -->
              <?php
              } else {
              ?>
                  <div class="col-md-12">
                      <div class="alert alert-info"><?php echo TEXT_NO_PRODUCTS; ?></div>
                  </div>
                  <?php
              }
              ?>
              </div><!-- /.col-* -->
          </div><!-- /.row -->
      </div><!-- /.container -->
