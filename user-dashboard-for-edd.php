<?php
/**
 * Plugin Name: User Dashboard - Easy Digital Downloads
 * Plugin URI: https://neatma.com
 * Description: Simple and light weight plugin to add an <strong> Customer Dashboard Page</strong> to easy digital downloads plugin. Use this shortcode on a page <code>[edd-dash]</code>
 * Version: 1.0.2
 * Author: Amin Nazemi
 * Author URI: https://neatma.com
 * Text Domain: edd-dash
 * Domain Path: /languages/
 *
 */


define('EDDUSERDASH_URL', plugin_dir_url( __FILE__ ));

 
function edd_user_dash_load_textdomain() {
    load_plugin_textdomain( 'edd-dash', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}

add_action( 'init', 'edd_user_dash_load_textdomain' );

function edd_user_dash_enqueue_styles() {
	
	global $post;
	if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'edd-dash') ) {
		wp_enqueue_style( 'edd-dash-main', EDDUSERDASH_URL . 'assets/css/style.css' );
		wp_enqueue_script( 'edd-dash-min', EDDUSERDASH_URL . 'assets/js/main.js' );
	}
}

add_action( 'wp_enqueue_scripts', 'edd_user_dash_enqueue_styles' );

function edd_user_dash_block() {
  wp_enqueue_script(
    'edd_user_dash',
    plugin_dir_url(__FILE__) . 'build/index.js',
    array('wp-blocks','wp-editor'),
    true
  );
}
   
add_action('enqueue_block_editor_assets', 'edd_user_dash_block');



function edd_user_dash_shortcode(){
	$payments = edd_get_users_purchases( get_current_user_id(), 20, true, 'any' );
    global $current_user;
    $user_id = empty( $user_id ) ? get_current_user_id() : $user_id;

	if ( is_user_logged_in() ) : ob_start(); ?>
	<div class="edd-user-dashboard">
	<div class="extended__dasboard__tab__menu">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#profile" data-toggle="tab"> <?php esc_html_e('Profile','edd-dash'); ?></a></li>
			<li><a href="#purchase" data-toggle="tab"> <?php esc_html_e('Purchases','edd-dash'); ?></a></li>
			<li><a href="#download" data-toggle="tab"> <?php esc_html_e('Downloads','edd-dash'); ?></a></li>
			<?php if( class_exists( 'EDD_Software_Licensing' ) ) : ?>
			<li><a href="#license" data-toggle="tab"> <?php esc_html_e('Licenses','edd-dash'); ?></a></li>
			<?php endif; ?>
			<?php if( class_exists( 'EDD_All_Access' ) ) : ?>
			<li><a href="#access-pass" data-toggle="tab"> <?php esc_html_e('Access Pass','edd-dash'); ?></a></li>
			<?php endif; ?>
			<?php if( class_exists( 'EDD_Recurring' ) ) : ?>
			<li><a href="#subscription" data-toggle="tab"> <?php esc_html_e('Subscription','edd-dash'); ?></a></li>
			<?php endif; ?>
			<?php if( class_exists( 'Support_Candy' ) ) : ?>
			<li><a href="#support" data-toggle="tab"> <?php esc_html_e('Support','edd-dash'); ?></a></li>
			<?php endif; ?>
			<li><a href="<?php echo wp_logout_url(home_url('/')) ?>" class="account__logout"><img src="<?php echo EDDUSERDASH_URL . '/assets/img/logout.svg' ?>"></img> <?php esc_html_e( 'Logout', 'edd-dash' ); ?></a></li>
		</ul>
		

	</div>
	<?php endif; ?>

	<div class="extended__dashboard__tab__content">
		<div class="tab-content user__dasboard__box clearfix">
			<div class="tab-pane active" id="profile">
				<?php echo do_shortcode('[edd_profile_editor]'); ?>
			</div>

			<div class="tab-pane" id="purchase">
				<?php echo do_shortcode('[purchase_history]');?>
			</div>

			<div class="tab-pane" id="download">
				<?php echo do_shortcode('[download_history]');?>
			</div>

			<?php if( class_exists( 'EDD_Software_Licensing' ) ) : ?>
			<div class="tab-pane" id="license">
				<?php echo do_shortcode('[edd_license_keys]'); ?>
			</div>
			<?php endif; ?>

			<?php if( class_exists( 'EDD_All_Access' ) ) : ?>
			<div class="tab-pane" id="access-pass">
				<?php echo do_shortcode('[edd_aa_customer_passes]'); ?>
			</div>
			<?php endif; ?>

			<?php if( class_exists( 'EDD_Recurring' ) ) : ?>
			<div class="tab-pane" id="subscription">
				<?php echo do_shortcode('[edd_subscriptions]'); ?>
			</div>
			<?php endif; ?>

			<?php if( class_exists( 'Support_Candy' ) ) : ?>
			<div class="tab-pane" id="support">
				<?php if( !$payments ): ?>
						<div class="entry-content clear" itemprop="text">
						<h4>It seems that you have not made any purchase yet!</h4>
						<span>Please purchase valid license of our product from <a href="#">here</a>.</span>
						</div>
				<?php else: ?>
						<?php echo do_shortcode('[supportcandy]'); ?>
				<?php endif; ?>		
			</div>				
			<?php endif; ?>
		</div>
	</div>
	</div>
<?php 
return ob_get_clean();
}

add_shortcode( 'edd-dash', 'edd_user_dash_shortcode' );



