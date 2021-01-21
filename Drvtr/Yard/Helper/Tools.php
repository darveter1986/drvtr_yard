<?php


namespace Drvtr\Yard\Helper;


use Drvtr\Yard\Api\Tools\DumperInterface;
use Drvtr\Yard\Api\Tools\LoggerPoolInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

/**
 * Class Tools
 */
class Tools extends AbstractHelper
{
    /**
     * @var LoggerPoolInterface
     */
    private $loggerPool;

    /**
     * @var DumperInterface
     */
    private $dumper;

    /**
     * Tools constructor.
     * @param Context $context
     * @param LoggerPoolInterface $loggerPool
     * @param DumperInterface $dumper
     */
    public function __construct(
        Context $context,
        LoggerPoolInterface $loggerPool,
        DumperInterface $dumper
    ) {
        parent::__construct($context);
        $this->loggerPool = $loggerPool;
        $this->dumper = $dumper;
    }

    /**
     * @return LoggerPoolInterface
     */
    public function logs()
    {
        return $this->loggerPool;
    }

    /**
     * @return DumperInterface
     */
    public function writer()
    {
        return $this->dumper;
    }
}
