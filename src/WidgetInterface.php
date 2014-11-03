<?php
/**
 * WidgetInterface.php
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

use Phalcon\Mvc\ViewInterface;

/**
 * Interface WidgetInterface
 * @package Phalcon\Ext\Widgets
 */
interface WidgetInterface
{
    /**
     * Create a new Widget component using $options for configuring widget
     *
     * @param array|null $options
     */
    public function __construct($options = null);

    /**
     * Renders the widget
     *
     * @param array|null $params
     *
     * @return string
     */
    public function render($params = null);

    /**
     * Set options for configuring widget
     *
     * @param array|null $options
     *
     * @return $this
     */
    public function setOptions($options);

    /**
     * Get options for configuring widget
     *
     * @param string|null $key
     * @param mixed|null $default
     *
     * @return mixed|null
     */
    public function getOptions($key = null, $default = null);

    /**
     * Sets the view service
     *
     * @param ViewInterface $view
     *
     * @return $this
     */
    public function setView(ViewInterface $view);

    /**
     * Gets the view service
     *
     * @return ViewInterface
     */
    public function getView();

}