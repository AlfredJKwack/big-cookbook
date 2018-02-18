						<div class="list-content-categories clear">
							<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'container_class' => 'primary-menu-container' ) ); ?>
<!-- 							
							<h1 class="clear">
								<?php
								if ( is_search() ) :
									printf( esc_html__( 'Search Results for: %s', 'big-cookbook' ), '<span>' . get_search_query() . '</span>' );
								elseif ( is_archive() ) :
									the_archive_title( '<h1 class="page-title">', '</h1>' );
									the_archive_description( '<div class="taxonomy-description">', '</div>' );
								else :
									echo 'More Articles';
								endif;
								?>
							</h1> 
-->
						</div>
