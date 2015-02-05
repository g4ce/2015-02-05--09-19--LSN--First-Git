<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<body>
<?php $msg = gtfc(); ?>
<form>
	<input type="text"></input>
	<input type="hidden" id="hidden-118" name="hidden-118" value="do kitu"></input>

</form>

<script type="text/javascript">
	
	jQuery(document).ready(function($) {
    $('#hidden-118').val('<?php echo $msg; ?>');
});

</script>
	
<?php 
function gtfc(){

  $msg ='<table style="text-align: left; width: 100%;" border="0" cellpadding="2"
cellspacing="2">
<tbody>
<tr>
<td style="vertical-align: top;">Product name<br>
</td>
<td style="vertical-align: top;">Product SKU<br>
</td>
<td style="vertical-align: top;">Qty<br>
</td>
<td style="vertical-align: top;">Price<br>
</td>
</tr>';
  global WC();
  if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>

    <?php
      foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
        $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

          $product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
          $product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
          $product_sku = $_product->sku;

          ?>
          <?php $msg .= '<tr>';?>
          <?php if ( $_product->is_visible() ) { ?>

              <?php $msg .= '<td style="vertical-align: top;">' . $product_name . '</td><td style="vertical-align: top;">'. $product_sku .'</td><td style="vertical-align: top;">'. $cart_item['quantity'] .'</td><td style="vertical-align: top;">'. $product_price .'</td></tr>';?>

          <?php } ?>
            <?php echo WC()->cart->get_item_data( $cart_item ); ?>

          <?php
        }
      }
    ?>
    <?php $price_total = WC()->cart->get_cart_subtotal(); ?>
    <?php $msg .= '<tr>
<td style="vertical-align: top;">
</td>
<td style="vertical-align: top;">
</td>
<td style="vertical-align: top;">Total
</td>
<td style="vertical-align: top;">' . $price_total .'
</td>
</tr>
</tbody>
</table>';

    echo $msg; ?>

    <?php endif; ?>


<?php
//$msg = wordwrap($msg, 70, "\r\n");
return $msg;

}
?>

</body>
</html>