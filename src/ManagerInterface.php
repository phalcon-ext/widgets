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
use Phalcon\Events\EventsAwareInterface;
use Phalcon\DI\Service;

/**
 * Class Manager
 * @package Phalcon\Ext\Widgets
 */
interface ManagerInterface extends EventsAwareInterface, InjectionAwareInterface
{
    /**
     * @param $name
     * @param array $params
     *
     * @return string
     */
    public function render($name, Array $params = []);

    /**
     * @param $name
     * @param array $options
     *
     * @return WidgetInterface
     * @throws \Exception
     */
    public function get($name, Array $options = []);

    /**
     * @param $name
     * @param $definition
     * @param bool $shared
     *
     * @return $this
     */
    public function set($name, $definition, $shared = false);

    /**
     * @param $name
     */
    public function remove($name);

    /**
     * @param $name
     *
     * @return bool
     */
    public function has($name);

    /**
     * @param $name
     *
     * @return Service
     */
    public function getService($name);

    /**
     * @return \Phalcon\DI\Service[]
     */
    public function getWidgets();
} 