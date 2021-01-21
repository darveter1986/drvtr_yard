<?php


namespace Drvtr\Yard\Plugin\Signifyd;


use Drvtr\Yard\Api\Tools\DumperInterface;
use Drvtr\Yard\Api\Tools\LoggerPoolInterface;
use Signifyd\Connect\Controller\Webhooks\Index as Subject;


class ControllerWebhooksPlugin
{
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

    public function beforeProcessRequest(Subject $subject, $request, $hash, $topic)
    {
        try {
            $this->dumper->dump( 'var/drvtr/%date%-Signifyd/%increment%-request_b.json', $request, );
            $this->dumper->dump( 'var/drvtr/%date%-Signifyd/%increment%-hash.txt', $hash, );
            $this->dumper->dump( 'var/drvtr/%date%-Signifyd/%increment%-topic.txt', $topic, );

        } catch (\Exception $exception) {
            $this->logs->get('var/drvtr/errors.log')->error($exception->getMessage());
        }

        return [$request, $hash, $topic];
    }
}
