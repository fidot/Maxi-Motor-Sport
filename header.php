<?php
  // Standard functions.
  include("maximotorsport_functions.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en-UK">
<head profile="http://www.w3.org/2005/10/profile">
<title>Maxi Motor Sport</title>
<link rel="icon"
      type="image/ico"
      href="http://www.maximotorsport.com/favicon.ico">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<link rel=stylesheet type="text/css" href="css/maximotorsport.css">

    <!-- External Links in New Window -->
    <script type="text/javascript" src="js/xhtml-external-links.js" ></script>

	<!-- Add jQuery library -->
	<script type="text/javascript" src="js/fancyBox/lib/jquery-1.10.1.min.js"></script>

	<!-- Add mousewheel plugin (this is optional) -->
	<script type="text/javascript" src="js/fancyBox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="js/fancyBox/source/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="js/fancyBox/source/jquery.fancybox.css?v=2.1.5" media="screen">

	<!-- Add Button helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="js/fancyBox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5">
	<script type="text/javascript" src="js/fancyBox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

	<!-- Add Thumbnail helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="js/fancyBox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7">
	<script type="text/javascript" src="js/fancyBox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

	<!-- Add Media helper (this is optional) -->
	<script type="text/javascript" src="js/fancyBox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			/*
			 *  Simple image gallery. Uses default settings
			 */

			$('.fancybox').fancybox();

			/*
			 *  Different effects
			 */

			// Change title type, overlay closing speed
			$(".fancybox-effects-a").fancybox({
				helpers: {
					title : {
						type : 'outside'
					},
					overlay : {
						speedOut : 0
					}
				}
			});

			// Disable opening and closing animations, change title type
			$(".fancybox-effects-b").fancybox({
				openEffect  : 'none',
				closeEffect	: 'none',

				helpers : {
					title : {
						type : 'over'
					}
				}
			});

			// Set custom style, close if clicked, change title type and overlay color
			$(".fancybox-effects-c").fancybox({
				wrapCSS    : 'fancybox-custom',
				closeClick : true,

				openEffect : 'none',

				helpers : {
					title : {
						type : 'inside'
					},
					overlay : {
						css : {
							'background' : 'rgba(238,238,238,0.85)'
						}
					}
				}
			});

			// Remove padding, set opening and closing animations, close if clicked and disable overlay
			$(".fancybox-effects-d").fancybox({
				padding: 0,

				openEffect : 'elastic',
				openSpeed  : 150,

				closeEffect : 'elastic',
				closeSpeed  : 150,

				closeClick : true,

				helpers : {
					overlay : null
				}
			});

			/*
			 *  Button helper. Disable animations, hide close button, change title type and content
			 */

			$('.fancybox-buttons').fancybox({
				openEffect  : 'none',
				closeEffect : 'none',

				prevEffect : 'none',
				nextEffect : 'none',

				closeBtn  : false,

				helpers : {
					title : {
						type : 'inside'
					},
					buttons	: {}
				},

				afterLoad : function() {
					this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
				}
			});


			/*
			 *  Thumbnail helper. Disable animations, hide close button, arrows and slide to next gallery item if clicked
			 */

			$('.fancybox-thumbs').fancybox({
				prevEffect : 'none',
				nextEffect : 'none',

				closeBtn  : false,
				arrows    : false,
				nextClick : true,

				helpers : {
					thumbs : {
						width  : 50,
						height : 50
					}
				}
			});

			/*
			 *  Media helper. Group items, disable animations, hide arrows, enable media and button helpers.
			*/
			$('.fancybox-media')
				.attr('rel', 'media-gallery')
				.fancybox({
					openEffect : 'none',
					closeEffect : 'none',
					prevEffect : 'none',
					nextEffect : 'none',

					arrows : false,
					helpers : {
						media : {},
						buttons : {}
					}
				});

			/*
			 *  Open manually
			 */

			$("#fancybox-manual-a").click(function() {
				$.fancybox.open('1_b.jpg');
			});

			$("#fancybox-manual-b").click(function() {
				$.fancybox.open({
					href : 'iframe.html',
					type : 'iframe',
					padding : 5
				});
			});

			$("#fancybox-manual-c").click(function() {
				$.fancybox.open([
					{
						href : '1_b.jpg',
						title : 'My title'
					}, {
						href : '2_b.jpg',
						title : '2nd title'
					}, {
						href : '3_b.jpg'
					}
				], {
					helpers : {
						thumbs : {
							width: 75,
							height: 50
						}
					}
				});
			});


		});
	</script>
	<style type="text/css">
		.fancybox-custom .fancybox-skin {
			box-shadow: 0 0 50px #222;
		}
	</style>
</head>
<body>
<div id="page-container" style="width:950px; background-color:#edfbc5; margin:0 auto; padding:20px">
  <div id="header" style="width:950px;">
    <img src="images/maxi-banner.jpg" width="950" alt="Maxi Motor Sport">
    <?php
      // Hero Image only required on home page.
      $hero_image_reqd = array("/index.php");
      if (in_array($_SERVER["SCRIPT_NAME"], $hero_image_reqd, true)) {
      ?>
<script language="JavaScript1.2">

var howOften = 3; //number often in seconds to rotate
var current = 0; //start the counter at 0
var ns6 = document.getElementById&&!document.all; //detect netscape 6

// place your images, text, etc in the array elements here
var items = new Array();
    items[0]="<a href='link.htm' ><img alt='image0 (9K)' src='/images/Hero Images/Palfrey1 205.jpg' height='515' width='950' border='0' /></a>"; //a linked image
    items[1]="<a href='link.htm'><img alt='image1 (9K)' src='/images/Hero Images/Satchell1 205.jpg' height='515' width='950' border='0' /></a>"; //a linked image
    items[2]="<a href='link.htm' ><img alt='image0 (9K)' src='/images/Hero Images/Gammon 106.jpg' height='515' width='950' border='0' /></a>"; //a linked image
    items[3]="<a href='link.htm'><img alt='image1 (9K)' src='/images/Hero Images/Palfrey 205.jpg' height='515' width='950' border='0' /></a>"; //a linked image
    items[4]="<a href='link.htm' ><img alt='image0 (9K)' src='/images/Hero Images/Godney 205.jpg' height='515' width='950' border='0' /></a>"; //a linked image
    items[5]="<a href='link.htm'><img alt='image1 (9K)' src='/images/Hero Images/Palfrey2 205.jpg' height='515' width='950' border='0' /></a>"; //a linked image
    items[6]="<a href='link.htm' ><img alt='image0 (9K)' src='/images/Hero Images/Satchell 205.jpg' height='515' width='950' border='0' /></a>"; //a linked image
    items[7]="<a href='link.htm'><img alt='image1 (9K)' src='/images/Hero Images/Palfrey3 205.jpg' height='515' width='950' border='0' /></a>"; //a linked image
    items[8]="<a href='link.htm' ><img alt='image0 (9K)' src='/images/Hero Images/Godney1 205.jpg' height='515' width='950' border='0' /></a>"; //a linked image
    items[9]="<a href='link.htm' ><img alt='image0 (9K)' src='/images/Hero Images/Gammon1 106.jpg' height='515' width='950' border='0' /></a>"; //a linked image
    items[10]="<a href='link.htm' ><img alt='image0 (9K)' src='/images/Hero Images/DrowneAX.jpg' height='515' width='950' border='0' /></a>"; //a linked image
    function rotater() {
    document.getElementById("placeholder").innerHTML = items[current];
    current = (current==items.length-1) ? 0 : current + 1;
    setTimeout("rotater()",howOften*1000);
}

function rotater() {
    if(document.layers) {
        document.placeholderlayer.document.write(items[current]);
        document.placeholderlayer.document.close();
    }
    if(ns6)document.getElementById("placeholderdiv").innerHTML=items[current]
        if(document.all)
            placeholderdiv.innerHTML=items[current];

    current = (current==items.length-1) ? 0 : current + 1; //increment or reset
    setTimeout("rotater()",howOften*1000);
}
window.onload=rotater;
//-->
</script>



        <layer id="placeholderlayer"></layer><div id="placeholderdiv"></div>
      <?php
      }
    ?>
	<!-- Menu required on all pages -->
	<nav>
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="aboutus.php">About Us</a>
    <?php
      // Check for existence of a menu cache file
      if (file_exists($menu_cache_file)) {
        // Read the data from the file.
        $tree = read_menu_array();
      } else {
        // Get all the menu items for products
        $full_menu = get_product_structure();

        // Build tree in correct order
        $tree = array();
        $tree = mapTree($full_menu);
      }

      // Display the resultant menu.
      $indent = 0;
      $first = TRUE;
      display_tree_menu($tree, $indent, $first);
    ?>
			<li><a href="contact.php">Contact Us</a></li>
			<li><a href="terms.php">Terms & Conditions</a></li>
		</ul>
    </nav>
  </div>
  <div id="middle" style="width:950px;">
    <div id="main" style="float:left; padding:10px; color:black;">