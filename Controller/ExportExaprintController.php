<?php

namespace DpdClassic\Controller;

use DpdClassic\Form\ExportExaprintForm;
use DpdClassic\DpdClassic;
use DpdClassic\Service\ConfigureSenderService;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Translation\Translator;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Core\Security\AccessManager;
use Symfony\Component\Routing\Annotation\Route;
use Propel\Runtime\Exception\PropelException;

/**
 * @Route("/admin/module/DpdClassic/update-sender", name="DpdClassic_update-sender")
 * Class ExportExaprintController
 * @package DpdClassic\Controller
 * @author Thelia <info@thelia.net>
 */
class ExportExaprintController extends BaseAdminController
{
    /**
     * @var ConfigureSenderService
     */
    protected $configureSenderService;

    public function __construct(ConfigureSenderService $configureSenderService)
    {
        $this->configureSenderService = $configureSenderService;
    }

    /**
     * @Route("", name="_update", methods="POST")
     */
    public function updateSenderAction()
    {
        if (null !== $response = $this->checkAuth(
                [AdminResources::MODULE],
                ['DpdClassic'],
                AccessManager::UPDATE
            )) {
            return $response;
        }

        $form = $this->createForm(ExportExaprintForm::getName());
        $error_message = null;

        try {
            $vform = $this->validateForm($form);

            $senderData = [
                'name' => $vform->get('name')->getData(),
                'addr' => $vform->get('addr')->getData(),
                'addr2' => $vform->get('addr2')->getData(),
                'zipcode' => $vform->get('zipcode')->getData(),
                'city' => $vform->get('city')->getData(),
                'tel' => $vform->get('tel')->getData(),
                'mobile' => $vform->get('mobile')->getData(),
                'mail' => $vform->get('mail')->getData(),
                'expcode' => $vform->get('expcode')->getData()
            ];

            $this->configureSenderService->saveSenderConfig($senderData);

            return $this->generateRedirectFromRoute(
                "admin.module.configure",
                [],
                [
                    'module_code' => "DpdClassic",
                    'current_tab' => "configure_export_exaprint",
                    '_controller' => 'Thelia\\Controller\\Admin\\ModuleController::configureAction'
                ]
            );
        } catch (PropelException $e) {
            $error_message = Translator::getInstance()->trans(
                "Erreur lors de l'enregistrement des données en base: %msg",
                ['%msg' => $e->getMessage()],
                DpdClassic::DOMAIN_NAME
            );
        } catch (\Exception $e) {
            $error_message = $e->getMessage();
        }

        $this->setupFormErrorContext(
            Translator::getInstance()->trans(
                "Erreur lors de la mise à jour des informations d'expédition",
                [],
                DpdClassic::DOMAIN_NAME
            ),
            $error_message,
            $form
        );

        return $this->render(
            'module-configure',
            [
                'module_code' => DpdClassic::getModuleCode(),
                'current_tab' => "configure_export_exaprint"
            ]
        );
    }
}
