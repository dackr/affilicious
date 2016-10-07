<?php
namespace Affilicious\Attribute\Application\Setup;

use Affilicious\Common\Application\Setup\SetupInterface;
use Affilicious\Attribute\Domain\Model\AttributeTemplate\Type;
use Affilicious\Attribute\Domain\Model\AttributeTemplateGroup;
use Affilicious\Attribute\Infrastructure\Persistence\Carbon\CarbonAttributeTemplateGroupRepository;
use Carbon_Fields\Container as CarbonContainer;
use Carbon_Fields\Field as CarbonField;

if (!defined('ABSPATH')) {
    exit('Not allowed to access pages directly.');
}

class AttributeTemplateGroupSetup implements SetupInterface
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $singular = __('Attribute Template Group', 'affilicious');
        $plural = __('Attribute Template Groups', 'affilicious');
        $labels = array(
            'name'                  => $plural,
            'singular_name'         => $singular,
            'menu_name'             => $singular,
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
            'uploaded_to_this_item' => sprintf(_x('Uploaded To This %s', 'Attribute Template', 'affilicious'), $singular),
            'items_list'            => $plural,
            'items_list_navigation' => sprintf(_x('%s Navigation', 'Attribute Template', 'affilicious'), $singular),
            'filter_items_list'     => sprintf(_x('Filter %s', 'Attribute Template', 'affilicious'), $plural),
        );

        register_post_type(AttributeTemplateGroup::POST_TYPE, array(
            'labels' => $labels,
            'public' => false,
            'menu_icon' => false,
            'show_ui' => true,
            '_builtin' => false,
            'menu_position' => 4,
            'capability_type' => 'page',
            'hierarchical' => true,
            'rewrite' => false,
            'query_var' => AttributeTemplateGroup::POST_TYPE,
            'supports' => array('title'),
            'show_in_menu' => 'edit.php?post_type=product',
        ));
    }

    /**
     * @inheritdoc
     */
    public function render()
    {
        $carbonContainer = CarbonContainer::make('post_meta', __('Attribute Templates', 'affilicious'))
            ->show_on_post_type(AttributeTemplateGroup::POST_TYPE)
            ->add_fields(array(
                CarbonField::make('complex', CarbonAttributeTemplateGroupRepository::ATTRIBUTES, __('Attributes', 'affilicious'))
                    ->add_fields(array(
                        CarbonField::make('text', CarbonAttributeTemplateGroupRepository::ATTRIBUTE_TITLE, __('Title', 'affilicious'))
                            ->set_required(true),
                        CarbonField::make('select', CarbonAttributeTemplateGroupRepository::ATTRIBUTE_TYPE, __('Type', 'affilicious'))
                            ->set_required(true)
                            ->add_options(array(
                                Type::TEXT => __('Text', 'affilicious'),
                                Type::NUMBER => __('Number', 'affilicious'),
                            )),
                        CarbonField::make('text', CarbonAttributeTemplateGroupRepository::ATTRIBUTE_VALUE, __('Value', 'affilicious')),
                        CarbonField::make('text', CarbonAttributeTemplateGroupRepository::ATTRIBUTE_HELP_TEXT, __('Help Text', 'affilicious'))
                    ))
                    ->set_header_template('
                        <# if (' . CarbonAttributeTemplateGroupRepository::ATTRIBUTE_TITLE . ') { #>
                            {{ ' . CarbonAttributeTemplateGroupRepository::ATTRIBUTE_TITLE . ' }}
                        <# } #>
                    ')
            ));

        apply_filters('affilicious_attribute_template_group_render_attribute_templates', $carbonContainer);
    }
}