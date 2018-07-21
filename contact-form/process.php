<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Contact Us</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet"> 

    <!-- styles -->
    <link rel="stylesheet" href="contact-form/assets/css/styles.css">

    <script src="/_cd/lib/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="/contact-form/assets/js/contact.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
      body {
        padding-top: 0;
      }
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body style="background-color: #ED7D29;">
    <!--contact_container-->
    <div class="contact_container bg_dark" style="height: 100vh; width: 100vw;">
      <div id="contact_us" class="center vertical-center">
        <div class="container top_90 btm_120" style="margin-top: 50%">
          <div class="col-lg-6 col-lg-offset-3">


            <?php
            /* ==================================================================
             * CUSTOMISABLE OPTIONS
             * ==================================================================
             *
             * These are your customisable options for the script.
             * Most of these will either need to be changed, or altered depending
             * on your preference and server setup.
             *
             * See comments to right for explanations of options
             *
             */

// Form options
            $options['captcha_secret'] = ''; // Google reCAPTCHA secret key
            $options['redirect_url'] = ''; // URL of custom success page
            $options['attachment_types'] = array('image/jpeg', // Array of mime-types to allow in uploads
              'image/gif',
              'image/png',
              'application/msword',
              'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
              'application/pdf',
              'application/zip'
            );

// Attachment management
            $options['attachment_dir'] = 'attachments/'; // Attachments upload directory
            $options['attachment_limit'] = 10; // 10mb is the considered "safe" size
            $options['attachment_store'] = false; // IMPORTANT: Setting this to "true" will leave all attachments on the server, and can eat up hosting space.
// Generic email options
            $options['from_address'] = ''; // Address the email is sent from
            $options['from_name'] = '';  // Name to attach to the address
            $options['to_addresses'] = array('myemail.com'); // To: addresse(s), add new array item for more
            $options['bcc_addresses'] = array('');  // BCC: addresse(s), add new array item for more
// Send confirmation message of successful email to end user
            $options['email_confirmation'] = false; // Should the end user get a confirmation email?
// SMTP options
            $options['use_smtp'] = false; // Should the email be sent via SMTP, or default PHP mail server?
            $options['smtp_host'] = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
            $options['smtp_auth'] = true; // Enable SMTP authentication
            $options['smtp_username'] = 'username';  // SMTP username
            $options['smtp_password'] = 'password';  // SMTP password
            $options['smtp_secure'] = 'tls'; // Enable TLS encryption, `ssl` also accepted
            $options['smtp_port'] = 587; // TCP port to connect to
// We use CURL to get the translations file.
// Some servers have CURL enabled, but disallow it for security.
// If this is the case, set this to false.
            $options['use_curl'] = true;

// set for demo mode
            $is_demo = false;

            /**
             * Checks to see if your server supports CURL operations
             * @return bool yep/nope
             */
            function curlEnabled() {
              global $protocol;
              global $options;
              if ($options['use_curl'] && function_exists('curl_version')) {
                $content = curl_file_get_contents($protocol . $_SERVER['HTTP_HOST']);
                $enabled = ($content) ? true : false;
                return $enabled;
              }
              else {
                return false;
              }
            }

            /**
             * Gets file contents from a URL (alternative to file_get_contents)
             * @param  string $url url of the content to grab
             * @return string      content from the url
             */
            function curl_file_get_contents($url) {
              $curl = curl_init();
              $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';

              curl_setopt($curl, CURLOPT_URL, $url); //The URL to fetch. This can also be set when initializing a session with curl_init().
              curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);    //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
              curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);       //The number of seconds to wait while trying to connect.

              curl_setopt($curl, CURLOPT_USERAGENT, $userAgent); //The contents of the "User-Agent: " header to be used in a HTTP request.
              curl_setopt($curl, CURLOPT_FAILONERROR, TRUE);     //To fail silently if the HTTP code returned is greater than or equal to 400.
              curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);  //To follow any "Location: " header that the server sends as part of the HTTP header.
              curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);     //To automatically set the Referer: field in requests where it follows a Location: redirect.
              curl_setopt($curl, CURLOPT_TIMEOUT, 10);           //The maximum number of seconds to allow cURL functions to execute.

              $contents = curl_exec($curl);
              curl_close($curl);
              return $contents;
            }

            /**
             * SETUP (ignore this part)
             * ==================================================================
             *
             */
// import and set up the mail instance
            require_once('phpmailer/PHPMailerAutoload.php');

// useful re-usable vars
            $is_ajax = ((!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) ? true : false;
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $translations_url = (curlEnabled()) ? $protocol . $_SERVER["HTTP_HOST"] . str_replace('process.php', 'translations.json', $_SERVER["REQUEST_URI"]) : 'translations.json';
            $translations = (curlEnabled()) ? curl_file_get_contents($translations_url) : file_get_contents($translations_url);
            $translations = json_decode($translations);
            $lang = $translations->default_lang;

// check if data has actually been sent to the form
            checkIfDataHasBeenSent();

// set up timezone and PHP "end of line";
            $timezone = ini_get('date.timezone');
            if (empty($timezone)) {
              date_default_timezone_set('Europe/London');
            }
            if (!defined("PHP_EOL")) {
              define("PHP_EOL", "\r\n");
            }

// grab data from form
            $fdata = sanitize_data($_POST);
            $files = (isset($_FILES['attachment'])) ? $_FILES['attachment'] : null;

            /**
             * VALIDATE FORM FIELD DATA
             * ==================================================================
             *
             * Add any custom validation you want for your form below.
             * Simply add a new "case" for each field in your form(s) for them
             * to be checked and validated against.
             *
             * e.g.
             * case 'field_name':
             *     if(empty($value)){ array_push($errors, 'Your message'); }
             *     break;
             *
             */
            function getValidationErrors() {
              global $translations, $lang, $fdata, $files, $options;

              // list of error messages to keep
              $errors = array();

              // loop through each of our form fields
              foreach ($fdata as $field => $value) {


                // Now switch functionality based on field name
                switch ($field) {

                  // name
                  case 'name':
                    if (empty($value)) {
                      array_push($errors, parseMessage($translations->form->error->required->$lang, array($field)));
                    }
                    break;

                  // email
                  case 'email':
                    if (empty($value)) {
                      array_push($errors, parseMessage($translations->form->error->required->$lang, array($field)));
                    }
                    elseif (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                      array_push($errors, $translations->form->error->email->$lang);
                    }
                    break;

                  // phone number
                  case 'phone':
                    if (!empty($value) && !is_numeric($value)) {
                      array_push($errors, parseMessage($translations->form->error->numeric->$lang, array($field)));
                    }
                    break;

                  // message
                  case 'message':
                    if (empty($value)) {
                      array_push($errors, parseMessage($translations->form->error->required->$lang, array($field)));
                    }
                    break;

                  // message
                  case 'honey':
                    if (!empty($value)) {
                      array_push($errors, $translations->form->error->honeypot->$lang);
                    }
                    break;
                }
              }

              // loop through any files and attempt to upload them
              // report any errors when files are uploaded
              if (!empty($files['name'][0])) {
                $upload_errs = attachmentUploaded();
                if (!empty($upload_errs)) {
                  for ($i = 0; $i < count($upload_errs); $i++) {
                    array_push($errors, $upload_errs[$i]);
                  }
                }
              }

              // check if reCAPTCHA has been used
              if (isset($_POST['g-recaptcha-response'])) {

                // grab the value
                $captcha = $_POST['g-recaptcha-response'];

                // if there's no value, tell the user it's not set
                if (!$captcha) {
                  array_push($errors, $translations->form->error->captcha->empty->$lang);
                }

                // otherwise it is set, and we need to verify it
                else {
                  $recaptcha = "https://www.google.com/recaptcha/api/siteverify?secret={$options['captcha_secret']}&response={$captcha}&remoteip={$_SERVER['REMOTE_ADDR']}";

                  // get recaptcha
                  $response = (curlEnabled()) ? curl_file_get_contents($recaptcha) : file_get_contents($recaptcha);
                  $response = json_decode($response);

                  // if the response comes back negative, it's a bot, error out
                  if (!empty($response)) {
                    if (!$response->success) {
                      removeUploadsFromServer();
                      array_push($errors, parseMessage($translations->form->error->captcha->bot->$lang, $response->{'error-codes'}));
                    }
                  }
                  else {
                    removeUploadsFromServer();
                    array_push($errors, parseMessage($translations->form->error->captcha->empty_response->$lang, array($recaptcha)));
                  }
                }
              }

              // spit the errors out for use
              return $errors;
            }

            /**
             * SANITIZE THE FORM DATA (prevents XSS)
             * ==================================================================
             *
             */
            function sanitize_data($fdata) {
              foreach ($fdata as $key => $value) {
                $data = $value;

                // Fix &entity\n;
                $data = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $data);
                $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
                $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
                $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

                // Remove any attribute starting with "on" or xmlns
                $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

                // Remove javascript: and vbscript: protocols
                $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
                $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
                $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

                // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
                $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
                $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
                $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

                // Remove namespaced elements (we do not need them)
                $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

                // Remove really unwanted tags
                do {
                  $old_data = $data;
                  $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
                } while ($old_data !== $data);

                // set the new cleaned out value
                $fdata[$key] = $data;
              }

              return $fdata;
            }

            /**
             * PARSE MESSAGES
             * ==================================================================
             *
             * This function takes a message string from the translations.json
             * file and inserts variables in the placeholders {$1}, {$2} etc.
             *
             */
            function parseMessage($msg, $arr) {

              // loop through the message, replace with vars
              for ($i = 0; $i < count($arr); $i++) {
                $regx = "/{\\$" . ($i + 1) . "}/";
                $msg = preg_replace($regx, $arr[$i], $msg);
              }

              // kick out revised message
              return $msg;
            }

            /**
             * CHECK THE PAGE HAS DATA TO PROCESS
             * ==================================================================
             *
             * This function deals with a lack of data and the post_max_size PHP limit:
             * http://stackoverflow.com/questions/2133652/how-to-gracefully-handle-files-that-exceed-phps-post-max-size
             *
             */
            function checkIfDataHasBeenSent() {
              global $translations, $lang, $is_ajax;

              if (empty($_POST) && empty($_FILES)) {
                if ($is_ajax) {
                  $error = array('errors' => array($translations->form->error->file->server_limit->$lang));
                  echo json_encode($error);
                }
                else {
                  echo '<h1>' . $translations->form->error->title->$lang . '</h1>';
                  echo '<p>' . $translations->form->error->file->server_limit->$lang . '</p>';
                }
                exit;
              }
            }

            /**
             * Uploads the attachment provided in the form
             * ==================================================================
             *
             * This function is useful for validation of file uploads
             *
             */
            function attachmentUploaded() {
              global $translations, $lang, $fdata, $options, $files;

              // store any errors in here
              $errors = array();

              // store the total size of attachments
              $sizes = 0;

              // loop through files
              for ($i = 0; $i < count($files['name']); $i++) {

                // check the file errors
                if ($files['error'][$i] !== 0) {
                  array_push($errors, parseMessage($translations->form->error->file->general->$lang, array($files['name'][$i], $files['error'][$i])));
                }

                // and if the file is in our "allowed" list
                if (!in_array($files['type'][$i], $options['attachment_types'])) {
                  array_push($errors, parseMessage($translations->form->error->file->type->$lang, array($files['name'][$i])));
                }

                // attempt file upload, if fails, report it, otherwise return true
                $target_path = $options['attachment_dir'] . basename($files['name'][$i]);
                if (!file_exists($target_path)) {
                  // if it fails to save, error out
                  if (!move_uploaded_file($files['tmp_name'][$i], $target_path)) {
                    array_push($errors, parseMessage($translations->form->error->file->failed->$lang, array($files['name'][$i])));
                  }
                }
                // otherwise, it exists, we should rename it and try again
                else {
                  $exploded = explode(".", $files['name'][$i]); // break up file name from extension
                  $filetitle = array_slice($exploded, 0, -1); // remove extension from exploded and assign to filetitle
                  $filetitle = implode('', $filetitle); // keep just the filename
                  $newfilename = $filetitle . '-' . round(microtime(true)) . '.' . end($exploded); // add a timestamp
                  $target_path = $options['attachment_dir'] . $newfilename; // set the new file path and name for storage
                  $files['name'][$i] = $newfilename; // update file for the email to send the correct one
                  // if it fails to save, error out
                  if (!move_uploaded_file($files['tmp_name'][$i], $target_path)) {
                    array_push($errors, parseMessage($translations->form->error->file->failed->$lang, array($files['name'][$i])));
                  }
                }
                // up the "sizes" variable so we can check total filesize for attachments
                $sizes += $files['size'][$i];
              }

              // check final attachment size is less than our limit option
              $mb = 1048576; //bytes in a megabyte
              if ($sizes / $mb > $options['attachment_limit']) {
                array_push($errors, parseMessage($translations->form->error->file->size->$lang, array($options['attachment_limit'])));
              }

              // if there are errors, we'll need to remove ALL files
              if (!empty($errors)) {
                removeUploadsFromServer();
              }

              return $errors;
            }

            /**
             * REMOVES FILES AFTER EMAIL IS SENT
             * ==================================================================
             *
             * This function will remove files from the $options['attachment_dir']
             * Once the processForm() function has finished running.
             *
             */
            function removeUploadsFromServer() {
              global $files, $options;

              // check we have files
              if (!empty($files['name'][0])) {

                // loop through files
                for ($i = 0; $i < count($files['name']); $i++) {

                  $file = $options['attachment_dir'] . basename($files['name'][$i]);

                  // remove them
                  if (file_exists($file)) {
                    unlink($file);
                  }
                }
              }
            }

            /**
             * HTML EMAIL CONTENT
             * ==================================================================
             *
             */
            function getHtmlEmailContent() {
              global $fdata;

              $content = '';

              // loop through fields and add to content
              $content .= '<style>';
              $content .= '.ucf-table { border:solid 1px white; border-right: 0; }';
              $content .= '.ucf-table th, .ucf-table td { border-bottom: solid 1px white; border-right: solid 1px white; padding: 10px 15px; text-align:left; }';
              $content .= '.ucf-table th { background: #00E672; color: white; font-weight:bold; }';
              $content .= '.ucf-table tr:last-child th, .ucf-table tr:last-child td { border-bottom: 0; }';
              $content .= '</style>';
              $content .= '<table class="ucf-table" cellpadding="0" cellspacing="0" border="0">';
              foreach ($fdata as $field => $value) {
                if ($field !== 'g-recaptcha-response' && $field !== 'honey') {
                  if (empty($value)) {
                    $value = '&mdash;';
                  }
                  $content .= '<tr>';
                  $content .= '<th>' . $field . '</th>';
                  $content .= '<td>' . $value . '</td>';
                  $content .= '</tr>';
                }
              }
              $content .= '</table><br /><br />';

              // send it back
              return $content;
            }

            /**
             * PLAIN EMAIL CONTENT
             * ==================================================================
             *
             */
            function getPlainEmailContent() {
              global $fdata;

              $content = '';

              // loop through fields and add to content
              foreach ($fdata as $field => $value) {
                if ($field !== 'g-recaptcha-response' && $field !== 'honey') {
                  if (empty($value)) {
                    $value = '—';
                  }
                  $content .= $field . ': ' . $value . PHP_EOL;
                }
              }

              // send it back
              return $content;
            }

            /**
             * FUNCTION TO SEND THE EMAIL
             * ==================================================================
             *
             */
            function sendEmailToSiteOwner() {
              global $files, $options, $fdata, $translations, $lang, $is_ajax;

              $mail = new PHPMailer;

              // if we're using SMTP
              if ($options['use_smtp']) {
                $mail->isSMTP();
                $mail->Host = $options['smtp_host'];
                $mail->SMTPAuth = $options['smtp_auth'];
                $mail->Username = $options['smtp_username'];
                $mail->Password = $options['smtp_password'];
                $mail->SMTPSecure = $options['smtp_secure'];
                $mail->Port = $options['smtp_port'];
              }

              // character encoding
              $mail->CharSet = 'UTF-8';

              // mail format
              $mail->isHTML = true;

              // from
              $mail->From = $options['from_address'];
              $mail->FromName = $options['from_name'];

              // to
              foreach ($options['to_addresses'] as $address) {
                $mail->addAddress($address);
              }

              // bcc
              if (isset($options['bcc_addresses'])) {
                foreach ($options['bcc_addresses'] as $address) {
                  $mail->addBCC($address);
                }
              }

              // reply to
              $mail->addReplyTo($fdata['email']);

              // add files to the email
              if ($files['name'][0] !== '') {
                for ($i = 0; $i < count($files['name']); $i++) {

                  // define file path
                  $path = __DIR__ . '/' . $options['attachment_dir'] . $files['name'][$i];

                  // add the attachment to the mail
                  $mail->addAttachment($path);
                }
              }

              // set subject
              $mail->Subject = parseMessage($translations->email->subject->$lang, array($fdata['name'], 'Website enquiry'));

              // set content
              $mail->Body = getHtmlEmailContent();
              $mail->AltBody = getPlainEmailContent();

              // successfully sent email
              if ($mail->send()) {
                emailSuccessfullySent();
              }

              // error sending email
              else {
                if ($is_ajax) {
                  echo json_encode(array('errors' => array(parseMessage($translations->email->error->$lang, array($mail->ErrorInfo)))));
                }
                else {
                  echo parseMessage($translations->email->error->$lang, $mail->ErrorInfo);
                }
              }

              // remove uploaded files from the server
              removeUploadsFromServer();
            }

            /**
             * FUNCTION TO SEND USER CONFIRMATION EMAIL
             * ==================================================================
             *
             */
            function sendConfirmationEmailToEndUser() {
              global $options, $fdata, $translations, $lang, $is_ajax;

              $mail = new PHPMailer;

              // if we're using SMTP
              if ($options['use_smtp']) {
                $mail->isSMTP();
                $mail->Host = $options['smtp_host'];
                $mail->SMTPAuth = $options['smtp_auth'];
                $mail->Username = $options['smtp_username'];
                $mail->Password = $options['smtp_password'];
                $mail->SMTPSecure = $options['smtp_secure'];
                $mail->Port = $options['smtp_port'];
              }

              // character encoding
              $mail->CharSet = 'UTF-8';

              // mail format
              $mail->isHTML = true;

              // from
              $mail->From = $options['from_address'];
              $mail->FromName = $options['from_name'];

              // to
              if (isset($fdata['email'])) {
                $mail->addAddress($fdata['email']);
              }

              // reply to
              $mail->addReplyTo($options['from_address']);

              // set subject
              $mail->Subject = $translations->email->confirmation->subject->$lang;

              // set content
              $mail->Body = $translations->email->confirmation->body->$lang;

              // send email
              $mail->send();
            }

            /**
             * REPORTS ERRORS TO THE USER
             * ==================================================================
             *
             */
            function reportErrors($errors) {
              global $translations, $lang, $is_ajax;

              // for ajax responses, we send back the errors in a JSON object
              if ($is_ajax) {
                $errors = array('errors' => $errors);
                echo json_encode($errors);
              }

              // otherwise, we need to echo them out as HTML for the browser
              else {
                echo '<h2>' . $translations->form->error->title->$lang . '</h2>';
                echo '<ul>';
                foreach ($errors as $error) {
                  echo '<li>' . $error . '</li>';
                }
                echo '</ul>';
                echo '<p>' . $translations->form->error->back_link->$lang . '</p>';
              }

              // if we have errors, we need to remove the files
              removeUploadsFromServer();
            }

            /**
             * SUCCESSFUL EMAIL, DO STUFF
             * ==================================================================
             *
             * This function performs the actions needed when the email is sent
             * successfully.
             *
             */
            function emailSuccessfullySent() {
              global $translations, $lang, $options, $fdata, $is_ajax;

              // if we're not keeping the files, remove them from the server
              if (!$options['attachment_store']) {
                removeUploadsFromServer();
              }

              if ($options['email_confirmation']) {
                sendConfirmationEmailToEndUser();
              }

              // redirect to custom "success" page if it's been set
              if (!empty($options['redirect_url'])) {
                if (!$is_ajax) {
                  header('Location: ' . $options['redirect_url']);
                }
                else {
                  echo json_encode(array('redirect' => array($options['redirect_url'])));
                }
                exit;
              }

              // if no redirect has been set, echo out the success message
              if ($is_ajax) {
                echo json_encode(array('success' => array($translations->form->success->title->$lang)));
              }
              else {
                echo '<h2>' . $translations->form->success->title->$lang . '</h2>';
              }
            }

            /**
             * PROCESS THE FORM
             * ==================================================================
             *
             * This function runs through the process of:
             * - validating the form
             * - sending data they supplied to you via email
             * - giving the user feedback when the email is sent
             *
             */
            function processForm() {
              global $is_demo, $translations, $lang, $fdata, $options;

              // create an attachments directory if it doesn't exist
              $dir = $options['attachment_dir'];
              if (!file_exists($dir) && !is_dir($dir)) {
                mkdir($dir, 0777, true);
              }

              // Validate the form data, grab any errors
              // If errors exist, stop processing and tell the user
              $errors = getValidationErrors();
              if (!empty($errors)) {
                reportErrors($errors);
                exit;
              }

              // Send the data to each email address in the options
              if (!$is_demo) {
                sendEmailToSiteOwner();
              }
              else {
                emailSuccessfullySent();
              }
            }

            processForm();
            ?>
          </div>
        </div>
      </div>
    </div>
    <!--jumbotron_container-->
  </body>
</html>