<?php include("header.php"); ?>
  <h2 style="font-family:verdana; font-size:24px;">Saving Menu</h2>
<?php
  // Get all the menu items for products
  $full_menu = get_product_structure();

  // Build tree in correct order
  $tree = array();
  $tree = mapTree($full_menu);

  // Store this into the menu cache file.
  write_menu_array($tree);

  // Now, read it from the file.
  $x = read_menu_array();

  $result = array_diff($tree, $x);
  echo "<p>Difference between writing and then reading.</p>";
  echo "<pre>";
  print_r($result);
  echo "</pre>";
?>
