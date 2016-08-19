<?php

class RestApiSendMail extends RestApi{

    public function post($params){
        var_dump($params);
        $name = tep_db_prepare_input($params['POST']['name']);
        $email_address = tep_db_prepare_input($params['POST']['email']);
        $enquiry = tep_db_prepare_input($params['POST']['enquiry']);
        if (!tep_validate_email($email_address)) {
            return array(array(data => 'send fail.'));
        }
        tep_mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, EMAIL_SUBJECT, $enquiry, $name, $email_address);
        var_dump(STORE_OWNER);
        return array(array(data => 'send success.'));
    }
}