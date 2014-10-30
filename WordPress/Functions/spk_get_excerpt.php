<?php

function spk_get_excerpt($chars = 20){
	$excerpt = get_the_content();
	$excerpt = strip_shortcodes($excerpt);
	$excerpt = strip_tags($excerpt);
	$the_str = substr($excerpt, 0, $chars);
	return $the_str . '... ';
}