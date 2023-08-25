<?php
    $price = get_post_meta( get_the_ID(), '_regular_price', true);
    // $price will return regular price

    $sale = get_post_meta( get_the_ID(), '_sale_price', true);
    // $sale will return sale price

?>