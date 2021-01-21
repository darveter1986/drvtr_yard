<?php


namespace Drvtr\Yard\Api\Tools;


use Psr\Log\LoggerInterface;

/**
 * Interface LoggerPoolInterface
 */
interface LoggerPoolInterface
{
    /**
     * @param string|null $fileName
     * @return LoggerInterface
     */
    public function get($fileName = null);
}
