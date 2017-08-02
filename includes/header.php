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

    <div class="header-bottom">
      <div class="container">
        <div class="input-group" style="float:left; margin: 10px 10px 10px 0px;width:400px;">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button" style="padding: 0px 0px;">
              <img src="assets/favicon.png" style="width:38px;"/>
            </button>
          </span>
          <input type="text" class="form-control" placeholder="Search...">
          <div class="input-group-btn">
            <button type="button" class="btn btn-default dropdown-toggle" 
            data-toggle="dropdown" 
            aria-haspopup="true" aria-expanded="false">
            Search By 
            <span class="caret"></span></button>
            <ul class="dropdown-menu dropdown-menu-right">
              <li><a href="javascript:;">Function</a></li>
              <li><a href="javascript:;">Industry</a></li>
              <li><a href="javascript:;">Location</a></li>
              <li><a href="javascript:;">Salary</a></li>
            </ul>
          </div><!-- /btn-group -->
        </div>
        <ul class="header-nav nav nav-pills collapse menu" style="float:right;">
          <li>
            <a href="index.php">
              <i class="fa fa-home"></i>
              <br/>
              Home
            </a>
          </li>

          <li>
            <a href="employers.php">
              <i class="fa fa-briefcase"></i>
              <br/>
              Jobs
            </a>
          </li>

          <li>
            <a href="job_seekers.php">
              <i class="fa fa-file-text"></i>
              <br/>
              CV
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
              <i class="fa fa-envelope-o"></i>
              <br/>
              Contact
            </a>
          </li>

          <li >
            <a href="javascript:void(0)">
              <i class="fa fa-user-circle-o"></i>
              <br/>
              Account
            </a>

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
                <li><a href="login.php">Login</a></li>
                <li><a href="create_account.php">Sign Up</a></li>
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