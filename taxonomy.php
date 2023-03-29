<?php
get_header();
	$data=get_queried_object();
	//print_r($data);
	
	$wpnew=array(
				'post_type'=>'artical',
		        'post_status'=>'publish',
				'tax_query'=>array(
					array(
						'taxonomy'=>'artical_category',
						'field'=>'term_id',
						'terms'=>$data->term_id
					)
				),
	);
	$newquery = new Wp_Query($wpnew);
	while($newquery->have_posts()){
		$newquery->the_post();
	
?>
	<h1><?php //echo $data->name; ?></h1>		
	<h2><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>		
	<div style="height:400px; width:400px;">
	   <?php the_post_thumbnail();?>
	</div>
	<p><?php echo get_the_content();?></p>
	<p><?php echo get_the_date();?></p>
	
<?php
	}
get_footer();
?>