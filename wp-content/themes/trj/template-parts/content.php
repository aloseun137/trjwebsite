<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package TRJ
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="post-intro">

		<div class="post-intro_banner">
			<?php the_post_thumbnail('large') ?>
		</div>

		<div class="post-intro_text">
			<?php
			if ( is_singular() ) :
				the_title( '<h1 class="intro-title">', '</h1>' );
			else :
				the_title( '<h2 class="intro-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;

			if ( 'post' === get_post_type() ) :
				?>

				<p class="intro-date"><?php the_date(); ?></p>

				<div class="intro-excerpt">
					<?php the_excerpt(); ?>
				</div>

				<div class="the_author">
					<p id="athr"><?php echo get_avatar(get_the_author_meta( 'ID' )) ?> <span> By <?php the_author() ?></span></p>
				</div>
			<?php endif; ?>
		</div>

	</div>

	<div class="entry-content post-details">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'trj' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'trj' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer post-details_footer">
		<div class="post-details_cat">
			<?php trj_entry_footer(); ?>
		</div>
		
		<div class="post-details_share">
			<div class="share-post">
				<a href="http://twitter.com/share?url=<?php echo urlencode(get_permalink($post->ID)); ?>&via=trjcompany&count=horizontal" >
					<svg xmlns="http://www.w3.org/2000/svg" width="62" height="62" viewBox="0 0 62 62">
						<g id="Group_2048" data-name="Group 2048" transform="translate(0.041)">
							<circle id="Ellipse_190" data-name="Ellipse 190" cx="31" cy="31" r="31" transform="translate(-0.041)" fill="rgba(10,53,236,0.17)"/>
							<path id="Path_2202" data-name="Path 2202" d="M167.108,338.518a7.924,7.924,0,0,1-2.826,4.017c.418-.091.837-.176,1.252-.276s.835-.209,1.248-.329.836-.264,1.324-.42a5.215,5.215,0,0,1-.3.434c-.865.99-1.727,1.981-2.607,2.958a.892.892,0,0,0-.253.619,23.445,23.445,0,0,1-3.48,12.042,18.942,18.942,0,0,1-11.436,8.284,22.95,22.95,0,0,1-7.252.76,17.917,17.917,0,0,1-7-1.93c-.676-.333-1.334-.7-2-1.057-.082-.043-.159-.1-.289-.177a14.6,14.6,0,0,0,10.344-3,8.363,8.363,0,0,1-4.137-1.527,7.735,7.735,0,0,1-2.54-3.6h2.78l.02-.1a7.319,7.319,0,0,1-5.515-7.169,14.28,14.28,0,0,0,1.393.532,7.689,7.689,0,0,0,1.446.2,7.22,7.22,0,0,1-2.654-4.515,7.312,7.312,0,0,1,.621-5.221c3.98,4.443,8.8,7.168,14.83,7.563-.053-.36-.118-.7-.151-1.045a6.49,6.49,0,0,1,3.139-6.367,7.829,7.829,0,0,1,5.228-1.311,5.9,5.9,0,0,1,4.1,2.1.391.391,0,0,0,.445.108,12.507,12.507,0,0,0,2.887-.964C166.159,338.931,166.6,338.743,167.108,338.518Z" transform="translate(-120.384 -321.168)" fill="#15195b"/>
						</g>
					</svg>
				</a>

				<a href="">
					<svg xmlns="http://www.w3.org/2000/svg" width="62" height="62" viewBox="0 0 62 62">
						<g id="Group_2049" data-name="Group 2049" transform="translate(0.32)">
							<circle id="Ellipse_191" data-name="Ellipse 191" cx="31" cy="31" r="31" transform="translate(-0.32)" fill="rgba(10,53,236,0.17)"/>
							<g id="Group_2046" data-name="Group 2046" transform="translate(13.101 13.101)">
								<g id="Group_2045" data-name="Group 2045" transform="translate(0 0)">
									<path id="Path_2203" data-name="Path 2203" d="M237.752,344.122c0,2.736.22,5.492-.046,8.2-.53,5.375-3.463,8.576-8.8,8.943a120.079,120.079,0,0,1-16.686,0c-5.488-.388-8.547-3.708-8.784-9.21s-.185-11.043.093-16.55a9.072,9.072,0,0,1,9.269-8.63c5.232-.092,10.467-.1,15.7,0,5.372.106,9.159,4.2,9.3,9.9.063,2.447.01,4.9.01,7.345Zm-3.073.181c0-2.5.026-4.994-.006-7.49-.053-4.15-2.4-6.724-6.547-6.831q-7.629-.2-15.266.006c-4.129.115-6.4,2.627-6.421,6.746q-.035,7.274,0,14.548c.02,4.053,2.482,6.785,6.544,6.907,5.037.151,10.084.14,15.122.007,4.1-.108,6.524-2.749,6.571-6.835C234.7,349.008,234.679,346.655,234.678,344.3Z" transform="translate(-203.289 -326.803)" fill="#15195b"/>
									<path id="Path_2204" data-name="Path 2204" d="M221.819,336.159a8.813,8.813,0,1,0,8.9,8.878A8.97,8.97,0,0,0,221.819,336.159Zm11.21-.489a2.085,2.085,0,0,0-2.161-2.019,2.056,2.056,0,0,0-1.912,2.106,1.943,1.943,0,0,0,2.141,1.972A1.971,1.971,0,0,0,233.029,335.67Z" transform="translate(-204.515 -327.676)" fill="#d4dcfc"/>
									<path id="Path_2205" data-name="Path 2205" d="M221.8,336.622a8.812,8.812,0,1,1-8.931,8.812A8.863,8.863,0,0,1,221.8,336.622Zm-5.8,8.759a5.678,5.678,0,0,0,5.718,5.773,5.77,5.77,0,0,0,5.772-5.765,5.834,5.834,0,0,0-5.69-5.73A5.747,5.747,0,0,0,216,345.381Z" transform="translate(-204.512 -328.056)" fill="#15195b"/>
								</g>
								<path id="Path_2206" data-name="Path 2206" d="M235.38,335.67a1.971,1.971,0,0,1-1.932,2.06,1.943,1.943,0,0,1-2.141-1.972,2.056,2.056,0,0,1,1.912-2.106A2.085,2.085,0,0,1,235.38,335.67Z" transform="translate(-206.866 -327.676)" fill="#15195b"/>
							</g>
						</g>
					</svg>
				</a>

				<a href="https://www.facebook.com/sharer?<?php echo urlencode(get_permalink($post->ID)); ?>" target="_blank" rel="noopener noreferrer">
					<svg xmlns="http://www.w3.org/2000/svg" width="62" height="62" viewBox="0 0 62 62">
						<g id="Group_2050" data-name="Group 2050" transform="translate(-0.211)">
							<circle id="Ellipse_192" data-name="Ellipse 192" cx="31" cy="31" r="31" transform="translate(0.211)" fill="rgba(10,53,236,0.17)"/>
							<path id="Path_2207" data-name="Path 2207" d="M283.521,324.17c-.879,0-1.766-.011-2.651,0a11.891,11.891,0,0,0-1.574.1,1.376,1.376,0,0,0-1.338,1.446c-.046,1.362-.012,2.727-.012,4.154h5.694l-.687,6.417H277.9v.62q0,8.662.008,17.325c0,.493-.116.644-.626.636-1.941-.031-3.882-.026-5.824,0-.466.006-.574-.145-.573-.589q.021-8.613.009-17.226v-.729H266.3V329.9h4.591c0-.246,0-.438,0-.629.026-1.611,0-3.225.093-4.833a7.949,7.949,0,0,1,1.2-4.163,5.285,5.285,0,0,1,3.908-2.306c1.579-.185,3.181-.167,4.775-.218.772-.025,1.546,0,2.32,0,.232,0,.425.009.424.326-.007,1.957-.006,3.915-.012,5.873A.941.941,0,0,1,283.521,324.17Z" transform="translate(-243.674 -305.825)" fill="#15195b"/>
						</g>
					</svg>
				</a>

				<a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink($post->ID)); ?>&title=<?php the_title(); ?>&https://trjcompanylimited.com/">
					<svg xmlns="http://www.w3.org/2000/svg" width="62" height="62" viewBox="0 0 62 62">
						<g id="Group_2051" data-name="Group 2051" transform="translate(0.068)">
							<circle id="Ellipse_193" data-name="Ellipse 193" cx="31" cy="31" r="31" transform="translate(-0.068)" fill="rgba(10,53,236,0.17)"/>
							<g id="bQNi6F.tif" transform="translate(13.102 13.102)">
								<g id="Group_2047" data-name="Group 2047" transform="translate(0 0)">
									<path id="Path_2208" data-name="Path 2208" d="M374.87,356.534q-2.507-.012-5.015-.023c-.9,0-1.794,0-2.758,0v-.519c0-3.753.022-7.506-.014-11.258a16.121,16.121,0,0,0-.313-3.128,3.294,3.294,0,0,0-2.882-2.841,4.064,4.064,0,0,0-4.03,1.562,4.455,4.455,0,0,0-.942,2.859q.014,6.387,0,12.775v.523h-7.789V333.116h7.783v3.165c.477-.562.878-1.1,1.343-1.569a7.139,7.139,0,0,1,4.484-2.093,9.161,9.161,0,0,1,5.993,1.2,8.411,8.411,0,0,1,3.7,5.514c.174.748.239,1.521.357,2.282.021.136.052.269.079.4Z" transform="translate(-338.597 -321.779)" fill="#15195b"/>
									<path id="Path_2209" data-name="Path 2209" d="M341.294,320.11a13.59,13.59,0,0,1,1.467.334,3.991,3.991,0,0,1-.5,7.657,4.583,4.583,0,0,1-4.638-1.245,4.531,4.531,0,0,1-.967-2.023v-1.35a.656.656,0,0,0,.075-.145,3.743,3.743,0,0,1,2.514-2.868,12.222,12.222,0,0,1,1.545-.362Z" transform="translate(-336.655 -320.11)" fill="#15195b"/>
									<path id="Path_2210" data-name="Path 2210" d="M344.938,356.578c-.152.008-.276.02-.4.02-2.3,0-4.611-.008-6.915.01-.382,0-.464-.114-.464-.477q.016-11.238.008-22.476v-.444h7.772Z" transform="translate(-336.723 -321.868)" fill="#15195b"/>
								</g>
							</g>
						</g>
					</svg>
				</a>
			</div>

			<p>SHARE THIS ARTICLE</p>
		</div>
	</footer><!-- .entry-footer -->

	<!--Recommend Articles-->

  <div class="blog-cat post___">
  
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

	</div>

  <!--All Categories-->

  <div class="blog-cat">
		<div class="blog-cat_heading">
			<h3>Categories</h3>
		</div>

		<div class="cat__">
			<div class="cat-list">
				<a href="http://localhost/trj/category/investments" class="cat-link">Investments</a>
				<a href="http://localhost/trj/category/loans" class="cat-link">Loans</a>
				<a href="http://localhost/trj/category/trust-funds" class="cat-link">Trust Funds</a>
				<a href="http://localhost/trj/category/portfolio-management" class="cat-link">Portfolio Management</a>
				<a href="http://localhost/trj/category/goals/" class="cat-link">Goals</a>
				<a href="http://localhost/trj/category/gadgets/" class="cat-link">Gadgets</a>
				<a href="http://localhost/trj/category/wealth" class="cat-link">Wealth</a>
			</div>
		</div>
	</div>

  <!--Subscription-->

  <div class="blog-cat trj-pd theme">
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
	</div>

</article><!-- #post-<?php the_ID(); ?> -->
