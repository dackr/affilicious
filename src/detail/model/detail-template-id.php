<?php
namespace Affilicious\Detail\Model;

use Affilicious\Common\Model\Simple_Value_Trait;
use Webmozart\Assert\Assert;

if (!defined('ABSPATH')) {
    exit('Not allowed to access pages directly.');
}

class Detail_Template_Id
{
    use Simple_Value_Trait {
        Simple_Value_Trait::__construct as private set_value;
    }

    /**
     * @since 0.8
     * @param int $value
     */
	public function __construct($value)
	{
        if (is_numeric($value) || is_string($value)) {
            $value = intval($value);
        }

        Assert::integer($value, 'Expected detail template ID to be an integer. Got: %s');

		$this->set_value($value);
	}
}
