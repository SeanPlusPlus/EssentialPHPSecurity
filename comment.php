<?php

  /* Useful Default Variables */

  $clean = array(); // assignment occurs inside if statement
  $html  = array(); // assign by passing $clean to htmlentities

  /* Filter Input ($name, $comment) */

  if ( (ctype_alnum($_POST['name'])) && (ctype_alnum($_POST['comment'])) ) {
    $clean['name']    = $_POST['name'];
    $clean['comment'] = $_POST['comment'];
  }

  /* Generate Output */

  $html['name']    = htmlentities($clean['name'], ENT_QUOTES, 'UTF-8');
  $html['comment'] = htmlentities($clean['comment'], ENT_QUOTES, 'UTF-8');

  /* Display */

  echo "<p><b>name: </b>{$html['name']}</p>";
  echo "<p><b>comment: </b>{$html['comment']}</p>";

?>
