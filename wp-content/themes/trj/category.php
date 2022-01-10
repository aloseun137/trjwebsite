<?php
/**
* TRJ Category Template
*/
get_header(); 
?>

<section class="blog-header">
  <img src="<?php bloginfo('template_directory');?>/asset/img/image-banner.png" alt="blog-banner" />
</section>

<section class="blog-cat">
  
    <div class="blog-cat_heading">
      <h3><?php single_cat_title( '', true );?></h3>
      <p>
        <?php if ( category_description() ) : ?>
        <div class="archive-meta"><?php echo category_description(); ?></div>
        <?php endif; ?> 
      </p>
    </div>

    <div class="blog-cat_posts">

      <?php if ( have_posts() ) : ?>

      <div class="posts-cat">
        
        <?php while ( have_posts() ) : the_post(); ?>
          <div class="trj-post">
            <a href="<?php the_permalink(); ?>" alt="<?php the_title_attribute(); ?>">
              <?php the_post_thumbnail(); ?>
            </a>

            <div class="post-summary">
              <div class="post-info">
                <h4>
                  <a href="<?php the_permalink(); ?>">
                    <?php the_title(); echo '...' ?>
                  </a>
                </h4>
              </div>
            </div>
          </div>
        <?php endwhile ?>

      </div>
      
      <?php else: ?>
        <p style="text-align:center;"><?php _e( 'Stay tuned for upcoming posts coming soon!' ); ?></p>
      <?php endif; ?>
      
    </div>

  </section>

<?php get_footer() ?>