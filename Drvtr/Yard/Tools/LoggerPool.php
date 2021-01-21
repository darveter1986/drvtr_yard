<?php


namespace Drvtr\Yard\Tools;


use Drvtr\Yard\ConfigInterface;
use Drvtr\Yard\Api\Tools\LoggerPoolInterface;
use Magento\Framework\Logger\Handler\Base as BaseHandler;
use Magento\Framework\Logger\Handler\BaseFactory as BaseHandlerFactory;
use Magento\Framework\Logger\MonologFactory as LogFactory;
use Psr\Log\LoggerInterface;


/**
 * Class LoggerPool
 */
class LoggerPool implements LoggerPoolInterface
{
    /**
     * @var LoggerInterface[]
     */
    private $loggers = [];

    /**
     * @var BaseHandlerFactory
     */
    private $baseHandlerFactory;

    /**
     * @var LogFactory
     */
    private $logFactory;

    /**
     * LoggerPool constructor.
     * @param BaseHandlerFactory $baseHandlerFactory
     * @param LogFactory $logFactory
     */
    public function __construct(
        BaseHandlerFactory $baseHandlerFactory,
        LogFactory $logFactory
    ) {
        $this->baseHandlerFactory = $baseHandlerFactory;
        $this->logFactory = $logFactory;
    }

    /**
     * @param string|null $fileName
     * @return LoggerInterface
     */
    public function get($fileName = null)
    {
        if (!isset($this->loggers[$fileName])) {
            /** @var BaseHandler $baseHandler */
            $baseHandler = $this->baseHandlerFactory->create(
                [
                    'fileName' => $fileName ? $fileName : ConfigInterface::DEFAULT_LOG_NAME
                ]
            );
            /** @var LoggerInterface $logger */
            $logger = $this->logFactory->create(
                [
                    'name' => $fileName ? $fileName : ConfigInterface::DEFAULT_LOG_NAME,
                    'handlers' => [
                        'system' => $baseHandler
                    ]
                ]
            );

            $this->loggers[$fileName] = $logger;
        }
        return $this->loggers[$fileName];
    }
}
