<?php
/**
 * Template part for displaying single event content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Bronze
 * @version 1.1.0
 */

if ( ! function_exists( 'we_get_event_meta' ) ) {
	return;
}

extract( we_get_event_meta() );
?>
<article <?php bronze_post_attr(); ?>>
	<meta itemprop="name" content="<?php echo esc_attr( $name ); ?>">
	<meta itemprop="url" content="<?php echo esc_url( $permalink ); ?>">
	<?php if ( $thumbnail_url ) : ?>
		<meta itemprop="image" content="<?php echo esc_url( $thumbnail_url ); ?>">
	<?php endif; ?>
	<meta itemprop="description" content="<?php echo esc_attr( $description ); ?>">
	<?php if ( $city || $address || $state || $zipcode ) : ?>
	<span itemprop="location" itemscope itemtype="https://schema.org/<?php echo esc_attr( apply_filters( 'bronze_microdata_event_itemtype_venue', 'MusicVenue' ) ); ?>">
		<span itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
			<?php if ( $city ) : ?>
				<meta itemprop="addressLocality" content="<?php echo esc_attr( $city ); ?>">
			<?php endif; ?>

			<?php if ( $address ) : ?>
				<meta itemprop="streetAddress" content="<?php echo esc_attr( $address ); ?>">
			<?php endif; ?>

			<?php if ( $state ) : ?>
				<meta itemprop="addressRegion" content="<?php echo esc_attr( $state ); ?>">
			<?php endif; ?>

			<?php if ( $zipcode ) : ?>
				<meta itemprop="postalCode" content="<?php echo esc_attr( $zipcode ); ?>">
			<?php endif; ?>
		</span>
		<meta itemprop="name"  content="<?php echo esc_attr( $venue ); ?>">
	</span>
	<?php endif; ?>
		<span itemprop="offers" itemscope="" itemtype="https://schema.org/Offer">
			<?php if ( $ticket_url ) : ?>
		<meta itemprop="url" content="<?php echo esc_url( $ticket_url ); ?>">
		<?php endif; ?>
			<?php if ( $free ) : ?>
				<meta itemprop="price" content="0">
			<?php elseif ( $formatted_price ) : ?>
				<meta itemprop="price" content="<?php echo esc_attr( $formatted_price ); ?>">
			<?php endif; ?>
			<?php if ( apply_filters( 'bronze_event_price_default_currency', $currency ) ) : ?>
				<meta itemprop="priceCurrency" content="<?php echo esc_attr( apply_filters( 'bronze_event_price_default_currency', $currency ) ); ?>">
			<?php endif; ?>
		</span>
	<div class="row">
		<div class="col col-3">
			<div class="event-thumbnail">
				<a class="lightbox" href="<?php echo esc_url( get_the_post_thumbnail_url( '', '%SLUG-XL%' ) ); ?>">
					<?php the_post_thumbnail(); ?>
				</a>
			</div><!-- .event-thumbnail -->
			<?php if ( $artist ) : ?>
				<div class="event-artist">
					<strong><?php echo wp_kses_post( $artist ); ?></strong>
				</div><!-- .event-artist -->
			<?php endif; ?>
			<div class="event-date">
				<?php if ( $raw_start_date ) : ?>
					<strong class="start-date" itemprop="startDate" content="<?php echo esc_attr( $raw_start_date ); ?>">
						<?php echo esc_attr( we_nice_date( $raw_start_date ) ); ?>
					</strong>
				<?php endif; ?>
				<?php if ( $raw_end_date ) : ?>
					&mdash;
					<strong class="end-date" itemprop="endDate" content="<?php echo esc_attr( $raw_end_date ); ?>">
						<?php echo esc_attr( we_nice_date( $raw_end_date ) ); ?>
					</strong>
				<?php endif; ?>
			</div><!-- .event-date -->
			<?php if ( $display_location ) : ?>
				<div class="event-location">
					<strong><?php echo esc_attr( $display_location ); ?></strong>
				</div><!-- .event-location -->
			<?php endif; ?>
			<div class="event-buttons">
				<?php if ( $cancelled ) : ?>
					<strong class="event-status"><?php esc_html_e( 'Cancelled', 'bronze' ); ?></strong>
				<?php elseif ( $soldout ) : ?>
					<strong class="event-status"><?php esc_html_e( 'Sold Out', 'bronze' ); ?></strong>
				<?php elseif ( $free ) : ?>
					<strong class="event-status"><?php esc_html_e( 'Free', 'bronze' ); ?></strong>
				<?php elseif ( $ticket_url ) : ?>
					<a target="_blank" class="<?php echo esc_attr( apply_filters( 'bronze_single_event_buy_ticket_button_class', 'button' ) ); ?>" href="<?php echo esc_url( $ticket_url ); ?>"><span class="fa fa-shopping-cart"></span>
					<?php esc_html_e( 'Buy Ticket', 'bronze' ); ?>
					<?php echo ( $price ) ? ' ' . esc_attr( $price ) : ''; ?>
				</a>
				<?php endif; ?>
				<?php if ( $facebook_url ) : ?>
					<a target="_blank" class="<?php echo esc_attr( apply_filters( 'bronze_single_event_fb_button_class', 'button fb-button' ) ); ?>" href="<?php echo esc_url( $facebook_url ); ?>"><span class="fa5 fa-facebook"></span><?php esc_html_e( 'facebook event', 'bronze' ); ?></a>
				<?php endif; ?>
				<?php if ( $bandsintown_url ) : ?>
					<a target="_blank" class="<?php echo esc_attr( apply_filters( 'bronze_single_event_bit_button_class', 'button single-bit-button' ) ); ?>" href="<?php echo esc_url( $facebook_url ); ?>"><span class="fa wolficon-bandsintown"></span><?php esc_html_e( 'bandsintown event', 'bronze' ); ?></a>
				<?php endif; ?>
			</div>
		</div>
		<div class="col col-9 event-container">
			<?php if ( $map ) : ?>
				<div class="event-map">
					<?php echo bronze_kses( we_get_iframe( $map ) ); ?>
				</div><!-- .event-map -->
			<?php endif; ?>
			<div class="event-details">
				<?php if ( $time && '00:00' !== $time ) : ?>
					<div class="event-time">
						<strong><?php esc_html_e( 'Time', 'bronze' ); ?></strong>: <?php echo esc_attr( $time ); ?>
					</div><!-- .event-time -->
				<?php endif; ?>
				<?php if ( $venue ) : ?>
					<div class="event-venue">
						<strong><?php esc_html_e( 'Venue', 'bronze' ); ?></strong>: <?php echo esc_attr( $venue ); ?>
					</div><!-- .event-venue -->
				<?php endif; ?>
				<?php if ( $address ) : ?>
					<div class="event-address">
						<strong><?php esc_html_e( 'Address', 'bronze' ); ?></strong>: <?php echo esc_attr( $address ); ?>
					</div><!-- .event-address -->
				<?php endif; ?>
				<?php if ( $zipcode ) : ?>
					<div class="event-zipcode">
						<strong><?php esc_html_e( 'Zipcode', 'bronze' ); ?></strong>: <?php echo esc_attr( $zipcode ); ?>
					</div><!-- .event-zipcode -->
				<?php endif; ?>
				<?php if ( $state ) : ?>
					<div class="event-state">
						<strong><?php esc_html_e( 'State', 'bronze' ); ?></strong>: <?php echo esc_attr( $state ); ?>
					</div><!-- .event-state -->
				<?php endif; ?>
				<?php if ( $country ) : ?>
					<div class="event-country">
						<strong><?php esc_html_e( 'Country', 'bronze' ); ?></strong>: <?php echo esc_attr( $country ); ?>
					</div><!-- .event-country -->
				<?php endif; ?>
				<?php if ( $phone ) : ?>
					<div class="event-phone">
						<strong><?php esc_html_e( 'Phone', 'bronze' ); ?></strong>: <?php echo esc_attr( $phone ); ?>
					</div><!-- .event-phone -->
				<?php endif; ?>
				<?php if ( $email ) : ?>
					<div class="event-email">
						<strong><?php esc_html_e( 'Email', 'bronze' ); ?></strong>: <a href="mailto:<?php echo esc_attr( sanitize_email( $email ) ); ?>"><?php echo esc_attr( sanitize_email( $email ) ); ?></a>
					</div><!-- .event-email -->
				<?php endif; ?>
				<?php if ( $website ) : ?>
					<div class="event-website">
						<strong><?php esc_html_e( 'Website', 'bronze' ); ?></strong>: <a href="<?php echo esc_url( $website ); ?>" target="_blank"><?php echo esc_url( $website ); ?></a>
					</div><!-- .event-website -->
				<?php endif; ?>
			</div><!-- .event-details -->
			<div class="event-content">
				<?php the_content(); ?>
			</div><!-- .event-content -->
			<?php
				/**
				 * Share buttons
				 */
				do_action( 'bronze_share' );
			?>
		</div>
	</div>
</article><!-- #post-## -->
