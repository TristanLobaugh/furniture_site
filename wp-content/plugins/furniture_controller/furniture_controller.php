<?php 
/**
* Plugin Name: furniture controller
* Description: This is the custom controller for the furniture site. It includes Stripe integration
* Version: 1.0.
* Author: Tristan Lobaugh
*/

function add_tags_to_attachments(){
	register_taxonomy_for_object_type("post_tag", "attachment");
}
add_action("init", "add_tags_to_attachments");

function get_image_urls_by_taxonomy_term($term){
	global $wpdb;

	if($term =="all"){
		$query = "SELECT posts.guid FROM wp_terms terms
		INNER JOIN wp_term_relationships rel ON rel.term_taxonomy_id = terms.term_id
		INNER JOIN wp_posts posts ON rel.object_id = posts.ID";
	}else{
		$query = "SELECT posts.guid FROM wp_terms terms
			INNER JOIN wp_term_relationships rel ON rel.term_taxonomy_id = terms.term_id
			INNER JOIN wp_posts posts ON rel.object_id = posts.ID
			WHERE terms.name = '".$term."'";
	}
	$result = $wpdb->get_results($query);

	$images = array();
	foreach ($result as $row){
		$images[] = $row->guid;
	}

	return $images;
	exit;


}

function stripe_checkout(){
require_once("inc/config.php");

$stripe_form = '<form action="/wp-content/plugins/furniture_controller/inc/charge.php" method="post">
				<label>Ammount to pay</label>
				<input type="number" placeholder="Amount to Pay" name="amount">
				<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
				data-key="'.$stripe['publishable_key'].'"
				data-description="Access for a year"
				data-amount=""
				data-locale="auto"></script>
</form>';

print $stripe_form;


}

?>