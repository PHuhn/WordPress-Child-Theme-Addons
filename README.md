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

Each usage requires adding two CSS classes to the block:

- gc-show-on-scroll gc-fade-in
- gc-show-on-scroll gc-fade-up
- gc-show-on-scroll gc-fade-down
- gc-show-on-scroll gc-fade-right
- gc-show-on-scroll gc-fade-left
- gc-show-once-on-scroll gc-fade-in
- gc-show-once-on-scroll gc-fade-up
- gc-show-once-on-scroll gc-fade-down
- gc-show-once-on-scroll gc-fade-right
- gc-show-once-on-scroll gc-fade-left

## gc_counter animation

gc_counter animation is combination of PHP (shortcode), Javascript and CSS.

The following is an example of the shortcode:

`[gc_counter id="cups-1" start="1000" end="2000" inc="50" interval="80"]`

The arguments are as follows:
- id    (not require) will assign a div id
- start (defaults to 0) is the starting counter value
- end   (defaults to 100) is the endding counter value
- inc   (defaults to 5, not less than 1) is the increamental value of the counter
- interval  (defaults to 100) is the number of milliseconds between increaments

## gc_year

gc_get_season is a PHP (shortcode) function that returns the current year.

The following is an example of the shortcode:

`[gc_year]`

## Instructions

For more information see the Wiki:

[Wiki](https://github.com/PHuhn/WordPress-Child-Theme-Addons/wiki/)
