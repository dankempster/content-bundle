<?php

namespace Symfony\Cmf\Bundle\ContentBundle\Model;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCRODM;

use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Cmf\Component\Routing\RouteAwareInterface;
use Symfony\Cmf\Component\Routing\RouteObjectInterface;
use Symfony\Cmf\Component\Routing\RouteReferrersWriteInterface;

use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishTimePeriodWriteInterface;
use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishableWriteInterface;
use Symfony\Cmf\Bundle\MenuBundle\Model\MenuNode;

/**
 * Standard implementation of StaticContent:
 *
 * Standard features:
 *
 * - Publish workflow
 * - Translatable
 * - RouteAware
 * - MenuAware
 *
 * Bundle specific:
 *
 * - Tags
 * - Additional Info Block
 */
class StaticContent extends StaticContentBase implements
    RouteAwareInterface,
    MenuReferrersWriteInterface,
    RouteReferrersWriteInterface,
    PublishTimePeriodWriteInterface,
    PublishableWriteInterface
{
    /**
     * @var boolean whether this content is publishable
     */
    protected $publishable = true;

    /**
     * @var \DateTime|null publication start time
     */
    protected $publishStartDate;

    /**
     * @var \DateTime|null publication end time
     */
    protected $publishEndDate;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var RouteObjectInterface[]
     */
    protected $routes;

    /**
     * MenuNode[]
     */
    protected $menus;

    /**
     * @var string[]
     */
    protected $tags = array();

    /**
     * Hashmap for application data associated to this document. Both keys and
     * values must be strings.
     */
    protected $extras;

    /**
     * This will usually be a ContainerBlock but can be any block that will be
     * rendered in the additionalInfoBlock area.
     *
     * @var \Sonata\BlockBundle\Model\BlockInterface
     */
    protected $additionalInfoBlock;

    public function __construct()
    {
        $this->routes = new ArrayCollection();
        $this->menus = new ArrayCollection();
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    public function getAdditionalInfoBlock()
    {
        return $this->additionalInfoBlock;
    }

    public function setAdditionalInfoBlock($block)
    {
        $this->additionalInfoBlock = $block;
    }

    /**
     * Set if the content is publishable
     *
     * @param boolean $publishable
     */
    public function setPublishable($publishable)
    {
        return $this->publishable = (bool) $publishable;
    }

    /**
     * Is publishable
     *
     * @return boolean $publishable
     */
    public function isPublishable()
    {
        return $this->publishable;
    }

    /**
     * Get the publish start date
     */
    public function getPublishStartDate()
    {
        return $this->publishStartDate;
    }

    public function setPublishStartDate(\DateTime $publishStartDate = null)
    {
        $this->publishStartDate = $publishStartDate;
    }

    /**
     * Get the publish end date
     */
    public function getPublishEndDate()
    {
        return $this->publishEndDate;
    }

    public function setPublishEndDate(\DateTime $publishEndDate = null)
    {
        $this->publishEndDate = $publishEndDate;
    }

    /**
     * Get the application information associated with this document
     *
     * @return array
     */
    public function getExtras()
    {
        return $this->extras;
    }

    /**
     * Get a single application information value
     *
     * @param string      $name
     * @param string|null $default
     *
     * @return string|null the value at $name if set, null otherwise
     */
    public function getExtra($name, $default = null)
    {
        return isset($this->extras[$name]) ? $this->extras[$name] : $default;
    }

    /**
     * Set the application information
     *
     * @param array $extras
     *
     * @return StaticContent - this instance
     */
    public function setExtras(array $extras)
    {
        $this->extras = $extras;

        return $this;
    }

    /**
     * Set a single application information value.
     *
     * @param string $name
     * @param string $value the new value, null removes the entry
     *
     * @return StaticContent - this instance
     */
    public function setExtra($name, $value)
    {
        if (is_null($value)) {
            unset($this->extras[$name]);
        } else {
            $this->extras[$name] = $value;
        }

        return $this;
    }

    /**
     * @param \Symfony\Cmf\Bundle\RoutingBundle\Document\Route $route
     */
    public function addRoute($route)
    {
        $this->routes->add($route);
    }

    /**
     * @param \Symfony\Cmf\Bundle\RoutingBundle\Document\Route $route
     */
    public function removeRoute($route)
    {
        $this->routes->removeElement($route);
    }

    /**
     * @return \Symfony\Component\Routing\Route[] Route instances that point to this content
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @param MenuNode $menu
     */
    public function addMenu($menu)
    {
        $this->menus->add($menu);
    }

    /**
     * @param MenuNode $menu
     */
    public function removeMenu($menu)
    {
        $this->menus->removeElement($menu);
    }

    /**
     * @return ArrayCollection of MenuNode that point to this content
     */
    public function getMenus()
    {
        return $this->menus;
    }

}
