<?php


namespace Drvtr\Yard\Plugin\Elasticsearch;


use Drvtr\Yard\Api\Tools\DumperInterface;
use Drvtr\Yard\Api\Tools\LoggerPoolInterface;
use Magento\Elasticsearch6\Model\Client\Elasticsearch;

/**
 * Class ClientPlugin
 */
class ClientPlugin
{
    const TAG = '[ELASTICSEARCH]';

    /**
     * @var DumperInterface
     */
    private $dumper;

    /**
     * @var LoggerPoolInterface
     */
    private $logs;

    /**
     * ClientPlugin constructor.
     */
    public function __construct(
        DumperInterface $dumper,
        LoggerPoolInterface $logs
    ) {
        $this->dumper = $dumper;
        $this->logs = $logs;
    }

    /**
     * @see Elasticsearch::query()
     * @param Elasticsearch $subject
     * @param array $query
     */
    public function beforeQuery(Elasticsearch $subject, $query)
    {
        \Drvtr\Yard\Tools::getLogger('var/dev/sorting')->info('ES Query');
        $this->dumper->dump( 'var/dev/%date%-layer-issue/%increment%-es-query.json', $query, true);
        return [$query];
    }

    /**
     * @param Elasticsearch $subject
     * @param array $query
     */
    public function afterQuery(Elasticsearch $subject, $result)
    {
        $this->dumper->dump( 'var/dev/%date%-layer-issue/%increment%-es-result.json', $result, true);
        return $result;
    }
}
