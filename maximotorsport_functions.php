<?php
// Path of top of products gallery.
$path_to_gallery = "products";

// File holding the menu cache.
$menu_cache_file = "menu_cache.txt";

// Case-insensitive version of file_exists
function file_exists_ci($file) {
  if (file_exists($file))
    return $file;

  $lowerfile = './' . strtolower($file);

  foreach (glob(dirname($file) . '/*')  as $file) {
    if (strtolower($file) == $lowerfile)
      return $file;
  }
  return FALSE;
}

// Find and Display contents of specified file
function display_ci_text_file($filename, $mandatory=TRUE, $print=TRUE) {
  $ci_text_file = file_exists_ci($filename);
  if ($ci_text_file) {
    $text = file_get_contents($ci_text_file);
  } else {
    if ($mandatory) {
      $text = "<p>Please upload content in " . $filename . ".</p>";
    } else {
      $text = "";
    }
  }
  if ($print) {
    printf ("%s\n", $text);
  } else {
    return $text;
  }
}

// Get the first image file in the specified folder.
function get_dir_image($directory) {

  // Get alphabetic directory listing. PHP v5 has scandir function, but on PHP v4, we have
  // to use opendir to populate an array and then sort it.
  $dirh = opendir($directory);
  while (($filename = readdir($dirh)) !== false) {
    $files[] = $filename;
  }
  sort($files);

  $image_found = '';
  for($k = 0; $k < count($files); $k++) {
    $file_name = $files[$k];
    if ($file_name == '.' || $file_name == '..') continue;		// skip to next iteration.

    // Differentiate between directories and images.
    $dir_path = $directory . "/" . $file_name;
    if (!is_dir($dir_path)) {

      // Ignore file types that we dont want.
      list($dummy,$file_type) = explode(".",$file_name);
      if ($file_type == 'php' || strtolower($file_type) == 'txt' || $file_type == 'db' || $dummy == 'error_log') continue;		// skip to next iteration.

      // An image
      $image_found = $file_name;
      break;

    } // end of if not a directory

  } // end of for loop

  closedir($dirh);
  return $image_found;

}

// Display Specific Gallery. This function compiles 2 strings (one for the sub-categories and one for the images)
function list_gallery($directory, $product_name) {

  // Get directory listing. PHP v5 has scandir function, but on PHP v4, we have
  // to use opendir to populate an array and then sort it.
  $dirh = opendir($directory);
  while (($filename = readdir($dirh)) !== false) {
    $files[] = $filename;
  }

  // Check for existence of a user-supplied ordering file and read it if it does.
  $user_order_file_name = $directory."/order.txt";
  $user_order_file = file_exists_ci($user_order_file_name);
  if ($user_order_file) {
    $order = file($user_order_file_name, FILE_IGNORE_NEW_LINES);
    if (count($order) > 0) {
      $files = array_intersect($order, $files);
    } else {
      // Empty user-ordering supplied - use alphabetic order
      sort($files);
    }
  } else {
    // Alphabetic order
    sort($files);
  }

  // Now, output the images.
  $directories = "<table id=\"latest-products\">\n";			// initialise string that outputs the sub-categories.
  $col_count   = 0;												// initilise count of sub-categories in current table row.
  $dir_count   = 0;												// initilise total number of sub-categories found.
  $imagestring = "";											// initialise string that outputs the images in a table.
  $images_found = FALSE;
  $mandatory = TRUE;											// Text files that must exist.
  for($k = 0; $k < count($files); $k++) {
    $file_name = $files[$k];
    if ($file_name == '.' || $file_name == '..') continue;		// skip to next iteration.

    // Differentiate between directories and images.
    $dir_path = $directory . "/" . $file_name;
    if (is_dir($dir_path)) {

      // This is a directory - Start new row in table of sub-categories if required.
      if ($col_count == 0) {
		$directories .= "<tr>\n";
      }

      // Find first image for this sub-category.
      $dir_image = get_dir_image($dir_path);
      if ($dir_image) {

        // Append output information with a link to select this directory in a new table cell.
        $directories .= sprintf("<td><a href=\"products.php?directory=%s\"><img src=\"%s\" alt=\"%s\"><br>%s</a></td>\n",
                                $dir_path, $dir_path. "/" .$dir_image, $file_name, $file_name);

      } else {

        // Append output information with a link to select this directory (no image)
        $directories .= sprintf("<td><a href=\"products.php?directory=%s\"><br>%s</a></td>\n", $dir_path, $file_name);
      }

      // Increment counts of sub-categories.
      $dir_count++;
      $col_count++;

      // End row in table of sub-categories and reset row count as required.
      if ($col_count == 4) {
		$directories .= "</tr>\n";
		$col_count = 0;
      }

    } else {

      // Ignore file types that we dont want.
      list($dummy,$file_type) = explode(".",$file_name);
      if ($file_type == 'php' || strtolower($file_type) == 'txt' || $file_type == 'db' ||
          $dummy == 'error_log'  || $dummy == 'logo' ) continue;							// skip to next iteration.

      // An image

      // If first one found, output div structure.
      if (!$images_found) {
        $imagestring .= "<div class=\"products_left\">\n";
        $images_found = TRUE;
      }

      // Get name of the image file.
      list($image_name) = explode(".",$file_name);

      // Include a description for this image, if one exists.
      $description = "<br>" . display_ci_text_file($directory . "/" . $image_name . ".txt", FALSE, FALSE);

      $file_name = $directory . "/" . $file_name;
      $imagestring .= sprintf ("<a class=\"fancybox\" href=\"%s\" data-fancybox-group=\"gallery\" title=\"%s\">
                                <img src=\"%s\" alt=\"%s\"></a><br><strong>%s</strong>%s\n",
                                $file_name, $image_name, $file_name, $image_name, $image_name, $description);

    } // end of if image

  } // end of for loop

  closedir($dirh);

  // Output HTML for end of list if required.
  if ($images_found) {
    $imagestring .= "<p><strong>Click on image for a larger photo.</strong></p></div>\n";
  }

  // If there are product images on this page, append the (mandatory) product description.
  if ($imagestring) {
    $imagestring .= "<div class=\"products_right\">" . display_ci_text_file($directory . "/" . "Product.txt", $mandatory, FALSE);

    // Get the (mandatory) prices (product and carriage separately).
    $pricestring = display_ci_text_file($directory . "/" . "Price.txt", $mandatory, FALSE);
    if (strpos($pricestring, 'Please upload content') !== false) {
      $imagestring .= $pricestring;
    } else {
      list($prod_price, $carr_price) = explode(" ",$pricestring);
      $total_price = $prod_price + $carr_price;
      $imagestring .= sprintf("<p>Product Price: &pound;%.2f<br>plus carriage: &pound;%.2f<br>total : &pound;%.2f</p>\n", $prod_price, $carr_price, $total_price);

      // PayPal button
      $imagestring .= sprintf("<div><p><strong>To order and pay via PayPal, please enter the quantity required and click the &quot;Buy Now&quot; button below.\n" .
                      "This will open up a new browser window.</strong></p>\n" .
                      "<form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" target=\"_blank\">\n" .
                      "<div><p>Quantity: <input type=\"text\" name=\"quantity\"></p>\n" .
                      "<input type=\"hidden\" name=\"cmd\" value=\"_xclick\">\n" .
                      "<input type=\"hidden\" name=\"business\" value=\"tonypalfrey@hotmail.co.uk\">\n" .
                      "<input type=\"hidden\" name=\"lc\" value=\"GB\">\n" .
                      "<input type=\"hidden\" name=\"button_subtype\" value=\"products\">\n" .
                      "<input type=\"hidden\" name=\"currency_code\" value=\"GBP\">\n" .
                      "<input type=\"hidden\" name=\"bn\" value=\"PP-BuyNowBF:btn_buynowCC_LG.gif:NonHostedGuest\">\n" .
                      "<input type=\"hidden\" name=\"item_name\" value=\"%s\">\n" .
                      "<input type=\"hidden\" name=\"amount\" value=\"%s\">\n" .
                      "<input type=\"image\" src=\"https://www.paypal.com/en_GB/i/btn/btn_buynowCC_LG.gif\" name=\"submit\" alt=\"Buy Now\">\n" .
                      "</div></form></div></div>",
                      $product_name, $total_price);
    }

  }

  // Complete row with empty table cells
  if ($dir_count > 0 && $col_count > 0) {
    for($cell = $col_count; $cell < 4; $cell++) {
      $directories .= "<td>&nbsp;</td>\n";
      if ($cell == 3) {
        $directories .= "</tr>";
      }
    }
  }

  // Output list of directories if required.
  if ($dir_count > 0) {
    printf ("%s</table>\n", $directories);
  }

  // Output list of images if required.
  if ($imagestring) { printf ("%s\n", $imagestring); }

}

// Get structure of the specified directory for the menu.
function get_directory_structure(&$full_menu, &$parents, $directory=1) {
  global $path_to_gallery;

  // Scan top-level directory unless other specified.
  if ($directory == 1) {
    $directory = $path_to_gallery;
  }

  // Get directory listing. PHP v5 has scandir function, but on PHP v4, we have
  // to use opendir to populate an array and then sort it.
  $dirh = opendir($directory);
  while (($filename = readdir($dirh)) !== false) {
    $files[] = $filename;
  }

  // Check for existence of a user-supplied ordering file and read it if it does.
  $user_order_file_name = $directory."/order.txt";
  $user_order_file = file_exists_ci($user_order_file_name);
  if ($user_order_file) {
    $order = file($user_order_file_name, FILE_IGNORE_NEW_LINES);
    if (count($order) > 0) {
      $files = array_intersect($order, $files);
    } else {
      // Empty user-ordering supplied - use alphabetic order
      sort($files);
    }
  } else {
    // Alphabetic order
    sort($files);
  }

  // Any directories found will belong to the current parent directory.
  $parent = array_search($directory, $full_menu);
  if (!$parent) $parent = null;

  // Loop through the directory listing and store directories.
  for($k = 0; $k < count($files); $k++) {
    $file_name = $files[$k];
    if ($file_name == '.' || $file_name == '..') continue;		// skip to next iteration.

    // Identify directories.
    $dir_path = $directory . "/" . $file_name;
    if (is_dir($dir_path)) {
      $full_menu[] = $dir_path;
      $parents[] = $parent;
    }
  }
}

// Get complete product directory sructure for the menu.
function get_product_structure() {

  $full_menu = array();
  $parents = array();
  $full_menu[] = 'products';
  $parents[] = null;
  get_directory_structure($full_menu, $parents);
  for($k = 1; $k < count($full_menu); $k++) {
    get_directory_structure($full_menu, $parents, $full_menu[$k]);
  }

  // Merge the URLs and parent nodes into one array, so that it is in the format required by the code
  // solution below, taken from http://www.tommylacroix.com/2008/09/10/php-design-pattern-building-a-tree/
  $dataset = array();
  for ($i = 0; $i < count($full_menu); $i++) {
	$dataset[$i] = array(
		'name' => $full_menu[$i],
		'parent' => $parents[$i]
	);
  }
  return $dataset;
}

function mapTree($dataset) {
	$tree = array();
	foreach ($dataset as $id=>&$node) {
		if ($node['parent'] === null) {
			$tree[$id] = &$node;
		} else {
			if (!isset($dataset[$node['parent']]['children'])) $dataset[$node['parent']]['children'] = array();
			$dataset[$node['parent']]['children'][$id] = &$node;
		}
	}

	return $tree;
}

// Outputs the tree menu in HTML.
function display_tree_menu($nodes, $indent=0, $first=FALSE) {
  if ($indent >= 20) return;	// Stop at 20 sub levels

  foreach ($nodes as $node) {
    // The title of the menu is the last part of the URL. Replace spaces with non-breaking spaces.
    $url = $node['name'];
    $title = end(explode("/", $url));
    $title = str_replace(" ", "&nbsp;", $title);

    if ($first) {
      if ($indent == 0) {
        // The first product item is "products", so we are ignoring this (special case).
      } else {
        // First element of this <ul> tag, so closing <li> tag not needed.
        printf("<li><a href=\"products.php?directory=%s\">%s</a>\n", $url, $title);
      }
      // End of special-case processing.
      $first = FALSE;
    } else {
      // Second or subsequent element of this <ul> tag, so closing <li> tag needed.
      printf("</li><li><a href=\"products.php?directory=%s\">%s</a>\n", $url, $title);
    }
	if (isset($node['children'])) {
	  // Start a new sub-menu
	  print("<ul>\n");
	  $new_sub_menu = TRUE;
      display_tree_menu($node['children'], $indent+1, $new_sub_menu);
	  print("</li></ul>\n");
    }
  }
}

// Write menu array to the cache file.
function write_menu_array($menu_array) {
  global $menu_cache_file;

  // Write a JSON representation of the menu array object to the file.
  $status = file_put_contents($menu_cache_file, json_encode($menu_array));
  echo "<p>Writing to " . realpath($menu_cache_file). ".</p>";
  echo "<p>status = $status</p>";
}

// Read menu array from the cache file.
function read_menu_array() {
  global $menu_cache_file;

  // Read the JSON representation of the menu array object.
  $data = file_get_contents($menu_cache_file);

  // Return the JSON decoded version of the data as an array.
  $arr = json_decode($data, true);
  return $arr;
}
?>