<?php

namespace Chain;

/**
 * Interface InterfaceChain
 * @package Chain
 */
interface InterfaceChain
{
    /**
     * @param string $className
     * @param string $method
     * @param callable      $filterCallback
     * @param null          $argv
     *
     * @return InterfaceChain
     */
    public function initialize($className, $method, callable $filterCallback, $argv = null): InterfaceChain;

    /**
     * @param string $className
     * @param string $method
     * @param callable|null $filterCallback
     *
     * @return InterfaceChain
     */
    public function link($className, $method, callable $filterCallback = null): InterfaceChain;
}