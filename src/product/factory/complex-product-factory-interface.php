<?php
namespace Affilicious\Product\Factory;

use Affilicious\Common\Model\Name;
use Affilicious\Common\Model\Slug;
use Affilicious\Product\Model\Complex_Product;

if (!defined('ABSPATH')) {
    exit('Not allowed to access pages directly.');
}

interface Complex_Product_Factory_Interface
{
    /**
     * Create a new complex product.
     *
     * @since 0.8
     * @param Name $name
     * @param Slug $slug
     * @return Complex_Product
     */
    public function create(Name $name, Slug $slug);
}
