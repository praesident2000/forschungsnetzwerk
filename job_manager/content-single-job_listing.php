<?php
/**
 * The template for displaying the WP Job Manager listing details on single listing pages
 *
 * @package Listable
 */

global $post;

$taxonomies = array();
$data_output = '';
$terms = get_the_terms(get_the_ID(), 'job_listing_type');
$termString = '';
if ( ! is_wp_error( $terms ) && ( is_array( $terms ) || is_object( $terms ) ) ) {
	$firstTerm = $terms[0];
	if ( ! $firstTerm == NULL ) {
		$term_id = $firstTerm->term_id;

		$data_output .= 'data-icon="' . listable_get_term_icon_url($term_id) .'"';
		$count = 1;
		foreach ( $terms as $term ) {
			$termString .= $term->name;
			if ( $count != count($terms) ) {
				$termString .= ', ';
			}
			$count++;
		}
	}
}

$listing_is_claimed  = get_post_meta( $post->ID, '_claimed', true );?>
<div class="title-container">
	<div class="title-wrapper">
		<div class="title-link-wrapper"><a class="return-link" href="https://forschungsnetzwerk-diabetes.info/forschungskarte/">Alle Projekte</a></div>
		<h1 class="entry-title" itemprop="name"><?php
			echo get_the_title();
			if ( $listing_is_claimed === '1' && function_exists('wpjmcl_init')) {
				echo '<span class="listing-claimed-icon">';
				get_template_part('assets/svg/checked-icon');
				echo '<span>';
			}
		?></h1>
	</div>
</div>
<div class="single_job_listing"
	data-latitude="<?php echo get_post_meta($post->ID, 'geolocation_lat', true); ?>"
	data-longitude="<?php echo get_post_meta($post->ID, 'geolocation_long', true); ?>"
	data-categories="<?php echo $termString; ?>"
	<?php echo $data_output; ?>>

	<?php if ( get_option( 'job_manager_hide_expired_content', 1 ) && 'expired' === $post->post_status ) : ?>
		<div class="job-manager-info"><?php esc_html_e( 'This listing has expired.', 'listable' ); ?></div>
	<?php else : ?>

		<div class="grid">
			<div class="grid__item  column-content  entry-content">
				<header class="entry-header">
					<?php /* removed breadcrumb */ ?>

					<?php
					the_company_tagline( '<span class="entry-subtitle" itemprop="description">', '</span>' );

					/**
					 * single_job_listing_start hook
					 *
					 * @hooked job_listing_meta_display - 20
					 * @hooked job_listing_company_display - 30
					 */
					do_action( 'single_job_listing_start' ); ?>
				</header><!-- .entry-header -->
				<?php if ( is_active_sidebar( 'listing_content' ) ) : ?>
					<div class="listing-sidebar  listing-sidebar--main">
						<div class="project-meta">
							<div class="row">
								<div class="column">
									<div class="project-meta-headline">
										<h2>Projektförderung</h2>
									</div>
									<div class="project-meta-content">
										<p><?php echo get_post_meta($post->ID, '_project_sponsorship', true); ?></p>
									</div>
								</div>
								<div class="column">
									<div class="project-meta-headline">
										<h2>Zeitraum</h2>
									</div>
									<div class="project-meta-content">
										<?php
											$dateStart = new DateTime(get_post_meta($post->ID, '_project_start', true));
											$dateEnd = new DateTime(get_post_meta($post->ID, '_project_end', true));
										?>
										<p><?php echo $dateStart->format('Y'); ?> bis <?php echo $dateEnd->format('Y'); ?></p>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="column">
									<div class="project-meta-headline">
										<h2>Themengebiete</h2>
									</div>
									<div class="project-meta-content">
										<p><?php echo get_post_meta($post->ID, '_project_area_of_research', true); ?></p>
									</div>
								</div>
								<div class="column">
									<div class="project-meta-headline">
										<h2>Forschungsschwerpunkt</h2>
									</div>
									<div class="project-meta-content">
										<p><?php echo get_post_meta($post->ID, '_project_main_research', true); ?></p>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="column">
									<div class="project-meta-headline">
										<h2>biologische Methoden / Modelle</h2>
									</div>
									<div class="project-meta-content">
										<p><?php echo get_post_meta($post->ID, '_project_research_method', true); ?></p>
									</div>
								</div>
								<div class="column">
									<div class="project-meta-headline">
										<h2>Tiermodelle</h2>
									</div>
									<div class="project-meta-content">
										<p><?php echo get_post_meta($post->ID, '_project_animal_model', true); ?></p>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="column">
									<div class="project-meta-headline">
										<h2>Humane Proben</h2>
									</div>
									<div class="project-meta-content">
										<p><?php echo get_post_meta($post->ID, '_project_human_specimen', true); ?></p>
									</div>
								</div>
							</div>
						</div>
						<?php dynamic_sidebar('listing_content'); ?>
					</div>
				<?php endif; ?>
			</div> <!-- / .column-1 -->

			<div class="grid__item  column-sidebar">
				<?php if ( is_active_sidebar( 'listing__sticky_sidebar' ) ) : ?>
					<div class="listing-sidebar  listing-sidebar--top  listing-sidebar--secondary">
						<div class="project-meta-headline">
							<h2>Kontakt</h2>
						</div>
						<div class="project-meta-content">
							<?php if ( !empty(get_post_meta($post->ID, '_project_institution_img', true)) ) : ?>
								<div class="project-institution-img">
									<img src="<?php echo get_post_meta($post->ID, '_project_institution_img', true); ?>" alt="Institutions Logo">
								</div>
							<?php endif; ?>
							<div class="project-institution">
								<p><strong><?php echo get_post_meta($post->ID, '_project_institution', true); ?></strong></p>
							</div>
							<div class="project-location">
								<p><?php echo get_post_meta($post->ID, '_job_location', true); ?></p>
							</div>
							<div class="project-website">
								<p><a href="<?php echo get_post_meta($post->ID, '_project_website', true); ?>" target="_blank"><?php echo trim(str_replace('http://', '', get_post_meta($post->ID, '_project_website', true)),'/'); ?></a></p>
							</div>
							<div class="project-contact">
								<p><strong>Ansprechpartner</strong></p>
								<?php if ( !empty(get_post_meta($post->ID, '_project_contact_person_img', true)) ) : ?>
									<div class="project-contact-img">
										<img src="<?php echo get_post_meta($post->ID, '_project_contact_person_img', true); ?>" alt="Profilbild">
									</div>
								<?php endif; ?>
								<p><?php echo get_post_meta($post->ID, '_project_contact_person', true); ?></p>
							</div>
							<div class="project-contact-details">
								<p><strong>M </strong>
									<?php if ( !empty(get_post_meta($post->ID, '_project_email', true)) ) : ?>
										<a href="mailto:<?php echo eae_encode_str(get_post_meta($post->ID, '_project_email', true)); ?>"><?php echo eae_encode_str(get_post_meta($post->ID, '_project_email', true)); ?></a></p>
									<?php endif; ?>
								<p><strong>T </strong><?php echo get_post_meta($post->ID, '_project_telephone', true); ?></p>
							</div>
						</div>
						<?php dynamic_sidebar('listing__sticky_sidebar');	?>
					</div>
				<?php endif;

				if ( is_active_sidebar( 'listing_sidebar' ) ) : ?>
					<div class="listing-sidebar  listing-sidebar--bottom  listing-sidebar--secondary"><?php
						dynamic_sidebar('listing_sidebar');
					?></div>
				<?php endif; ?>

			</div><!-- / .column-2 -->
		</div>
	<?php endif; ?>
</div>
<div class="social-share">
	<span>Teilen</span>
	<?php echo '<span><a class="social_link" href="https://twitter.com/home?status='. get_permalink() .'" target="_blank">Twitter</a></span></li>';?>
	<?php echo '<span><a class="social_link" href="https://www.xing.com/app/user?op=share;url='. get_permalink() .'" target="_blank">Xing</a></span></li>';?>
	<?php echo '<span><a class="social_link" href="https://www.linkedin.com/shareArticle?mini=true&url='. get_permalink() .'" target="_blank">LinkedIn</a></span></li>';?>
	<?php echo '<span><a class="social_link" href="mailto:?subject=Projekt in der Diabetesforschung: '. get_the_title() .'&body=' . get_permalink() .'"" target="_blank">eMail</a></span></li>';?>
</div>
<div class="related-projects">
	<?php $state = get_post_meta($post->ID, 'geolocation_state_long'); ?>
	<?php
		$args = array(
			'title' => 'Weitere Forschungsprojekte in ' . $state[0],
			'subtitle'        => '',
			'number_of_items' => '100',
			'show'            => 'all',
			'orderby'         => 'rand',
			'items_ids'       => '',
			'categories_slug' => ''
		)
	?>
	<?php the_widget( 'Front_Page_Listing_Cards_Widget', $args); ?>
</div>
