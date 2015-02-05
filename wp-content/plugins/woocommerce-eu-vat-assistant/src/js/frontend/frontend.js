/* JavaScript for Frontend pages */
jQuery(document).ready(function($) {
	var main = this;
	this.params = aelia_eu_vat_assistant_params;
	// Determine on which address VAT should be calculated
	this.tax_based_on = main.params.tax_based_on;
	this.vat_country = '';
	// Convenience object to keep track of the self certification field element
	this.$self_certification_element = $('#woocommerce_location_self_certification');
	this.$eu_vat_field;
	// The last VAT number entered in the VAT number field. Used to prevent validating the same number when it doesn't change
	this.last_vat_number = '';

	// Test
	//main.params.ip_address_country = 'IE';

	/**
	 * Returns the country that will be used for EU VAT calculations.
	 *
	 * @return string
	 */
	this.get_vat_country = function() {
		if((this.tax_based_on == 'shipping') &&  $('#ship-to-different-address input').is(':checked')) {
			var country_field_selector = 'select#shipping_country';
		}
		else {
			var country_field_selector = 'select#billing_country';
		}

		// Determine the country that will be used for tax calculation
		return $(country_field_selector).val();
	}

	/**
	 * Determines if there is enough evidence about customer's location to satisfy
	 * EU requirements.
	 *
	 * @return bool
	 */
	this.sufficient_location_evidence = function() {
		var country_count = {};
		country_count[$('#billing_country').val()] = ++country_count[$('#billing_country').val()] || 1;

		// Take shipping country as evidence only if explicitly told so
		if(main.params.use_shipping_as_evidence) {
			if($('#ship-to-different-address-checkbox').is(':checked') && ($('#shipping_country').length > 0)) {
				country_count[$('#shipping_country').val()] = ++country_count[$('#shipping_country').val()] || 1;
			}
		}
		country_count[main.params.ip_address_country] = ++country_count[main.params.ip_address_country] || 1;

		for(var country_id in country_count) {
			// We have sufficient evidence as long as we have at least a count of 2
			// for any given, non empty country
			if((country_id != '') && (country_count[country_id] >= 2)) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Shows/hides the self-certification field, depending on the data entered on
	 * checkout page and the plugin settings.
	 */
	this.update_self_certification_element = function() {
		var show_element = true;
		// If VAT number is valid, and option "hide self-certification when
		// VAT number is valid" is enabled, the self-certification field must
		// be hidden. It will be ignored at checkout
		if(main.$eu_vat_field.prop('valid') && (main.params.hide_self_cert_field_with_valid_vat == 1)) {
			show_element = false;
		}
		else {
			switch(main.params.show_self_cert_field) {
				case 'yes':
					show_element = true;
					break;
				case 'conflict-only':
					show_element = !this.sufficient_location_evidence();
					break;
			}
		}

		// Replace tokens in the self certification box, if any
		var self_cert_label = main.params.user_interface.self_certification_field_title;
		main.$self_certification_element
			.find('label')
			.html(self_cert_label.replace('{billing_country}',$('#billing_country option:selected').text()));

		if(show_element) {
			main.$self_certification_element.fadeIn();
		}
		else {
			main.$self_certification_element.fadeOut();
		}
	}

	/**
	 * Validates the VAT number entered by the customer and updates the checkout
	 * page according to the result.
	 */
	this.validate_vat_number = function () {
		var vat_number = main.$eu_vat_field.val();
		// If the number has not changed since last time, skip the validation
		if((main.vat_country + vat_number) == main.last_vat_number) {
			return;
		}

		// Don't bother sending an Ajax request when the required values are
		// empty
		if((main.vat_country == '') || (vat_number == '')) {
			return;
		}

		// Store the last validated number
		main.last_vat_number = main.vat_country + vat_number;
		var ajax_args = {
			'action': 'validate_eu_vat_number',
			'country': main.vat_country,
			'vat_number': vat_number
		};
		$.get(main.params.ajax_url, ajax_args, function(response) {
			//console.log(response);
			// Tag the field to indicate if it's valit or not
			main.$eu_vat_field.prop('valid', response.valid);
			// Update the display of the self certification element
			main.update_self_certification_element();
		});
	}

	/**
	 * Sets the handlers required for the validation of the EU VAT field.
	 *
	 * @param object eu_vat_element A jQuery object wrapping the EU VAT field.
	 */
	this.set_eu_vat_field_handlers = function($eu_vat_element) {
		var eu_vat_countries = main.params.eu_vat_countries;
		switch(this.tax_based_on) {
			case 'billing':
				var event_selector = 'select#billing_country';
				break;
			case 'shipping':
				var event_selector = 'select#billing_country, select#shipping_country, input#ship-to-different-address-checkbox';
				break;
		}

		$('form.checkout, form#order_review').on('change', event_selector, function() {
			var previous_vat_country = main.vat_country;
			main.vat_country = main.get_vat_country();

			// Hide or show the EU VAT element, depending on the country (field is visible
			// for EU only)
			if(main.vat_country && ($.inArray(main.vat_country, eu_vat_countries) >= 0)) {
				$eu_vat_element.fadeIn();
			}
			else {
				$eu_vat_element.fadeOut(function() {
					main.$eu_vat_field.val('');
				});
			}

			// Show the self-certification field, depending on the selected VAT country
			if(main.$self_certification_element.length > 0) {
				main.update_self_certification_element();
			}

			// Validate the VAT number when the VAT country changes
			if(main.vat_country != previous_vat_country) {
				main.validate_vat_number();
			}
		});

		// Validate EU VAT number on the fly
		main.$eu_vat_field.on('blur', function() {
			main.validate_vat_number();
		});
	}

	// Show the EU VAT field on checkout
	var $eu_vat_element = $('#woocommerce_eu_vat_number');
	if($eu_vat_element.length > 0) {
		// Store a reference to the VAT number field
		this.$eu_vat_field = $eu_vat_element.find('#vat_number');

		this.set_eu_vat_field_handlers($eu_vat_element);
		// Trigger an update of the checkout form to display the EU VAT field
		$('select#billing_country').change();
	}
});
