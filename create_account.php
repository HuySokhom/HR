<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  $term_info_query = tep_db_query("select pages_content as content from page_description where id = 1");
  $term_info = tep_db_fetch_array($term_info_query);

// needs to be included earlier to set the success message in the messageStack
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CREATE_ACCOUNT);
// echo $sessiontoken;
//   var_dump($HTTP_POST_VARS);exit;
  $process = false;
  if (isset($HTTP_POST_VARS['action']) && ($HTTP_POST_VARS['action'] == 'process') && 
    isset($HTTP_POST_VARS['formid'])) {
    $process = true;
//    if (ACCOUNT_GENDER == 'true') {
//      if (isset($HTTP_POST_VARS['gender'])) {
//        $gender = tep_db_prepare_input($HTTP_POST_VARS['gender']);
//      } else {
//        $gender = false;
//      }
//    }
    $name = tep_db_prepare_input($HTTP_POST_VARS['name']);
    $type = $HTTP_POST_VARS['type'];
    $firstname = tep_db_prepare_input($HTTP_POST_VARS['firstname']);
    $lastname = tep_db_prepare_input($HTTP_POST_VARS['lastname']);
    if (ACCOUNT_DOB == 'true') $dob = tep_db_prepare_input($HTTP_POST_VARS['dob']);
    $email_address = tep_db_prepare_input($HTTP_POST_VARS['email_address']);
    if (ACCOUNT_COMPANY == 'true') $company = tep_db_prepare_input($HTTP_POST_VARS['company']);
    $street_address = tep_db_prepare_input($HTTP_POST_VARS['street_address']);
    if (ACCOUNT_SUBURB == 'true') $suburb = tep_db_prepare_input($HTTP_POST_VARS['suburb']);
    $postcode = tep_db_prepare_input($HTTP_POST_VARS['postcode']);
    $city = tep_db_prepare_input($HTTP_POST_VARS['city']);
    if (ACCOUNT_STATE == 'true') {
      $state = tep_db_prepare_input($HTTP_POST_VARS['state']);
      if (isset($HTTP_POST_VARS['zone_id'])) {
        $zone_id = tep_db_prepare_input($HTTP_POST_VARS['zone_id']);
      } else {
        $zone_id = false;
      }
    }
    $country = 36;//tep_db_prepare_input($HTTP_POST_VARS['country']);
    $telephone = tep_db_prepare_input($HTTP_POST_VARS['telephone']);
    $fax = tep_db_prepare_input($HTTP_POST_VARS['fax']);
    if (isset($HTTP_POST_VARS['newsletter'])) {
      $newsletter = tep_db_prepare_input($HTTP_POST_VARS['newsletter']);
    } else {
      $newsletter = false;
    }
    $password = tep_db_prepare_input($HTTP_POST_VARS['password']);
    $confirmation = tep_db_prepare_input($HTTP_POST_VARS['confirmation']);

    $error = false;
    if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
      $error = true;

      $messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR);
    } elseif (tep_validate_email($email_address) == false) {
      $error = true;

      $messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
    } else {
      $check_email_query = tep_db_query("select count(*) as total from " . TABLE_CUSTOMERS . " where customers_email_address = '" . tep_db_input($email_address) . "'");
      $check_email = tep_db_fetch_array($check_email_query);
      if ($check_email['total'] > 0) {
        $error = true;

        $messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);
      }
    }


    if (strlen($password) < ENTRY_PASSWORD_MIN_LENGTH) {
      $error = true;

      $messageStack->add('create_account', ENTRY_PASSWORD_ERROR);
    } elseif ($password != $confirmation) {
      $error = true;

      $messageStack->add('create_account', ENTRY_PASSWORD_ERROR_NOT_MATCHING);
    }
    $date = date('Y/m/d H:i:s');
    if ($error == false) {
      $sql_data_array = array(
          'user_name' => $name,
          'user_type' => $type,
          'customers_firstname' => $firstname,
          'customers_lastname' => $lastname,
          'customers_email_address' => $email_address,
          'customers_telephone' => $telephone,
          'customers_fax' => $fax,
          'customers_newsletter' => $newsletter,
          'customers_location' => 'Cambodia',
          'photo' => 'images/icon-person.png',
          'customers_password' => tep_encrypt_password($password),
          'create_date' => $date
      );

      if (ACCOUNT_GENDER == 'true') $sql_data_array['customers_gender'] = $gender;
      if (ACCOUNT_DOB == 'true') $sql_data_array['customers_dob'] = tep_date_raw($dob);

      tep_db_perform(TABLE_CUSTOMERS, $sql_data_array);

      $customer_id = tep_db_insert_id();

      $sql_data_array = array('customers_id' => $customer_id,
                              'entry_firstname' => $firstname,
                              'entry_lastname' => $lastname,
                              'entry_street_address' => $street_address,
                              'entry_postcode' => $postcode,
                              'entry_city' => $city,
                              'entry_country_id' => $country);

      if (ACCOUNT_GENDER == 'true') $sql_data_array['entry_gender'] = $gender;
      if (ACCOUNT_COMPANY == 'true') $sql_data_array['entry_company'] = $company;
      if (ACCOUNT_SUBURB == 'true') $sql_data_array['entry_suburb'] = $suburb;
      if (ACCOUNT_STATE == 'true') {
        if ($zone_id > 0) {
          $sql_data_array['entry_zone_id'] = $zone_id;
          $sql_data_array['entry_state'] = '';
        } else {
          $sql_data_array['entry_zone_id'] = '0';
          $sql_data_array['entry_state'] = $state;
        }
      }

      tep_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);

      $address_id = tep_db_insert_id();

      tep_db_query("update " . TABLE_CUSTOMERS . " set customers_default_address_id = '" . (int)$address_id . "' where customers_id = '" . (int)$customer_id . "'");

      //tep_db_query("insert into " . TABLE_CUSTOMERS_INFO . " (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('" . (int)$customer_id . "', '0', NOW())");

      if (SESSION_RECREATE == 'True') {
        tep_session_recreate();
      }

      $customers_email_address = $email_address;
      $user_type = $type;
      $customer_first_name = $firstname;
      $customer_default_address_id = $address_id;
      $customer_country_id = $country;
      $customer_zone_id = $zone_id;
      tep_session_register('customers_email_address');
      tep_session_register('user_type');
      tep_session_register('customer_id');
      tep_session_register('customer_first_name');
      tep_session_register('customer_default_address_id');
      tep_session_register('customer_country_id');
      tep_session_register('customer_zone_id');

// reset session token
      $sessiontoken = md5(tep_rand() . tep_rand() . tep_rand() . tep_rand());

// restore cart contents
      $cart->restore_contents();

// build the message content
      $name = $firstname . ' ' . $lastname;

      // if (ACCOUNT_GENDER == 'true') {
      //    if ($gender == 'm') {
      //      $email_text = sprintf(EMAIL_GREET_MR, $lastname);
      //    } else {
      //      $email_text = sprintf(EMAIL_GREET_MS, $lastname);
      //    }
      // } else {
      //   $email_text = sprintf(EMAIL_GREET_NONE, $firstname);
      // }
      // $email_text .= EMAIL_WELCOME . EMAIL_TEXT . EMAIL_CONTACT . EMAIL_WARNING;
      $email_text = "
        <b>Dear Value User</b>
        <br/><br/><br/>
        Welcome to Aseanhr! We are delighted to have you as our newest aseanhr user!
        To start using aseanhr, please login your account by clicking on the linked 
        <a href='http://aseanhr.com/login.php'>http://aseanhr.com/login.php</a> and enter your username & password as below: 
        <br/>
        Username: ".$email_address."
        Password: ".$password."
        <br/>
        You can now take part in the various services we offer you such as:
        <ul>
          <li> - Online jobs posting </li>
          <li> - Company advertising</li>
          <li> - Candidates’ CV offering</li>
          <li> - Online CVs posting</li>
          <li> - Search jobs offering and more….!</li>
        </ul>
        By clicking the activation button above, you agree to our Terms and Conditions. If you did not register or registered by mistake with us, 
        please DO NOT click the activation button or ignore this email. Then, the registration won’t be completed.
        <br/><br/>
        Shall you have any concerns; do not hesitate to contact us. Please email the web-owner: jobs@aseanhr.com.
        <br/><br/><br/><br/>  
        Sincerely,
        <br/><br/><br/><br/>          
        Aseanhr Team
        
      ";
      tep_mail($name, $email_address, EMAIL_SUBJECT, $email_text, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);

      tep_redirect(tep_href_link(FILENAME_ACCOUNT, '', 'SSL'));
    }
  }

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'));

  require(DIR_WS_INCLUDES . 'template_top.php');
  require('includes/form_check.js.php');
?>
<br>
  <div class="container">
  <?php
  if ($messageStack->size('create_account') > 0) {
    echo $messageStack->output('create_account');
  }
  ?>
  <div class="row">
    <div class="col-md-8">
<div class="alert alert-warning">
  <?php echo sprintf(TEXT_ORIGIN_LOGIN, tep_href_link(FILENAME_LOGIN, tep_get_all_get_params(), 'SSL')); ?><span class="inputRequirement pull-right text-right"><?php echo FORM_REQUIRED_INFORMATION; ?></span>
</div>

<?php echo tep_draw_form('create_account', tep_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'), 
      'post', 'class="form-horizontal" onsubmit="return check_form(create_account);"', true) 
      . tep_draw_hidden_field('action', 'process'); ?>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="form-group has-feedback">
          <label for="inputEmail" class="control-label col-sm-5"><?php echo ENTRY_EMAIL_ADDRESS; ?></label>
          <div class="col-sm-7">
            <?php
            echo tep_draw_input_field('email_address', NULL, 'required aria-required="true" id="inputEmail" placeholder="' . ENTRY_EMAIL_ADDRESS . '"', 'email');
            echo FORM_REQUIRED_INPUT;
            if (tep_not_null(ENTRY_EMAIL_ADDRESS_TEXT)) echo '<span class="help-block">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>';
            ?>
          </div>
        </div>
        <div class="contentText">
          <div class="form-group has-feedback">
            <label for="inputPassword" class="control-label col-sm-5"><?php echo ENTRY_PASSWORD; ?></label>
            <div class="col-sm-7">
              <?php
              echo tep_draw_password_field('password', NULL, 'required aria-required="true" id="inputPassword" placeholder="' . ENTRY_PASSWORD . '"');
              echo FORM_REQUIRED_INPUT;
              if (tep_not_null(ENTRY_PASSWORD_TEXT)) echo '<span class="help-block">' . ENTRY_PASSWORD_TEXT . '</span>';
              ?>
            </div>
          </div>
          <div class="form-group has-feedback">
            <label for="inputConfirmation" class="control-label col-sm-5"><?php echo ENTRY_PASSWORD_CONFIRMATION; ?></label>
            <div class="col-sm-7">
              <?php
              echo tep_draw_password_field('confirmation', NULL, 'required aria-required="true" id="inputConfirmation" placeholder="' . ENTRY_PASSWORD_CONFIRMATION . '"');
              echo FORM_REQUIRED_INPUT;
              if (tep_not_null(ENTRY_PASSWORD_CONFIRMATION_TEXT)) echo '<span class="help-block">' . ENTRY_PASSWORD_CONFIRMATION_TEXT . '</span>';
              ?>
            </div>
          </div>
        </div>

        <div class="contentText">
          <div class="form-group has-feedback">
            <label for="inputPassword" class="control-label col-sm-5"><?php echo ENTRY_TYPE; ?></label>
            <div class="col-sm-7">
              <select name="type" class="form-control">
                <option value="normal">Job Seeker</option>
                <option value="agency">Employer</option>
              </select>
            </div>
          </div>
        </div>

        <div class="contentText">
          <div class="form-group has-feedback">
            <label for="inputPassword" class="control-label col-sm-5"></label>
            <div class="col-sm-7">
                <div class="">
                    <label>
                        <input type="checkbox" name="term" required>
                        <a href="#" data-toggle="modal" data-target="#term">I accept all terms and conditions</a>
                    </label>
                </div>
            </div>
          </div>
        </div>
        
        <div class="buttonSet">
          <div class="text-right">
            <button type="submit" class="btn btn-success">
              <i class="fa fa-check-square-o"></i>
              Create Account
            </button>
        </div>
    </div>
</form>
</div></div></div>
   
  </div>
</div>


<div class="col-md-4">
      <div class="">
        <?php require('advanced_search_box_right.php');?>
      </div>
    </div>
</div>
</div>

<!-- Modal For Function PopUp -->
<div id="term" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Terms and Conditions</h4>
      </div>
      <div class="modal-body">
          <?php 
            echo $term_info['content'];
          ?>
      </div>
    </div>
  </div>
</div>
<?php 
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
