<?php
/**
 * Single post.
 *
 * @package ImperialSteaks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	$built_with_elementor = imperial_steaks_built_with_elementor();
	?>

	<main id="main">

		<?php if ( ! $built_with_elementor ) : ?>
			<section class="imperial-banner">
				<div class="container">
					<h1 class="imperial-banner__title"><?php the_title(); ?></h1>
					<p class="imperial-banner__subtitle"><?php echo esc_html( get_the_date() ); ?></p>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $built_with_elementor ) : ?>
			<?php the_content(); ?>
		<?php else : ?>
			<div class="section section--onyx">
				<div class="container">
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-content imperial-intro__text' ); ?>>
						<?php the_content(); ?>
					</article>
					<?php
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
					?>
				</div>
			</div>
		<?php endif; ?>

	</main>

	<?php
endwhile;

get_footer();
