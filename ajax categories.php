<?php 

function load_category_posts() {
  $category = $_POST['category'];
  $args = array(
    'category_name' => $category,
    'posts_per_page' => -1
  );
  $posts = get_posts($args);
  $output = '';
  foreach($posts as $post) {
    $output .= '<h2>' . $post->post_title . '</h2>';
    $output .= '<div>' . $post->post_content . '</div>';
  }
  echo $output;
  wp_die();
}
add_action('wp_ajax_load_category_posts', 'load_category_posts');
add_action('wp_ajax_nopriv_load_category_posts', 'load_category_posts');
5:43
<?php /*  Template Name: Ajax Category Posts */ ?>
<?php get_header(); ?>
<div id="primary" class="content-area">
  <main id="main" class="site-main" role="main">
    <h1><?php the_title(); ?></h1>
    <?php
      // Get all categories
      $categories = get_categories();
    ?>
    <label for="category-dropdown">Select Category:</label>
    <select id="category-dropdown">
      <option value="">All Categories</option>
      <?php foreach($categories as $category) { ?>
        <option value="<?php echo $category->slug; ?>"><?php echo $category->name; ?></option>
      <?php } ?>
    </select>
    <div id="category-posts"></div>
  </main>
</div>
<script>
  jQuery(document).ready(function($) {
    $('#category-dropdown').on('change', function() {
      var category = $(this).val();
      $.ajax({
        type: 'POST',
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        data: {
          action: 'load_category_posts',
          category: category
        },
        success: function(response) {
          $('#category-posts').html(response);
        }
      });
    });
  });
</script>
<?php get_footer(); ?>