<?php
/**
 * Template part for displaying recent posts, categories and tags widgets.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

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

                    // Only show the widget if sit has multiple tags.
                    if (big_cookbook_tagged_blog()) : 
                        $tag_title = esc_html__('These topics might also spark an interest.','big-cookbook');
                        the_widget('WP_Widget_Tag_Cloud', Array("title" => $tag_title) );

                    endif;