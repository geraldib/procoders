<?php
namespace Gerald\GutenbergBlocks\Blocks\GeraldCourseGrid;

class GeraldCourseGrid
{

    public function render_block($block_attributes, $content)
    {
        $title = array_key_exists('title', $block_attributes) ? $block_attributes['title'] : '';

        $category = get_category_by_slug('state-1');
        if ($category) {
            $category_id = $category->term_id;
        
            $args = array(
                'post_type' => 'course',
                'posts_per_page'   => 6,
                'paged'            => 1,
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
            $loadMoreClass = $query->max_num_pages > 1 ? '' : 'course-grid__load--disabled';
            $courses = $query->posts;
        }

        ob_start(); ?>
         <div class="course-grid">
            <div class="course-grid__container">
                <h2 class="course-grid__title"><?= $title ?></h2>
                <div class="course-grid__filter">
                    <div data-slug="state-1" class="course-grid__state course-grid__state--active">state 1</div>
                    <div data-slug="state-2" class="course-grid__state">state 2</div>
                </div>
                <div id="course-grid" class="course-grid__courses">
                    <?php foreach ($courses as $course) { 
                        $courseIcon = get_field('course_icon', $course->ID);
                        $courseImageWhite = get_field('course_image_white', $course->ID);
                    ?>
                        <div class="course-grid__card">
                            <img class="course-grid__card-image" src="<?= $courseIcon['url'] ?>" />
                            <img class="course-grid__card-imagewhite" src="<?= $courseImageWhite['url'] ?>" />
                            <p><?= $course->post_excerpt ?></p>
                        </div>
                    <?php } ?>
                </div>
                <div id="course-load" class="course-grid__load <?= $loadMoreClass ?>">Load more...</div>
            </div>
         </div>
        <?php

        $html = ob_get_clean();
        return $html;
    }
}