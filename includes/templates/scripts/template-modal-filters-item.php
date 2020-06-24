<?php
/**
 * Template Library Filter Item
 */
?>
<label class="pixerex-template-filter-label">
	<input type="radio" value="{{ slug }}" <# if ( '' === slug ) { #> checked<# } #> name="pixerex-template-filter">
	<span>{{ title.replace('&amp;', '&') }}</span>
</label>