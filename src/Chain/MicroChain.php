<?php

namespace Chain;

use InvalidArgumentException;
use MicroChainException;

/**
 * Class MicroChain
 *
 * @package Chain
 * @author robotomzie@gmail.com
 */
class MicroChain implements InterfaceChain
{
    /**
     * Current param value
     *
     * @var
     */
    private $pointer;

    /**
     * @var bool
     */
    private $init;

    /**
     * @param string $className
     * @param string $request
     * @param callable                $filterCallback
     * @param null                    $argv
     *
     * @return $this|MicroChain
     * @throws MicroChainException
     */
    public function initialize($className, $method, callable $filterCallback, $argv = null): InterfaceChain
    {
        $this->pointer = $argv;
        $this->init = true;
        return $this->link($className, $method, $filterCallback);
    }

    /**
     * @param      $className
     * @param      $methodCall
     * @param      $methodFinished
     * @param null $argv
     *
     * @return $this
     */
    public function link($className, $method, callable $filterCallback = null): InterfaceChain
    {
        $result = null;

        if ($this->init === false) {
            throw new MicroChainException('Call the initialization for a start');
        }

        if (!class_exists($className)) {
            throw new InvalidArgumentException($className . ' does not exist ');
        }

        $result = (new $className())->$method($this->pointer);
        
        if ($result === null) {
            throw new NullModelException();
        }

        if ($filterCallback !== null) {
            $this->pointer = $filterCallback($result);
        } else {
            $this->pointer = $result;
        }

        if ($this->pointer === null) {
            throw new NullModelException();
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPointer()
    {
        return $this->pointer;
    }

    /**
     * @return mixed
     */
    public function __invoke()
    {
        return $this->pointer;
    }
}


