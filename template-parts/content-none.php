<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */
?>
        <article class="no-content not-found">
            <header class="page-header">
                <div class="featured-img focuspoint">                
                    <img src="<?php echo get_template_directory_uri(); ?>/img/no-content.jpg" alt="No content found" />
                </div>
                <div id="abstract">
                    <h1 class="page-title"><?php esc_html_e('We came up empty!', 'big-cookbook'); ?></h1>
                    <!--
                    <a href="javascript:void(0)" class="left-menu button trigger more"><span>More recipes</span></a>
                    <a href="javascript:void(0)" class="left-menu button trigger less">Continue reading</a>
                    -->
                </div>
            </header><!-- .page-header -->
            <div id="article_body">

                <a id="" href="javascript:void(0)" class="right-menu button trigger"><span>&equiv;</span></a>

                <section>
                    <?php
                    if (is_home() && current_user_can('publish_posts')) : ?>

                        <p><?php printf(wp_kses(__('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'big-cookbook'), array('a' => array('href' => array()))), esc_url(admin_url('post-new.php'))); ?></p>

                    <?php
                    elseif (is_search()) :
                    ?>

                        <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords or try some of the other suggestions below.', 'big-cookbook'); ?></p>
                        <?php
                            get_search_form();

                            get_template_part('template-parts/content', 'widgets');

                    else : 
                    // You should never get here since a 404.php page exists...
                    ?>

                        <p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'big-cookbook'); ?></p>
                        <?php
                            get_search_form();
                    
                    endif; ?>

                    <br/>
                </section>
            </div><!-- #article_body -->
        </article><!-- .no-content not-found ?> -->
