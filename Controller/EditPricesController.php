<?php
namespace DpdClassic\Controller;

use DpdClassic\Service\EditPricesService;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Core\Security\AccessManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/module/DpdClassic", name="dpdclassic_")
 */
class EditPricesController extends BaseAdminController
{
    /** @var EditPricesService */
    private EditPricesService $pricesService;

    public function __construct(RequestStack $requestStack, EditPricesService $pricesService)
    {
        $this->requestStack = $requestStack;
        $this->pricesService = $pricesService;
    }

    /**
     * @Route("/add-price-slice", name="add_price_slice", methods="POST")
     * @throws \ErrorException
     */
    public function addPriceSliceAction()
    {
        $authResponse = $this->checkAuth([AdminResources::MODULE], ['DpdClassic'], AccessManager::CREATE);
        if ($authResponse !== null) {
            return $authResponse;
        }

        $request = $this->requestStack->getCurrentRequest();
        $areaId = $request->get('area-id');
        $weight = $request->get('weight');
        $price = $request->get('price');

        $this->pricesService->saveSlice($areaId, $weight, $price);

        return $this->redirectToConfigurationPage();
    }

    /**
     * @Route("/update-price-slice", name="update_price_slice", methods="POST")
     * @throws \ErrorException
     */
    public function updatePriceSliceAction()
    {
        $authResponse = $this->checkAuth([AdminResources::MODULE], ['DpdClassic'], AccessManager::UPDATE);
        if ($authResponse !== null) {
            return $authResponse;
        }

        $request = $this->requestStack->getCurrentRequest();
        $areaId = $request->get('area-id');
        $weight = $request->get('weight');
        $price = $request->get('price');

        $this->pricesService->updateSlice($areaId, $weight, $price);

        return $this->redirectToConfigurationPage();
    }

    /**
     * @Route("/delete-price-slice", name="delete_price_slice", methods="POST")
     * @throws \ErrorException
     */
    public function deletePriceSliceAction()
    {
        $authResponse = $this->checkAuth([AdminResources::MODULE], ['DpdClassic'], AccessManager::DELETE);
        if ($authResponse !== null) {
            return $authResponse;
        }

        $request = $this->requestStack->getCurrentRequest();
        $areaId = $request->get('area-id');
        $weight = $request->get('weight');

        $this->pricesService->deleteSlice($areaId, $weight);

        return $this->redirectToConfigurationPage();
    }

    /**
     * Méthode utilitaire pour rediriger vers la page de configuration
     */
    private function redirectToConfigurationPage()
    {
        return $this->generateRedirectFromRoute(
            'admin.module.configure',
            [],
            [
                'module_code' => 'DpdClassic',
                'current_tab' => 'price_slices_tab',
                '_controller' => 'Thelia\\Controller\\Admin\\ModuleController::configureAction'
            ]
        );
    }
}
