<?php
require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ADVANCED_SEARCH);
?>
<div>
  <aside class="widget widget-search">
    <h2 class="widget-title">
      <?php echo TEXT_SEARCH;?>
      <span>
        <?php echo JOB;?>
      </span>
    </h2>
    <form name="advance_search" action="advanced_search_result.php" method="get">
      <?php
        echo tep_draw_input_field('keywords', '', 'required aria-required="true" id="inputKeywords" placeholder="' . TEXT_SEARCH_PLACEHOLDER . '"', 'search');
      ?>
      <br>
      <?php
        echo tep_draw_pull_down_menu(
            'categories_id',
            tep_get_categories(array(array('id' => '', 'text' => TEXT_ALL_CATEGORIES))),
            NULL,
            'id="entryCategories" class="form-control"');
      ?>
      <br>
      <?php
        echo tep_draw_pull_down_menu(
            'location',
            tep_get_province(array(array('id' => '', 'text' => TEXT_ALL_LOCATION))),
            NULL,
            'id="province" class="form-control"'
        );
      ?>
      <button type="submit" class="btn btn-secondary btn-block"><?php echo SEARCH;?></button>
    </form>
  </aside>

  <aside class="widget widget-property-featured">
    <div class="fb-page"
         data-href="https://www.facebook.com/skwebsolution"
         data-small-header="false" data-adapt-container-width="true"
         data-hide-cover="false" data-show-facepile="true">
      <blockquote cite="https://www.facebook.com/skwebsolution"
                  class="fb-xfbml-parse-ignore">
        <a href="https://www.facebook.com/skwebsolution">
          SKWeb Solution
        </a>
      </blockquote>
    </div>
<!--    <img src="images/free-ads.jpg" alt="" class="img-responsive" style="width: 100%;">-->
  </aside>
</div>