<?php
/**
 * ManagerInterface.php
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

use Phalcon\DI\InjectionAwareInterface;
use Phalcon\Events\EventsAwareInterface;
use Phalcon\DI\Service;

/**
 * Interface ManagerInterface
 * @package Phalcon\Ext\Widgets
 */
interface ManagerInterface extends EventsAwareInterface, InjectionAwareInterface
{
    /**
     * Renders the widget
     *
     * @param string $name
     * @param array|null $params
     * @param array|null $options
     *
     * @return string
     * @see \Phalcon\Ext\Widgets\WidgetInterface
     */
    public function render($name, $params = null, $options = null);

    /**
     * Resolves the service of widget based on its configuration
     *
     * @param string $name
     * @param array|null $options
     *
     * @return WidgetInterface
     * @throws \Exception
     *
     * @see \Phalcon\Ext\Widgets\Manager::resolve()
     */
    public function get($name, $options = null);

    /**
     * Registers a widget in the container
     *
     * @param string $name
     * @param string|array|\Closure $definition
     * @param bool $shared
     *
     * @return $this
     *
     * @see \Phalcon\DI\Service
     */
    public function set($name, $definition, $shared = false);

    /**
     * Removes a widget from the container
     *
     * @param string $name
     */
    public function remove($name);

    /**
     * Check whether the Manager contains a widget by a name
     *
     * @param string $name
     *
     * @return bool
     */
    public function has($name);

    /**
     * Returns the corresponding Phalcon\Di\Service instance for a widget
     *
     * @param string $name
     *
     * @return Service
     *
     * @see Phalcon\Di\Service
     */
    public function getService($name);

    /**
     * Return the services registered in the Manager
     *
     * @return \Phalcon\DI\Service[]
     */
    public function getWidgets();
} 