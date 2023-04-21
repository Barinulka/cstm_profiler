<?php
function EA($obj, $end = true) {
	echo '<pre>';
	print_r($obj);
	echo '</pre>';
	if ($end) exit;
}