<?php
namespace Affilicious\Detail\Domain\Model;

use Affilicious\Common\Domain\Model\Key;
use Affilicious\Common\Domain\Model\Name;
use Affilicious\Common\Domain\Model\Title;
use Affilicious\Detail\Domain\Model\DetailTemplate\DetailTemplate;

if (!defined('ABSPATH')) {
    exit('Not allowed to access pages directly.');
}

class DetailTemplateGroup
{
    const POST_TYPE = 'detail_group';

	/**
	 * @var DetailTemplateGroupId
	 */
	private $id;

    /**
     * @var Title
     */
    private $title;

    /**
     * @var Name
     */
    private $name;

    /**
     * @var Key
     */
    private $key;

    /**
     * @var DetailTemplate[]
     */
    private $details;

    /**
     * @since 0.6
     * @param Title $title
     * @param Name $name
     * @param Key $key
     */
    public function __construct(Title $title, Name $name, Key $key)
    {
        $this->title = $title;
        $this->name = $name;
        $this->key = $key;
        $this->details = array();
    }

    /**
     * Check if the detail template group has an ID
     *
     * @since 0.6
     * @return bool
     */
    public function hasId()
    {
        return $this->id !== null;
    }

    /**
     * Get the detail template group ID
     *
     * @since 0.6
     * @return DetailTemplateGroupId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the detail template group ID
     *
     * Note that you just get the ID in Wordpress, if you store a post.
     * Normally, you place the ID to the constructor, but it's not possible here
     *
     * @since 0.6
     * @param null|DetailTemplateGroupId $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get the title
     *
     * @since 0.6
     * @return Title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the title
     *
     * @since 0.6
     * @param Title $title
     */
    public function setTitle(Title $title)
    {
        $this->title = $title;
    }

    /**
     * Get the name for url usage
     *
     * @since 0.6
     * @return Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the name for the url usage
     *
     * @since 0.6
     * @param Name $name
     */
    public function setName(Name $name)
    {
        $this->name = $name;
    }

	/**
     * Get the key for database usage
     *
	 * @return Key
	 */
	public function getKey()
	{
		return $this->key;
	}

    /**
     * Check if a detail template with the given key exists
     *
     * @since 0.6
     * @param Key $key
     * @return bool
     */
    public function hasDetail(Key $key)
    {
        return isset($this->details[$key->getValue()]);
    }

    /**
     * Add a new detail template
     *
     * @since 0.6
     * @param DetailTemplate $detail
     */
    public function addDetail(DetailTemplate $detail)
    {
        $this->details[$detail->getKey()->getValue()] = $detail;
    }

    /**
     * Remove an existing detail template by the key
     *
     * @since 0.6
     * @param Key $key
     */
    public function removeDetail(Key $key)
    {
        unset($this->details[$key->getValue()]);
    }

    /**
     * Get an existing detail template by the key
     * You don't need to check for the key, but you will get null on non-existence
     *
     * @since 0.6
     * @param Key $key
     * @return null|DetailTemplate
     */
    public function getDetail(Key $key)
    {
        if($this->hasDetail($key)) {
            return $this->details[$key->getValue()];
        }

        return null;
    }

    /**
     * Get all detail templates
     *
     * @since 0.6
     * @return DetailTemplate[]
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set all detail templates
     *
     * @since 0.6
     * @param DetailTemplate[] $details
     */
    public function setDetails($details)
    {
    	// addDetail checks for the type
    	foreach ($details as $detail) {
    		$this->addDetail($detail);
	    }
    }

    /**
     * Get the raw post
     *
     * @since 0.6
     * @return null|\WP_Post
     */
    public function getRawPost()
    {
        if(!$this->hasId()) {
            return null;
        }

        return get_post($this->id->getValue());
    }
}