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
//        if (isset($query['body']['query']['bool']['must'])) {
//            $query['body']['query']['bool']['must'][] = [
//                'term' => [
//                    'tx_sub_category_id' => '43'
//                ]
//            ];
//        }

//        if (isset($query['body']['sort'][0]['manufacturer'])) {
//            unset($query['body']['sort'][0]);
//            $query['body']['sort'][] = [
//                [
//                    'manufacturer_value' => ['order' => 'asc']
//                ]
//            ];
//        }
//        $query['body']['sort'] = [
//            [
//                'position_category_581' => ['order' => 'asc']
//            ]
//        ];
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
