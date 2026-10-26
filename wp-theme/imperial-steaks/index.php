<?php
/**
 * Fallback template - used for the blog index and anything with no more
 * specific template. Intentionally plain; Elementor handles real page layout.
 *
 * @package ImperialSteaks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main" class="section section--onyx">
	<div class="container">

		<?php if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<div class="section__head">
					<h1 class="section__title"><?php single_post_title(); ?></h1>
					<hr class="imperial-rule imperial-rule--center">
				</div>
			<?php endif; ?>

			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'imperial-product-row' ); ?>>
					<h2 class="imperial-product-row__title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h2>
					<hr class="imperial-rule">
					<div class="imperial-product-row__text"><?php the_excerpt(); ?></div>
				</article>
			<?php endwhile; ?>

			<?php the_posts_pagination( array( 'class' => 'u-mt-lg' ) ); ?>

		<?php else : ?>
			<p><?php esc_html_e( 'Nothing found.', 'imperial-steaks' ); ?></p>
		<?php endif; ?>

	</div>
</main>

<?php
get_footer();
