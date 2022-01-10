<!--Recommend Articles-->

  <section class="blog-cat">
  
    <div class="blog-cat_heading">
      <h3>Recommended Articles</h3>
    </div>

    <div class="blog-cat_posts">
      <?php
        $arg = array(
          'posts_per_page'=>3,
          'meta_key' => 'trj_post_views_count',
          'orderby' => 'meta_value_num', 
          'order' => 'DESC'
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

  <!--All Categories-->

  <section class="blog-cat">
      <div class="blog-cat_heading">
        <h3>Categories</h3>
      </div>

      <div class="cat__">
        <div class="cat-list">
          <a href="http://trj.dodo.ng/category/investments" class="cat-link">Investments</a>
          <a href="http://trj.dodo.ng/category/loans" class="cat-link">Loans</a>
          <a href="http://trj.dodo.ng/category/trust-funds" class="cat-link">Trust Funds</a>
          <a href="http://trj.dodo.ng/category/portfolio-management" class="cat-link">Portfolio Management</a>
          <a href="http://trj.dodo.ng/category/goals/" class="cat-link">Goals</a>
          <a href="http://trj.dodo.ng/category/gadgets/" class="cat-link">Gadgets</a>
          <a href="http://trj.dodo.ng/category/wealth" class="cat-link">Wealth</a>
        </div>
      </div>
  </section>

  <!--Subscription-->

  <section class="blog-cat trj-pd theme">
    <div class="blog-sub blog-cat_heading">
      <h3>Sign up for our newsletter</h3>

      <form class="blog-sub_form" action="https://trjcompanylimited.us4.list-manage.com/subscribe/post?u=8790bd041c6c8b2687e34bb34&amp;id=92d67bb50e" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" novalidate>
        <input type="email" name="EMAIL" />
        <input type="submit" value="Submit" name="subscribe" />
      </form>
      <div id="mce-responses" class="clear">
	  <div class="response" id="mce-error-response" style="display:none"></div>
	  <div class="response" id="mce-success-response" style="display:none"></div>
    </div>
  </section>

