<?php
/**
 * Plugin Name: Gerald Gutenberg Blocks
 * Description: Gutenberg Blocks developed by Gerald for Procoders
 * Author: Gerald Ibra
 * Author URI: https://www.linkedin.com/in/gerald-ibra-15a722168/
 * Text-Domain: gerald-gutenberg-blocks
 */

if (!defined('ABSPATH')) : exit();
endif;

// Include Graf_Services
require(__DIR__ . '/src/blocks/gerald_course_grid/GeraldCourseGrid.php');
use Gerald\GutenbergBlocks\Blocks\GeraldCourseGrid\GeraldCourseGrid as GeraldCourseGrid;

final class GeraldGutenbergBlocks
{

    const VERSION = '1.0.0';

    /**
     * Construct Function
     */
    private function __construct()
    {
        $this->plugin_constants();
        add_action('plugins_loaded', [$this, 'init_plugin']);
    }

    /**
     * Define plugin constants
     */
    public function plugin_constants()
    {
        define('PREFIX_VERSION', self::VERSION);
        define('PREFIX_PLUGIN_PATH', trailingslashit(plugin_dir_path(__FILE__)));
        define('PREFIX_PLUGIN_URL', trailingslashit(plugins_url('/', __FILE__)));
    }

    /**
     * Singletone Instance
     */
    public static function init()
    {
        static $instance = false;
        if (!$instance) {
            $instance = new self();
        }
        return $instance;
    }

    /**
     * Plugin Init
     */
    public function init_plugin()
    {
        $this->enqueue_scripts();
    }

    /**
     * Enqueue Scripts
     */
    public function enqueue_scripts()
    {
        add_action('enqueue_block_editor_assets', [$this, 'register_block_editor_assets']);
        add_action('init', [$this, 'register_blocks']);
        add_action('init', [$this, 'registerCategory']);
    }

    /**
     * Regsiter Block Editor Assets
     */
    public function register_block_editor_assets()
    {
        wp_enqueue_script(
            'prefix-wp-gutenberg-plugin-starter',
            PREFIX_PLUGIN_URL . '/build/index.js',
            [
                'wp-blocks',
                'wp-editor',
                'wp-i18n',
                'wp-element',
                'wp-components',
                'wp-data'
            ]

        );
    }

    /**
     * Register Blocks
     */
    public function register_blocks()
    {
        register_block_type('gerald-gutenberg-blocks/gerald-hero', []);
        register_block_type('gerald-gutenberg-blocks/gerald-course-grid', [
            'render_callback' => [new GeraldCourseGrid(), 'render_block'],
        ]);
    }

    public function registerCategory()
    {
        function register_gerald_category($categories)
        {

            $categories[] = array(
                'slug'  => 'gerald-blocks',
                'title' => 'Gerald Custom Blocks'
            );

            return $categories;
        }

        add_filter('block_categories_all', 'register_gerald_category');
    }
}

/**
 * Init Main Plugin
 */
function prefix_run_plugin()
{
    return GeraldGutenbergBlocks::init();
}
// Run the plugin
prefix_run_plugin();
