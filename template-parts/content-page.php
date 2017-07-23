<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */
?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <div class="featured-img focuspoint">                
                    <?php
                    if (has_post_thumbnail()) {
                        the_post_thumbnail('full', array('class' => 'is--invisible'));
                    } ?>
                </div>
                <div id="abstract">
                    <?php
                    the_title('<h1 class="entry-title">', '</h1>');
                    if ('post' === get_post_type()) : ?>
                        <div id="meta">
                            <?php
                                big_cookbook_posted_on();
                                the_posts_navigation();
                            ?>
                        </div><!-- #meta -->
                    <?php
                    endif; ?>
                    <a href="javascript:void(0)" class="left-menu button trigger more"><span>More recipes</span></a>
                    <a href="javascript:void(0)" class="left-menu button trigger less">Continue reading</a>
                </div>
            </header><!-- .entry-header -->
            <div id="article_body">
                <a id="" href="javascript:void(0)" class="right-menu button trigger"><span>&equiv;</span></a>
                <section>
                    <?php
                        the_content(sprintf(
                            /* translators: %s: Name of current post. */
                            wp_kses(__('Continue reading %s <span class="meta-nav">&rarr;</span>', 'big-cookbook'), array('span' => array('class' => array()))),
                            the_title('<span class="screen-reader-text">"', '"</span>', false)
                        ));

                        wp_link_pages(array(
                            'before' => '<div class="page-links">'.esc_html__('Pages:', 'big-cookbook'),
                            'after' => '</div>',
                        ));
                    ?>                    
                </section>
                <section>
                    <?php
                    // If comments are open or we have at least one comment, load up the comment template.
                    global $withcomments;
                    $withcomments = 1;
                    //if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    //endif;
                    ?>                    
                </section>
                <footer class="entry-footer">
                    <?php big_cookbook_entry_footer(); ?>
                </footer><!-- .entry-footer -->                
            </div><!-- #article_body -->
        </article><!-- #post-<?php the_ID(); ?> -->
