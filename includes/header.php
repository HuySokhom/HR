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
              <img src="assets/favicon.png"/>
              <span class="header-logo-text">HRKING<span class="header-logo-highlight">.</span>Com</span>
            </a>
          </div>
          <!-- /.header-logo-->
        </div>
        <!-- /.header-brand -->
        <?php
          if(tep_db_num_rows($query) > 0) {
            ?>
            <div class="col-md-7">
              <a href="<?php echo $ad['link']; ?>" target="_blank">
                <img src="images/<?php echo $ad['image']; ?>"
                     alt="<?php echo $ad['title']; ?>"
                     title="<?php echo $ad['title']; ?>"
                     border="0"
                     style="width: 800px;height: 85px;"
                     class="img-responsive"/>
              </a>
            </div>
        <?php
          }
        ?>
        <ul class="header-actions nav nav-pills">
        <?php
          if(!tep_session_is_registered('customer_id')){
        ?>
          <li><a href="login.php"><i class="fa fa-sign-in"></i> Login</a></li>
          <li><a href="create_account.php"><i class="fa fa-external-link"></i> Sign Up</a></li>
        <?php }else{
          echo '<li><a href="account.php"><i class="fa fa-user"></i>  My Account</a></li>
            <li><a href="logoff.php"><i class="fa fa-sign-out"></i> Sign Out</a></li>
          ';
          }?>
          <?php
          if(!tep_session_is_registered('customer_id')) {
            ?>
            <li><a href="account.php#/manage/post" class="primary">Post Job Now</a></li>
            <?php
          }
          ?>
        </ul><!-- /.header-actions -->

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
        <ul class="header-nav nav nav-pills collapse menu">
          <li>
            <a href="index.php">Home</a>
          </li>

          <li>
            <a href="employers.php">
              Employers
            </a>
          </li>

          <li>
            <a href="job_seekers.php">
              Job Seekers
            </a>
          </li>

          <li >
            <a href="javascript:void(0)">
              Services
              <i class="fa fa-chevron-down"></i>
            </a>

            <ul class="sub-menu">
              <li><a href="<?php echo tep_href_link(FILENAME_PAGES, 'pages_id=1');?>">Recruitment</a></li>
              <li><a href="<?php echo tep_href_link(FILENAME_PAGES, 'pages_id=2');?>">Training</a></li>
              <li><a href="<?php echo tep_href_link(FILENAME_PAGES, 'pages_id=3');?>">Outsourcing</a></li>
              <li>
                <a href="<?php echo tep_href_link(FILENAME_PAGES, 'pages_id=4');?>">
                  Consulting
                </a>
              </li>
            </ul><!-- /.sub-menu -->
          </li>
          <li>
            <a href="contact_us.php">
              Contact us
            </a>
          </li>
          <li>
            <a href="lesson.php">
              Lesson
            </a>
          </li>
        </ul>

      </div><!-- /.container -->
    </div><!-- /.header-bottom -->
  </div><!-- /.header -->
</div>
<!-- /.header-wrapper-->