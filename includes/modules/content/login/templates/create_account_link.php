
<?php echo tep_draw_form('create_account', tep_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'), 
      'post', 'class="form-horizontal" onsubmit="return check_form(create_account);"', true) 
      . tep_draw_hidden_field('action', 'process'); ?>

  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="form-group has-feedback">
          <label for="inputEmail" class="col-md-4"><?php echo ENTRY_EMAIL_ADDRESS; ?></label>
          <div class="col-md-8">
            <?php
            echo tep_draw_input_field('email_address', NULL, 'required aria-required="true" id="inputEmail" placeholder="' . ENTRY_EMAIL_ADDRESS . '"', 'email');
            echo FORM_REQUIRED_INPUT;
            if (tep_not_null(ENTRY_EMAIL_ADDRESS_TEXT)) echo '<span class="help-block">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>';
            ?>
          </div>
        </div>
        <div class="contentText">
          <div class="form-group has-feedback">
            <label for="inputPassword" class="col-md-4"><?php echo ENTRY_PASSWORD; ?></label>
            <div class="col-md-8">
              <?php
              echo tep_draw_password_field('password', NULL, 'required aria-required="true" id="inputPassword" placeholder="' . ENTRY_PASSWORD . '"');
              echo FORM_REQUIRED_INPUT;
              if (tep_not_null(ENTRY_PASSWORD_TEXT)) echo '<span class="help-block">' . ENTRY_PASSWORD_TEXT . '</span>';
              ?>
            </div>
          </div>
          <div class="form-group has-feedback">
            <label for="inputConfirmation" class="col-md-4"><?php echo ENTRY_PASSWORD_CONFIRMATION; ?></label>
            <div class="col-md-8">
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
            <label for="inputPassword" class="col-md-4"><?php echo ENTRY_TYPE; ?></label>
            <div class="col-md-8">
              <select name="type" class="form-control">
                <option value="normal">Job Seeker</option>
                <option value="agency">Employer</option>
              </select>
            </div>
          </div>
        </div>
    <div class="buttonSet">
      <div class="text-right">
        <?php 
          echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 
            'fa fa-chevron-right', null, 
            'primary', null, 'btn-success'); 
        ?>
      </div>
  </div></div>
</div></div>
</form>