<?php
	require('includes/application_top.php');

	if (!isset($HTTP_GET_VARS['cv_id'])) {
		tep_redirect(tep_href_link(FILENAME_DEFAULT));
	}

	require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_PRODUCT_INFO);

	require(DIR_WS_INCLUDES . 'template_top.php');
	$info_query = tep_db_query("
		SELECT
			p.customer_id,
			p.summary,
			p.experience,
			p.viewed,
			p.phone_number,
			p.email,
			DATE_FORMAT(p.create_date, '%d/%m/%Y') as create_date,
			p.cover_letter_summary,
			p.working_history,
			p.apply_for,
			p.photo,
			p.prefer_location,
			l.name as prefer_location_name,
			p.nationality,
			p.religion,
			p.health,
			current_position,
			p.present_address,
			p.phone_number,
			p.full_name,
			p.function,
			cd.categories_name as function_name,
			p.marital_status,
			p.gender,
			p.dob,
			p.state_city,
			country_id,
			c.countries_name as country_name,
			p.salary_expected,
			p.is_publish,
			p.status
		FROM
			post_cv p LEFT JOIN countries c ON p.country_id = c.countries_id
			INNER JOIN categories_description cd ON p.function = cd.categories_id
			INNER JOIN location l ON l.id = p.prefer_location
		WHERE
			p.id = " . (int)$HTTP_GET_VARS['cv_id'] . "
				and
			status = 1
				and
			is_publish = 2
	");
	$info = tep_db_fetch_array($info_query);
?>
<div class="container">
	<br/>
	<div class="col-md-8">
<?php
  if (tep_db_num_rows($info_query) < 1) {
?>
	<div class="alert alert-warning">CV not found.</div>
	<div class="pull-right">
		<?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'fa fa-mail-forward', tep_href_link(FILENAME_DEFAULT)); ?>
	</div>
<?php
  } else {
?>
	 
	 <form data-ng-submit="vm.save()" class="form-horizontal" name="accountForm">
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="page-header title-header text-center" style="margin-top: 0px;">
						Cover Letter
					</div>
				</div>
				<div class="row">
					<div class="cv-header pull-right">
						<div class="text-right">
							<h4>
								<?php echo $info['full_name'];?>
							</h4>
						</div>
						<div class="text-right">
							<span> Present address: <?php echo $info['present_address'];?></span>
						</div>
						<?php 
							if (tep_session_is_registered('customer_id') == $info['customer_id']) {
								echo '<div class="text-right">
										<span> Phone number: '.$info['phone_number'].' </span>
									</div>
									<div class="text-right">
										<span> Email: '. $info['email'] . '</span>
									</div>';
							}
						?>
						
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="form-group">
					<label class="col-md-3">
						Apply For
					</label>
					<div class="col-md-5">
						<?php echo $info['apply_for'];?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3">
						Function
					</label>
					<div class="col-md-5">
						<?php echo $info['function_name'];?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3">
						Prefer Location
					</label>
					<div class="col-md-5">
						<?php echo $info['prefer_location_name'];?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3">
						Salary Expected
					</label>
					<div class="col-md-5">
						<?php echo $info['salary_expected'];?>
					</div>
				</div>
				<div class="row">
					<div class="page-header title-header col-md-12">
						Cover Letter Detail
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12">
						<?php echo $info['cover_letter_summary'];?>
					</div>
				</div>
				<!-- START CV INFORMATION -->
				<div class="row">
					<div class="page-header title-header text-center col-md-12">
						Curriculum Vitae(CV)
					</div>
				</div>
				<div class="row">
					<div class="col-md-9">
						<div class="form-group">
							<label class="col-md-3">
								Full Name
							</label>
							<div class="col-md-9">
								<?php echo $info['full_name'];?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3">
								Gender
							</label>
							<div class="col-md-9">
								<?php echo $info['gender'];?>
							</div>
						</div>
						<?php 
							if (tep_session_is_registered('customer_id') == $info['customer_id']) {
								echo '<div class="form-group">
									<label class="col-md-3">
										Date of Birth
									</label>
									<div class="col-md-9">
										'. $info['dob'] .'
									</div>
								</div>';
							}
						?>						
						<div class="form-group">
							<label class="col-md-3">
								Nationality
							</label>
							<div class="col-md-9">
								<?php echo $info['nationality'];?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3">
								Religion
							</label>
							<div class="col-md-9">
								<?php echo $info['religion'];?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3">
								Health
							</label>
							<div class="col-md-9">
								<?php echo $info['health'];?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3">
								Marital Status
							</label>
							<div class="col-md-9">
								<?php echo $info['marital_status'];?>
							</div>
						</div>
						<?php 
							if (tep_session_is_registered('customer_id') == $info['customer_id']) {
								echo '<div class="form-group">
									<label class="col-md-3">
										Telephone
									</label>
									<div class="col-md-9">
										'. $info['phone_number'] .'
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3">
										Email Address
									</label>
									<div class="col-md-9">
										'. $info['email'] .'
									</div>
								</div>';
							}
						?>
						
						<div class="form-group">
							<label class="col-md-3">
								Country
							</label>
							<div class="col-md-9">
								<?php echo $info['country_name'];?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3">
								State/City
							</label>
							<div class="col-md-9">
								<?php echo $info['state_city'];?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3">
								Current Position                             
							</label>
							<div class="col-md-9">
								<?php echo $info['current_position'];?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3">
								Present Address
							</label>
							<div class="col-md-9">
								<?php echo $info['present_address'];?>
							</div>
						</div>
					</div>

					<div class="col-sm-3">
						<img src="<?php echo $info['photo'];?>" alt="" srcset="" class="img-thumbnail">
					</div>
				</div>
				
				<!-- START Other -->
				<div class="row">
					<div class="page-header title-header col-md-12">
						Education Background
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<?php echo $info['experience'];?>
					</div>
				</div>
				<div class="row">
					<div class="page-header title-header col-md-12">
						Working Experience
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<?php echo $info['working_history'];?>
					</div>
				</div>
				<!-- START Other -->
				<div class="row">
					<div class="page-header title-header col-md-12">
						Other
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<?php echo $info['summary'];?>
					</div>
				</div>
			</div>
		</div>
		<!-- /.center -->
	</form>
<?php
  }
?>
	</div>
	
	<div class="col-md-4">
		<div class="">
			<?php include('advanced_search_box_right.php'); ?>
		</div>
		<?php
            $query = tep_db_query("
                select
                    a.title,
                    a.link,
                    a.image,
                    ad.name
                from
                    advertising_banner a, advertising_detail ad
                where
                    a.status = 1 
                        and 
                    a.id = ad.advertising_banner_id
                        and
					ad.name = 'CV List'
				order by
                    a.sort_order asc
            ");
            while ($item = tep_db_fetch_array($query)) {
                //var_dump($item);
                echo "<div class='col-md-12 col-sm-6 col-xs-6'>
                    <img src='images/". $item['image']."' class='img-responsive ads'/>
                </div>";
            }
        ?>
	</div>
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