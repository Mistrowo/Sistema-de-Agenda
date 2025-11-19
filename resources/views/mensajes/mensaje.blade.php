<?php
    // Update the path below to your autoload.php,
    // see https://getcomposer.org/doc/01-basic-usage.md
    require_once '/path/to/vendor/autoload.php';
    use Twilio\Rest\Client;

    $sid    = "ACcc5ef93e16498b28df5ce9ac1d374a9e";
    $token  = "[AuthToken]";
    $twilio = new Client($sid, $token);

    $message = $twilio->messages
      ->create("whatsapp:+56958159901", // to
        array(
          "from" => "whatsapp:+14155238886",
          "body" => 'Your  code is 1238432'
        )
      );

print($message->sid);