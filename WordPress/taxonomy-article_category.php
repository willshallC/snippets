<?php
    get_header();

    $data=get_queried_object();
	
	
	echo "<pre>";
	  print_r($data);
	echo "</pre>";
	
?>

<?php
    get_footer();
?>
