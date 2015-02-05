/* Common JavaScript for Admin section */
jQuery(document).ready(function($) {
	var main = this;
	this.$tax_rates_form = $('.wc_tax_rates');
	this.params = aelia_eu_vat_assistant_admin_params;
	if(this.$tax_rates_form.length > 0) {
		this.tax_settings_params = main.params.tax_settings;
		this.ui_params = this.tax_settings_params.user_interface;
	}

	function runTipTip() {
		$(".tips, .help_tip").tipTip({
			'attribute' : 'data-tip',
			'fadeIn' : 50,
			'fadeOut' : 50,
			'delay' : 200
		});
	}

	/**
	 * Marks every row in the tax rates table with the code of the country to which
	 * the settings in the row are related. This will make it easier to find which
	 * countries are missing later on.
	 *
	 * @param obect $rates_table A jQuery object representing the tax rates table.
	 */
	this.mark_assing_countries_to_rows = function($rates_table) {
		$rates_table.find('td.country').each(function() {
			var $country_cell = $(this);
			$country_cell.parent('tr').attr('country', $country_cell.find('input').val());
		});
	}

	/**
	 * Populates the tax rates table by adding one row for each of the missing EU
	 * countries.
	 *
	 * @param obect $rates_table A jQuery object representing the tax rates table.
	 * @param array vat_rates An array of VAT rates.
	 */
	this.add_rows_for_missing_eu_countries = function($rates_table, vat_rates) {
		main.mark_assing_countries_to_rows($rates_table);

		for(var country_code in vat_rates) {
			// Add all missing rows for the EU countries
			if($rates_table.find('tr[country="' + country_code + '"]').length <= 0) {
				//console.log('Row missing for ' + country_code + '. Adding it.');
				main.$tax_rates_form.find('.button.insert').click();
				// Mark the new row and set the country code
				var $new_row = $rates_table
					.find('tr.new')
					.first()
					.attr('country', country_code)
					.removeClass('new');
				$new_row.find('.country input').val(country_code);
			}
		}
	}

	/**
	 * Updates the VAT rate for a specific EU country. For new countries, it also adds
	 * a default description.
	 *
	 * @param obect $country_input A jQuery object representing the input field
	 * that contains the country code.
	 * @param array vat_rates An array of VAT rates.
	 * @param string vat_rate_type_to_use The type of VAT rate to use (e.g. standard,
	 * reduced, etc).
	 */
	this.update_country_rate = function($country_input, vat_rates, vat_rate_type_to_use) {
		var country_code = $country_input.val();
		// If we have a VAT rate for one of the currencies in the list, we can update it
		if(vat_rates.hasOwnProperty(country_code.toUpperCase())) {
			$country_input.parents('tr').find('.rate input').val(vat_rates[country_code][vat_rate_type_to_use]);

			// If a description is missing for the rate, add a default one
			var $rate_label = $country_input.parents('tr').find('.name input');
			if($rate_label.val().trim() == '') {
				$rate_label.val(vat_rates[country_code][vat_rate_type_to_use] + '% ' + country_code + ' ' + main.ui_params.vat_label);
			}
		}
	}

	/**
	 * Checks if the VAT rates retrieved by the EU VAT Assistant are valid. Rates
	 * are valid when, for each country, they contain at least a standard rate
	 * (invalid rates often have a "null" object associated to them).
	 *
	 * @param object vat_rates An object containing the VAT rates for all EU
	 * countries
	 * @return bool
	 */
	this.valid_vat_rates = function(vat_rates) {
		for(var country_code in vat_rates) {
			if(!vat_rates[country_code].hasOwnProperty('standard_rate')) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Updates the VAT rate for all EU countries. For new countries, it also adds
	 * a default description.
	 *
	 * @param string vat_rate_type_to_use The type of VAT rate to use (e.g. standard,
	 * reduced, etc).
	 */
	this.update_vat_rates = function(vat_rate_type_to_use) {
		var $rates_table = main.$tax_rates_form.find('tbody#rates');
		var vat_rates = main.params.tax_settings.eu_vat_rates.rates;

		// Validate VAT rates before trying to use them
		if(!this.valid_vat_rates(vat_rates)) {
			// Inform the user when VAT rates are invalid
			alert(main.params.tax_settings.user_interface.invalid_vat_rates);
			return false;
		}

		// Populate the table with all the EU countries
		main.add_rows_for_missing_eu_countries($rates_table, vat_rates);

		// Set the VAT rates for all EU Countries
		var $existing_rates = $rates_table.find('.country input');
		$existing_rates.each(function() {
			main.update_country_rate($(this),vat_rates, vat_rate_type_to_use);
		});
		// Inform the user that he should save the settings
		alert(main.params.tax_settings.user_interface.vat_updated_message);
		return true;
	}

	this.add_ui_for_automatic_tax_population = function() {
		// Create a button to allow to automatically update the VAT rates
		var $update_eu_vat_rates_button = $('<a>');
		$update_eu_vat_rates_button
			.attr('id', 'update_tax_rates')
			.attr('href', '#')
			.text(main.ui_params.update_eu_vat_rates_button_label)
			.addClass('button')
			.on('click', function(event) {
				event.stopImmediatePropagation();
				main.update_vat_rates($('#tax_rate_types').val());
				return false;
			});

		// Populate the dropdown containing the available types of VAT rates
		var $eu_vat_rate_types_dropdown = $('<select>');
		$eu_vat_rate_types_dropdown.attr('id', 'tax_rate_types');

		// Add the various tax type options
		var vat_rate_types = main.params.tax_settings.eu_vat_rate_types;
		for(var vat_type in vat_rate_types) {
			var $option = $('<option>')
				.val(vat_type)
				.text(vat_rate_types[vat_type]);
			$eu_vat_rate_types_dropdown.append($option);
		}

		// Create a text element make the UI easier to understand
		var $label = $('<span>')
			.text(main.ui_params.eu_vat_rates_using_text)
			.addClass('label');
		var $ui_container = $('<div>')
			.addClass('eu_vat_assistant update_vat_rates')
			.append($update_eu_vat_rates_button)
			.append($label)
			.append($eu_vat_rate_types_dropdown);

		var $export_button = main.$tax_rates_form.find('.button.export');
		$export_button.before($ui_container);
	}

	this.add_extra_fields_to_row = function($row) {
		var tax_rates_data = main.tax_settings_params.tax_rates_data;
		var country_field_name = $row.find('.country input[name^="tax_rate_country"]').attr('name');
		var tax_rate_id = country_field_name.match(/tax_rate_country\[(.*)\]/)[1];

		// Create an input field for the "payable to country" value
		var $payable_to_country_field = $('<input type="text" name="" class="ui-autocomplete-input" autocomplete="off">')
			.attr('placeholder', main.ui_params.tax_payable_to_country.field_placeholder)
			.attr('name', 'tax_payable_to_country[' + tax_rate_id + ']');

		if((typeof(tax_rates_data[tax_rate_id]) != 'undefined') &&
			 tax_rates_data[tax_rate_id].hasOwnProperty('tax_payable_to_country')) {
			$payable_to_country_field.val(tax_rates_data[tax_rate_id].tax_payable_to_country);
		}

		// Create the element in which the field will be stored
		var $payable_to_country_element = $('<td>')
			.addClass('tax_payable_to_country')
			.append($payable_to_country_field);

		$row
			.append($payable_to_country_element)
			.addClass('aelia_extra_fields_added');
	}

	this.add_extra_fields = function() {
		var $tax_rates_table = $('.wc_tax_rates');

		// Add "payable to country" header column
		var tip = "Tooltip";
		var $payable_to_country_header = $('<th class="payable_to_country">')
			// TODO Replace static text with variable
			.html(main.ui_params.tax_payable_to_country.header_label +
						' <span class="tips" data-tip="' + main.ui_params.tax_payable_to_country.header_tooltip + '">[?]</span>');
		$tax_rates_table.find('thead > tr').append($payable_to_country_header);

		var column_count = $tax_rates_table.find('thead tr th').length;
		$tax_rates_table.find('tfoot tr > th').first().attr('colspan', column_count);

		var $tbody = $tax_rates_table.find('#rates');
		$tbody.find('tr').each(function() {
			var $row = $(this);
			main.add_extra_fields_to_row($row);
		});

		$tax_rates_table.find('.insert').on('click', function() {
			$tax_rates_table.find('tr.new:not(".aelia_extra_fields_added")').each(function(){
				main.add_extra_fields_to_row($(this));
			});
		});
	}

	/**
	 * Extends the Admin UI of the Tax Settings page by adding elements that allow
	 * the Admin to automatically update the VAT rates for all EU countries.
	 */
	this.extend_tax_rates_ui = function() {
		// Adds the elements that allow admin to automatically populate tax rates
		this.add_ui_for_automatic_tax_population();

		this.add_extra_fields();
		runTipTip();
	}

	/**
	 * If we on the Tax Settings page, add the UI to allow automatic updates of
	 * VAT rates. If not, just carry on.
	 */
	if(this.$tax_rates_form.length > 0) {
		// If no VAT rates are available, there's no point in populating the UI
		// that allows to update them automatically
		if(main.params.tax_settings.eu_vat_rates.rates == null) {
			console.log('EU VAT rates unavailable, automatic update cannot be used.')
			return;
		}
		// Add the "Update VAT rates" interface
		this.extend_tax_rates_ui();
	}
});
