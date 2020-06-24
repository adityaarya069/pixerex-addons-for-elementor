<?php
/**
 * Templates Keywords Filter
 */
?>
<#
	if ( ! _.isEmpty( keywords ) ) {
#>
<label><?php echo __('Filter by Widget / Addon', 'pixerex-addons-for-elementor'); ?></label>
<select id="elementor-template-library-filter-subtype" class="elementor-template-library-filter-select pixerex-library-keywords" data-elementor-filter="subtype">
    <option value=""><?php echo __( 'All Widgets/Addons', 'pixerex-addons-for-elementor' ); ?></option>
    <# _.each( keywords, function( title, slug ) { #>
    <option value="{{ slug }}">{{ title }}</option>
    <# } ); #>
</select>
<#
	}
#>