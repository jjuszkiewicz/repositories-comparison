<?php


namespace AppBundle\Controller\Api;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use AppBundle\Service\CompareRepositoriesServices;

/**
 * @RouteResource("Repo")
 */
class CompareRepositoriesController extends FOSRestController
{
    /**
     * @Route(
     *      requirements={
     *          "repoNameFirst": "^[a-zA-Z0-9\-]+\/[a-zA-Z0-9\-]+$",
     *          "repoNameSecond": "^[a-zA-Z0-9\-]+\/[a-zA-Z0-9\-]+$"
     *      }
     * )
     * @View()
     * @ApiDoc()
     *
     * @param $repoNameFirst
     * @param $repoNameSecond
     * @return \FOS\RestBundle\View\View
     */
    public function getComparisonAction($repoNameFirst, $repoNameSecond)
    {
        /** @var CompareRepositoriesServices $compareRepositoriesServices */
        $compareRepositoriesServices = $this->get('service.compare_repositories');
        $compareRepositoryStatistics = $compareRepositoriesServices->compare($repoNameFirst, $repoNameSecond);

        return $this->view(['ds'=>2]);
    }
}