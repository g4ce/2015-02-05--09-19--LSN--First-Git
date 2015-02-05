<?php
/**
 * GeoIP wrapper class
 *
 * @package   Woocommerce Multi Currency Store
 * @author    Code Ninjas 
 * @link      http://codeninjas.co
 * @copyright 2014 Code Ninjas
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
require_once 'lib/GeoIp2/vendor/autoload.php';
use GeoIp2\Database\Reader;
  
class WMCS_GeoIp {

	public function __construct()
	{
		
	}
	
	public function get_country( $ip_address = FALSE ){
	
		if( !$ip_address ) return FALSE;
		
		$reader = new Reader(WMCS_DIR.'includes/lib/GeoLite2-Country.mmdb');
		
		$record = $reader->country($ip_address);
		$country_code = $record->country->isoCode;
		$reader->close();
		
		return $country_code;

	}
	
}