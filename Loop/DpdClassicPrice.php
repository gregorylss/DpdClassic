<?php
/*************************************************************************************/
/*                                                                                   */
/*      Thelia	                                                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : info@thelia.net                                                      */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      This program is free software; you can redistribute it and/or modify         */
/*      it under the terms of the GNU General Public License as published by         */
/*      the Free Software Foundation; either version 3 of the License                */
/*                                                                                   */
/*      This program is distributed in the hope that it will be useful,              */
/*      but WITHOUT ANY WARRANTY; without even the implied warranty of               */
/*      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                */
/*      GNU General Public License for more details.                                 */
/*                                                                                   */
/*      You should have received a copy of the GNU General Public License            */
/*	    along with this program. If not, see <http://www.gnu.org/licenses/>.         */
/*                                                                                   */
/*************************************************************************************/

namespace DpdClassic\Loop;

use DpdClassic\Model\DpdClassicPriceSlice;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Core\Template\Loop\Argument\Argument;
use DpdClassic\Model\DpdClassicPriceSliceQuery;

/**
 * Class DpdClassicPrice
 * @package DpdClassic\Loop
 * @author Thelia <info@thelia.net>
 */
class DpdClassicPrice extends BaseLoop implements PropelSearchLoopInterface
{
    /**
     * @return ArgumentCollection
     */
    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntTypeArgument('area', null, true)
        );
    }

    public function buildModelCriteria()
    {
        $areaId = $this->getArea();

        if (null === $areaId) {
            return DpdClassicPriceSliceQuery::create();
        }

        return DpdClassicPriceSliceQuery::create()
            ->filterByAreaId($areaId)
            ->orderByMaxWeight();
    }

    public function parseResults(LoopResult $loopResult)
    {
        /** @var DpdClassicPriceSlice $slice */
        foreach ($loopResult->getResultDataCollection() as $slice) {
            $row = new LoopResultRow($this);

            $row->set('ID', $slice->getId());
            $row->set('AREA_ID', $slice->getAreaId());
            $row->set('MAX_WEIGHT', $slice->getMaxWeight());
            $row->set('PRICE', $slice->getPrice());

            $loopResult->addRow($row);
        }

        return $loopResult;
    }
}
