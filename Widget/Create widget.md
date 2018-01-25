if(!class_exists('download_brochure')) {
    
    class download_brochure extends WP_Widget {
        
        /**
         * Sets up the widgets name etc
         */
        public function __construct() {
            $widget_ops = array(
                'classname' => 'download_brochure',
                'description' => 'Download Brochure',
            );
            parent::__construct( 'download_brochure', 'Download Brochure', $widget_ops );
        }
        
        /**
         * Outputs the content of the widget
         *
         * @param array $args
         * @param array $instance
         */
        public function widget( $args, $instance ) {
            // outputs the content of the widget
            if ( ! isset( $args['widget_id'] ) ) {
                $args['widget_id'] = $this->id;
            }
            
            // widget ID with prefix for use in ACF API functions
            $widget_id = 'widget_' . $args['widget_id'];
            
            $title = get_field( 'title', $widget_id ) ? get_field( 'title', $widget_id ) : '';
            
            echo $args['before_widget'];
            
            if ( $title ) {
                echo $args['before_title'] . esc_html($title) . $args['after_title'];
            }
            if(have_rows('list_download',$widget_id)):
                echo '<div class="download">';
                while (have_rows('list_download',$widget_id)):the_row();
             ?>
                <a href="<?php the_sub_field('file')?>" target="_blank">
                    <span class="download-icon"><i class="fa <?php the_sub_field('icon')?>" style="color: #ffffff"></i></span>
                    <span class="download-title" style="color: #ffffff"><?php the_sub_field('title')?></span>
                </a>
             <?php  
                endwhile;
                echo '</div>';
            endif;
            echo $args['after_widget'];
            
        }
    }
    
}

function register_cta_widget()
{
    register_widget( 'download_brochure' );
}
add_action( 'widgets_init', 'register_cta_widget' );
