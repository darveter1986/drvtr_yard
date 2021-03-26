<?php


namespace Drvtr\Yard\Tools;


use Drvtr\Yard\ConfigInterface;
use Drvtr\Yard\Api\Tools\DumperInterface;
use Drvtr\Yard\Api\Tools\LoggerPoolInterface;
use Drvtr\Yard\Lib\Dumpling;
use Drvtr\Yard\Lib\SqlFormatter;
use FilesystemIterator;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem;


/**
 * Class Dumper
 */
class Dumper implements DumperInterface
{
    /**
     * @var DirectoryList
     */
    private $directoryList;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var LoggerPoolInterface
     */
    private $logs;

    /**
     * Dumper constructor.
     * @param DirectoryList $directoryList
     * @param Filesystem $filesystem
     */
    public function __construct(
        DirectoryList $directoryList,
        Filesystem $filesystem,
        LoggerPoolInterface $logs
    ) {
        $this->directoryList = $directoryList;
        $this->filesystem = $filesystem;
        $this->logs = $logs;
    }

    /**
     * @param string $fileName //EXAMPLE: 'var/drvtr/%date%-debug-files/%increment%-output.txt'
     * @param mixed $content
     * @param bool $prettyPrint
     */
    public function dump($fileName, $content, $prettyPrint = true)
    {
        try {
            $filePath = $this->buildPath($fileName);
            $content = $this->format($content, $filePath, $prettyPrint);

            $writeDirectory = $this->filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
            $stream = $writeDirectory->openFile($filePath, 'w+');
            $stream->lock();
            $stream->write($content);
            $stream->unlock();
            $stream->close();
        } catch (\Exception $e) {
            $this->logs->get(ConfigInterface::DUMPER_LOG_PATH)->critical(sprintf('Dumper Exception write file[%s]', $fileName));
            $this->logs->get(ConfigInterface::DUMPER_LOG_PATH)->error($e->getMessage());
            return;
        }
        $formattedFlag = $prettyPrint ? ' [FORMATTED]' : '';
        $this->logs->get(ConfigInterface::DUMPER_LOG_PATH)->info($filePath . $formattedFlag);
    }

    /**
     * @param mixed $content
     * @param string $fileName
     * @param bool $prettyPrint
     * @return string
     */
    private function format($content, $fileName, $prettyPrint)
    {
        $pathParts = pathinfo($fileName);
        $ext = $pathParts['extension'] ?? null;

        if (is_object($content)) {
            $content = Dumpling::D($content, 2);

            if ($content instanceof \DOMDocument) {
                $dom = $content->getDom();
                $dom->formatOutput = true;
                $content = $dom->saveXML();
            }

            return $content;
        }

        if (!$prettyPrint) {
            if (is_string($content)) {
                return $content;
            }
            if (is_array($content)) {
                switch ($ext) {
                    case 'json':
                        $content = json_encode($content);
                        break;
                    case 'txt':
                        $content = Dumpling::D($content, 4);
                        break;
                    default :
                        $content = Dumpling::D($content, 4);
                }
                return $content;
            }
        }

        if (is_string($content)) {
            switch ($ext) {
                case 'json':
                    $content = json_encode(json_decode($content), JSON_PRETTY_PRINT);
                    break;
                case 'sql':
                    $content = SqlFormatter::format((string) $content, false);
                    break;
                case 'html':
                    break;
            }
            return $content;
        }

        if (is_array($content)) {
            $deep = 8;
            foreach ($content as $item) {
                if (is_object($item)) {
                    $deep = 4;
                    break;
                }
            }
            switch ($ext) {
                case 'json':
                    $content = json_encode($content, JSON_PRETTY_PRINT);
                    break;
                case 'txt':
                    $content = Dumpling::D($content, $deep);
                    break;
                default :
                    $content = Dumpling::D($content, $deep);
            }
            return $content;
        }

        return $content;
    }

    /**
     * @param string $dir
     * @param string $fileName
     * @throws FileSystemException
     */
    private function buildPath($fileName)
    {
        if (false === strpos($fileName, 'var/')) {
            $this->logs->get(ConfigInterface::DUMPER_LOG_PATH)
                ->warning(sprintf('Incorrect path [%s]. #/var/* path is required. Redirect output to DEFAULT_DEBUG_FILE_PATTERN', $fileName));
            $fileName = ConfigInterface::DEFAULT_DEBUG_FILE_PATTERN;
        }

        $fileName = trim($fileName, '/');
        $fileName = ltrim($fileName, 'var/');
        $fileName = $this->directoryList->getPath(DirectoryList::VAR_DIR) . '/' . $fileName;

        $fileName = str_replace('%date%', $this->getDate() , $fileName);
        $pathParts = pathinfo($fileName);
        $path = $pathParts['dirname'] ?? 'var';
        $fileName = str_replace('%increment%', $this->getFileIncrement($path), $fileName);

        return $fileName;
    }

    /**
     * @return string
     */
    private function getDate()
    {
        return date('ymd');
    }

    /**
     * Pattern 1001, 1002, 1003 ...1999
     *
     * @param string $path
     * @return string
     */
    private function getFileIncrement($path)
    {
        $count = 0;
        if (file_exists($path)) {
            $fi = new FilesystemIterator($path, FilesystemIterator::SKIP_DOTS);
            $count = iterator_count($fi);
        }
        $count++;
        return '1' . str_pad($count,3, '0', STR_PAD_LEFT);
    }
}
