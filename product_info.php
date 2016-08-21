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
			cu.company_name,
			cu.photo_thumbnail,
			cu.customers_email_address,
			cu.customers_address,
			cu.customers_website,
			cu.customers_telephone,
			p.products_kind_of,
			p.gender,
			p.number_of_hire,
			pd.products_name,
			l.name as province_name,
			pd.products_description,
			pd.skill,
			pd.benefits,
			pd.products_viewed,
			p.salary,
			p.products_date_added,
			p.products_close_date
		from
			" . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, location l, customers cu
		where
			p.products_status = '1'
				and
			cu.customers_id = p.customers_id
				and
			l.id = p.province_id
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
					  <?php echo $product_info['products_name'];?>
					  <span>Urgent</span>
				  </h1>
			  </div><!-- /.position-header -->

			  <div class="position-general-information">
				  <dl>
					  <dt>Location</dt>
					  <dd><?php echo $product_info['province_name'];?></dd>

					  <dt>Public Date</dt>
					  <dd><?php echo $product_info['products_date_added'];?></dd>
					  <dt>Close Date</dt>
					  <dd><?php echo $product_info['products_close_date'];?></dd>

					  <dt>Contract</dt>
					  <dd><?php echo $product_info['products_kind_of'];?></dd>

					  <dt>Salary</dt>
					  <dd>
						  <?php
						  	if($product_info['salary'] > 0){
								echo '$'.$product_info['salary'];
							}else{
								echo "Negotiable";
							}
						  ?>
					  </dd>

					  <dt>Number Of Hire</dt>
					  <dd><?php echo $product_info['number_of_hire'];?></dd>

					  <dt>Gender</dt>
					  <dd><?php echo $product_info['gender'];?></dd>

					  <dt>Job ID</dt>
					  <dd>#<?php echo $product_info['products_id'];?></dd>

					  <dt>View</dt>
					  <dd>
						  <?php echo $product_info['products_viewed'];?>
					  </dd>
				  </dl>
			  </div><!-- /.position-general-information -->

			  <h3 class="page-header">Description, duties, responsibilities</h3>
			  <p>
				  <?php echo $product_info['products_description'];?>
			  </p>

			  <h3 class="page-header">Other benefits</h3>
			  <?php echo $product_info['benefits'];?>

			  <h3 class="page-header">Personality requirements and skills</h3>
			  <?php echo $product_info['skill'];?>

		  </div><!-- /.col-* -->

		  <div class="col-sm-4">
			  <div class="company-card">
				  <div class="company-card-image">
					  <a href="<?php echo tep_href_link(FILENAME_INFORMATION, 'info_id=' . $product_info['customers_id']) ?>">
						  <img src="<?php echo $product_info['photo_thumbnail'];?>" alt=""></a>
					  </a>
				  </div><!-- /.company-card-image -->

				  <div class="company-card-data">
					  <dl>
						  <dt>Website</dt>
						  <dd>
							  <?php
								  if($product_info['customers_website']){
									  echo '
										  <a href="http://' . $product_info['customers_website'] . '" target="_blank">
											  ' . $product_info['customers_website'] . '
										  </a>';
								  }else{
									  echo 'N/A';
								  }
							  ?>
						  </dd>

						  <dt>E-mail</dt>
						  <dd>
							  <a href="mailto:<?php echo $product_info['customers_email_address'];?>">
								  <?php echo $product_info['customers_email_address'];?>
							  </a>
						  </dd>

						  <dt>Phone</dt>
						  <dd><?php echo $product_info['customers_telephone'];?></dd>

						  <dt>Address</dt>
						  <dd>
							  <?php echo $product_info['customers_address'];?>
						  </dd>
					  </dl>
				  </div><!-- /.company-card-data -->
			  </div><!-- /.company-card -->

			  <div class="hero-content-carousel">
				  <h2>Hot Jobs</h2>
				  <ul class="cycle-slideshow vertical"
					  data-cycle-fx="carousel"
					  data-cycle-slides="li"
					  data-cycle-carousel-visible="7"
					  data-cycle-carousel-vertical="true">
					  <li><a href="company-detail.html">Dropbox</a> is looking for UX/UI designer.</li>
					  <li>Python Developer <a href="index.html#">John Doe</a>.</li>
					  <li><a href="position-detail.html">IT consultant</a> is needed by <a href="company-detail.html">Twitter</a>.</li>
					  <li>Project manager wanted for <a href="company-detail.html">e-shop portal</a>.</li>
					  <li><a href="company-detail.html">Mark Peterson</a> needs to fix his website.</li>
					  <li><a href="company-detail.html">Facebook</a> is looking for <a href="position-detail.html">beta testers</a>.</li>
					  <li><a href="company-detail.html">Instagram</a> needs help with new API.</li>
					  <li><a href="company-detail.html">Dropbox</a> is looking for UX/UI designer.</li>
					  <li>Python Developer <a href="resume.html">John Doe</a> is looking for work.</li>
					  <li><a href="position-detail.html">IT consultant</a> is needed by <a href="company-detail.html">Twitter</a>.</li>
					  <li>Project manager wanted for one time <a href="index.html#">e-shop portal</a>.</li>
					  <li><a href="company-detail.html">Mark Peterson</a> needs to fix his website.</li>
					  <li><a href="company-detail.html">Facebook</a> is looking for <a href="position-detail.html">beta testers</a>.</li>
					  <li><a href="company-detail.html">Instagram</a> needs help with new API.</li>
				  </ul>
				  <a href="positions.html" class="hero-content-show-all">Show All</a>
			  </div>
			  <div class="widget">
				  <h2>Apply For Position</h2>

				  <form>
					  <div class="form-group">
						  <input type="text" id="name" class="form-control" placeholder="Name" required>
					  </div><!-- /.form-group -->

					  <div class="form-group">
						  <input type="email" class="form-control" id="email" placeholder="Your E-mail" required>
					  </div><!-- /.form-group -->

					  <div class="form-group">
						  <textarea class="form-control" rows="5" id="text" placeholder="Your Message" required></textarea>
					  </div><!-- /.form-group -->

					  <button class="btn btn-secondary pull-right" type="submit" id="sendEmail">Apply Now</button>
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
<script>

	$(function() {
		$('form').submit(function (e) {
			var form = {
				name: $('#name').val(),
				email: $('#email').val(),
				enquiry: $('#text').val()
			};
			e.preventDefault();
			console.log(form);
			$.ajax({
				type: 'POST',
				url: 'api/SendMail',
				data: form,
				success: function (response) {
					console.log(response);
					if (response == 0) {
						// ============================ Not here, this would be too late
						span.text('email does not exist');
					}
				}
			});
		});
	});

</script>