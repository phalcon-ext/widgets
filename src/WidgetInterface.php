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
     * @param array $options
     */
    public function __construct(Array $options = []);

    /**
     * Called after __construct
     *
     * @return void
     */
    public function onConstruct();

    /**
     * @param array $params
     *
     * @return string
     */
    public function render(Array $params = []);

    /**
     * Set options for configuring widget
     *
     * @param array $options
     *
     * @return $this
     */
    public function setOptions(Array $options);

    /**
     * Get options for configuring widget
     *
     * @param null $key
     * @param null $default
     *
     * @return mixed|null
     */
    public function getOptions($key = null, $default = null);

    /**
     * @param ViewInterface $view
     *
     * @return $this
     */
    public function setView(ViewInterface $view);

    /**
     * @return ViewInterface
     */
    public function getView();

} 