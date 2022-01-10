<?php
/**
 * The template for displaying trj-blog page
 * 
 * Template Name: TRJ-blog
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package TRJ
 */

get_header();
?>

<main id="primary" class="site-main">

  <section class="blog-header">
    <img src="<?php bloginfo('template_directory');?>/asset/img/image-banner.png" alt="blog-banner" />
  </section>

  <section class="blog-intro">
    <h1>
      Get all the information you need to manage your portfolio
    </h1>
    <p>
      We have provided a few tips and tricks to help you manage your finances, gain more insight into what we do, and understand how to achieve financial freedom
    </p>
  </section>

  <!--Editors-->

  <section class="blog-cat theme">

    <div class="blog-cat_heading">
      <h3>Editor’s Picks</h3>
      <p>Stories from our customers</p>
    </div>

    <div class="blog-cat_posts">
      <?php
        $arg = array(
          'cat'=>3,
          'posts_per_page'=>3
        );
      ?>
      <?php $catquery = new WP_Query($arg); ?>
      <?php if ( $catquery->have_posts() ) : ?>
        <div class="posts-cat">
          
            <?php while($catquery->have_posts()) : $catquery->the_post(); ?>
            <div class="trj-post">
              <a href="<?php the_permalink(); ?>" alt="<?php the_title_attribute(); ?>">
                <?php the_post_thumbnail(); ?>
              </a>

              <div class="post-summary">
                <div class="post-info">
                  <p><?php echo get_the_date() ?></p>
                  <h4>
                    <a href="<?php the_permalink(); ?>">
                      <?php the_title(); echo '...' ?>
                    </a>
                  </h4>
                </div>

                <div class="post-author">
                  <p>By <?php the_author(); ?></p>
                </div>
              </div>
            </div>

          <?php endwhile; wp_reset_postdata(); ?>
        </div>
      <?php else: ?>
        <p style="text-align:center;"><?php _e( 'Stay tuned for upcoming posts coming soon!' ); ?></p>
      <?php endif; ?>
    </div>

  </section>

  <!--Investment-->

  <section class="blog-cat">
  
    <div class="blog-cat_heading">
      <h3>Investment Tips</h3>
      <p>Get tips that help you know how to pick the right investment opportunity and increase your portfolio</p>
    </div>

    <div class="blog-cat_posts">
      <?php
        $arg = array(
          'cat'=>4,
          'posts_per_page'=>3
        );
      ?>
      <?php $catquery = new WP_Query($arg); ?>
      <?php if ( $catquery->have_posts() ) : ?>
      <div class="posts-cat">
          <?php while($catquery->have_posts()) : $catquery->the_post(); ?>
          <div class="trj-post">
            <a href="<?php the_permalink(); ?>" alt="<?php the_title_attribute(); ?>">
              <?php the_post_thumbnail(); ?>
            </a>

            <div class="post-summary">
              <div class="post-info hl">
                <h4>
                  <a href="<?php the_permalink(); ?>">
                    <?php the_title(); echo '...' ?>
                  </a>
                </h4>
              </div>
            </div>
          </div>

        <?php endwhile; wp_reset_postdata(); ?>
      </div>
      <?php else: ?>
        <p style="text-align:center;"><?php _e( 'Stay tuned for upcoming posts coming soon!' ); ?></p>
      <?php endif; ?>

    </div>

  </section>

  <!--Loans-->

  <section class="blog-cat">
  
    <div class="blog-cat_heading">
      <h3>Loans and More</h3>
      <p>The A-Z of applying and repayment of loans. Here are all the information you need to know before you apply for a loan and how to manage existing loans</p>
    </div>

    <div class="blog-cat_posts">
      <?php
        $arg = array(
          'cat'=>5,
          'posts_per_page'=>3
        );
      ?>
      <?php $catquery = new WP_Query($arg); ?>
      <?php if ( $catquery->have_posts() ) : ?>
      <div class="posts-cat">
          <?php while($catquery->have_posts()) : $catquery->the_post(); ?>
          <div class="trj-post">
            <a href="<?php the_permalink(); ?>" alt="<?php the_title_attribute(); ?>">
              <?php the_post_thumbnail(); ?>
            </a>

            <div class="post-summary">
              <div class="post-info hl">
                <h4>
                  <a href="<?php the_permalink(); ?>">
                    <?php the_title(); echo '...' ?>
                  </a>
                </h4>
              </div>
            </div>
          </div>

        <?php endwhile; wp_reset_postdata(); ?>
      </div>
      <?php else: ?>
        <p style="text-align:center;"><?php _e( 'Stay tuned for upcoming posts coming soon!' ); ?></p>
      <?php endif; ?>

    </div>

  </section>

  <?php require 'blog-footer.php' ?>

</main>

<?php get_footer() ?>