<?php 
	//Template Name: Home Page
	get_header();
	
 ?>

<?php
	$searchdata='';

	if($_GET['title']!=""){
		$searchdata=$_GET['title'];
		
	}
?>

<div class="searching">
	<form method="get">
		<input type="text" name="title" placeholder="Search By Name" value="<?php echo $_GET['title']; ?>"/>
		<input type="submit" value="Search" name=""/>
	</form>

</div>

<div class="post-grid">
			
			<?php
				
				
					$args = array(
						'posts_per_page' => 3,
						'post_type'=>'post',
						'post_status'=>'publish',
						's'=> $searchdata,
						
						
					);
					$the_query = new Wp_Query($args);
				
					while($the_query->have_posts()){ 
						$the_query->the_post();
						//the_title();	
		

				
			?>		
				<div class="boxx">
					
					 <?php  the_post_thumbnail(array(350,350)); ?>
					 <h2><?php the_title(); ?></h2>
					<p><?php the_excerpt(); ?></p>
					<a href="<?php the_permalink(); ?>"><input type="button" name="" value="Read More"/></a>
				</div>
			<?php
				}
			?>
			
							
		</div>


 <?php
    get_footer();
 ?>