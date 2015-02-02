<?php
// Path of top of products gallery.
$path_to_gallery = "products";

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
function display_ci_text_file($filename) {
  $ci_text_file = file_exists_ci($filename);
  if ($ci_text_file) {
    $text = file_get_contents($ci_text_file);
  } else {
    $text = "<p>Please upload content in " . $filename . ".</p>";
  }
  printf ("%s\n", $text);
}

// Display Specific Gallery. This function compiles 2 strings (one for the sub-categories and one for the images)
function list_gallery($directory) {

  // Get alphabetic directory listing. PHP v5 has scandir function, but on PHP v4, we have
  // to use opendir to populate an array and then sort it.
  $dirh = opendir($directory);
  while (($filename = readdir($dirh)) !== false)
  {
    $files[] = $filename;
  }
  sort($files);

  // Now, output the pictures, maxcols per row.
  $maxcols  = 3;							// maximum columns per row.
  $colcount = 0;							// column count within a row.
  $directories = "";						// initialise string that outputs the sub-categories.
  $imagestring = "";						// initialise string that outputs the images in a table.
  $images_found = FALSE;
  for($k = 0; $k < count($files); $k++)
  {
    $file_name = $files[$k];
    list($dummy,$file_type) = explode(".",$file_name);
    if ($file_name == '.' || $file_name == '..' || $file_type == 'php' || $file_type == 'txt' || $dummy == 'error_log') continue;		// skip to next iteration.

    // Differentiate between directories and images.
    $dir_path = $directory . "/" . $file_name;
    if (is_dir($dir_path)) {
      // Directory - Append output information with a link to select this directory.
      $directories .= sprintf("<p>Category: <a href=\"products.php?directory=%s\">%s</a></p>\n", $dir_path, $file_name);
    } else {

      // An image

      // If first one found, output table structure.
      if (!$images_found) {
        $imagestring .= "<table class=\"gallery_list_table\">\n<tr><th>Click on image for a larger photo.</th></tr>\n ";
        $images_found = TRUE;
      }

      // Increment column count and output a new row if required.
      $colcount++;
      if ($colcount == 1){ $imagestring .= sprintf ("<tr>\n"); }
      list($image_name) = explode(".",$file_name);

      // Include a description for this product, if one exists.
      $desc_file = $directory . "/" . $image_name . ".txt";
      if (file_exists($desc_file)) {
        $description = "<p>" . file_get_contents($desc_file) . "</p>";
      } else {
        $description = "";
      }

      $file_name = $directory . "/" . $file_name;
      $imagestring .= sprintf ("<td align=\"center\" valign=\"top\">
                                <a class=\"fancybox\" href=\"%s\" data-fancybox-group=\"gallery\" title=\"%s\">
                                <img src=\"%s\" width=\"200\" alt=\"%s\"></a><br><strong>%s</strong>%s</td>\n",
                                $file_name, $image_name, $file_name, $image_name, $image_name, $description);

      if ($colcount == $maxcols)
      {
        $imagestring .= "</tr>\n";
        $colcount = 0;
      }

    } // end of if image

  } // end of for loop

  // Handle the last row of pictures in the case where it is not full (i.e. the total number
  // of pictures is not a multiple of maxcols), by filling the columns with blank space.
  if ($colcount > 0)
  {
    $row_terminator = "";
    for($i = $colcount+1; $i <= $maxcols; $i++)
    {
      $row_terminator .= "<td align=\"center\" valign=\"top\">&nbsp;</td>" ;
    }
    $row_terminator .= "</tr>";
    $imagestring .= sprintf ("%s\n", $row_terminator);
    $colcount = 0;
  }
  closedir($dirh);

  // Output end of table if required.
  if ($images_found) {
    $imagestring .= "</table>\n";
  }

  // Output list of directories if required.
  if ($directories) { printf ("%s\n", $directories); }

  // Output list of images if required.
  if ($imagestring) { printf ("%s\n", $imagestring); }

}
?>
