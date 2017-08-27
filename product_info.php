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
			cu.photo,
			cu.customers_email_address,
			cu.customers_address,
			cu.customers_website,
			cu.customers_telephone,
			cu.detail,
			p.products_kind_of,
			p.gender,
			p.number_of_hire,
			pd.products_name,
			l.name as province_name,
			pd.products_description,
			pd.skill,
			pd.benefits,
			pd.products_viewed,
			p.salary_id,
			DATE_FORMAT(p.products_date_added, '%d/%M/%Y') as products_date_added,
			DATE_FORMAT(p.products_close_date, '%d/%M/%Y') as products_close_date
		from
			" . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, 
			location l, customers cu
		where
			p.products_status = 1
			    and 
            p.is_publish = 1
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

	// query salary range if salary id > 0
	if($product_info['salary_id'] > 0){
		$salary_query = tep_db_query("
			select
				from_salary,
				to_salary
			from
				salary_range
			where
				id = ". $product_info['salary_id'] ."
		");
		$salary_info = tep_db_fetch_array($salary_query);
	}

	// query hot jobs
	$hot_product_query = tep_db_query("
		select
			p.products_id,
			p.customers_id,
			cu.company_name,
			pd.products_name
		from
			" . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, customers cu
		where
			p.products_status = '1'
				and
			cu.customers_id = p.customers_id
				and
			p.products_id != '".(int)$_GET['products_id'] ."'
				and
			pd.products_id = p.products_id
				and
			pd.language_id = '" . (int)$languages_id . "'
		order by
        	p.products_promote desc, rand(), p.products_close_date desc
		limit 15
	");
	$array_hot = array();
	while( $product_hot_info = tep_db_fetch_array($hot_product_query) ){
		$array_hot[] = $product_hot_info ;
	}

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
						<!--<span>Urgent</span>-->
				  </h1>
			  </div><!-- /.position-header -->

			  <div class="position-general-information table-responsive">
				<table class="table table-striped table-bordered">
					<tr>
						<td width="20%">
							Location
						</td>
						<td width="30%">
							<?php echo $product_info['province_name'];?>
						</td>						
						<td width="20%">
							Contract
						</td>
						<td width="30%">
							<?php echo $product_info['products_kind_of'];?>
						</td>
					</tr>
					<tr>
						<td>
							Public Date
						</td>
						<td>
							<?php echo $product_info['products_date_added'];?>
						</td>
						<td>
							Close Date
						</td>
						<td>
							<?php echo $product_info['products_close_date'];?>
						</td>
					</tr>
					<tr>
						<td>
							Salary
						</td>
						<td>
							<?php
								if($product_info['salary_id'] > 0){
									echo '$'.$salary_info['from_salary'] . ' - $'.$salary_info['to_salary'];
								}else{
									echo "Negotiable";
								}
							?>
						</td>
						<td>
							Number Of Hire
						</td>
						<td>
							<?php echo $product_info['number_of_hire'];?>
						</td>
					</tr>
					<tr>
						<td>
							Gender
						</td>
						<td>
							<?php echo $product_info['gender'];?>
						</td>
						<td>
							Job ID
						</td>
						<td>
							#<?php echo $product_info['products_id'];?>
						</td>
					</tr>
					<tr>
						<td>
							View
						</td>
						<td colspan="3">
							<?php echo $product_info['products_viewed'];?>
						</td>
					</tr>
  				</table>
			  </div><!-- /.position-general-information -->

			  <h3 class="page-header background-header">Description, duties, responsibilities</h3>
			  <p>
				  <?php echo $product_info['products_description'];?>
			  </p>

			  <h3 class="page-header background-header">Other benefits</h3>
			  <?php echo $product_info['benefits'];?>

			  <h3 class="page-header background-header">Personality requirements and skills</h3>
			  <?php echo $product_info['skill'];?>

			  <h3 class="page-header background-header">About Company</h3>
			  <?php echo $product_info['detail'];?>
		  </div><!-- /.col-* -->

		  <div class="col-sm-4">
			  <div class="company-card">
				  <div class="company-card-image">
					  <a href="<?php echo tep_href_link(FILENAME_INFORMATION, 'info_id=' . $product_info['customers_id']) ?>">
						  <img src="images/<?php echo $product_info['photo'];?>" alt=""></a>
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
					  data-cycle-carousel-visible="10"
					  data-cycle-carousel-vertical="true"
				  >
					  <?php
					  	foreach($array_hot as $hot){
							echo '
								<li>
									<a href="'. tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $hot['products_id']) .'"
									>
										' . $hot['products_name'] . '
									</a>
									' . $hot['company_name']. '
								</li>
							';
						}
					  ?>
				  </ul>
				  <a href="jobs_list.php" class="hero-content-show-all">Show All</a>
			  </div>
			  <div class="widget">
                  <img src="images/free-ads.jpg" class="img-responsive">
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