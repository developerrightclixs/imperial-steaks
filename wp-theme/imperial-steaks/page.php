<?php
/**
 * Single page.
 *
 * When the page is built with Elementor the theme prints nothing of its own -
 * no banner, no title - so Elementor owns the whole canvas. Only non-Elementor
 * pages get the fallback banner.
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
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $built_with_elementor ) : ?>
			<?php the_content(); ?>
		<?php else : ?>
			<div class="section section--onyx">
				<div class="container">
					<div class="entry-content imperial-intro__text"><?php the_content(); ?></div>
				</div>
			</div>
		<?php endif; ?>

	</main>

	<?php
endwhile;

get_footer();
