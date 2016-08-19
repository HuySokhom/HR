<?php
echo
    tep_draw_form('advanced_search', tep_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false),
        'get',
        'class="form-horizontal" onsubmit="return check_form(this);"') . tep_hide_session_id();
?>
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
  echo tep_draw_pull_down_menu(
      'categories_id',
      tep_get_categories(array(array('id' => '', 'text' => TEXT_ALL_CATEGORIES))),
      NULL,
      'id="entryCategories" class="form-control"');
  ?>
</div><!-- /.form-group -->

<div class="form-group col-sm-3">
  <button type="submit" class="btn btn-block btn-secondary">Search</button>
</div><!-- /.form-group -->
</div><!-- /.row -->
</form>