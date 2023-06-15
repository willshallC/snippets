<?php
	get_header();
	$data=get_queried_object();
	
	
	/*echo "<pre>";
	  print_r($data);
	echo "</pre>";
		*/
?>

<h2><?php echo $data->name ?></h2>

<h3><a href="<?php //echo site_url(); ?>"><i>Home/</i></a><?php echo $data->name ?></h3>

<?php
	$wpnew=array(
				'post_type'=>'Article',
		        'post_status'=>'publish',
				'tax_query'=>array(
					array(
						'taxonomy'=>'article_category',
						'field'=>'term_id',
						'terms'=>$data->term_id
					)
				),
	);
	$newquery = new Wp_Query($wpnew); 
	while($newquery->have_posts()){ 
		$newquery->the_post();
?>

<?php  the_post_thumbnail(array(350,350)); ?>
	<h2><?php the_title(); ?></h2>
	<p><?php the_date(); ?></p>
<?php
	}
?>
<?php
	get_footer();
?>