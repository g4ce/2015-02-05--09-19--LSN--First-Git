<?php

class WMCS_WC_Price{

	var $captured_price = NULL;
	var $currency = NULL;

	public function __construct( $currency = '' )
	{		
		$this->currency = $currency;
		
		/**
		 * Woo outputs order prices and totals in the store base currency rather than the order currency!!!
		 * So we'll have to filter the output for order only.
		 * The price output is the actual price at the time of purchase in the customer currency with the correct formatting and decimal places,
		 * so we just need to output the currency symbol
		 *
		 * Also by the time the price comes to us, its already been formatted to the stores decimal places and separators
		 * so we will attempt to capture the price before any formatting (using raw_woocommerce_price) and then when our filter is run, we will use this captured price
		 */
		//add_filter( 'raw_woocommerce_price', array( $this, 'filter_raw_woocommerce_price' ) );
		//add_filter( 'wc_price', array( $this, 'filter_wc_price' ), 10, 3 );
		
	}
	
	public function filter_raw_woocommerce_price( $price ){
		$this->captured_price = $price;
		return $price;
	}
	
	public function filter_wc_price( $return, $price, $args ){
	
		if( !$price ) return $return;
		
		if( $this->captured_price ) $price = $this->captured_price;
		else $price = $price;
	
		if( isset( $args['currency'] ) ) $customers_currency = $args['currency'];
		elseif( $this->currency ) $customers_currency = $this->currency;
		else $customers_currency = wmcs_get_customers_currency();
		
		if( !$customers_currency ) return $return;
		
		$store_currencies = get_option( 'wmcs_store_currencies', array() );
		if( !array_key_exists( $customers_currency, $store_currencies ) ) return $return;
		
		$currency_symbol = get_woocommerce_currency_symbol( $customers_currency );
		$decimal_places = $store_currencies[$customers_currency]['decimal_places'];
		$decimal_sep = $store_currencies[$customers_currency]['decimal_separator'];
		$thousand_sep = $store_currencies[$customers_currency]['thousand_separator'];
		$currency_position = $store_currencies[$customers_currency]['position'];
		$rounding_precision = (int)$store_currencies[$customers_currency]['rounding_to'];
		
		$price = str_replace( ',', '', $price ); //price is already formatted by wc_price and may contain a ',' so remove it
		
		//rounding
		if( $store_currencies[$customers_currency]['rounding_type'] != 'none' ){
			if( $store_currencies[$customers_currency]['rounding_type'] == 'up' )	$price = round( $price, $rounding_precision, PHP_ROUND_HALF_UP );
			else $price = round( $price, $rounding_precision, PHP_ROUND_HALF_DOWN );
		}
		
		//formatting
		$price = number_format( $price, $decimal_places, $decimal_sep, $thousand_sep );
		
		//symbol position
		switch( $currency_position ){
			case 'right':
				$price = $price.$currency_symbol;
				break;
			case 'left_space':
				$price = $currency_symbol.' '.$price;
				break;
			case 'right_space':
				$price = $price.' '.$currency_symbol;
				break;
			case 'left':
			default:
				$price = $currency_symbol.$price;
				break;
		}
	
		$this->captured_price = NULL; //reset it just incase!
		return $price;
	
	}

}


function wmcs_log( $message, $log_type = 'error' ){
	
	$path = WMCS_DIR.'logs/'.$log_type.'.log';
	
	$fp = fopen( $path, 'a+' );
	fwrite( $fp, date('Y-m-d H:i:s') . ' | ' . $message . PHP_EOL );
	fclose( $fp );

}

/**
 * Get the customers currency based on their country (from their IP address)
 *
 * @since     1.0.0
 */
function wmcs_get_customers_currency(){
	
	$currency = isset($_SESSION['wmcs_currency']) ? $_SESSION['wmcs_currency'] : FALSE;
	
	if( !$currency ){
	
		//try local geoip db
		try{
			include 'class-wmcs-geoip.php';
			$geoip = new WMCS_GeoIp();
			$country_code = $geoip->get_country( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'] );
			//$country_code = $geoip->get_country('112.5.20.132');
			
			$country_currency_mapping = wmcs_country_currency_mapping();
			if( array_key_exists( $country_code, $country_currency_mapping ) ){
				$currency = $country_currency_mapping[$country_code];
				$_SESSION['wmcs_currency'] = $currency;
			}
			
		} catch(Exception $e){
			wmcs_log( $e->getMessage(), 'geoip' );
		}
		
	}
	
	return $currency;
	
}

function wmcs_convert_price( $price, $currency = '' ){

	if( !$currency )
		$currency = wmcs_get_customers_currency();
		
	$exchange_rate = WMCS_Exchange_Api::get_rate( $currency );
	
	if( !$exchange_rate || $currency == get_option('woocommerce_currency') ) return $price;
	
	return $price * $exchange_rate;
	
}

function wmcs_country_currency_mapping(){
		
	return array(
		'NZ' => 'NZD',
		'CK' => 'NZD',
		'NU' => 'NZD',
		'PN' => 'NZD',
		'TK' => 'NZD',
		'AU' => 'AUD',
		'CX' => 'AUD',
		'CC' => 'AUD',
		'HM' => 'AUD',
		'KI' => 'AUD',
		'NR' => 'AUD',
		'NF' => 'AUD',
		'TV' => 'AUD',
		'AS' => 'EUR',
		'AD' => 'EUR',
		'AT' => 'EUR',
		'BE' => 'EUR',
		'FI' => 'EUR',
		'FR' => 'EUR',
		'GF' => 'EUR',
		'TF' => 'EUR',
		'DE' => 'EUR',
		'GR' => 'EUR',
		'GP' => 'EUR',
		'IE' => 'EUR',
		'IT' => 'EUR',
		'LU' => 'EUR',
		'MQ' => 'EUR',
		'YT' => 'EUR',
		'MC' => 'EUR',
		'NL' => 'EUR',
		'PT' => 'EUR',
		'RE' => 'EUR',
		'WS' => 'EUR',
		'SM' => 'EUR',
		'SI' => 'EUR',
		'ES' => 'EUR',
		'VA' => 'EUR',
		'GS' => 'GBP',
		'GB' => 'GBP',
		'JE' => 'GBP',
		'IO' => 'USD',
		'GU' => 'USD',
		'MH' => 'USD',
		'FM' => 'USD',
		'MP' => 'USD',
		'PW' => 'USD',
		'PR' => 'USD',
		'TC' => 'USD',
		'US' => 'USD',
		'UM' => 'USD',
		'VG' => 'USD',
		'VI' => 'USD',
		'HK' => 'HKD',
		'CA' => 'CAD',
		'JP' => 'JPY',
		'AF' => 'AFN',
		'AL' => 'ALL',
		'DZ' => 'DZD',
		'AI' => 'XCD',
		'AG' => 'XCD',
		'DM' => 'XCD',
		'GD' => 'XCD',
		'MS' => 'XCD',
		'KN' => 'XCD',
		'LC' => 'XCD',
		'VC' => 'XCD',
		'AR' => 'ARS',
		'AM' => 'AMD',
		'AW' => 'ANG',
		'AN' => 'ANG',
		'AZ' => 'AZN',
		'BS' => 'BSD',
		'BH' => 'BHD',
		'BD' => 'BDT',
		'BB' => 'BBD',
		'BY' => 'BYR',
		'BZ' => 'BZD',
		'BJ' => 'XOF',
		'BF' => 'XOF',
		'GW' => 'XOF',
		'CI' => 'XOF',
		'ML' => 'XOF',
		'NE' => 'XOF',
		'SN' => 'XOF',
		'TG' => 'XOF',
		'BM' => 'BMD',
		'BT' => 'INR',
		'IN' => 'INR',
		'BO' => 'BOB',
		'BW' => 'BWP',
		'BV' => 'NOK',
		'NO' => 'NOK',
		'SJ' => 'NOK',
		'BR' => 'BRL',
		'BN' => 'BND',
		'BG' => 'BGN',
		'BI' => 'BIF',
		'KH' => 'KHR',
		'CM' => 'XAF',
		'CF' => 'XAF',
		'TD' => 'XAF',
		'CG' => 'XAF',
		'GQ' => 'XAF',
		'GA' => 'XAF',
		'CV' => 'CVE',
		'KY' => 'KYD',
		'CL' => 'CLP',
		'CN' => 'CNY',
		'CO' => 'COP',
		'KM' => 'KMF',
		'CD' => 'CDF',
		'CR' => 'CRC',
		'HR' => 'HRK',
		'CU' => 'CUP',
		'CY' => 'CYP',
		'CZ' => 'CZK',
		'DK' => 'DKK',
		'FO' => 'DKK',
		'GL' => 'DKK',
		'DJ' => 'DJF',
		'DO' => 'DOP',
		'TP' => 'IDR',
		'ID' => 'IDR',
		'EC' => 'ECS',
		'EG' => 'EGP',
		'SV' => 'SVC',
		'ER' => 'ETB',
		'ET' => 'ETB',
		'EE' => 'EEK',
		'FK' => 'FKP',
		'FJ' => 'FJD',
		'PF' => 'XPF',
		'NC' => 'XPF',
		'WF' => 'XPF',
		'GM' => 'GMD',
		'GE' => 'GEL',
		'GI' => 'GIP',
		'GT' => 'GTQ',
		'GN' => 'GNF',
		'GY' => 'GYD',
		'HT' => 'HTG',
		'HN' => 'HNL',
		'HU' => 'HUF',
		'IS' => 'ISK',
		'IR' => 'IRR',
		'IQ' => 'IQD',
		'IL' => 'ILS',
		'JM' => 'JMD',
		'JO' => 'JOD',
		'KZ' => 'KZT',
		'KE' => 'KES',
		'KP' => 'KPW',
		'KR' => 'KRW',
		'KW' => 'KWD',
		'KG' => 'KGS',
		'LA' => 'LAK',
		'LV' => 'LVL',
		'LB' => 'LBP',
		'LS' => 'LSL',
		'LR' => 'LRD',
		'LY' => 'LYD',
		'LI' => 'CHF',
		'CH' => 'CHF',
		'LT' => 'LTL',
		'MO' => 'MOP',
		'MK' => 'MKD',
		'MG' => 'MGA',
		'MW' => 'MWK',
		'MY' => 'MYR',
		'MV' => 'MVR',
		'MT' => 'MTL',
		'MR' => 'MRO',
		'MU' => 'MUR',
		'MX' => 'MXN',
		'MD' => 'MDL',
		'MN' => 'MNT',
		'MA' => 'MAD',
		'EH' => 'MAD',
		'MZ' => 'MZN',
		'MM' => 'MMK',
		'NA' => 'NAD',
		'NP' => 'NPR',
		'NI' => 'NIO',
		'NG' => 'NGN',
		'OM' => 'OMR',
		'PK' => 'PKR',
		'PA' => 'PAB',
		'PG' => 'PGK',
		'PY' => 'PYG',
		'PE' => 'PEN',
		'PH' => 'PHP',
		'PL' => 'PLN',
		'QA' => 'QAR',
		'RO' => 'RON',
		'RU' => 'RUB',
		'RW' => 'RWF',
		'ST' => 'STD',
		'SA' => 'SAR',
		'SC' => 'SCR',
		'SL' => 'SLL',
		'SG' => 'SGD',
		'SK' => 'SKK',
		'SB' => 'SBD',
		'SO' => 'SOS',
		'ZA' => 'ZAR',
		'LK' => 'LKR',
		'SD' => 'SDG',
		'SR' => 'SRD',
		'SZ' => 'SZL',
		'SE' => 'SEK',
		'SY' => 'SYP',
		'TW' => 'TWD',
		'TJ' => 'TJS',
		'TZ' => 'TZS',
		'TH' => 'THB',
		'TO' => 'TOP',
		'TT' => 'TTD',
		'TN' => 'TND',
		'TR' => 'TRY',
		'TM' => 'TMT',
		'UG' => 'UGX',
		'UA' => 'UAH',
		'AE' => 'AED',
		'UY' => 'UYU',
		'UZ' => 'UZS',
		'VU' => 'VUV',
		'VE' => 'VEF',
		'VN' => 'VND',
		'YE' => 'YER',
		'ZM' => 'ZMK',
		'ZW' => 'ZWD',
		'AX' => 'EUR',
		'AO' => 'AOA',
		'AQ' => 'AQD',
		'BA' => 'BAM',
		'CD' => 'CDF',
		'GH' => 'GHS',
		'GG' => 'GGP',
		'IM' => 'GBP',
		'LA' => 'LAK',
		'MO' => 'MOP',
		'ME' => 'EUR',
		'PS' => 'JOD',
		'BL' => 'EUR',
		'SH' => 'GBP',
		'MF' => 'ANG',
		'PM' => 'EUR',
		'RS' => 'RSD',
		'USAF' => 'USD'
	);
	
}