<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Insight_Posts_Widget extends WP_Widget {

	function __construct() {
		$widget_details = array(
			'classname'   => 'widget_posts_widget',
			'description' => 'The posts list with thumbnail widget.'
		);

		parent::__construct( 'insight_postswidget', esc_html__( '[Insight] Posts', 'tm-organik' ), $widget_details );
	}

	function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$cat   = $instance['cat'];
		$num   = $instance['num'];
		echo wp_kses( $args['before_widget'], 'insight-widget' );
		if ( $cat == 'c1' ) {
			if ( ! empty( $title ) ) {
				echo wp_kses( $args['before_title'] . $title . $args['after_title'], 'insight-widget' );
			} else {
				echo wp_kses( $args['before_title'] . '&nbsp;' . $args['after_title'], 'insight-widget' );
			}
			$tmrp_args = array(
				'post_type'           => 'post',
				'ignore_sticky_posts' => 1,
				'posts_per_page'      => $num
			);
		} elseif ( $cat == 'c3' ) {
			if ( ! empty( $title ) ) {
				echo wp_kses( $args['before_title'] . $title . $args['after_title'], 'insight-widget' );
			} else {
				echo wp_kses( $args['before_title'] . '&nbsp;' . $args['after_title'], 'insight-widget' );
			}
			$sticky    = get_option( 'sticky_posts' );
			$tmrp_args = array(
				'post_type'      => 'post',
				'post__in'       => $sticky,
				'posts_per_page' => $num
			);
		} else {
			echo wp_kses( $args['before_title'] . '<a href="' . esc_url( get_category_link( $cat ) ) . '" title="' . esc_attr( get_cat_name( $cat ) ) . '">' . get_cat_name( $cat ) . '</a>' . $args['after_title'], 'insight-widget' );
			$tmrp_args = array(
				'post_type'           => 'post',
				'cat'                 => $cat,
				'ignore_sticky_posts' => 1,
				'posts_per_page'      => $num
			);
		}
		$tmrp_query = new WP_Query( $tmrp_args );
		if ( $tmrp_query->have_posts() ) {
			while ( $tmrp_query->have_posts() ) {
				$tmrp_query->the_post();
				?>
                <div class="item">
                    <div class="thumb">
	                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		                    <?php if ( has_post_thumbnail() ) {
			                    the_post_thumbnail( array( 80, 80 ) );
		                    } ?>
	                    </a>
                    </div>
                    <div class="info">
						<span class="title">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
								<?php the_title(); ?>
							</a>
						</span>
                        <span class="date">
							<?php the_time( 'F j, Y' ); ?>
						</span>
                    </div>
                </div>
				<?php
			}
		}
		wp_reset_postdata();
		echo wp_kses( $args['after_widget'], 'insight-widget' );
	}

	function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['cat']   = ( ! empty( $new_instance['cat'] ) ) ? strip_tags( $new_instance['cat'] ) : '';
		$instance['num']   = ( ! empty( $new_instance['num'] ) ) ? strip_tags( $new_instance['num'] ) : '';

		return $instance;
	}

	function form( $instance ) {
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = esc_html__( 'New title', 'tm-organik' );
		}
		if ( isset( $instance['cat'] ) ) {
			$cat = $instance['cat'];
		} else {
			$cat = 'c1';
		}
		if ( isset( $instance['num'] ) ) {
			$num = $instance['num'];
		} else {
			$num = 5;
		}
		?>
        <p>
            <label
                    for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'tm-organik' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $title ); ?>"/>
        </p>
        <p>
            <label
                    for="<?php echo esc_attr( $this->get_field_id( 'cat' ) ); ?>"><?php esc_html_e( 'Category:', 'tm-organik' ); ?></label>
            <select name="<?php echo esc_attr( $this->get_field_name( 'cat' ) ); ?>">
                <option value="c1" <?php
				if ( $cat == 'c1' ) {
					echo 'selected';
				}
				?>>Recent
                </option>
                <option value="c3" <?php
				if ( $cat == 'c3' ) {
					echo 'selected';
				}
				?>>Sticky
                </option>
				<?php
				$categories = get_categories( 'hide_empty=0' );
				if ( $categories ) {
					foreach ( $categories as $category ) {
						$sl = '';
						if ( $category->term_id == $cat ) {
							$sl = 'selected';
						}
						echo '<option value="' . esc_attr( $category->term_id ) . '" ' . $sl . '>' . esc_html__( 'Category: ', 'tm-organik' ) . $category->name . '</option>';
					}
				}
				?>
            </select>
        </p>
        <p>
            <label
                    for="<?php echo esc_attr( $this->get_field_id( 'num' ) ); ?>"><?php esc_html_e( 'Number:', 'tm-organik' ); ?></label>
            <select name="<?php echo esc_attr( $this->get_field_name( 'num' ) ); ?>">
				<?php
				for ( $i = 1; $i <= 40; $i ++ ) {
					$sl = '';
					if ( $i == $num ) {
						$sl = 'selected';
					}
					echo '<option value="' . esc_attr( $i ) . '" ' . $sl . '>' . $i . '</option>';
				}
				?>
            </select>
        </p>
		<?php
	}
}

class Insight_Categories_Widget extends WP_Widget {

	function __construct() {
		$widget_details = array(
			'classname'   => 'widget_categories_widget',
			'description' => 'The categories list with posts count.'
		);

		parent::__construct( 'insight_categorieswidget', esc_html__( '[Insight] Categories', 'tm-organik' ), $widget_details );
	}

	function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo wp_kses( $args['before_widget'], 'insight-widget' );
		echo wp_kses( $args['before_title'] . $title . $args['after_title'], 'insight-widget' );
		$categories = get_categories( 'hide_empty=0' );
		if ( $categories ) {
			foreach ( $categories as $category ) {
				echo '<div class="item"><a href="' . get_category_link( $category->term_id ) . '">' . $category->name . '</a><span>' . $category->count . '</span></div>';
			}
		}
		echo wp_kses( $args['after_widget'], 'insight-widget' );
	}

	function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

	function form( $instance ) {
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = esc_html__( 'New title', 'tm-organik' );
		}
		?>
        <p>
            <label
                    for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'tm-organik' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $title ); ?>"/>
        </p>
		<?php
	}
}

add_filter( 'insight_widgets', 'insight_widgets', 10, 1 );

function insight_widgets() {
	return array( 'Insight_Posts_Widget', 'Insight_Categories_Widget' );
}