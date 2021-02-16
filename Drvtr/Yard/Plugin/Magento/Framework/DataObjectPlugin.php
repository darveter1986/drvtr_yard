<?php
/**
 * DataObjectPlugin
 *
 * @copyright Copyright © 2019 Dmitry Shkoliar. All rights reserved.
 * @author    dmitry@shkoliar.com
 */

namespace Drvtr\Yard\Plugin\Magento\Framework;

use Magento\Framework\DataObject;
use Drvtr\Yard\Tools\XDebugHelper;

/**
 * Class DataObjectPlugin
 */
class DataObjectPlugin
{
    /**
     * @var XDebugHelper
     */
    protected $debugHelper;

    /**
     * @param XDebugHelper   $debugHelper
     */
    public function __construct(XDebugHelper $debugHelper)
    {
        $this->debugHelper = $debugHelper;
    }

    /**
     * @param DataObject    $subject
     * @param string|array  $key
     * @param mixed         $value
     *
     * @return array|null
     */
    public function beforeSetData(DataObject $subject, $key, $value = null)
    {
        $this->debugHelper->check($key, $value);

        return null;
    }
}
