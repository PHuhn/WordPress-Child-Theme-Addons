# WordPress-Child-Theme-Addons

This is a template for a WordPress child theme with a few custom addons.

The addons are as follows:
- gc_get_season (PHP function)
- gc-fade animation (js and CSS)
- gc_counter animation (shortcode, js and CSS)
- gc_marquee animation (shortcode, js and CSS)
- gc_type_writer animation (shortcode, js and CSS)
- gc_slider animation (shortcode, js and CSS)
- gc_image_item animation (shortcode, js and CSS)
- gc_slider, gc_image_item and gc_slider_item
- gc_box_posts (shortcode and CSS)
- gc_posts_slider animation (shortcode, js and CSS)
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

[gc_counter] animation is a combination of PHP (shortcode), Javascript and CSS.

The following is an example of the shortcode:

`[gc_counter id="cups-1" start="1000" end="2000" inc="50" interval="80"]`

The arguments are as follows:
- id:    (not require) will assign a div id (**'id'** value must be unique on the page)
- start: (defaults to 0) is the starting counter value
- end:   (defaults to 100) is the ending counter value
- inc:   (defaults to 5, not less than 1) is the incremental value of the counter
- interval:  (defaults to 100) is the number of milliseconds between increments

## gc_marquee animation

[gc_marquee] animation is a combination of PHP (shortcode), Javascript and CSS.  [gc_marquee] displays a marquee/ticker.

The following is an example of the shortcode:

`[gc_marquee id="marq-1" text="Short marquee text!" milli-sec="16000" height="75" bg-color="black" text-color="#dddddd" text-tag="h3" margin="15" weight="bold"]`

The arguments are as follows:
- id:         (not require) assigns an id for the outer tag (**'id'** value must be unique on the page).
- text:       (required) text for the marquee.
- milli-sec:  (defaults to 20000 or 20 seconds) # of milliseconds to finish one full pass
- height:     (defaults to 28px) style height applied to outer tag.
- bg-color:   (defaults to system) background color applied to outer tag.
- text-color: (defaults to system) font color applied to outer tag.
- text-tag:   (defaults to p) HTML inner tag value (no &gt; and &lt;).
- margin:     (defaults to none) style applied to inner tag, if 5 then would look like 'margin 5px auto;'.
- weight:     (defaults to none) font-weight style applied to inner tag.

## gc_type_writer animation

[gc_type_writer] animation is a combination of PHP (shortcode), Javascript and CSS. [gc_type_writer] displays text a letter or word at a time.

The following are examples of the shortcode:

`[gc_type_writer id="tw-1" text="Short type writer text!" type="letter" milli-sec="60" bg-color="black" text-color="#dddddd" text-tag="h3" weight="bold"]`

or:

`[gc_type_writer id="tw-2" text="Short type writer text!" type="word" milli-sec="450" bg-color="darkgray" text-color="red" text-tag="p" weight="bold"]`

The arguments are as follows:
- id:         (not require) assigns an id for the tag (**'id'** value must be unique on the page),
- text:       (required) text for the type writer,
- type:       (default is letter) options of letter/word,
- milli-sec:  (default 50 or 1/20 seconds) # of milliseconds between typing,
- bg-color:   (system default) background color applied to the tag,
- text-color: (system default) font color applied to the tag,
- text-tag:   (default is p) HTML tag value,
- weight:     (defaults to none) font-weight style applied to the tag.

## gc_slider

[gc_slider] returns the HTML code for an animated GC slider.
[gc_slider] is a two part shortcode as follows [gc_slider]content[/gc_slider].  The content is imbedded and should be another list of shortcodes.  Also see the [gc_image_item] shortcode.
This is a wrapper for another shortcodes or content.  It renders a
collection of items, all set to display: none (i.e. hidden).
The JavaScript loops through allow each one to display the item.

Note:

That [gc_slider] will remove `<br />` from the output.  If you want to use a br in the imbedded content, try using a `<br/>` instead.

[gc_slider] shortcode example:

[gc_slider type='image' aria_label='Beautiful sunrises on Lake Huron' milli_sec='5500' bg_color='#dddddd' text_color='brown']Your content here...[/gc_slider]

The arguments are as follows:
- id:         (not require) assigns an id for the tag (**'id'** value must be unique on the page),
- type:       (required, default none) type/role of slider, options are img/list,
- aria_label: (default 'Marketing images') accessibility value for the slider,
- milli_sec:  (default 5000 or 5 seconds) # of milliseconds to finish one full pass,
- header:     (default none) header for the slider,
- footer:     (default none) footer for the slider,
- bg_color:   (default none) background color applied to outer div tag,
- text_color: (default none) font color applied to outer div tag.
- border_color: (default is none) style for border, if value then 1px solid border,

## gc_image_item

[gc_image_item] is used with the [gc_slider] shortcode.  This displays an image on one half of the screen and the title on the other half.  Both the image and the title slide in on the **'image_side'**.  The animation is done by CSS @keyframes.

Note:

That [gc_slider] will remove <br /> from the output.  If you want to use a br in the imbedded content, try using a <br/> instead.

Example:

[gc_image_item id='ii-1' image_id='22' image_title='Beautiful sunrise' image_side='right' bg_color='#dddddd' text_color='brown']

The arguments are as follows:
- id:              (not require) assigns an id for the tag (**'id'** value must be unique on the page),
- image_id:        (default is none) id for an image, use either **'image_id'** or **'image_url'** to get image,
- image_title:     (required, default none) display message (title) beside the image,
- title_font_size: (required, default '60px') Font size of the image_title value,
- image_side:      (required, default 'right') which side the image is on, options right/left,
- image_url:       (default none) use either **'image_id'** or **'image_url'** to define which image,
- image_alt:       (default none) needed if used **'image_url'**, if **'image_id'** used, it can get the value from the image (if available),
- bg_color:        (default none) background color applied to title div tag,
- text_color:      (default none) font color applied to title div tag.

## gc_slider and gc_image_item

Combine the [gc_slider] with the [gc_image_item] to create an image slider.

If one needs to apply additional CSS, then I suggest using an **'id'** for the slider for a reference selector.  Then I suggest the **'id'** might be best to be unique across the site.

Example:
```
[gc_slider id='is-1' type='image' aria_label='Beautiful sunrises on Lake Huron' title='Sunrises' milli_sec='5500' bg_color='#dddddd' text_color='brown']
[gc_image_item id='ii-1' image_id='1370' image_title='Beautiful sunrise' image_side='right' bg_color='#eeeeee' text_color='black']
[gc_image_item id='ii-2' image_id='1369' image_title='Another sunrise' image_side='left' bg_color='#eeeeee' text_color='brown']
[gc_image_item id='ii-1' image_id='1368' image_title='Beautiful sunrise' image_side='right' bg_color='#eeeeee' text_color='black']
[gc_image_item id='ii-2' image_id='1367' image_title='Another sunrise' image_side='left' bg_color='#eeeeee' text_color='brown']
[/gc_slider]
```

## gc_slider_item

[gc_slider_item] is used with the [gc_slider] shortcode.  
This shortcode wrappers content.  [gc_slider_item] is a two part shortcode as follows:

[gc_slider_item]content[/gc_slider_item]

The animation is done by CSS @keyframes.

Note:

That [gc_slider_item] will remove <br /> from the output.  If you want to use a br in the imbedded content, try using a <br/> instead.

Example:
```
[gc_slider_item id='si-1' animate='fade-right' bg_color='#dddddd' text_color='brown']
 <div style="display: table-cell; vertical-align: middle; heigth: 100px;">Hello World</div>
[/gc_slider_item]
```

The arguments are as follows:

- id:            An id for the outer tag (unique value on the page).
- type:          Type/role of slider item, option is img/list (default is none),
- animate:       Options for fade-in animation (default is none),
  - fade-left
  - fade-big-left
  - fade-right
  - fade-big-right
  - fade-in
  - fade-up
  - fade-down
- bg_color:      style background color applied to outer tag, default is none.
- text_color:    style font color applied to outer tag, default is none.
- border_color:  style for border, if value then 1px solid border, (default is none)

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

## gc_posts_slider

[gc_posts_slider] returns the HTML code for a GC animate a slider.  The
posts displayed can be a category, tag or custom post type.

Example:

`[gc_posts_slider id='ps-1' aria_label='Latest Meetings' category_slug='meetings' tag_slug='2020' show_posts=5 border_color='red']`

Such that:
- id:           An id for the outer tag (unique value on the page).
- type:         Type/role of slider, option is img/list (default is none this is required),
- aria_label:   Accessibility value for the slider (default is none),
- milli_sec:    # of milliseconds to finish one full pass (default 6000 or 6 seconds),
- header:       Header for the slider (default is none),
- footer:       Footer for the slider (default is none),
- bg_color:     style background color applied to outer tag (default is none),
- text_color:   style font color applied to outer tag (default is none),
- border_color: style for border, if value then 1px solid border (default is none),
- animate:      Options for fade animation (default is fade-right),
  - fade-left
  - fade-big-left
  - fade-right
  - fade-big-right
  - fade-in
  - fade-up
  - fade-down
- post_type:    a custom post type (default to none),
- category_slug: a post category slug or comma seperated slugs (default is none), if blank the latest posts
- tag_slug:     a post tag slug or comma seperated slugs (default is none), if blank then see category_slug
- show_posts:   the number of posts to displayed (the default is 5),
- show_date:    include the date, option true/false (default is true),
- show_author:  include the author, option true/false (default is true),
- orderby:      order by option (default is 'date'),
- order:        order direction option DESC/ASC (default is 'DESC')

## gc_year

gc_year is a PHP (shortcode) function that returns the current year.

The following is an example of the shortcode:

`[gc_year]`

## Instructions

For more information see the Wiki:

[Wiki](https://github.com/PHuhn/WordPress-Child-Theme-Addons/wiki/)
