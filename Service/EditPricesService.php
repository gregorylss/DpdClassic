<?php
namespace DpdClassic\Service;

use DpdClassic\Model\DpdClassicPriceSliceQuery;
use Thelia\Model\AreaQuery;
use function PHPUnit\Framework\throwException;

readonly class EditPricesService
{
    public function checkAreaId($areaId)
    {
        if (!preg_match('#^\d+$#', $areaId)) {
            throw new \ErrorException('Zone invalide');
        }
    }

    public function checkWeight($weight)
    {
        if (!preg_match('#^\d+(\.\d+)?$#', $weight)) {
            throw new \ErrorException('Poids invalide');
        }
        if ($weight <= 0) {
            throw new \ErrorException('Le poids doit être supérieur à 0');
        }
    }

    public function checkPrice($price)
    {
        if (!preg_match('#^\d+(\.\d+)?$#', $price)) {
            throw new \Exception('Prix invalide');
        }
    }

    public function findAreaOrFail($areaId)
    {
        $area = AreaQuery::create()->findPK($areaId);
        if ($area === null) {
            throw new \Exception('Zone introuvable');
        }
        return $area;
    }

    public function saveSlice($areaId, $weight, $price)
    {
        $this->findAreaOrFail($areaId);
        $this->checkAreaId($areaId);
        $this->checkWeight($weight);
        $this->checkPrice($price);

        $slice = DpdClassicPriceSliceQuery::create()
            ->filterByAreaId($areaId)
            ->filterByMaxWeight($weight)
            ->findOneOrCreate();

        $slice->setAreaId($areaId);
        $slice->setMaxWeight($weight);
        $slice->setPrice($price);

        $slice->save();
    }

    public function updateSlice($areaId, $weight, $price)
    {
        $this->checkAreaId($areaId);
        $this->checkWeight($weight);
        $this->checkPrice($price);
        $this->findAreaOrFail($areaId);

        $slice = DpdClassicPriceSliceQuery::create()
            ->filterByAreaId($areaId)
            ->filterByMaxWeight($weight)
            ->findOne();
        if ($slice) {
            $slice->setPrice($price);
            $slice->save();
        }
    }

    public function deleteSlice($areaId, $weight)
    {
        $this->findAreaOrFail($areaId);
        $this->checkAreaId($areaId);
        $this->checkWeight($weight);

        $slice = DpdClassicPriceSliceQuery::create()
            ->filterByAreaId($areaId)
            ->filterByMaxWeight($weight)
            ->findOne();
        if ($slice) {
            $slice->delete();
        }
    }
}
