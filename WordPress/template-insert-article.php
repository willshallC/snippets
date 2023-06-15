<?php 
	//Template Name: Add Article
	get_header();

    if(isset($_POST['save_article'])){
		
		$id=wp_insert_post(  
				array(
					'post_type'=>'Article',
					'post_status'=>'draft',
					'post_title'=>$_POST['atitle'],
					'post_content'=>$_POST['ades']					
				)			
		);
		
	}
?>

<div>
	<form method="post">		 
			Article Title:<br>
				<input type="text" name="atitle"/><br><br>
		 
			Article Description:<br>
				<textarea name="ades"></textarea><br><br>
									
			<input type="submit" name="save_article" value="Save Article"/>		
	</form>
</div>

<?php
    get_footer();
?>