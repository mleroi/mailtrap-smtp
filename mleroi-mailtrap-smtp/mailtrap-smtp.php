<?php
/*
  Plugin Name: Mleroi Mailtrap SMTP
  Description: Send all WordPress emails using Mailtrap. When activated and Mailtrap credentials set, no real email is sent to users.
  Version: 1.0
  Author: mleroi
 */

/**
 * Set your Mailtrap user and pass here:
 */
define( 'MSMTP_MAILTRAP_USER', '' );
define( 'MSMTP_MAILTRAP_PASS', '' );

add_action( 'phpmailer_init', 'msmtp_mailtrap' );
function msmtp_mailtrap( $phpmailer ) {
	$phpmailer->isSMTP();
	$phpmailer->Host = 'smtp.mailtrap.io';
	$phpmailer->SMTPAuth = true;
	$phpmailer->Port = 2525;
	$phpmailer->Username = MSMTP_MAILTRAP_USER;
	$phpmailer->Password = MSMTP_MAILTRAP_PASS;
}

add_action( 'admin_menu', 'msmtp_add_mailtrap_menu' );
function msmtp_add_mailtrap_menu() {
	add_options_page( 'Mailtrap SMTP', 'Mailtrap SMTP', 'manage_options', 'msmtp_settings', 'msmtp_settings_page' );
}

function msmtp_settings_page() {
	
	$feedback = array();
	
	if ( !empty( $_POST['submit'] ) ) {
	
		$email = isset( $_POST['email'] ) ? sanitize_email( trim( $_POST['email'] ) ) : '';
		
		if ( !empty( $email ) ) {
			$email = sanitize_email( $_POST['email'] );
			$feedback['ok'] = wp_mail( $email, 'Mailtrap SMTP email test from ' . get_option( 'siteurl' ), 'If you see this message, which was sent on '. date('Y-m-d H:i:s') .', Mailtrap SMTP works well :)' );
			$feedback['message'] = $feedback['ok'] ? 'Email sent successfully! Check your Mailtrap account :)' : 'An error occured: email not sent';
		} else {
			$feedback['ok'] = false;
			$feedback['message'] = 'Please provide an email';
		}
	
	}
	
	?>
	<div class="wrap">
		
		<?php if ( !empty( $feedback ) ): ?>
			<div class="<?php echo $feedback['ok'] ? 'updated' : 'error'; ?>">
				<?php echo $feedback['message']; ?>
			</div>
		<?php endif; ?>
		
		<h2>Send test email</h2>
		<form method="post">
			<input type="email" name="email" value="">
			<input type="submit" name="submit" value="Send test email">
		</form>
	</div>
	<?php
}

add_filter( 'plugin_row_meta', 'msmtp_add_settings_link_to_plugin_header', 10, 2 );
function msmtp_add_settings_link_to_plugin_header( $meta, $file ) {
	if ( $file === plugin_basename( __FILE__ ) ) {
		$meta[] = '<a href="options-general.php?page=msmtp_settings">Send test email</a>';
	}
	return $meta;
}
