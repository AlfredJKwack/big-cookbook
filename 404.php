<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 */
get_header(); ?>
    
        <article class="error-404 not-found">
            <header class="page-header">
                <div class="featured-img focuspoint">                
                    <img src="<?php echo get_template_directory_uri(); ?>/img/404.png" alt="404 Error image" />
                </div>
                <div id="abstract">
                    <h1 class="page-title"><?php esc_html_e('Oops! It looks like that page is toast.', 'big-cookbook'); ?></h1>
                    <!--
                    <a href="javascript:void(0)" class="left-menu button trigger more"><span>More recipes</span></a>
                    <a href="javascript:void(0)" class="left-menu button trigger less">Continue reading</a>
                    -->
                </div>
            </header><!-- .page-header -->
            <div id="article_body">
                <!--
                <a id="" href="javascript:void(0)" class="right-menu button trigger"><span>&equiv;</span></a>
                -->
                <section>
                    <p><?php esc_html_e('It seems like there is nothing pertinent at this location. Maybe try one of the links below or a search?', 'big-cookbook'); ?></p>

                    <?php
                    get_search_form();

                    the_widget('WP_Widget_Recent_Posts');

                    // Only show the widget if site has multiple categories.
                    if (big_cookbook_categorized_blog()) :
                    ?>

                    <div class="widget widget_categories">
                        <h2 class="widget-title"><?php esc_html_e('Most Used Categories', 'big-cookbook'); ?></h2>
                        <ul>
                        <?php
                            wp_list_categories(array(
                                'orderby' => 'count',
                                'order' => 'DESC',
                                'show_count' => 1,
                                'title_li' => '',
                                'number' => 10,
                            ));
                        ?>
                        </ul>
                    </div><!-- .widget -->

                    <?php
                    endif;

                    /* translators: %1$s: smiley */
                    $archive_content = '<p>'.sprintf(esc_html__('Try looking in the monthly archives. %1$s', 'big-cookbook'), convert_smilies(':)')).'</p>';
                    the_widget('WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content");

                    the_widget('WP_Widget_Tag_Cloud');
                    ?>
                    <br/>
                </section>
            </div><!-- #article_body -->
        </article><!-- .error-404 not-found ?> -->
<?php
get_footer();
