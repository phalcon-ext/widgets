<?php
/**
 * Manager.php
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
use Phalcon\Mvc\User\Component;
use Phalcon\DI\Service;

/**
 * Class Manager
 * @package Phalcon\Ext\Widgets
 */
class Manager extends Component
{
    /**
     * @var Service[]
     */
    protected $_widgets = [];

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
    public function render($name, $params = null, $options = null)
    {
        return $this->get($name, $options)->render($params);
    }

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
    public function get($name, $options = null)
    {
        if ($this->has($name)) {
            return $this->resolve($name, $options);
        } else {
            $this->throwNotFound($name);
            return false;
        }
    }

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
    public function set($name, $definition, $shared = false)
    {
        /** @var $widget \Phalcon\DI\Service */
        $widget = $this->getDI()->get('\Phalcon\DI\Service', [$name, $definition, $shared]);
        $this->_widgets[$name] = $widget;

        return $this;
    }

    /**
     * Removes a widget from the container
     *
     * @param string $name
     */
    public function remove($name)
    {
        unset($this->_widgets[$name]);
    }

    /**
     * Check whether the Manager contains a widget by a name
     *
     * @param string $name
     *
     * @return bool
     */
    public function has($name)
    {
        return isset($this->_widgets[$name]);
    }

    /**
     * Returns the corresponding Phalcon\Di\Service instance for a widget
     *
     * @param string $name
     *
     * @return Service
     *
     * @see Phalcon\Di\Service
     */
    public function getService($name)
    {
        if ($this->has($name)) {
            return $this->_widgets[$name];
        } else {
            $this->throwNotFound($name);
            return false;
        }
    }

    /**
     * Return the services registered in the Manager
     *
     * @return \Phalcon\DI\Service[]
     */
    public function getWidgets()
    {
        return $this->_widgets;
    }

    /**
     * Resolves the widget
     *
     * @param string $name
     * @param array|null $options
     *
     * @return WidgetInterface
     */
    protected function resolve($name, $options = null)
    {
        $widget = $this->getService($name);
        $wDefinition = $widget->getDefinition();

        if (is_array($wDefinition) && !$widget->isResolved()) {

            if (isset($wDefinition['path']) && !class_exists($wDefinition['className'], false)) {
                include_once $wDefinition['path'];
            }

            if (isset($wDefinition['options'])) {
                $options = array_merge($wDefinition['options'], $options);
            }
        }

        $instance = $widget->resolve([$options], $this->getDI());

        if ($instance instanceof InjectionAwareInterface) {
            $instance->setDI($this->getDI());
        }

        return $instance;
    }

    /**
     * @param string $name
     * @throws \Exception
     */
    protected function throwNotFound($name)
    {
        throw new \Exception('Widget "' . $name . '" wasn\'t found in the container');
    }
} 