
  <?php
  require('includes/application_top.php');
  $email_address = "kom.huy@gmail.com";
  $password = "sokhoM@123";
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

    