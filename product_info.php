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
			DATE_FORMAT(p.products_date_added, '%d/%m/%Y') as products_date_added,
			DATE_FORMAT(p.products_close_date, '%d/%m/%Y') as products_close_date
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
			p.products_status = 1
				and
			p.is_publish = 1
				and
			date(p.products_close_date) >= date(NOW())
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
<div class="container" data-ng-controller="product_info_ctrl as vm">
<?php
if (tep_db_num_rows($product_info_query) < 1) {
?>
	<br>
	<div class="col-md-8">
		<div class="alert alert-warning"><?php echo TEXT_PRODUCT_NOT_FOUND; ?></div>
		<div class="pull-right">
			<?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'fa fa-mail-forward', tep_href_link(FILENAME_DEFAULT)); ?>
		</div>
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
					ad.name = 'Job Description'
			");
			while ($item = tep_db_fetch_array($query)) {
				//var_dump($item);
				echo "<div class='col-md-12 col-sm-6 col-xs-6'>
					<img src='images/". $item['image']."' class='img-responsive ads'/>
				</div>";
			}
		?>
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
					<?php 
						if(!tep_session_is_registered('customer_id')){
							echo '<button class="btn btn-info btn-apply pull-right" data-toggle="modal" data-target="#please-login">
									<i class="fa fa-location-arrow"></i>
									Apply Now
								</button>';
						}else{
							echo '<button class="btn btn-info btn-apply pull-right" data-toggle="modal" data-target="#apply-job">
									<i class="fa fa-location-arrow"></i>
									Apply Now
								</button>
							';
						}
					?>
				</h1>
			</div>
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
			<div class="page-header title-header">
				Description
			</div>
			<p>
				<?php echo $product_info['products_description'];?>
			</p>
			<div class="page-header title-header">
				Requirements
			</div>
			
			<?php echo $product_info['skill'];?>
			<div class="page-header title-header">
				Others
			</div>
			
			<?php echo $product_info['benefits'];?>
			<p class="text-center" style="margin-top: 10px;">
				<?php 
					if(!tep_session_is_registered('customer_id')){
						echo '<button class="btn btn-info btn-apply" data-toggle="modal" data-target="#please-login">
								<i class="fa fa-location-arrow"></i>
								Apply Now
							</button>';
					}else{
						echo '<button class="btn btn-info btn-apply" data-toggle="modal" data-target="#apply-job">
								<i class="fa fa-location-arrow"></i>
								Apply Now
							</button>
						';
					}
				?>
			</p>
			<div class="page-header title-header">
				About Company
			</div>
			<?php echo $product_info['detail'];?>
		</div><!-- /.col-* -->

		<div class="col-sm-4">
			<div class="company-card">
				<div class="company-card-image">
					<a href="<?php echo tep_href_link(FILENAME_INFORMATION, 'info_id=' . $product_info['customers_id']) ?>">
						<img src="<?php echo $product_info['photo'];?>" alt=""></a>
					</a>
				</div><!-- /.company-card-image -->

				<div class="company-card-data">
				<form class="form-horizontal">
					<div class="col-md-12">	
						<div class="form-group">
							<label class="col-sm-4">
								Company
							</label>
							<div class="col-sm-8">
								<?php
									echo $product_info['company_name'];
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4">
								Website
							</label>
							<div class="col-sm-8">
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
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4">
								E-mail
							</label>
							<div class="col-sm-8">
								<a href="mailto:<?php echo $product_info['customers_email_address'];?>">
									<?php echo $product_info['customers_email_address'];?>
								</a>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4">
								Phone
							</label>
							<div class="col-sm-8">
								<?php echo $product_info['customers_telephone'];?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4">
								Address
							</label>
							<div class="col-sm-8">
								<?php echo $product_info['customers_address'];?>
							</div>
						</div>
					</div>
				</form>
				<div class="clearfix"></div>
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
						ad.name = 'Job Description'
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
		</div><!-- /.col-* -->
	</div><!-- /.row -->
	<?php
}
?>

<!-- Modal For Apply PopUp -->
<div id="please-login" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Login</h4>
      </div>
      <div class="modal-body">
	  		Please login to apply job <i class="fa fa-hand-o-right"></i> <a style="color:#ed1c24;" href="login.php">Login Now</a>.
      </div>
    </div>
  </div>
</div>

<!-- Modal For Apply PopUp -->
<div id="apply-job" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Apply Job</h4>
      </div>
      <div class="modal-body">
	  	<form data-ng-submit="vm.save()" name="applyFrom" class="form-horizontal">
			<div class="">
				<div class="form-group">
					<label class="col-xs-3 control-label">
						Company
					</label>
					<div class="col-xs-9">					
						<input type="text" class="form-control" readonly value="<?php echo $product_info['company_name'];?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">
						Apply To
					</label>
					<div class="col-xs-9">					
						<input type="text"​​ readonly value="<?php echo $product_info['customers_email_address'];?>" class="form-control col-md-6" placeholder="To"/>
						<input type="email" class="form-control col-md-6" placeholder="CC"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">
						Position Apply For
					</label>
					<div class="col-xs-9">
					<input type="text" class="form-control" value="<?php echo $product_info['products_name'];?>" readonly/>
						
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">
						Attach CV Form
					</label>
					<div class="col-xs-9">					
						<input type="radio" value="attachFile" name="attach" id="attach" data-ng-model="vm.attach">
						Attach CV
						<input type="radio" name="attach" value="browse" id="attach" data-ng-model="vm.attach">
						Browse File
						<div data-ng-if="vm.attach == 'browse'">
							<input type="file" name="file" id="file" class="form-control">
						</div>
						<div data-ng-if="vm.attach == 'attachFile'">
							<hr>
							<table class="table table-striped">
								<thead>
									<tr>
										<th width="1%">Select</th>
										<th width="99%">Apply For</th>
									</tr>
								</thead>
								<tbody>
									<tr data-ng-repeat="row in vm.data">
										<td>
											<input type="radio" value="attach" name="se;ect" 
												id="attach" data-ng-model="row.attach">
										</td>
										<td>
											{{row.apply_for}}
										</td>
									</tr>
									<tr data-ng-if="vm.data.length == 0">
										<td colspan="2">
											<b>No Record Found.</b>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">
						Description
					</label>
					<div class="col-xs-9">					
						<textarea name="description" class="form-control" id="" 
							rows="5"
							placeholder="Description"></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-3"></div>
					<div class="col-xs-9">					
						<button class="btn btn-apply">Submit</button>
					</div>
				</div>
			</div>
		</form>
      </div>
    </div>
  </div>
</div>

</div><!-- /.container -->
<br><br>
<?php
require(DIR_WS_INCLUDES . 'template_bottom.php');
require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
<script
    type="text/javascript"
    src="ext/ng/lib/angular/1.5.6/angular.min.js"
></script>
<!-- custom file -->
<script
    type="text/javascript"
    src="ext/ng/app/product_info/main.js"
></script>
<script
    type="text/javascript"
    src="ext/ng/app/core/restful/restful.js"
></script>
<script
    type="text/javascript"
    src="ext/ng/app/product_info/controller/product_info_ctrl.js"
></script>
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
