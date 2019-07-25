
<!DOCTYPE html>
<html>
<body>

<head>
  <link href="../css/style.css" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script type="text/javascript" src="../js/myscript.js" async></script>
  <?php include("class_lib.php"); ?>
</head>

<?php

/* main code to be executed at the start
 * The feed url can be changed as per the requirement.
 */
$urlVal = 'https://dev98.de/feed';
$objpost = new  posts($urlVal);
$contentItem =  $objpost->getItems();
if($contentItem == null)
    Echo "No feed to display";
else
    $objpost->displayFeed($contentItem);
/* end of main code*/
?>

</body>
</html>


