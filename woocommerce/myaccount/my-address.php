<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters( 'woocommerce_my_account_get_addresses', array(
		'billing' => __( 'Billing Address', 'woocommerce' ),
		'shipping' => __( 'Shipping Address', 'woocommerce' )
	), $customer_id );
} else {
	$get_addresses = apply_filters( 'woocommerce_my_account_get_addresses', array(
		'billing' =>  __( 'Billing Address', 'woocommerce' )
	), $customer_id );
}

$oldcol = 1;
$col    = 1;
?>

<p class="myaccount_address">
	<?php echo apply_filters( 'woocommerce_my_account_my_address_description', __( 'The following addresses will be used on the checkout page by default.', 'woocommerce' ) ); ?>
</p>

<?php if ( ! wc_ship_to_billing_address_only() && get_option( 'woocommerce_calc_shipping' ) !== 'no' ) echo '<div class="row addresses">'; ?>

<div class="row">
	<?php foreach ( $get_addresses as $name => $title ) : ?>

		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 address">
			<header class="title">
				<h3><?php echo $title; ?></h3>
			</header>
			<address>
				<?php
				$address = apply_filters( 'woocommerce_my_account_my_address_formatted_address', array(
					'first_name'     => array(
						'title' => 'First Name',
						'value' => get_user_meta( $customer_id, $name . '_first_name', true )
					),
					'last_name'     => array(
						'title' => 'Last Name',
						'value' => get_user_meta( $customer_id, $name . '_last_name', true )
					),

				), $customer_id, $name );


				if ( ! $address )
					_e( 'You have not set up this type of address yet.', 'woocommerce' );
				else

					$output = '';
				$output .= '<div class="table-responsive">';
				$output .= '<table class="table table-stripped address-table">';
				$output .= '<tbody>';
				foreach($address as $value ) {
					$output .= '<tr><th>'. esc_html( $value['title'] ).'</th><td>'. esc_html( $value['value'] ).'</td></tr>';
				}
				$output .= '</tbody>';
				$output .= '</table>';
				$output .= '</div>';
				echo balanceTags( $output, true );
				?>
			</address>
			<footer>
				<a href="<?php echo wc_get_endpoint_url( 'edit-address', $name ); ?>" class="button edit edit-billing-address"><?php _e( 'Edit', 'woocommerce' ); ?></a>
			</footer>
		</div>

	<?php endforeach; ?>
</div> <!-- row -->
<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) echo '</div>'; ?>
