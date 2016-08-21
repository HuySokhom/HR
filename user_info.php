<?php
    require('includes/application_top.php');
    require(DIR_WS_INCLUDES . 'template_top.php');
    /**
     * query user information with filter by ID (int)$_GET['info_id']
     **/
    $query = tep_db_query("
        SELECT
            company_name,
            customers_website,
            user_type,
            photo
        FROM
            customers
        WHERE
            customers_id = ". (int)$_GET['info_id'] . "
        LIMIT 1
    ");
    $customer_info = tep_db_fetch_array($query);
?>
<br>
<div class="container">
    <?php
        if($customer_info['user_type'] == 'normal')
        {
    ?>
    <div class="resume">
        <div class="resume-main">
            <div class="resume-main-image">
                <img src="assets/img/tmp/resume.jpg" alt="">

                <a href="#" class="resume-main-image-label">
                    <img src="assets/img/tmp/instagram.png" alt="">
                </a>
            </div><!-- /.resume-main-image -->

            <div class="resume-main-content">
                <h2>Elliot Sarah Scott
                    <span class="resume-main-verified"><i class="fa fa-check"></i></span>

        <span class="resume-main-rating">
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <span class="resume-main-rating-count">/ 32</span>
        </span><!-- /.resume-main-rating -->
                </h2>

                <h3>Senior Data Analytist</h3>

                <p class="resume-main-contacts">
                    Timothy Blvd, Silicon Valley, California<br>
                    Email: <a href="mailto:hello@example.com">hello@example.com</a> - Website: <a href="http://example.com">www.example.com</a>
                </p><!-- /.resume-main-contact -->

                <div class="resume-main-actions">
                    <a href="#" class="btn btn-secondary"><i class="fa fa-download"></i> Download</a>
                    <a href="#" class="btn btn-default">Contact</a>
                    <a href="#" class="btn btn-default">Save</a>
                </div><!-- /.resume-main-actions -->
            </div><!-- /.resume-main-content -->
        </div><!-- /.resume-main -->

        <div class="resume-chapter">
            <div class="resume-chapter-inner">
                <div class="resume-chapter-content">
                    <div class="row">
                        <div class="col-sm-3">
                <span class="resume-chapter-social">
                    <span class="resume-chapter-social-icon"><i class="fa fa-facebook-square"></i></span>
                    <span class="resume-chapter-social-value">5 699 likes</span>
                </span><!-- /.resume-chapter-social -->
                        </div><!-- /.col-* -->

                        <div class="col-sm-3">
                <span class="resume-chapter-social">
                    <span class="resume-chapter-social-icon"><i class="fa fa-twitter-square"></i></span>
                    <span class="resume-chapter-social-value">800 tweets </span>
                </span><!-- /.resume-chapter-social -->
                        </div><!-- /.col-* -->

                        <div class="col-sm-3">
                <span class="resume-chapter-social">
                    <span class="resume-chapter-social-icon"><i class="fa fa-linkedin-square"></i></span>
                    <span class="resume-chapter-social-value">@elliot </span>
                </span><!-- /.resume-chapter-social -->
                        </div><!-- /.col-* -->

                        <div class="col-sm-3">
                <span class="resume-chapter-social">
                    <span class="resume-chapter-social-icon"><i class="fa fa-youtube-square"></i></span>
                    <span class="resume-chapter-social-value">@elliot</span>
                </span><!-- /.resume-chapter-social -->
                        </div><!-- /.col-* -->
                    </div><!-- /.row -->
                </div><!-- /.recume-chapter-content -->
            </div><!-- /.resume-chapter-inner -->
        </div><!-- /.resume-chapter -->

        <div class="resume-chapter">
            <div class="resume-chapter-inner">
                <div class="resume-chapter-title">
                    <h2>Summary</h2>
                </div><!-- /.resume-chapter-title -->

                <div class="resume-chapter-content">
                    <p>
                        Curabitur sed tortor id elit elementum tincidunt eget a turpis. Pellentesque nibh felis, rhoncus ut sem vel, blandit viverra felis. Integer consequat volutpat lectus vel commodo.
                    </p>

                    <p>
                        Nam pellentesque ac orci at tempus. Nulla sed nunc scelerisque, rhoncus magna vitae, placerat nisi. Fusce convallis ex nec tellus vulputate vehicula. Duis venenatis turpis a varius lacinia. Fusce eu est lectus. Integer commodo fringilla libero, non sodales ipsum consectetur sit amet. Aenean non ligula ac est dapibus feugiat.
                    </p>
                </div><!-- /.resume-chapter-content -->
            </div><!-- /.resume-chapter-inner -->
        </div><!-- /.resume-chapter -->

        <div class="resume-chapter">
            <div class="resume-chapter-inner">
                <div class="resume-chapter-content">
                    <h2 class="mb40">Working History</h2>

                    <dl>
                        <dt>Current</dt>

                        <dd>
                            <h3>Project Manager</h3>

                            <p>
                                Fusce eu est lectus. Integer commodo fringilla libero, non sodales ipsum consectetur sit amet. Aenean non ligula ac est dapibus feugiat. Fusce convallis ex nec tellus vulputate.
                            </p>
                        </dd>

                        <dt>2011 - 2014</dt>

                        <dd>
                            <h3>Senior UX/UI designer</h3>

                            <p>
                                Fusce eu est lectus. Integer commodo fringilla libero, non sodales ipsum consectetur sit amet. Aenean non ligula ac est dapibus feugiat. Fusce convallis ex nec tellus vulputate.
                            </p>
                        </dd>

                        <dt>2010 - 2011</dt>

                        <dd>
                            <h3>Junior UX/UI designer</h3>

                            <p>
                                Fusce eu est lectus. Integer commodo fringilla libero, non sodales ipsum consectetur sit amet. Aenean non ligula ac est dapibus feugiat. Fusce convallis ex nec tellus vulputate.
                            </p>
                        </dd>

                        <dt>2009 - 2010</dt>

                        <dd>
                            <h3>UX Tester</h3>

                            <p>
                                Fusce eu est lectus. Integer commodo fringilla libero, non sodales ipsum consectetur sit amet. Aenean non ligula ac est dapibus feugiat. Fusce convallis ex nec tellus vulputate.
                            </p>
                        </dd>
                    </dl>
                </div><!-- /.resume-chapter-content -->
            </div><!-- /.resume-chapter-inner -->
        </div><!-- /.resume-chapter -->

        <div class="resume-chapter">
            <div class="resume-chapter-inner">
                <div class="resume-chapter-title">
                    <h2>Experience</h2>
                </div><!-- /.resume-chapter-title -->

                <div class="resume-chapter-content">
                    <div class="row">
                        <div class="col-sm-4">
                            <h4>Frameworks</h4>

                            <ul>
                                <li>Laravel, <span>4 years</span></li>
                                <li>Zend, <span>3 years</span></li>
                                <li>CakePHP, <span>1 year</span></li>
                                <li>Yii, <span>1 year</span></li>
                            </ul>
                        </div><!-- /.col-* -->

                        <div class="col-sm-4">
                            <h4>Operating Systems</h4>

                            <ul>
                                <li>Debian, <span>7 years</span></li>
                                <li>FreeBSD, <span>5 years</span></li>
                                <li>Ubuntu, <span>1 year</span></li>
                                <li>Gentoo, <span>1 year</span></li>
                            </ul>
                        </div><!-- /.col-* -->

                        <div class="col-sm-4">
                            <h4>Languages</h4>

                            <ul>
                                <li>English, <span>native</span></li>
                                <li>German, <span>intermediate</span></li>
                                <li>French, <span>beginner</span></li>
                                <li>Spanish, <span>beginner</span></li>
                            </ul>
                        </div><!-- /.col-* -->
                    </div><!-- /.row -->
                </div><!-- /.resume-chapter-content -->
            </div><!-- /.resume-chapter-inner -->
        </div><!-- /.resume-chapter -->
    </div>
    <?php
        }else{
    ?>
    <div class="col-sm-4">
        <div class="company-card">
            <div class="company-card-image">
                <span>Top Employeer</span>
                <a href="company-detail.html">
                    <img src="assets/img/tmp/dropbox.png" alt=""></a>

            </div><!-- /.company-card-image -->
<?php
var_dump($customer_info);
?>
            <div class="company-card-data">
                <dl>
                    <dt>Website</dt>
                    <dd><a href="http://example.com">www.example.com</a></dd>

                    <dt>E-mail</dt>
                    <dd><a href="#">info@example.com</a></dd>

                    <dt>Phone</dt>
                    <dd>1-234-456-789</dd>

                    <dt>Address</dt>
                    <dd>
                        Everton Street 231,<br>
                        San Francisco, California
                    </dd>
                </dl>
            </div><!-- /.company-card-data -->
        </div><!-- /.company-card -->


        <div class="widget">
            <ul class="social-links">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                <li><a href="#"><i class="fa fa-tumblr"></i></a></li>
            </ul>
        </div><!-- /.widget -->

        <div class="widget">
            <h2>Contact Company</h2>

            <form method="get" action="?">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Subject">
                </div><!-- /.form-group -->

                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Your E-mail">
                </div><!-- /.form-group -->

                <div class="form-group">
                    <textarea class="form-control" rows="5" placeholder="Your Message"></textarea>
                </div><!-- /.form-group -->

                <button class="btn btn-secondary pull-right" type="submit">Post Message</button>
            </form>
        </div><!-- /.widget -->
    </div><!-- /.col-* -->

    <div class="col-sm-8">
        <div class="company-header">
            <h1>Dropbox <span>File Hosting Service</span></h1>

            <a href="#" class="btn btn-secondary">Favorite</a>
            <a href="#" class="btn btn-default">Receive updates</a>
            <a href="#" class="btn btn-default">Follow</a>
        </div><!-- /.company-header -->

        <div class="company-stats">
            <div class="company-stat">
                <span>Positions</span>
                <strong>12</strong>
            </div><!-- /.company-stat -->

            <div class="company-stat">
                <span>Employees</span>
                <strong>43</strong>
            </div><!-- /.company-stat -->

            <div class="company-stat">
                <span>Followers</span>
                <strong>324</strong>
            </div><!-- /.company-stat -->
        </div><!-- /.company-stat -->

        <h3 class="page-header">Company Profile</h3>

        <p>
            Mauris ut blandit dolor. Cras sit amet pulvinar ante. Phasellus elementum vel diam quis molestie. Quisque vitae urna tincidunt, consequat lectus nec, vehicula risus. Proin lacus felis, viverra ut nisl vel, ornare sollicitudin turpis. Vestibulum scelerisque commodo malesuada. Fusce eu augue ex. Praesent risus dui, suscipit in efficitur viverra, eleifend sed erat. Curabitur ac pharetra neque.
        </p>

        <h3 class="page-header">Open Positions</h3>

        <div class="positions-list">
            <div class="positions-list-item">
                <h2><a href="#">Senior Data Analytist</a></h2>
                <h3><span><img src="assets/img/tmp/dropbox.png" alt=""></span> San Francisco, Dropbox <br></h3>

                <div class="position-list-item-date">11/11/2015</div><!-- /.position-list-item-date -->
                <div class="position-list-item-action"><a href="#">Save Position</a></div><!-- /.position-list-item-action -->
            </div><!-- /.positions-list-item -->

            <div class="positions-list-item">
                <h2><a href="#">Lead Python Developer</a></h2>
                <h3><span><img src="assets/img/tmp/dropbox.png" alt=""></span> San Francisco, Dropbox <br></h3>

                <div class="position-list-item-date">11/11/2015</div><!-- /.position-list-item-date -->
                <div class="position-list-item-action"><a href="#">Save Position</a></div><!-- /.position-list-item-action -->
            </div><!-- /.positions-list-item -->

            <div class="positions-list-item">
                <h2><a href="#">Personal Relations Manager</a></h2>
                <h3><span><img src="assets/img/tmp/dropbox.png" alt=""></span> San Francisco, Dropbox <br></h3>

                <div class="position-list-item-date">11/11/2015</div><!-- /.position-list-item-date -->
                <div class="position-list-item-action"><a href="#">Save Position</a></div><!-- /.position-list-item-action -->
            </div><!-- /.positions-list-item -->

            <div class="positions-list-item">
                <h2><a href="#">Account Manager</a></h2>
                <h3><span><img src="assets/img/tmp/dropbox.png" alt=""></span> San Francisco, Dropbox <br></h3>

                <div class="position-list-item-date">11/11/2015</div><!-- /.position-list-item-date -->
                <div class="position-list-item-action"><a href="#">Save Position</a></div><!-- /.position-list-item-action -->
            </div><!-- /.positions-list-item -->
        </div><!-- /.positions-list -->
    </div><!-- /.col-sm-8 -->
    <?php
        }
    ?>
</div>
<?php
    require(DIR_WS_INCLUDES . 'template_bottom.php');
    require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
