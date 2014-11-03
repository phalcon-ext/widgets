<?php
/**
 * WidgetBase.php
 * ----------------------------------------------
 *
 * @author      Stanislav Kiryukhin <korsar.zn@gmail.com>
 * @copyright   Copyright (c) 2014, CKGroup.ru
 *
 * ----------------------------------------------
 * All Rights Reserved.
 * ----------------------------------------------
 */
namespace Phalcon\Ext\Widgets;

use Phalcon\Mvc\User\Component;
use Phalcon\Mvc\View\Simple as ViewSimple;
use Phalcon\Mvc\ViewInterface;

/**
 * Class WidgetBase
 * @package Phalcon\Ext\Widgets
 */
abstract class WidgetBase extends Component implements WidgetInterface
{
    const VIEW_DIR_NAME = 'widgets';

    /**
     * @var array
     */
    protected $_options = [];

    /**
     * @var ViewInterface
     */
    protected $_view;

    /**
     * Create a new Widget component using $options for configuring widget
     *
     * @param array $options
     */
    public function __construct(Array $options = [])
    {
        $this->setOptions($options);

        /**
         * Called after __construct
         */
        if (method_exists($this, 'onConstruct')) {
            $this->onConstruct();
        }
    }

    /**
     * Set options for configuring widget
     *
     * @param array $options
     *
     * @return $this
     */
    public function setOptions(Array $options)
    {
        $this->_options = array_merge($this->getDefaultOptions(), $options);

        return $this;
    }

    /**
     * Get options for configuring widget
     *
     * @param null $key
     * @param null $default
     *
     * @return mixed|null
     */
    public function getOptions($key = null, $default = null)
    {
        if ($key !== null) {
            return isset($this->_options[$key]) ? $this->_options[$key] : $default;
        } else {
            return $this->_options;
        }
    }

    /**
     * @param ViewInterface $view
     * @return $this
     */
    public function setView(ViewInterface $view)
    {
        $this->_view = $view;

        return $this;
    }

    /**
     * @return ViewSimple|ViewInterface
     */
    public function getView()
    {
        if (!$this->_view) {

            $defaultViewsDir = $this->getDI()->get('view')->getViewsDir() . '/' . static::VIEW_DIR_NAME . '/';

            $this->_view = new ViewSimple();
            $this->_view->setViewsDir($this->getOptions('viewsDir', $defaultViewsDir));
        }

        return $this->_view;
    }

    /**
     * @return array
     */
    protected function getDefaultOptions()
    {
        return [];
    }
} 