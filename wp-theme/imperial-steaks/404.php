<?php
/**
 * 404.
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
		<h1 class="imperial-banner__title"><?php esc_html_e( 'Page not found', 'imperial-steaks' ); ?></h1>
		<p class="imperial-banner__subtitle"><?php esc_html_e( 'Error 404', 'imperial-steaks' ); ?></p>
	</div>
</section>

<main id="main" class="section section--onyx">
	<div class="container container--narrow text-center">
		<p><?php esc_html_e( 'That page does not exist. It may have been moved or renamed.', 'imperial-steaks' ); ?></p>
		<div class="btn-row u-mt-md">
			<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php esc_html_e( 'Back to home', 'imperial-steaks' ); ?>
			</a>
		</div>
	</div>
</main>

<?php
get_footer();
