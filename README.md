# WordPress-Child-Theme-Addons

This is a template for a WordPress child theme with a few custom addons.

The addons are as follows:
- gc_get_season (PHP function)
- gc-fade animation (js and CSS)
- gc_counter animation (shortcode, js and CSS)
- gc_year (shortcode)

## gc_get_season

gc_get_season is a PHP function that returns the following possible sting values:
- spring
- summer
- autumn
- winter

One use is this function can be used to inject a season into the page's class.  For example, say in twenty-twenty theme copy header.php into child theme and change the following from:

`<body <?php body_class(); ?>>`

to:

`<body <?php body_class(gc_get_season( )); ?>>`

The above will render as follows:

`<body class="page-template-default page page-id-667 ... winter ...">`

## gc-fade animation

gc-fade animation is a combination of Javascript and CSS.

## gc_counter animation

gc_counter animation is combination of PHP (shortcode), Javascript and CSS.

## gc_year

gc_get_season is a PHP (shortcode) function that returns the current year.
