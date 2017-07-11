<?php


namespace AppBundle\Controller\Api;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use AppBundle\Service\CompareRepositoriesServices;
use AppBundle\Entity\RepositoryStatistics;

/**
 * @RouteResource("Repo")
 */
class CompareRepositoriesController extends FOSRestController
{
    /**
     * @Route(
     *      requirements={
     *          "repoNameFirst": "^[a-zA-Z0-9\-]+\/[a-zA-Z0-9\-]+$",
     *          "repoNameSecond": "^[a-zA-Z0-9\-]+\/[a-zA-Z0-9\-]+$",
     *          "_format": "json"
     *      }
     * )
     * @View()
     * @ApiDoc(
     *  section="Repo",
     *  description="Compares details of two repositories",
     * )
     *
     * @return \AppBundle\Entity\RepositoryStatistics[]|View
     */
    public function getComparisonAction($repoNameFirst, $repoNameSecond)
    {
        try {
            /** @var CompareRepositoriesServices $compareRepositoriesServices */
            $compareRepositoriesServices = $this->get('service.compare_repositories');
            $compareRepositoryStatistics = $compareRepositoriesServices->compare($repoNameFirst, $repoNameSecond);

            return $compareRepositoryStatistics;
        } catch (\RuntimeException $e) {
            return $this->view(['error' => ['message' => $e->getMessage()]], 500);
        } catch (\AppBundle\Repository\Exception\NotFoundException $e) {
            return $this->view(['error' => ['message' => $e->getMessage()]], 404);
        }
    }
}