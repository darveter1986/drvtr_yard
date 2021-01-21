<?php


namespace Drvtr\Yard\Api\Tools;

/**
 * Interface DumperInterface
 */
interface DumperInterface
{
    /**
     * @param string $fileName //EXAMPLE: 'var/drvtr/%date%-debug-files/%increment%-output.txt'
     * @param mixed $content
     * @param bool $prettyPrint
     */
    public function dump($fileName, $content, $prettyPrint = true);
}
