<?php
	require('includes/application_top.php');

	if (!isset($HTTP_GET_VARS['lesson_id'])) {
	tep_redirect(tep_href_link(FILENAME_DEFAULT));
	}

	require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_PRODUCT_INFO);

	require(DIR_WS_INCLUDES . 'template_top.php');
	$info_query = tep_db_query("
		select
			title,
			file_leason,
			description
		from
			leason
		where
			status = 1
				and
			language_id = '" . (int)$languages_id . "'
				and
			id = '". (int)$HTTP_GET_VARS['lesson_id'] ."'
	");
	$info = tep_db_fetch_array($info_query);

?>
<div class="container">
	<br>
	<div class="col-md-3">
		<div class="filter-stacked">
			<?php include('advanced_search_box_right.php'); ?>
		</div>
	</div>
	<div class="col-md-8">
<?php
  if (tep_db_num_rows($info_query) < 1) {
?>
	<div class="alert alert-warning"><?php echo TEXT_PRODUCT_NOT_FOUND; ?></div>
	<div class="pull-right">
		<?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'fa fa-mail-forward', tep_href_link(FILENAME_DEFAULT)); ?>
	</div>
<?php
  } else {
?>
	  <div class="position-header">
		  <h1>
			  <?php echo $info['title'];?>
				<!--<span>Urgent</span>-->
		  </h1>
	  </div><!-- /.position-header -->
	  <?php echo $info['description'];?>
	  <?php
		  if (!tep_session_is_registered('customer_id')) {
			  echo '
			  	<button disabled class="btn btn-secondary">
					  <i class="fa fa-download"></i>
					  <small>Login to download</small>
				  </button>
			  ';
		  }else{
			  echo '
			  	<a href="' . $info['file_leason'] . '" class="btn btn-secondary" download>
					  <i class="fa fa-download"></i>
					  Download Now
				  </a>
			  ';
		  }
	  ?>

<?php
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