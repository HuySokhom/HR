<?php
    require('includes/application_top.php');
    require(DIR_WS_INCLUDES . 'template_top.php');
    $query = tep_db_query("select * from page_description where pages_id = ".(int)$_GET['pages_id']." and language_id = ". (int)$languages_id ." ");
    $content = tep_db_fetch_array($query);
?>
<br>
<div class="container">
  <div class="col-md-3">
    <div class="filter-stacked">
      <?php include('advanced_search_box_right.php');?> 
    </div>
  </div>
  <div class="contentContainer col-md-9 col-sm-6 p_l_z">
      <h4><?php echo $content['pages_title']; ?></h4>
      <p style="text-align: justify;">
          <?php echo $content['pages_content']?>
      </p>
  </div>
</div>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
