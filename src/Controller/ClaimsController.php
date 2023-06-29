<?php

namespace App\Controller;

use App\Entity\Claims;
use App\Entity\Trait\CreatedAtTrait;
use App\Form\ClaimsType;
use App\Repository\ClaimsRepository;
use App\Repository\CommentsRepository;

use DateTime;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;

#[Route('/claims')]
class ClaimsController extends AbstractController
{
    #[Route('/', name: 'app_claims_index', methods: ['GET'])]
    public function index(ClaimsRepository $claimsRepository): Response
    {

       // $host = base_path();
        $claims = $claimsRepository->getAllData();
        // $claimsRepository->findAll()
        return $this->render('claims/index.html.twig', [
            'claims' => $claims,
         //   'host' => $host
        ]);
    }

    #[Route('/new', name: 'app_claims_new', methods: ['GET', 'POST'])]

    public function new(Request $request, ClaimsRepository $claimsRepository): Response
    {
        /*
        $claim = new Claims();
        $claim->setUserId(1);
        $claim->setStatusId(1);
        $form = $this->createForm(ClaimsType::class, $claim);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $claimsRepository->save($claim, true);
            return $this->redirectToRoute('app_claims_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('claims/new.html.twig', [
            'claim' => $claim,
            'form' => $form,
        ]);
        */

        $claim = new Claims();
        $form = $this->createFormBuilder($claim)
            ->add('Text', TextType::class)
            ->add('files', FileType::class, array('label' => 'Photo (png, jpeg)'))
           // ->add('save', SubmitType::class, array('label' => 'Submit'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $path = $this->getParameter('kernel.project_dir')."/public/uploads";
          //  dd($path);
           // dd($claim->getPhoto());
            $file = new File($claim->getFile());
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($path, $fileName);

            $claim->setFile($fileName);

            $claim->setUserId(1);
            $claim->setStatusId(1);

            $dateTimeNow = new DateTimeImmutable();
          //  dd($dateTimeNow2);
            $claim->setCreatedAt($dateTimeNow);
            $claim->setUpdatedAt($dateTimeNow);

            $claimsRepository->save($claim, true);

            $claims = $claimsRepository->getAllData();
            return $this->render('claims/index.html.twig', [
                'claims' => $claims,
            ]);
          //  return new Response("User photo is successfully uploaded.");
        } else {
            return $this->render('claims/new.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }

    #[Route('/{id}', name: 'app_claims_show', methods: ['GET'])]
    public function show(Claims $claim, CommentsRepository $commentRepository): Response
    {
        $comments = $commentRepository->findBy(['claims_id' => $claim]);
       // dump($comments);die;
        //dd($comments);
        return $this->render('claims/show.html.twig', [
            'claim' => $claim,
            'comments' => $comments,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_claims_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Claims $claim, ClaimsRepository $claimsRepository): Response
    {
        $form = $this->createForm(ClaimsType::class, $claim);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
        if ($this->isCsrfTokenValid('delete'.$claim->getId(), $request->request->get('_token'))) {
            $claimsRepository->remove($claim, true);
        }
        return $this->redirectToRoute('app_claims_index', [], Response::HTTP_SEE_OTHER);
    }
}
