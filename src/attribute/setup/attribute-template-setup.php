<?php
namespace Affilicious\Attribute\Setup;

use Affilicious\Attribute\Model\Attribute_Template;
use Affilicious\Attribute\Model\Type;
use Affilicious\Attribute\Repository\Carbon\Carbon_Attribute_Template_Repository;
use Affilicious\Product\Model\Product;
use Carbon_Fields\Container as Carbon_Container;
use Carbon_Fields\Field as Carbon_Field;

if (!defined('ABSPATH')) {
    exit('Not allowed to access pages directly.');
}

class Attribute_Template_Setup
{
    /**
     * @hook init
     * @since 0.8
     */
    public function init()
    {
        do_action('affilicious_attribute_template_setup_before_init');

        $singular = __('Attribute Template', 'affilicious');
        $plural = __('Attribute Templates', 'affilicious');
        $labels = array(
            'name'                  => $plural,
            'singular_name'         => $singular,
            'menu_name'             => __('Attributes', 'affilicious'),
            'name_admin_bar'        => $singular,
            'archives'              => sprintf(_x('%s Archives', 'Attribute Template', 'affilicious'), $singular),
            'parent_item_colon'     => sprintf(_x('Parent %s:', 'Attribute Template', 'affilicious'), $singular),
            'all_items'             => __('Attributes', 'affilicious'),
            'add_new_item'          => sprintf(_x('Add New %s', 'Attribute Template', 'affilicious'), $singular),
            'new_item'              => sprintf(_x('New %s', 'Attribute Template', 'affilicious'), $singular),
            'edit_item'             => sprintf(_x('Edit %s', 'Attribute Template', 'affilicious'), $singular),
            'update_item'           => sprintf(_x('Update %s', 'Attribute Template', 'affilicious'), $singular),
            'view_item'             => sprintf(_x('View %s', 'Attribute Template', 'affilicious'), $singular),
            'search_items'          => sprintf(_x('Search %s', 'Attribute Template', 'affilicious'), $singular),
            'insert_into_item'      => sprintf(_x('Insert Into %s', 'Attribute Template', 'affilicious'), $singular),
            'uploaded_to_this_item' => sprintf(_x('Uploaded to this %s', 'Attribute Template', 'affilicious'), $singular),
            'items_list'            => $plural,
            'items_list_navigation' => sprintf(_x('%s Navigation', 'Attribute Template', 'affilicious'), $singular),
            'filter_items_list'     => sprintf(_x('Filter %s', 'Attribute Template', 'affilicious'), $plural),
        );

        register_taxonomy(Attribute_Template::TAXONOMY, Product::POST_TYPE, array(
            'hierarchical'      => false,
            'public'            => false,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => false,
            'show_in_nav_menus' => false,
            'show_tagcloud'     => false,
            'meta_box_cb'       => false,
            'query_var'         => true,
            'description'       => false,
            'rewrite'           => false,
        ));

        do_action('affilicious_attribute_template_setup_after_init');
    }

    /**
     * @hook init
     * @since 0.8
     */
    public function render()
    {
        do_action('affilicious_attribute_template_setup_before_render');

        $carbon_container = Carbon_Container::make('term_meta', __('Attribute Template', 'affilicious'))
            ->show_on_taxonomy(Attribute_Template::TAXONOMY)
            ->add_fields(array(
                Carbon_Field::make('select', Carbon_Attribute_Template_Repository::TYPE, __('Type', 'affilicious'))
                    ->set_required(true)
                    ->add_options(array(
                        Type::TEXT => __('Text', 'affilicious'),
                        Type::NUMBER => __('Number', 'affilicious'),
                    )),
                Carbon_Field::make('text', Carbon_Attribute_Template_Repository::UNIT, __('Unit', 'affilicious'))
                    ->set_conditional_logic(array(
                        'relation' => 'and',
                        array(
                            'field' => Carbon_Attribute_Template_Repository::TYPE,
                            'value' => Type::NUMBER,
                            'compare' => '=',
                        )
                    )),
            ));

        apply_filters('affilicious_attribute_template_render_attribute_template_container', $carbon_container);
        do_action('affilicious_attribute_template_setup_after_render');
    }
}
