<?php

namespace App\Controller;

use App\Entity\Claims;

use App\Form\ClaimsType;
use App\Repository\ClaimsRepository;
use App\Repository\CommentsRepository;

use App\Service\FileService;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;


#[Route('/claims')]
class ClaimsController extends AbstractController
{
    #[Route('/', name: 'app_claims_index', methods: ['GET'])]
    public function index(ClaimsRepository $claimsRepository, UserInterface $user, Request $request): Response
    {
        $roles = $user->getRoles();
        $user_id = $user->getUserIdentifier();
        if (in_array($roles, array('ROLE_ADMIN', 'ROLE_MANAGER'))) {
            $claims = $claimsRepository->getClaimsUsers();
        } else {
            $claims = $claimsRepository->getClaimsUserByUserId($user_id);
        }
        $token = $user->getToken();

        return $this->render('claims/index.html.twig', [
            'claims' => $claims,
            'token'  => $token
        ]);
    }

    #[Route('/new', name: 'app_claims_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ClaimsRepository $claimsRepository, FileService $fileService, UserInterface $user): Response
    {
        $claim = new Claims();
        $form = $this->createForm(ClaimsType::class, $claim);
        $form->handleRequest($request);

        if ($form->isSubmitted() /*&& $form->isValid()*/) {

           // dd($form);
            $file = $form['file']->getData();
            if (!empty($file)) {
                $path = $this->getParameter('kernel.project_dir') . "/public/uploads/claims";
                $claim = $fileService->saveFile($claim, $file, $path);
            }
            $user_id = $user->getUserIdentifier();
            $claim->setUserId($user_id);
            $dateTimeNow = new DateTimeImmutable();
            $claim->setCreatedAt($dateTimeNow);
            $claim->setUpdatedAt($dateTimeNow);
            $claimsRepository->save($claim, true);

            $roles = $user->getRoles();
            $user_id = $user->getUserIdentifier();

            if (in_array($roles, array('ROLE_ADMIN', 'ROLE_MANAGER'))) {
                $claims = $claimsRepository->getClaimsUsers();
            } else {
                $claims = $claimsRepository->getClaimsUserByUserId($user_id);
            }
            $token = $user->getToken();

            return $this->render('claims/index.html.twig', [
                'claims' => $claims,
                'token' => $token
            ]);
        } else {
            return $this->render('claims/new.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    #[Route('/{id}', name: 'app_claims_show', methods: ['GET'])]
    public function show(Claims $claim, CommentsRepository $commentRepository, ClaimsRepository $claimsRepository): Response
    {
        $claims = $claimsRepository->getClaimUserById($claim->getId());
        $comments = $commentRepository->getCommentsUsersByClaimId($claim->getId());

        return $this->render('claims/show.html.twig', [
            'claim' => $claims,
            'comments' => $comments,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_claims_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Claims $claim, ClaimsRepository $claimsRepository, FileService $fileService): Response
    {
        $form = $this->createForm(ClaimsType::class, $claim);
        $form->handleRequest($request);

        if ($form->isSubmitted() /* && $form->isValid()*/) {
            $file = $form['file']->getData();
            if (!empty($file)) {
                $path = $this->getParameter('kernel.project_dir') . "/public/uploads/claims";
                $claim = $fileService->saveFile($claim, $file, $path);
            }
            $status = $form['status']->getData();
            $claim->setStatusId($status->getId());
            $dateTimeNow = new DateTimeImmutable();
            $claim->setUpdatedAt($dateTimeNow);
            $claimsRepository->save($claim, true);
            return $this->redirectToRoute('app_claims_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('claims/edit.html.twig', [
            'claim' => $claim,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_claims_delete', methods: ['POST'])]
    public function delete(Request $request, Claims $claim, ClaimsRepository $claimsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $claim->getId(), $request->request->get('_token'))) {
            $claimsRepository->remove($claim, true);
        }
        return $this->redirectToRoute('app_claims_index', [], Response::HTTP_SEE_OTHER);
    }
}
