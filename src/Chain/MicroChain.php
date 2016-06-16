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
     * Chain process
     */
    const STATUS_PROCESS = 1;

    /**
     * Chain finished
     */
    const STATUS_FINISHED = 2;

    /**
     * Current param value
     *
     * @var
     */
    private $pointer;

    /**
     * Chain stateful
     *
     * @var int
     */
    private $stateful;

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
        $this->stateful = self::STATUS_PROCESS;
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

        if ($this->stateful === null) {
            throw new MicroChainException('call initialize method first');
        }

        if ($filterCallback === null) {
            $this->stateful = self::STATUS_FINISHED;
        }

        if (!class_exists($className)) {
            throw new InvalidArgumentException($className . ' does not exist ');
        }

        $model = new $className();

        $result = $model->$method($this->pointer);

        if ($this->stateful !== self::STATUS_FINISHED) {
            $this->pointer = $filterCallback($result);
        } else {
            $this->pointer = null;
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStateful()
    {
        return $this->stateful;
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


