<?php

namespace DpdClassic\Service;

use DpdClassic\Model\DpdClassicSenderConfig;
use DpdClassic\Model\DpdClassicSenderConfigQuery;
use Propel\Runtime\Exception\PropelException;
use Thelia\Core\Translation\Translator;
use DpdClassic\DpdClassic;

class ConfigureSenderService
{
    /**
     * Récupère la configuration de l'expéditeur
     *
     * @return DpdClassicSenderConfig|null
     */
    public function getSenderConfig()
    {
        return DpdClassicSenderConfigQuery::create()->findOne();
    }

    /**
     * Récupère toutes les données du sender sous forme de tableau
     *
     * @return array
     */
    public function getSenderConfigArray()
    {
        $config = $this->getSenderConfig();

        if (null === $config) {
            return [];
        }

        return [
            'name' => $config->getName(),
            'addr' => $config->getPrimaryAdress(),
            'addr2' => $config->getSecondaryAdress(),
            'zipcode' => $config->getZipcode(),
            'city' => $config->getCity(),
            'tel' => $config->getPhone(),
            'mobile' => $config->getMobilePhone(),
            'mail' => $config->getEmail(),
            'expcode' => $config->getDpdCode(),
        ];
    }

    /**
     * Sauvegarde ou met à jour la configuration de l'expéditeur
     *
     * @param array $data Les données de l'expéditeur
     * @throws PropelException
     * @return DpdClassicSenderConfig
     */
    public function saveSenderConfig(array $data)
    {
        $config = $this->getSenderConfig();

        if (null === $config) {
            $config = new DpdClassicSenderConfig();
        }

        $config
            ->setName($data['name'])
            ->setPrimaryAdress($data['addr'])
            ->setSecondaryAdress($data['addr2'])
            ->setZipcode($data['zipcode'])
            ->setCity($data['city'])
            ->setPhone($data['tel'])
            ->setMobilePhone($data['mobile'])
            ->setEmail($data['mail'])
            ->setDpdCode($data['expcode'])
            ->save();

        return $config;
    }
}
