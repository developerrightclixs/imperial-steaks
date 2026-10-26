<?php
/**
 * Search results.
 *
 * @package ImperialSteaks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<section class="imperial-banner">
	<div class="container">
		<h1 class="imperial-banner__title">
			<?php
			printf(
				/* translators: %s: search query */
				esc_html__( 'Search: %s', 'imperial-steaks' ),
				esc_html( get_search_query() )
			);
			?>
		</h1>
	</div>
</section>

<main id="main" class="section section--onyx">
	<div class="container">
		<?php if ( have_posts() ) : ?>
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
			<p><?php esc_html_e( 'No results. Try a different search.', 'imperial-steaks' ); ?></p>
			<div class="u-mt-md"><?php get_search_form(); ?></div>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
