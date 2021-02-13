<?php
declare(strict_types = 1);

namespace RobotessNet;

trait Singleton
{
    /**
     * @var self|null
     */
    private static $instance;

    private function __construct()
    { /***/ }

    /**
     * @return self
     */
    public static function instance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}