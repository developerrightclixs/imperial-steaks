<?php
/**
 * Archive template.
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
		<h1 class="imperial-banner__title"><?php the_archive_title(); ?></h1>
		<?php if ( get_the_archive_description() ) : ?>
			<p class="imperial-banner__subtitle"><?php echo wp_kses_post( get_the_archive_description() ); ?></p>
		<?php endif; ?>
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
			<p><?php esc_html_e( 'Nothing found.', 'imperial-steaks' ); ?></p>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
