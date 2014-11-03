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
     * @param $name
     * @param array $params
     *
     * @return string
     */
    public function render($name, Array $params = [])
    {
        return $this->get($name)->render($params);
    }

    /**
     * @param $name
     * @param array $options
     *
     * @return WidgetInterface
     * @throws \Exception
     */
    public function get($name, Array $options = [])
    {
        if ($this->has($name)) {
            return $this->resolve($name, $options);
        } else {
            $this->throwNotFound($name);
            return false;
        }
    }

    /**
     * @param $name
     * @param $definition
     * @param bool $shared
     *
     * @return $this
     */
    public function set($name, $definition, $shared = false)
    {
        /** @var $widget \Phalcon\DI\Service */
        $widget = $this->getDI()->get('\Phalcon\DI\Service', [$name, $definition, $shared]);
        $this->_widgets[$name] = $widget;

        return $this;
    }

    /**
     * @param $name
     */
    public function remove($name)
    {
        unset($this->_widgets[$name]);
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function has($name)
    {
        return isset($this->_widgets[$name]);
    }

    /**
     * @param $name
     *
     * @return Service
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
     * @return \Phalcon\DI\Service[]
     */
    public function getWidgets()
    {
        return $this->_widgets;
    }

    /**
     * @param $name
     * @param array $options
     *
     * @return WidgetInterface
     */
    protected function resolve($name, Array $options = [])
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

    protected function throwNotFound($name)
    {
        throw new \Exception('Widget "' . $name . '" wasn\'t found in the container');
    }
} 