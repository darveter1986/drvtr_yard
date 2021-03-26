<?php


namespace Drvtr\Yard;

use Drvtr\Yard\Api\Tools\DumperInterface;
use Drvtr\Yard\Api\Tools\LoggerPoolInterface;
use Magento\Framework\App\ObjectManager;
use Psr\Log\LoggerInterface;

/**
 * Class Yard
 */
class Tools
{
    /**
     * @param $filename
     * @return LoggerInterface
     */
    public static function getLogger($filename)
    {
        $loggerPool =  ObjectManager::getInstance()->get(LoggerPoolInterface::class);
        return $loggerPool->get($filename);
    }

    /**
     * @return void
     */
    public static function dump($fileName, $content, $prettyPrint = true)
    {
        $dumper =  ObjectManager::getInstance()->get(DumperInterface::class);
        return $dumper->dump($fileName, $content, $prettyPrint);
    }
}
