=== ProWoos Posts Grid ===
Contributors: rafael.minuesa
Tags: posts grid, blog grid, shortcode, responsive grid, post cards
Requires at least: 5.6
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A lightweight shortcode plugin that displays WordPress posts in a responsive card grid with featured images, titles, excerpts, and dates.

== Description ==

ProWoos Posts Grid provides a simple `[prowoos_posts_grid]` shortcode that outputs a responsive card-style post grid. It works with any theme and page builder, including Elementor Free.

Drop the shortcode into any page, post, or widget area to display a grid of your latest blog posts — no premium page builder widgets needed.

== Usage ==

= Basic =

    [prowoos_posts_grid]

Displays 6 posts in a 3-column grid (2 on tablet, 1 on mobile).

= With Options =

    [prowoos_posts_grid posts="9" columns="3" category="blog" excerpt_length="15"]

= All Available Attributes =

| Attribute        | Default        | Values                          | Description                          |
|------------------|----------------|---------------------------------|--------------------------------------|
| posts            | 6              | Any number                      | Number of posts to display           |
| columns          | 3              | 1–4                             | Desktop columns                      |
| columns_tablet   | 2              | 1–3                             | Tablet columns (mobile is always 1)  |
| category         | (all)          | Any category slug               | Filter by category slug              |
| excerpt_length   | 20             | Any number                      | Number of words in excerpt           |
| orderby          | date           | date, title, rand, modified     | Sort field                           |
| order            | DESC           | ASC, DESC                       | Sort direction                       |
| offset           | 0              | Any number                      | Skip this many posts                 |
| show_date        | yes            | yes, no                         | Show or hide post date               |
| show_excerpt     | yes            | yes, no                         | Show or hide excerpt                 |
| show_readmore    | yes            | yes, no                         | Show or hide "Read More" link        |
| readmore_text    | Read More →    | Any text/HTML                   | Custom read more link text           |

= Using with Elementor =

1. Add an **HTML** or **Shortcode** widget to your page.
2. Paste the shortcode.
3. Save and preview.

= Examples =

Show 4 posts in 2 columns, no excerpt:

    [prowoos_posts_grid posts="4" columns="2" show_excerpt="no"]

Show posts from "tutorials" category, sorted by title:

    [prowoos_posts_grid category="tutorials" orderby="title" order="ASC"]

Show 12 posts in 4 columns with short excerpts:

    [prowoos_posts_grid posts="12" columns="4" excerpt_length="10"]

== Changelog ==

= 1.0.0 =
* Initial release.
