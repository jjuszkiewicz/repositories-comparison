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

        try {
            $compareRepositoryStatistics = null;
            if ($request->get('repo') && $request->get('repo2')) {
                $form->setData(
                    [
                        'repositoryName' => $request->get('repo'),
                        'repositoryNameSecond' => $request->get('repo2')
                    ]
                );
                /** @var CompareRepositoriesServices $projectContributorsService */
                $projectContributorsService = $this->get('service.compare_repositories');
                $compareRepositoryStatistics = $projectContributorsService->compare($request->get('repo'), $request->get('repo2'));
            }
        } catch (\RuntimeException $e) {
            $this->addFlash('error', $e->getMessage());
        }

        return $this->render('AppBundle:CompareRepositories:index.html.twig', [
            'compareRepositoryStatistics' => $compareRepositoryStatistics,
            'form' => $form->createView()
        ]);
    }
}
