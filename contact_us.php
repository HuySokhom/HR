<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CONTACT_US);

  if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'send') && isset($HTTP_POST_VARS['formid']) && ($HTTP_POST_VARS['formid'] == $sessiontoken)) {
    $error = false;

    $name = tep_db_prepare_input($HTTP_POST_VARS['name']);
    $email_address = tep_db_prepare_input($HTTP_POST_VARS['email']);
    $enquiry = tep_db_prepare_input($HTTP_POST_VARS['enquiry']);

    if (!tep_validate_email($email_address)) {
      $error = true;

      $messageStack->add('contact', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
    }

    $actionRecorder = new actionRecorder('ar_contact_us', (tep_session_is_registered('customer_id') ? $customer_id : null), $name);
    if (!$actionRecorder->canPerform()) {
      $error = true;

      $actionRecorder->record(false);

      $messageStack->add('contact', sprintf(ERROR_ACTION_RECORDER, (defined('MODULE_ACTION_RECORDER_CONTACT_US_EMAIL_MINUTES') ? (int)MODULE_ACTION_RECORDER_CONTACT_US_EMAIL_MINUTES : 15)));
    }

    if ($error == false) {
      tep_mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, EMAIL_SUBJECT, $enquiry, $name, $email_address);

      $actionRecorder->record();

      tep_redirect(tep_href_link(FILENAME_CONTACT_US, 'action=success'));
    }
  }

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_CONTACT_US));

  require(DIR_WS_INCLUDES . 'template_top.php');
?>
<br>
<div class="container">
<div class="col-md-3 col-sm-6 ">
  <div class="filter-stacked">
    <?php include('advanced_search_box_right.php');?> 
  </div>
</div>
<div class="col-md-9 col-sm-6">
  <div class="row">

<?php
  if ($messageStack->size('contact') > 0) {
    echo $messageStack->output('contact');
  }
  if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'success')) {
  ?>

  <div class="contentContainer">
    <div class="contentText">
      <div class="alert alert-info"><?php echo TEXT_SUCCESS; ?></div>
    </div>

    <div class="pull-right">
      <?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'fa fa-mail-reply', tep_href_link(FILENAME_DEFAULT)); ?>
    </div>
  </div>
  <?php 
    } else {
  ?>
    <div class="col-md-6">
      <address>
          <h4><?php echo ENTRY_ADDRESS; ?></h4>
          <?php echo nl2br(STORE_ADDRESS); ?><br>
          Phone:
          <?php echo STORE_PHONE; ?>
          <br>
          Email:
          <a href="mailto:<?php echo STORE_OWNER_EMAIL_ADDRESS; ?>" target="_top">
              <?php echo STORE_OWNER_EMAIL_ADDRESS; ?>
          </a>
      </address>
    </div>
    <div class="col-md-6">
      <p class="inputRequirement text-right"><?php echo FORM_REQUIRED_INFORMATION; ?></p>
      <div class="clearfix"></div>
      <?php echo tep_draw_form('contact_us', tep_href_link(FILENAME_CONTACT_US, 'action=send'), 'post', 'class="form-horizontal"', true); ?>

        <?php
        echo tep_draw_input_field('name', NULL, 'required autofocus="autofocus" aria-required="true" id="inputFromName" placeholder="' . ENTRY_NAME . '"');          ?>
        <br>
        <?php
        echo tep_draw_input_field('email', NULL, 'required aria-required="true" id="inputFromEmail" placeholder="' . ENTRY_EMAIL . '"', 'email');
        ?>
        <br>
        <?php
        echo tep_draw_textarea_field('enquiry', 'soft', 30, 6, NULL, 'required aria-required="true" id="inputEnquiry" placeholder="' . ENTRY_ENQUIRY . '"');          ?>
        <br>
        <div class="buttonSet">
          <div class="text-right"><?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'fa fa-send-o', null, 'primary', null, 'btn-success'); ?></div>
        </div>
      </form>
    </div>
    <?php 
  }
  ?>
  </div>
</div>
</div>

<?php

  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
