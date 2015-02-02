<?php include("header.php"); ?>
<?php
  global $path_to_gallery;

  // Initialise breadcrumb variable.
  $crumbs = NULL;
  // Check if a directory has been specified.
  $directory = NULL;
  if ($_GET && $_GET['directory']) {
    $directory = $_GET['directory'];
  }
  if ($directory) {
    $crumbs = explode("/", $directory);
    $link = "/products.php";
    // Output Breadcrumbs
    for($k = 0; $k < count($crumbs)-1; $k++)
    {
      if ($k > 0) {
        $link .= "/" . $crumbs[$k];
      }
      printf(">> <a href=\"%s\">%s</a>\n", $link, $crumbs[$k]);
      if ($k == 0) {
        $link .= "?directory=products";
      }
    }
    // Page Title is name of last folder.
    printf("<h2>%s</h2>\n", $crumbs[count($crumbs)-1]);
  } else {
    $directory = $path_to_gallery;
    printf ("<h2 style=\"font-family:verdana; font-size:23px;\">Our Products</h2>\n");
  }
  // Output gallery
  list_gallery($directory, $crumbs[count($crumbs)-1]);
?>
<?php include("footer.php"); ?>