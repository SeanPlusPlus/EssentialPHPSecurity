<?php

  /*
  Validate an email address.
  Provide email address (raw input)
  Returns true if the email address has the email
  address format and the domain exists.
  source:
  http://www.linuxjournal.com/article/9585?page=0,3
  */

  function validEmail($email)
  {
    $isValid = true;
    $atIndex = strrpos($email, "@");
    if (is_bool($atIndex) && !$atIndex)
    {
      $isValid = false;
    }
    else
    {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
        // local part length exceeded
        $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
        // domain part length exceeded
        $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
        // local part starts or ends with '.'
        $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
        // local part has two consecutive dots
        $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
        // character not valid in domain part
        $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
        // domain part has two consecutive dots
        $isValid = false;
      }
      else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                str_replace("\\\\","",$local)))
      {
        // character not valid in local part unless
        // local part is quoted
        if (!preg_match('/^"(\\\\"|[^"])+"$/',
            str_replace("\\\\","",$local)))
        {
            $isValid = false;
        }
      }
      if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
      {
        // domain not found in DNS
        $isValid = false;
      }
    }
    return $isValid;
  }

  /* Useful Default Variables */

  $clean = array(); // assignment occurs inside if statement
  $html  = array(); // to assign, pass $clean to htmlentities

  /* Filter Input */

  if ( validEmail($_POST['email']) )  {
    $clean['email'] = $_POST['email'];
  }
  else {
    $clean['email'] = "Invalid Email Address";
  }

  if ( preg_match("/<\s*script/i", $_POST['comment']) )  {
    $clean['comment'] = "Are You Kidding Me?!";
  }
  else {
    $clean['comment'] = $_POST['comment'];
  }

  /* Generate Output */

  $html['email']    = htmlentities($clean['email'], ENT_QUOTES, 'UTF-8');
  $html['comment'] = htmlentities($clean['comment'], ENT_QUOTES, 'UTF-8');

  /* Display */

  echo "<p><b>email: </b>{$html['email']}</p>";
  echo "<p><b>comment: </b>{$html['comment']}</p>";

  /* How Not to Do It */

  //$email = $_POST['email'];
  //$comment = $_POST['comment'];

  //echo  "<p><b>email: </b>$email</p>";
  //echo "<p><b>comment: </b>$comment</p>";

?>
