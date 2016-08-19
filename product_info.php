<?php
	require('includes/application_top.php');

	if (!isset($HTTP_GET_VARS['products_id'])) {
	tep_redirect(tep_href_link(FILENAME_DEFAULT));
	}

	require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_PRODUCT_INFO);

	require(DIR_WS_INCLUDES . 'template_top.php');
	$product_info_query = tep_db_query("
		select
			p.products_id,
			p.customers_id,
			p.products_kind_of,
			p.products_image_thumbnail,
			pd.products_name,
			v.name_en as village_name,
			l.name as province_name,
			d.name_en as district_name,
			pd.products_description,
			p.map_lat,
			p.map_long,
			p.bed_rooms,
			p.bath_rooms,
			p.number_of_floors,
			pd.products_viewed,
			p.products_image,
			p.products_price,
			p.products_tax_class_id,
			p.products_date_added
		from
			" . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, location l, village v, district d
		where
			p.products_status = '1'
				and
			v.id = p.village_id
				and
			l.id = p.province_id
				and
			d.id = p.district_id
				and
			p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "'
				and
			pd.products_id = p.products_id
				and
			pd.language_id = '" . (int)$languages_id . "'
	");
	$product_info = tep_db_fetch_array($product_info_query);
?>
<br>
<div class="container">
<?php
  if (tep_db_num_rows($product_info_query) < 1) {
?>
	<br>
	<div class="col-md-3">
		<div class="filter-stacked">
			<?php include('advanced_search_box_right.php'); ?>
		</div>
	</div>
	<div class="col-md-8">
		<div class="alert alert-warning"><?php echo TEXT_PRODUCT_NOT_FOUND; ?></div>
		<div class="pull-right">
			<?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'fa fa-mail-forward', tep_href_link(FILENAME_DEFAULT)); ?>
		</div>
	</div>
	<br>
	<br>
	<br>
<?php
  } else {
    tep_db_query("
        UPDATE
            " . TABLE_PRODUCTS_DESCRIPTION . "
        SET
            products_viewed = products_viewed+1
        WHERE
            products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "'
    ");

?>
	  <div class="row">
		  <div class="col-sm-8">
			  <div class="position-header">
				  <h1>
					  Senior Java Developer
					  <span>Urgent</span>
				  </h1>

				  <h2>
				<span class="position-header-company-image">
					<a href="company-detail.html">
						<img src="assets/img/tmp/dropbox.png" alt="">
					</a>
				</span>

					  <a href="company-detail.html">
						  Dropbox
					  </a>
				  </h2>
			  </div><!-- /.position-header -->

			  <div class="position-general-information">
				  <dl>
					  <dt>Location</dt>
					  <dd>San Fracisco, California</dd>

					  <dt>Start Date</dt>
					  <dd>28/11/2015</dd>

					  <dt>Contract</dt>
					  <dd>Full time</dd>

					  <dt>Salary</dt>
					  <dd>By agreement</dd>

					  <dt>Job ID</dt>
					  <dd>#1234</dd>
				  </dl>
			  </div><!-- /.position-general-information -->

			  <h3 class="page-header">Description, duties, responsibilities</h3>
			  <p>
				  Vivamus dignissim ex eu diam eleifend pharetra. Aliquam eleifend arcu quis risus scelerisque feugiat. Donec suscipit tincidunt purus et vulputate. Proin ac rutrum urna, nec elementum leo. Praesent commodo neque nunc, efficitur aliquam quam iaculis a. Sed quis eros justo. Pellentesque ut turpis quam.
			  </p>

			  <h3 class="page-header">Other benefits</h3>

			  <ul>
				  <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
				  <li>Aliquam tincidunt mauris eu risus.</li>
				  <li>Vestibulum auctor dapibus neque.</li>
				  <li>Nunc dignissim risus id metus.</li>
				  <li>Cras ornare tristique elit.</li>
				  <li>Vivamus vestibulum nulla nec ante.</li>
				  <li>Praesent placerat risus quis eros.</li>
				  <li>Fusce pellentesque suscipit nibh.</li>
				  <li>Integer vitae libero ac risus egestas placerat.</li>
				  <li>Vestibulum commodo felis quis tortor.</li>
				  <li>Ut aliquam sollicitudin leo.</li>
				  <li>Cras iaculis ultricies nulla.</li>
				  <li>Donec quis dui at dolor tempor interdum.</li>
				  <li>Vivamus molestie gravida turpis.</li>
				  <li>Fusce lobortis lorem at ipsum semper sagittis.</li>
				  <li>Nam convallis pellentesque nisl.</li>
				  <li>Integer malesuada commodo nulla.</li>
			  </ul>

			  <h3 class="page-header">Personality requirements and skills</h3>

			  <ul>
				  <li>Ut aliquam sollicitudin leo.</li>
				  <li>Cras iaculis ultricies nulla.</li>
				  <li>Donec quis dui at dolor tempor interdum.</li>
				  <li>Vivamus molestie gravida turpis.</li>
				  <li>Fusce lobortis lorem at ipsum semper sagittis.</li>
			  </ul>
		  </div><!-- /.col-* -->

		  <div class="col-sm-4">
			  <div class="company-card">
				  <div class="company-card-image">
					  <span>Top Employeer</span>
					  <a href="company-detail.html">
						  <img src="assets/img/tmp/dropbox.png" alt=""></a>
					  </a>
				  </div><!-- /.company-card-image -->

				  <div class="company-card-data">
					  <dl>
						  <dt>Website</dt>
						  <dd><a href="http://example.com">www.example.com</a></dd>

						  <dt>E-mail</dt>
						  <dd><a href="position-detail.html#">info@example.com</a></dd>

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
				  <h2>Apply For Position</h2>

				  <form method="get" action="position-detail_2.html">
					  <div class="form-group">
						  <input type="text" class="form-control" placeholder="Subject">
					  </div><!-- /.form-group -->

					  <div class="form-group">
						  <input type="text" class="form-control" placeholder="Your E-mail">
					  </div><!-- /.form-group -->

					  <div class="form-group">
						  <textarea class="form-control" rows="5" placeholder="Your Message"></textarea>
					  </div><!-- /.form-group -->

					  <button class="btn btn-secondary pull-right" type="submit">Apply Now</button>
				  </form>
			  </div><!-- /.widget -->
		  </div><!-- /.col-* -->
	  </div><!-- /.row -->
	  <?php
  }
?>
</div><!-- /.container -->
<br><br>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
<script
	type="text/javascript"
	src="ext/ng/lib/angular/1.3.15/angular.min.js"
></script>
<script>
	var app = angular.module('main', []);
	app.controller(
		'send_mail_ctrl', [
			'$scope'
			, '$http'
			, function ($scope, $http){
				$scope.language_id = '';
				$scope.sendMail = function(){
					var params = {
						name: $scope.name,
						email: $scope.email,
						enquiry: $scope.enquiry
					};
					console.log(params);
					$http({
						url: 'api/SendMail',
						method: 'POST',
						headers: {
							'Content-Type': undefined
						},
						data: JSON.stringify(params)
					}).success(function(data){
						console.log(data);
					});
				};


			}
		]);
</script>