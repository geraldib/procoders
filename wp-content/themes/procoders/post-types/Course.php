<?php
if (!class_exists('Course')) {
    class Course
    {
        function __construct()
        {
            add_action('init', [$this, 'create_posttype'], 997);
            add_action('init', [$this, 'addFieldsToPostType'], 998);
            add_action('rest_api_init', [$this, 'register_courses_api'], 999);
        }

        public function create_posttype()
        {
            register_post_type( 'course', array(
                'labels' => array(
                    'name' => 'Courses',
                    'singular_name' => 'Course',
                    'menu_name' => 'Courses',
                    'all_items' => 'All Courses',
                    'edit_item' => 'Edit Course',
                    'view_item' => 'View Course',
                    'view_items' => 'View Courses',
                    'add_new_item' => 'Add New Course',
                    'new_item' => 'New Course',
                    'parent_item_colon' => 'Parent Course:',
                    'search_items' => 'Search Courses',
                    'not_found' => 'No courses found',
                    'not_found_in_trash' => 'No courses found in Trash',
                    'archives' => 'Course Archives',
                    'attributes' => 'Course Attributes',
                    'insert_into_item' => 'Insert into course',
                    'uploaded_to_this_item' => 'Uploaded to this course',
                    'filter_items_list' => 'Filter courses list',
                    'filter_by_date' => 'Filter courses by date',
                    'items_list_navigation' => 'Courses list navigation',
                    'items_list' => 'Courses list',
                    'item_published' => 'Course published.',
                    'item_published_privately' => 'Course published privately.',
                    'item_reverted_to_draft' => 'Course reverted to draft.',
                    'item_scheduled' => 'Course scheduled.',
                    'item_updated' => 'Course updated.',
                    'item_link' => 'Course Link',
                    'item_link_description' => 'A link to a course.',
                ),
                'public' => true,
                'show_in_rest' => true,
                'supports' => array(
                    0 => 'title',
                    1 => 'editor',
                    2 => 'thumbnail',
                    3 => 'excerpt',
                ),
                'taxonomies' => array(
                    0 => 'category',
                ),
                'delete_with_user' => false,
            ));
        }

        public function addFieldsToPostType()
        {
            if ( ! function_exists( 'acf_add_local_field_group' ) ) {
                return;
            }
        
            acf_add_local_field_group( array(
                'key' => 'group_649eec2c326bf',
                'title' => 'Courses',
                'fields' => array(
                    array(
                        'key' => 'field_649eec2c63a64',
                        'label' => 'Course Icon',
                        'name' => 'course_icon',
                        'aria-label' => '',
                        'type' => 'image',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'array',
                        'library' => 'all',
                        'min_width' => '',
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => '',
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => '',
                        'preview_size' => 'medium',
                    ),
                    array(
                        'key' => 'field_649eec7463a65',
                        'label' => 'Course Image White',
                        'name' => 'course_image_white',
                        'aria-label' => '',
                        'type' => 'image',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'array',
                        'library' => 'all',
                        'min_width' => '',
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => '',
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => '',
                        'preview_size' => 'medium',
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'course',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'side',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'field',
                'hide_on_screen' => '',
                'active' => true,
                'description' => 'Two images needed for displaying courses',
                'show_in_rest' => 1,
            ));
        }

        // {home url}/wp-json/custom/v1/courses/?page=' + pageNr + '&slug=' + stateSlug
        public function register_courses_api()
        {
            register_rest_route('custom/v1', '/courses', array(
                'methods' => 'GET',
                'callback' => [$this, 'get_all_courses'],
                'permission_callback' => '__return_true',
            ));
        }

        public function get_all_courses(WP_REST_Request $request)
        {
            $page = $request->get_param('filter') == 'yes' ? '1' : $request->get_param('page');
            $slug = $request->get_param('slug');

            $category = get_category_by_slug($slug);
            if ($category) {
                $category_id = $category->term_id;
            
                $args = array(
                    'post_type' => 'course',
                    'posts_per_page'   => 6,
                    'paged'            => (int)$page,
                    'order' => 'ASC',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field' => 'term_id',
                            'terms' => $category_id,
                        ),
                    ),
                );
                $query = new \WP_Query($args);
                $next = (int)$page < $query->max_num_pages ? true : false;
                $courses = $query->posts;
            }
            
            $html = '';
            ob_start(); 
            foreach ($courses as $course) { 
                $courseIcon = get_field('course_icon', $course->ID);
                $courseImageWhite = get_field('course_image_white', $course->ID);
            ?>
                    <div class="course-grid__card">
                        <img class="course-grid__card-image" src="<?= $courseIcon['url'] ?>" />
                        <img class="course-grid__card-imagewhite" src="<?= $courseImageWhite['url'] ?>" />
                        <p><?= $course->post_excerpt ?></p>
                    </div>
            <?php } 
            $html .= ob_get_clean();

            $response = new WP_REST_Response(['html' => $html, 'next' => $next]);
            $response->set_status(200);
            return $response;
        }

    }
    new Course();
}