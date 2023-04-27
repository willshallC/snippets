<?php $cat = get_terms(array('taxonomy'=>'articles_category', 'hide_empty'=>false, 'parent'=>0, 'hierarchical'=>1)); //0 no?>

<div class="cat-main">
<?php 

    foreach($cat as $pcat){ ?>
        <?php
            $subcat = get_terms(array('taxonomy'=>'articles_category', 'parent'=>$pcat->term_id));
        ?>
            <div class="parent">
                <h3 class="parent-cat" id=<?php echo $pcat->term_id; ?>><?php echo $pcat->name; ?></h3>
                <div class="child-cat">
                <?php
                foreach($subcat as $sc){
                    
                // Get posts from that child topic  
                $the_query = new WP_Query( array(
                    'post_type' => 'articles',
                    'tax_query' => array(
                      'relation' => 'AND',
                      array(
                        'taxonomy' => $pcat->taxonomy,
                        'field'    => 'slug',
                        'terms'    => array( $sc->slug )
                      )
                    )
                  ) );
                  ?>

<a href="<?echo get_category_link($sc->term_id)?>"><h2><?php echo $sc->name; echo $sc->term_id; ?></h2></a>
                    
                    <?php
                    echo "<h1>$pcat->taxonomy</h1>";
                        if($the_query->have_posts()){
                            while($the_query->have_posts()){
                                $the_query->the_post();
                                ?>
                                <p><?php echo get_the_title(); ?></p>
                                <?php 
                            }
                            wp_reset_query();
                        }
                    ?>
                
                <?php } 
        ?>
            </div>
        </div>   
        
   <?php }
?>
</div>
                
<style>
    .child-cat{
        display: none;
    }
</style>
<script>
    let childCat = document.querySelectorAll(".child-cat");
    let parentCat = document.querySelectorAll(".parent-cat");

    parentCat.forEach(p=>{
        p.addEventListener('click',function(){
            //this.nextSibling.style.display="block";
            for(let x of childCat){
                x.style.display="none";
            }
            this.nextElementSibling.style.display="block";
        })
    })
</script>
