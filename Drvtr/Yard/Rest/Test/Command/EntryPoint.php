<?php


namespace Drvtr\Yard\Rest\Test\Command;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;


class EntryPoint
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * productPositionTest constructor.
     * @param State $state
     */
    public function __construct(
        State $state,
        ProductRepositoryInterface $productRepository
    ) {
        $this->state = $state;
        $this->productRepository = $productRepository;
    }

    /**
     * @api
     * @param string $id
     *
     * @return []
     *
     * @throws \Exception
     */
    public function execute($id)
    {
        $result = $this->state->emulateAreaCode(Area::AREA_FRONTEND, function ()
            use ($id) {
                return $this->productRepository->getById($id);
            }
        );

        return $result;
    }
}
