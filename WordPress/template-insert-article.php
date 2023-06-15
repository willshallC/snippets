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
		
		wp_set_object_terms( $id, $_POST['articleCat'], 'article_category'  );
		
	}
?>

<div>
	<form method="post">		 
			Article Title:<br>
				<input type="text" name="atitle"/><br><br>
		 
			Article Description:<br>
				<textarea name="ades"></textarea><br><br>
				
				<select name="articleCat" style="width:300px; height:40px;">
					<option>Select Article Category</option>					
					
					<?php					
						$artical_cat = get_terms(array('taxonomy'=>'article_category','hide_empty'=>false,
	
						'orderby'=>'name',
						'order'=>'DESC',
						'parent'=> 0
						
						));
						
						foreach($artical_cat as $artical_cat_value){
							
						?>
					
						<option value="<?php echo $artical_cat_value->name ?>">
						<?php echo $artical_cat_value->name ?>
						</option>
					
					<?php } ?>
						
					
				</select><br><br>
					
			<input type="submit" name="save_article" value="Save Article"/>		
	</form>
</div>

<?php
	get_footer();
?>