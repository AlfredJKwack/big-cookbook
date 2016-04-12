<?php
/**
 * Template part for displaying post list thumbnail style.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Big_Cookbook
 */

?>

		<div class="col col--6">

			<?php 
			$entry_permalink = '<a href="%1$s" class="list-item list-item--stacked">';
			$entry_permalink = sprintf( $entry_permalink,
				esc_url( get_permalink() )
			);

			echo $entry_permalink;
			?>
				  
			    <div class="thumbnail" style="background-color: #131723">
			      <div class="image-wrapper content-fill" style="overflow: hidden;">
						<?php 
						if ( has_post_thumbnail() ) {
							the_post_thumbnail( 'category-thumb' );
						}; ?>
			      </div>
			    </div>
				  

				<div class="list-item-text">
					<?php the_title( '<h1 class="title">', '</h1>' ); ?>

					<div class="excerpt"><?php the_excerpt () ?></div>

					<div class="list-item-meta">

						<?php

						$time_label = '<time class="date" datetime="%1$s">%2$s</time>';


						$time_label = sprintf( $time_label,
							esc_attr( get_the_date( 'c' ) ),
							esc_html( get_the_date() )
						);

						echo $time_label

						?>

					</div>
				</div><!-- .list-item-text -->
			</a><!-- .list-item -->
		</div>