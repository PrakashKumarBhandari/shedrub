<?php

include_once trailingslashit( dirname( __FILE__ ) ) .  'acf-helpers/class-svg-select.php';

add_action( 'init', 'acf_fields_loader', 20 );
function acf_fields_loader(){
	require_once dirname(__FILE__) . '/field-groups/footer-settings.php'; 
	require_once dirname(__FILE__) . '/field-groups/settings.php'; 
}
?>