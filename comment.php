<?php

  $clean = array();
  $html = array();


  /* Filter Input ($name, $comment) */

  if ( (ctype_alnum($_POST['name'])) && (ctype_alnum($_POST['comment'])) ) {
    $clean['name'] = $_POST['name'];
    $clean['comment'] = $_POST['comment'];
  }


  $html['name'] = htmlentities($clean['name'], ENT_QUOTES, 'UTF-8');
  $html['comment'] = htmlentities($clean['comment'], ENT_QUOTES, 'UTF-8');


  echo "<p>{$html['name']} writes:<br />";
  echo "<blockquote>{$html['comment']}</blockquote></p>";

?>
