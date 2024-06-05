<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;

use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    // #[Route('/', name: 'app_home')]
    // public function index(ArticleRepository $repository): Response
    // {
    //     // $repository = $doctrine->getRepository(Article::class);
    //     $articles = $repository->findAll();
    //     return $this->render('article/index.html.twig', ['articles' => $articles]);
    // }

    #[Route('/', name: 'app_home')]
    public function index(ArticleRepository $repository): Response
    {
        $articles = $repository->findBy([], ['prix' => 'DESC']);
        return $this->render('article/index.html.twig', ['articles' => $articles]);
    }

    #[Route('/article/{id<[0-9]+>}', name: 'article_show')]
    public function show(Article $article): Response
    {
        if (!$article) {
            throw $this->createNotFoundException(
                'Personne non trouvée avec l\'id' . $article->id
            );
        }

        //$repository = $doctrine->getRepository(Article::class);
        //$article = $repository->find($id);
        return $this->render('article/show.html.twig', ['article' => $article]);
    }

    //tester une requete DQL

    #[Route('/article/prix/{prix}', name: 'article_morethanprix')]
    public function showArticlesGreaterThanPrice($prix, ArticleRepository
    $rep)
    {
        $articles = $rep->findAllGreaterThanPrice($prix);
        return $this->render(
            'article/index.html.twig',
            ['articles' => $articles]
        );
    }

    // #[IsGranted('ROLE_ADMIN')]
    #[Route('/article/create', name: 'article_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $article = new Article;
        // $form = $this->createFormBuilder($article)
        //     ->add('reference')
        //     ->add('libelle')
        //     ->add('prix')
        //     ->getForm();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->renderForm('article/create.html.twig', ['formArticle' => $form]);
    }

    // #[IsGranted('ROLE_ADMIN')]
    #[Route('/article/{id<\d+>}/edit', name: 'article_edit')]
    public function edit(Article $article, Request $request, EntityManagerInterface $em)
    {
        //$article = new Article;
        // $form = $this->createFormBuilder($article)
        //     ->add('reference')
        //     ->add('libelle')
        //     ->add('prix')
        //     ->getForm();
        $form = $this->createForm(ArticleType::class, $article, ['is_edit' => true]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->renderForm('article/edit.html.twig', ['formArticle' => $form]);
    }

    // #[IsGranted('ROLE_ADMIN')]
    #[Route('/article/{id<\d+>}/delete', name: 'article_delete')]
    public function delete(Article $article, EntityManagerInterface $em)
    {
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute('app_home');
    }
}
