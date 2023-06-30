<?php

namespace App\Controller;

use App\Entity\Claims;
use App\Entity\Comments;

use App\Form\CommentsType;
use App\Repository\CommentsRepository;
use App\Service\FileService;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/comments')]
class CommentsController extends AbstractController
{
    #[Route('/', name: 'app_comments_index', methods: ['GET'])]
    public function index(CommentsRepository $commentsRepository): Response
    {
        return $this->render('comments/index.html.twig', [
            'comments' => $commentsRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_comments_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CommentsRepository $commentsRepository, Claims $claims, FileService $fileService): Response
    {
        $comment = new Comments();
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['file']->getData();
            if(!empty($file)){
                $path = $this->getParameter('kernel.project_dir')."/public/uploads/comments";
                $comment =  $fileService->saveFile($comment, $file, $path);
            }
            $comment->setUserId(1);
            $comment->setClaimsId($claims->getId());
            $dateTimeNow = new DateTimeImmutable();
            $comment->setCreatedAt($dateTimeNow);
            $comment->setUpdatedAt($dateTimeNow);
            $commentsRepository->save($comment, true);

            return $this->redirectToRoute('app_claims_show', ['id'=>$claims->getId()], Response::HTTP_SEE_OTHER);
        } else {
            return $this->render('comments/new.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }

    #[Route('/{id}', name: 'app_comments_show', methods: ['GET'])]
    public function show(Comments $comment, CommentsRepository $commentsRepository): Response
    {
        $comment = $commentsRepository->getCommentUserById($comment->getId());
        return $this->render('comments/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_comments_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Comments $comment, CommentsRepository $commentsRepository, FileService $fileService): Response
    {
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['file']->getData();
            if(!empty($file)){
                $path = $this->getParameter('kernel.project_dir')."/public/uploads/comments";
                $comment =  $fileService->saveFile($comment, $file, $path);
            }
            $comment->setUserId(1);
            $dateTimeNow = new DateTimeImmutable();
            $comment->setUpdatedAt($dateTimeNow);
            $commentsRepository->save($comment, true);
            return $this->redirectToRoute('app_claims_show', ['id'=>$comment->getClaimsId()], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('comments/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_comments_delete', methods: ['POST'])]
    public function delete(Request $request, Comments $comment, CommentsRepository $commentsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $commentsRepository->remove($comment, true);
        }
        return $this->redirectToRoute('app_comments_index', [], Response::HTTP_SEE_OTHER);
    }
}
