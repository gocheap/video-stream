<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if ( $wp_query->max_num_pages > 1 ) : ?>
	<div id="nav-above" class="navigation">
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'videostream' ) ); ?></div>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'videostream' ) ); ?></div>
	</div><!-- #nav-above -->
<?php endif; ?>

<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
	<div id="post-0" class="post error404 not-found">
		<h1 class="entry-title"><?php _e( 'Not Found', 'videostream' ); ?></h1>
		<div class="entry-content">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'videostream' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</div><!-- #post-0 -->
<?php endif; ?>

<?php
 ?>
<?php while ( have_posts() ) : the_post(); ?>

<?php /* How to display posts of the Gallery format. The gallery category is the old way. */ ?>

	<?php if ( ( function_exists( 'get_post_format' ) && 'gallery' == get_post_format( $post->ID ) ) || in_category( _x( 'gallery', 'gallery category slug', 'videostream' ) ) ) : ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<h3 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'videostream' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>

			<div class="entry-meta">
				<?php videostream_posted_on(); ?>
			</div><!-- .entry-meta -->

			<div class="entry-content">
<?php if ( post_password_required() ) : ?>
				
<?php else : ?>
				<?php
					$images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
					if ( $images ) :
						$total_images = count( $images );
						$image = array_shift( $images );
						$image_img_tag = wp_get_attachment_image( $image->ID, 'thumbnail' );
				?>
						<div class="gallery-thumb">
							<a class="size-thumbnail" href="<?php the_permalink(); ?>"><?php echo $image_img_tag; ?></a>
						</div><!-- .gallery-thumb -->
						<p><em><?php printf( _n( 'This gallery contains <a %1$s>%2$s photo</a>.', 'This gallery contains <a %1$s>%2$s photos</a>.', $total_images, 'videostream' ),
								'href="' . get_permalink() . '" title="' . sprintf( esc_attr__( 'Permalink to %s', 'videostream' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark"',
								number_format_i18n( $total_images )
							); ?></em></p>
				<?php endif; ?>
						<?php the_excerpt(); ?>
<?php endif; ?>
			</div><!-- .entry-content -->

			<div class="entry-utility">
			<?php if ( function_exists( 'get_post_format' ) && 'gallery' == get_post_format( $post->ID ) ) : ?>
				<a href="<?php echo get_post_format_link( 'gallery' ); ?>" title="<?php esc_attr_e( 'View Galleries', 'videostream' ); ?>"><?php _e( 'More Galleries', 'videostream' ); ?></a>
				<span class="meta-sep">|</span>
			<?php elseif ( in_category( _x( 'gallery', 'gallery category slug', 'videostream' ) ) ) : ?>
				<a href="<?php echo get_term_link( _x( 'gallery', 'gallery category slug', 'videostream' ), 'category' ); ?>" title="<?php esc_attr_e( 'View posts in the Gallery category', 'videostream' ); ?>"><?php _e( 'More Galleries', 'videostream' ); ?></a>
				<span class="meta-sep">|</span>
			<?php endif; ?>
				
			</div><!-- .entry-utility -->

		</div><!-- #post-## -->

<?php /* How to display posts of the Aside format. The asides category is the old way. */ ?>

	<?php elseif ( ( function_exists( 'get_post_format' ) && 'aside' == get_post_format( $post->ID ) ) || in_category( _x( 'asides', 'asides category slug', 'videostream' ) )  ) : ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php if ( is_archive() || is_search() ) : // Display excerpts for archives and search. ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
		<?php else : ?>
			<div class="entry-content">
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'videostream' ) ); ?>
			</div><!-- .entry-content -->
		<?php endif; ?>

			<div class="entry-utility">
				<?php videostream_posted_on(); ?>
				<span class="meta-sep">|</span>
				<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'videostream' ), __( '1 Comment', 'videostream' ), __( '% Comments', 'videostream' ) ); ?></span>
				
			</div><!-- .entry-utility -->
		</div><!-- #post-## -->

<?php /* How to display all other posts. */ ?>

	<?php else : ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="post-widget" ><h3 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'videostream' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>

		<div style="padding:5px;"><div class="entry-meta">
				<?php videostream_posted_on(); ?>
			</div><!-- .entry-meta -->

	<?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
	<?php else : ?>
			<div class="entry-content">
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'videostream' ) ); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'videostream' ), 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->
	<?php endif; ?>

			<div class="entry-utility">
				<?php if ( count( get_the_category() ) ) : ?>
					<span class="cat-links">
						<?php printf( __( '<span class="%1$s">Posted in</span> %2$s', 'videostream' ), 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list( ', ' ) ); ?>
					</span>
					<span class="meta-sep">|</span>
				<?php endif; ?>
				<?php
					$tags_list = get_the_tag_list( '', ', ' );
					if ( $tags_list ):
				?>
					<span class="tag-links">
						<?php printf( __( '<span class="%1$s">Tagged</span> %2$s', 'videostream' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list ); ?>
					</span>
					<span class="meta-sep">|</span>
				<?php endif; ?>
				<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'videostream' ), __( '1 Comment', 'videostream' ), __( '% Comments', 'videostream' ) ); ?></span>
				
			</div></div><!-- .entry-utility -->
		</div></div><!-- #post-## -->

		<?php comments_template( '', true ); ?>

	<?php endif; // This was the if statement that broke the loop into three parts based on categories. ?>

<?php endwhile; // End the loop. Whew. ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
				<div id="nav-below" class="navigation">
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'videostream' ) ); ?></div>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'videostream' ) ); ?></div>
				</div><!-- #nav-below -->
<?php endif; ?>
