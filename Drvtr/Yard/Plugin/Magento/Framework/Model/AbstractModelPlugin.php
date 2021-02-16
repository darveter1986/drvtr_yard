<?php
/**
 * AbstractModelPlugin
 *
 * @copyright Copyright © 2019 Dmitry Shkoliar. All rights reserved.
 * @author    dmitry@shkoliar.com
 */

namespace Drvtr\Yard\Plugin\Magento\Framework\Model;

use Magento\Framework\Model\AbstractModel;
use Drvtr\Yard\Tools\XDebugHelper;

/**
 * Class AbstractModelPlugin
 */
class AbstractModelPlugin
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
     * @param AbstractModel $subject
     * @param string|array  $key
     * @param mixed         $value
     *
     * @return array|null
     */
    public function beforeSetData(AbstractModel $subject, $key, $value = null)
    {
        $this->debugHelper->check($key, $value);

        return null;
    }
}
