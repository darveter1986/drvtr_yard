<?php


namespace Drvtr\Yard\Plugin;


use Drvtr\Yard\Api\Tools\DumperInterface;
use Drvtr\Yard\Api\Tools\LoggerPoolInterface;
use Taxjar\SalesTax\Model\Client as TaxjarClient;

class TaxjarClientPlugin
{
    const TAG = '[TAXJARCLIENT]';

    /**
     * @var DumperInterface
     */
    private $dumper;

    /**
     * @var LoggerPoolInterface
     */
    private $logs;

    /**
     * TaxjarClientPlugin constructor.
     * @param DumperInterface $dumper
     * @param LoggerPoolInterface $logs
     */
    public function __construct(
        DumperInterface $dumper,
        LoggerPoolInterface $logs
    ) {
        $this->dumper = $dumper;
        $this->logs = $logs;
    }

    /**
     * @see TaxjarClient::postResource()
     */
    public function beforePostResource(TaxjarClient $subject, $resource, $data, $errors = [])
    {
        $this->dumper->dump( 'var/drvtr/%date%-Taxjar/%increment%-postResource.json', $data, true);
        return [$resource, $data, $errors];
    }

    /**
     * @see TaxjarClient::postResource()
     */
    public function beforePutResource(TaxjarClient $subject, $resource, $resourceId, $data, $errors = [])
    {
        $this->dumper->dump( 'var/drvtr/%date%-Taxjar/%increment%-putResource.json', $data, true);
        return [$resource, $data, $errors];
    }

    /**
     * @see TaxjarClient::getResource()
     *
     * @param TaxjarClient $subject
     * @param $result
     * @return mixed
     */
    public function afterGetResource(TaxjarClient $subject, $result)
    {
        $this->dumper->dump( 'var/drvtr/%date%-Taxjar/%increment%-getResource.txt', $result, true);
        return $result;
    }
}
