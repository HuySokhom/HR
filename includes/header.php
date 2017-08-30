<?php
  $query = tep_db_query("
    select
      title, link, image
    from
      advertising_banner
    where
      status = 1 and location = 'top'
    order by id desc limit 1
  ");
  $ad = tep_db_fetch_array($query);
?>
<div class="header-wrapper">
  <div class="header">
    <div class="header-top">
      <div class="container">
        <div class="header-brand">
          <div class="header-logo">
            <a href="index.php">
              <?php
                echo '<a href="' . tep_href_link('index.php') . '">
                    <img src="' . DIR_WS_IMAGES . STORE_LOGO .'" 
                    class="header-logo-text" alt="logo"/></a>';
              ?>
            </a>
          </div>
          <!-- /.header-logo-->
        </div>
        <!-- /.header-brand -->
        <?php
          if(tep_db_num_rows($query) > 0) {
            ?>
            <div class="col-md-7 col-sm-7">
              <a href="<?php echo $ad['link']; ?>" target="_blank">
                <img src="images/<?php echo $ad['image']; ?>"
                     alt="<?php echo $ad['title']; ?>"
                     title="<?php echo $ad['title']; ?>"
                     border="0"
                     style="max-height: 85px;"
                     class="img-responsive"/>
              </a>
            </div>
        <?php
          }
        ?>
        <!-- /.header-actions -->

        <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".header-nav">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div><!-- /.container -->
    </div><!-- /.header-top -->

    <div class="header-bottom hidden-xs">
      <div class="container">
        <?php
          echo
              tep_draw_form('advanced_search', tep_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false),
                  'get',
                  'class="form-horizontal" onsubmit="return check_form(this);"') . tep_hide_session_id();
        ?>
          <div class="input-group" style="float:left; margin: 10px 10px 10px 0px;width:400px;">
            <span class="input-group-btn">
              <button class="btn btn-default" type="submit" style="padding: 0px 0px;">
                <img src="assets/favicon.png" style="width:38px;"/>
              </button>
            </span>
            <input type="text" class="form-control" name="keywords" placeholder="Search...">
            <div class="input-group-btn">
              <button type="button" class="btn btn-default dropdown-toggle" 
              data-toggle="dropdown" 
              aria-haspopup="true" aria-expanded="false">
              Search By 
              <span class="caret"></span></button>
              <ul class="dropdown-menu dropdown-menu-right">
                <li><a href="javascript:;" data-toggle="modal" data-target="#function">Functions</a></li>
                <li><a href="javascript:;" data-toggle="modal" data-target="#industry">Industries</a></li>
                <li><a href="javascript:;" data-toggle="modal" data-target="#locations">Locations</a></li>
                <li><a href="javascript:;" data-toggle="modal" data-target="#salary">Salaries</a></li>
              </ul>
            </div><!-- /btn-group -->
          </div>
        </form>
        <ul class="header-nav nav nav-pills collapse menu" style="float:right;">
          <li>
            <a href="index.php">
              <i class="fa fa-home"></i>
              <br/>
              Home
            </a>
          </li>

          <li>
            <a href="jobs_list.php">
              <i class="fa fa-briefcase"></i>
              <br/>
              Jobs
            </a>
          </li>

          <li>
            <a href="job_seekers.php">
              <i class="fa fa-file-text"></i>
              <br/>
              CVs
            </a>
          </li>
          <li>
            <a href="employers.php">
              <i class="fa fa-briefcase"></i>
              <br/>
              Companies
            </a>
          </li>
          <!-- <li>
            <a href="account.php#/manage/post">
              <i class="fa fa-cloud"></i>
              <br/>
              Post Job
            </a>
          </li> -->
          <li>
            <a href="contact_us.php">
              <i class="fa fa-phone"></i>
              <br/>
              Contact Us
            </a>
          </li>

          <li>
            <?php
              if(!tep_session_is_registered('customer_id')){
                echo '
                  <a href="javascript:void(0)">
                    <i class="fa fa-user-circle-o"></i>
                    <br/>
                    Account
                  </a>';
              }else{
                if($_SESSION['user_name']){
                  $user = $_SESSION['user_type'] == "normal" ? $_SESSION['user_name'] : $_SESSION['company_name'];
                  echo '
                    <a href="javascript:void(0)">
                      <img src="images/'.$_SESSION['user_photo'].'" class="img-circle" width="30px"/>
                      <br/>
                      $user
                    </a>
                  ';
                }else{
                  echo '
                    <a href="javascript:void(0)">
                      <i class="fa fa-user-circle-o"></i>
                      <br/>
                      Account
                    </a>';
                }
              }
            ?>
            <ul class="sub-menu">
              <?php
                if(!tep_session_is_registered('customer_id')){
              ?>
              <!-- <li><a href="<?php echo tep_href_link(FILENAME_PAGES, 'pages_id=1');?>">Recruitment</a></li>
              <li><a href="<?php echo tep_href_link(FILENAME_PAGES, 'pages_id=2');?>">Training</a></li>
              <li><a href="<?php echo tep_href_link(FILENAME_PAGES, 'pages_id=3');?>">Outsourcing</a></li>
              <li>
                <a href="<?php echo tep_href_link(FILENAME_PAGES, 'pages_id=4');?>">
                  Consulting
                </a>
              </li>  -->
                <li><a href="login.php">Login Or Register</a></li>
                <!-- <li><a href="create_account.php">Sign Up</a></li> -->
              <?php }else{
                echo '<li><a href="account.php">My Profile</a></li>
                  <li><a href="logoff.php">Sign Out</a></li>
                ';
                }?>
            </ul><!-- /.sub-menu -->
          </li>          
        </ul>
        <!-- <ul class="header-actions nav nav-pills">        
        </ul> -->
      </div><!-- /.container -->
    </div><!-- /.header-bottom -->
  </div><!-- /.header -->
</div>
<!-- /.header-wrapper-->

<!-- Modal For Function PopUp -->
<div id="function" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Functions</h4>
      </div>
      <div class="modal-body">
        <ul class="filter-list">
            <?php echo tep_get_categories_list();?>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- Modal For Locations PopUp -->
<div id="locations" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Locatons</h4>
      </div>
      <div class="modal-body">
        <ul class="filter-list">
            <?php echo tep_get_province_list();?>
        </ul>
      </div>
    </div>
  </div>
</div>


<!-- Modal For Salary PopUp -->
<div id="salary" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Salary Range</h4>
      </div>
      <div class="modal-body">
        <ul class="filter-list">
            <?php echo tep_get_salary_range_list();?>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- Modal For Industries PopUp -->
<div id="industry" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Industries Range</h4>
      </div>
      <div class="modal-body">
        <ul class="filter-list">
            <?php echo tep_get_industry_list();?>
        </ul>
      </div>
    </div>
  </div>
</div>