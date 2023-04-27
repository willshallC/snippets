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
                    
                
                