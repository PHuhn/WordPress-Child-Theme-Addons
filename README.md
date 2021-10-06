# WordPress-Child-Theme-Addons

This is a template for a WordPress child theme with a few custom addons.

The addons are as follows:
- gc_get_season (PHP function)
- gc-fade animation (js and CSS)
- gc_counter animation (shortcode, js and CSS)
- gc_marquee animation (shortcode, js and CSS)
- gc_box_posts (shortcode and CSS)
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

Additional stand-alone animation:
- gc-pulse

## gc_counter animation

gc_counter animation is a combination of PHP (shortcode), Javascript and CSS.

The following is an example of the shortcode:

`[gc_counter id="cups-1" start="1000" end="2000" inc="50" interval="80"]`

The arguments are as follows:
- id:    (not require) will assign a div id (id value must be unique on the page)
- start: (defaults to 0) is the starting counter value
- end:   (defaults to 100) is the ending counter value
- inc:   (defaults to 5, not less than 1) is the incremental value of the counter
- interval:  (defaults to 100) is the number of milliseconds between increments

## gc_marquee animation

gc_marquee animation is a combination of PHP (shortcode), Javascript and CSS.  gc_marquee displays a marquee/ticker.

The following is an example of the shortcode:

`[gc_marquee id="marq-1" text="Short marquee text!" milli-sec="16000" height="75" bg-color="black" text-color="#dddddd" text-tag="h3" margin="15" weight="bold"]`

The arguments are as follows:
- id:         (not require) will assign a div id for the outer tag (id value must be unique on the page).
- text:       (required) text for the marquee.
- milli-sec:  (defaults to 20000 or 20 seconds) # of milliseconds to finish one full pass
- height:     (defaults to 28px) style height applied to outer tag.
- bg-color:   (defaults to system) background color applied to outer tag.
- text-color: (defaults to system) font color applied to outer tag.
- text-tag:   (defaults to p) HTML inner tag value (no &gt; and &lt;).
- margin:     (defaults to none) style applied to inner tag, if 5 then would look like 'margin 5px auto;'.
- weight:     (defaults to none) font-weight style applied to inner tag.

## gc_box_posts

gc_box_posts is a PHP (shortcode) function and CSS, that lists posts in two formats.  The formats are as follows:
- rectangle: rectangular image with post title in white field,
- circle: post image inside of a circle, with title below.

Posts can be selected in any combination of three way:
- post_type: a custom post type,
- category:  a post category,
- tag:       a post tag.

The following is an example of the shortcode:
`[gc_box_posts format='rectangle' category_slug='meetings' tag_slug='2020' posts_per_row=3 showposts=6]`
or
`[gc_box_posts format='circle' category_slug='hnv-blogs' showposts=5]`

The arguments are as follows:
- format:        (default is rectangle) rectangle or circle,
- post_type:     (default to none) a custom post type,
- category_slug: (default to none) a post category slug or comma seperated slugs, if blank the latest posts,
- tag_slug:      (default to none) a post tag slug or comma seperated slugs, if blank then see category_slug
- posts_per_row: (default is 5) the number of posts displayed in a row,
- showposts:     (default is 5) the number of posts to displayed.

## gc_year

gc_year is a PHP (shortcode) function that returns the current year.

The following is an example of the shortcode:

`[gc_year]`

## Instructions

For more information see the Wiki:

[Wiki](https://github.com/PHuhn/WordPress-Child-Theme-Addons/wiki/)
