<?php
/**
 * Plugin Name: ProWoos Posts Grid
 * Description: A lightweight shortcode plugin that displays WordPress posts in a responsive card grid with featured images, titles, excerpts, and dates.
 * Version:     1.0.0
 * Author:      Rafael Minuesa
 * Author URI:  https://prowoos.com
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: prowoos-posts-grid
 * Requires at least: 5.6
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the [prowoos_posts_grid] shortcode.
 */
function prowoos_posts_grid_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'posts'          => 6,
			'columns'        => 3,
			'columns_tablet' => 2,
			'category'       => '',
			'excerpt_length' => 20,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'offset'         => 0,
			'show_date'      => 'yes',
			'show_excerpt'   => 'yes',
			'show_readmore'  => 'yes',
			'readmore_text'  => 'Read More &rarr;',
		),
		$atts,
		'prowoos_posts_grid'
	);

	$query_args = array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => absint( $atts['posts'] ),
		'orderby'        => sanitize_key( $atts['orderby'] ),
		'order'          => in_array( strtoupper( $atts['order'] ), array( 'ASC', 'DESC' ), true ) ? strtoupper( $atts['order'] ) : 'DESC',
		'offset'         => absint( $atts['offset'] ),
	);

	if ( ! empty( $atts['category'] ) ) {
		$query_args['category_name'] = sanitize_text_field( $atts['category'] );
	}

	$query   = new WP_Query( $query_args );
	$columns = absint( $atts['columns'] );
	$tablet  = absint( $atts['columns_tablet'] );

	if ( ! $query->have_posts() ) {
		return '<p>' . esc_html__( 'No posts found.', 'prowoos-posts-grid' ) . '</p>';
	}

	prowoos_posts_grid_enqueue_styles();

	ob_start();
	?>
	<div class="pwpg-grid" style="--pwpg-cols: <?php echo esc_attr( $columns ); ?>; --pwpg-cols-tablet: <?php echo esc_attr( $tablet ); ?>;">
		<?php
		while ( $query->have_posts() ) :
			$query->the_post();
			?>
			<article class="pwpg-card">
				<?php if ( has_post_thumbnail() ) : ?>
					<a href="<?php the_permalink(); ?>" class="pwpg-card-image" aria-hidden="true" tabindex="-1">
						<?php the_post_thumbnail( 'medium_large' ); ?>
					</a>
				<?php endif; ?>

				<div class="pwpg-card-body">
					<?php if ( 'yes' === $atts['show_date'] ) : ?>
						<time class="pwpg-card-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
							<?php echo esc_html( get_the_date() ); ?>
						</time>
					<?php endif; ?>

					<h3 class="pwpg-card-title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h3>

					<?php if ( 'yes' === $atts['show_excerpt'] ) : ?>
						<p class="pwpg-card-excerpt">
							<?php echo esc_html( wp_trim_words( get_the_excerpt(), absint( $atts['excerpt_length'] ), '&hellip;' ) ); ?>
						</p>
					<?php endif; ?>

					<?php if ( 'yes' === $atts['show_readmore'] ) : ?>
						<a href="<?php the_permalink(); ?>" class="pwpg-card-readmore">
							<?php echo wp_kses_post( $atts['readmore_text'] ); ?>
						</a>
					<?php endif; ?>
				</div>
			</article>
		<?php endwhile; ?>
	</div>
	<?php
	wp_reset_postdata();

	return ob_get_clean();
}
add_shortcode( 'prowoos_posts_grid', 'prowoos_posts_grid_shortcode' );

/**
 * Enqueue front-end styles when the shortcode is rendered.
 *
 * We enqueue inside the shortcode callback instead of wp_enqueue_scripts
 * because Elementor stores shortcodes in post meta, not post_content,
 * so has_shortcode() won't detect it.
 */
function prowoos_posts_grid_enqueue_styles() {
	wp_enqueue_style(
		'prowoos-posts-grid',
		plugin_dir_url( __FILE__ ) . 'style.css',
		array(),
		'1.0.0'
	);
}
