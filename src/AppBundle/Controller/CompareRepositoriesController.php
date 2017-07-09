<?php

namespace AppBundle\Controller;

use AppBundle\Repository\SearchRepository;
use AppBundle\Service\CompareRepositoriesServices;
use AppBundle\Sort\Sort;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CompareRepositoriesController extends Controller
{
    public function indexAction(Request $request)
    {
        $form = $this->createForm('AppBundle\Form\CompareRepositoriesType');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            return $this->redirectToRoute('homepage', ['repo' => $data['repositoryName'], 'repo2' => $data['repositoryNameSecond']]);
        }

        $compareRepositoryStatistics = null;
        if ($request->get('repo') && $request->get('repo2')) {
            /** @var CompareRepositoriesServices $projectContributorsService */
            $projectContributorsService = $this->get('service.compare_repositories');
            $compareRepositoryStatistics = $projectContributorsService->compare($request->get('repo'), $request->get('repo2'));
            echo "<pre>";var_dump($compareRepositoryStatistics);exit;
        }

        return $this->render('AppBundle:CompareRepositories:index.html.twig', [
            'compareRepositoryStatistics' => $compareRepositoryStatistics,
            'form' => $form->createView()
        ]);
    }
}
