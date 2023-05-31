<?php
    //Add this code in functions.php filr
    register_sidebar(
		array(
			'name'=>'Sidebar Location',
			'id'=>'sidebar'
		)
	);
?>
<!--Where you want to display the widget, do this function-->
<div class="sidebar">
	<?php dynamic_sidebar('sidebar'); ?> 
</div>