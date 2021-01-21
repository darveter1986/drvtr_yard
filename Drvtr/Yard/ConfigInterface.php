<?php


namespace Drvtr\Yard;

/**
 * Interface Config
 */
interface ConfigInterface
{
    const DUMPER_LOG_PATH = 'var/drvtr/dumper.log';
    const DEFAULT_LOG_NAME = 'var/drvtr/default.log';

    /**
     * EXAMPLE:
     * \Drvtr\Yard\Tools::dump( 'var/dev/%date%-dumps/%increment%-output.txt', $items, true);
     */
    const DEFAULT_DEBUG_FILE_PATTERN = 'var/drvtr/%date%-dumps/%increment%-output.txt';
}
