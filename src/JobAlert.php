<?

namespace App;


class JobAlert
{

    public function __construct($var)
    {
        add_action('init', [$this, 'regiserSubs']);

        add_action('wp_ajax_add_sub', [$this, 'addSub']);
        add_action('wp_ajax_nopriv_add_sub', [$this, 'addSub']);
        add_action('wp_ajax_remove_sub', [$this, 'removeSub']);
        add_action('wp_ajax_nopriv_remove_sub', [$this, 'removeSub']);

        add_filter('acf/settings/remove_wp_meta_box', [$this, 'allowCustomFields']);
    }

    public function allowCustomFields()
    {
        if (get_post_type() === "subscriber") return false;
    }


    public function addSub()
    {

        $data = [
            'email' => sanitize_email($_POST['email']),
            'name' => sanitize_text_field($_POST['name']),
            'categories' => $this->sanitizeTags($_POST['tags']),
        ];

        $post_meta = [
            'email' => $data['email'],
            'name' => $data['name'],
        ];

        $post_taxonomies = [
            'job_tags' => [20],
        ];

        $post_args = [
            'post_type' => 'subscriber',
            'post_status' => 'publish',
            'post_title' => $data['email'],
            'meta_input' => $post_meta,
            'tax_input' => $post_taxonomies
        ];

        $sub = wp_insert_post($post_args);
        wp_redirect(home_url() . '/subscribe');
    }

    public function sanitizeTags(array $arr)
    {
        $arr = isset($arr) ? (array) $arr : array();
        return array_map('intval', $arr);
    }



    public function remove_sub()
    {
    }


    /**
     * Regiser the Subscriber CPT
     */
    public function regiserSubs()
    {
        /**
         * Post Type: Subscribers.
         */

        $labels = [
            "name" => __("Subscribers", "custom-post-type-ui"),
            "singular_name" => __("Subscriber", "custom-post-type-ui"),
            "menu_name" => __("Subscribers", "custom-post-type-ui"),
            "all_items" => __("All Subscribers", "custom-post-type-ui"),
            "add_new" => __("Add new", "custom-post-type-ui"),
            "add_new_item" => __("Add new Subscriber", "custom-post-type-ui"),
            "edit_item" => __("Edit Subscriber", "custom-post-type-ui"),
            "new_item" => __("New Subscriber", "custom-post-type-ui"),
            "view_item" => __("View Subscriber", "custom-post-type-ui"),
            "view_items" => __("View Subscribers", "custom-post-type-ui"),
            "search_items" => __("Search Subscribers", "custom-post-type-ui"),
            "not_found" => __("No Subscribers found", "custom-post-type-ui"),
            "not_found_in_trash" => __("No Subscribers found in trash", "custom-post-type-ui"),
            "parent" => __("Parent Subscriber:", "custom-post-type-ui"),
            "featured_image" => __("Featured image for this Subscriber", "custom-post-type-ui"),
            "set_featured_image" => __("Set featured image for this Subscriber", "custom-post-type-ui"),
            "remove_featured_image" => __("Remove featured image for this Subscriber", "custom-post-type-ui"),
            "use_featured_image" => __("Use as featured image for this Subscriber", "custom-post-type-ui"),
            "archives" => __("Subscriber archives", "custom-post-type-ui"),
            "insert_into_item" => __("Insert into Subscriber", "custom-post-type-ui"),
            "uploaded_to_this_item" => __("Upload to this Subscriber", "custom-post-type-ui"),
            "filter_items_list" => __("Filter Subscribers list", "custom-post-type-ui"),
            "items_list_navigation" => __("Subscribers list navigation", "custom-post-type-ui"),
            "items_list" => __("Subscribers list", "custom-post-type-ui"),
            "attributes" => __("Subscribers attributes", "custom-post-type-ui"),
            "name_admin_bar" => __("Subscriber", "custom-post-type-ui"),
            "item_published" => __("Subscriber published", "custom-post-type-ui"),
            "item_published_privately" => __("Subscriber published privately.", "custom-post-type-ui"),
            "item_reverted_to_draft" => __("Subscriber reverted to draft.", "custom-post-type-ui"),
            "item_scheduled" => __("Subscriber scheduled", "custom-post-type-ui"),
            "item_updated" => __("Subscriber updated.", "custom-post-type-ui"),
            "parent_item_colon" => __("Parent Subscriber:", "custom-post-type-ui"),
        ];

        $args = [
            "label" => __("Subscribers", "custom-post-type-ui"),
            "labels" => $labels,
            "description" => "",
            "public" => false,
            "publicly_queryable" => false,
            "show_ui" => true,
            "show_in_rest" => true,
            "rest_base" => "",
            "rest_controller_class" => "WP_REST_Posts_Controller",
            "has_archive" => false,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "delete_with_user" => false,
            "exclude_from_search" => false,
            "capability_type" => "post",
            "map_meta_cap" => true,
            "hierarchical" => false,
            "rewrite" => ["slug" => "subscribers", "with_front" => true],
            "query_var" => true,
            "menu_icon" => "dashicons-bell",
            "supports" => ["title", "custom-fields"],
            "show_in_graphql" => false,
        ];

        register_post_type("subscriber", $args);
    }
}
