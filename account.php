<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  	require('includes/application_top.php');
	if (!tep_session_is_registered('customer_id')) {
		$navigation->set_snapshot();
		tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
	}
  	require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ACCOUNT);
  	$breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_ACCOUNT, '', 'SSL'));

	require(DIR_WS_INCLUDES . 'template_top.php');
?>
<link href="ext/ng/lib/angular-datetime/angularjs-datetime-picker.css" rel="stylesheet" type="text/css">
<div
	class="container"
	data-ng-app="main"
>
	<br/>	
	<?php
	  if ($messageStack->size('account') > 0) {
		echo $messageStack->output('account');
	  }
	?>
	<div class="row">
		<div class="col-md-12">
			<div class="panel with-nav-tabs panel-default">
				<div class="panel-heading">
					<div class="tab-content">
						<ul class="nav nav-tabs" role="tablist">
							<?php 
								if($_SESSION['user_type'] == "agency"){
									echo '
										<li ui-sref-active="active">
											<a ng-href="account.php#/manage" ui-sref="/manage">
												<icon class="fa fa-desktop"></icon>
												' . ENTRY_MANAGE_POST . '
											</a>
										</li>
									';
								}
							?>
							<li ui-sref-active="active" ui-sref="/account">
								<a href="account.php#/account">
									<i class="fa fa-user"></i>
									<?php echo ENTRY_MY_ACCOUNT;?>
								</a>
							</li>
							<?php
								if($_SESSION['user_type'] == 'member'){
							?>
							<li ui-sref-active="active">
								<a ui-sref="/manage_news" href="account.php#/manageNews">
									<i class="fa fa-newspaper-o"></i>
									<?php echo ENTRY_MANAGE_NEWS;?>
								</a>
							</li>
							<?php
								}
							?>
						</ul>
					</div>
				</div>
				<div class="panel-body">
					<div class="tab-content">
						<div data-ui-view=""></div>
					</div>
				</div>
			</div>

<!--			<div class="alert alert-info">-->
<!--				<i class="fa fa-star"></i>-->
<!--				--><?php //echo TEXT_PLAN;?>
<!--			</div>-->
<!--			<div plan></div>-->
		</div>
    <?php
    	// don't need to show
//    	 echo $oscTemplate->getContent('account');
    ?>
	</div>
</div>
<?php
require(DIR_WS_INCLUDES . 'template_bottom.php');
require(DIR_WS_INCLUDES . 'application_bottom.php');
?>

<!-- lib -->
<script src="ext/tinymce/tinymce.min.js"></script>
<script
	type="text/javascript"
	src="ext/ng/lib/angular/1.3.15/angular.min.js"
></script>
<script
	type="text/javascript"
	src="ext/ng/lib/angular-cookies/angular-cookies.min.js"
></script>
<script
	type="text/javascript"
	src="ext/ng/lib/angular-ui-route/angular-ui-router.min.js"
></script>
<script
	type="text/javascript"
	src="ext/ng/lib/angular-sanitize/angular-sanitize.min.js"
></script>
<script
	type="text/javascript"
	src="ext/ng/lib/angular-tinymce/tinymce.js"
></script>
<script
	type="text/javascript"
	src="ext/ng/lib/angular-ui-bootstrap/ui-bootstrap-tpls-0.12.0.min.js"
></script>
<script
	type="text/javascript"
	src="ext/ng/lib/angular-alertify/js/ngAlertify.js"
></script>
<script
	type="text/javascript"
	src="ext/ng/lib/angular-datetime/angularjs-datetime-picker.min.js"
></script>
<script src="ext/ng/lib/angular-upload/ng-file-upload-shim.min.js"></script>
<!-- for no html5 browsers support -->
<script src="ext/ng/lib/angular-upload/ng-file-upload.min.js"></script>

<!-- custom file -->

<script
	type="text/javascript"
	src="ext/ng/app/account/main.js"
></script>
<script
	type="text/javascript"
	src="ext/ng/app/account/config/route.js"
></script>
<script
	type="text/javascript"
	src="ext/ng/app/core/restful/restful.js"
></script>
<script
	type="text/javascript"
	src="ext/ng/app/core/services/services.js"
></script>


<script
	type="text/javascript"
	src="ext/ng/app/account/controller/account_ctrl.js"
></script>
<script
	type="text/javascript"
	src="ext/ng/app/account/controller/account_edit_ctrl.js"
></script>
<script
	type="text/javascript"
	src="ext/ng/app/account/controller/property_ctrl.js"
></script>
<script
	type="text/javascript"
	src="ext/ng/app/account/controller/property_post_ctrl.js"
></script>
<script
	type="text/javascript"
	src="ext/ng/app/account/controller/property_edit_ctrl.js"
></script>
<script
	type="text/javascript"
	src="ext/ng/app/core/directive/number.js"
></script>
<script
	type="text/javascript"
	src="ext/ng/app/account/directive/plan.js"
></script>
