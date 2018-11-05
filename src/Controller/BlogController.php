<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Manager\ArticleManager;
use App\Repository\ArticleRepository;
use App\Service\Blog\Pagination;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/actualites/{page}", name="blog", requirements={"page"="\d+"})
     */
    public function blog(ArticleRepository $repository, int $page = 1, Pagination $pagination)
    {
        $perPage = 1;
        $allArticles = $repository->findAll();
        $nbPages = $pagination->getTotalPages($allArticles, $perPage);
        $limit = $pagination->getLimit($page, $perPage);
        $offset = $pagination->getOffset($limit, $perPage);
        $articles = $repository->findBy(
            [],
            ['id' => 'DESC'],
            $limit,
            $offset
        );
        return $this->render('blog/blog.html.twig', [
            'articles' => $articles,
            'per_page' => $perPage,
            'nb_pages' => $nbPages,
            'page' => $page
        ]);
    }

    /**
     * @Route(path="/actualites/{slug}", name="article")
     * @ParamConverter("article", class="App\Entity\Article")
     * @param ArticleRepository $repository
     * @return Response
     */
    public function article(ArticleRepository $repository, Article $article, ArticleManager $articleManager, Request $request)
    {
        $previousArticle = $repository->findOneBy(['id' => $article->getId()-1]);
        $nextArticle = $repository->findOneBy(
            array(
                'id' => $article->getId()+1
            )
        );
        $comment = new Comment();
        $comment->setArticle($article);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setAuthor($this->getUser());
            $articleManager->update($comment);
            $this->addFlash('success',"Commentaire ajouté !");
            return $this->redirectToRoute('article', ['slug' => $article->getSlug()]);
        }
        return $this->render(
            'blog/article.html.twig', [
                'article' => $repository->findOneBy(
                    array(
                        'slug' => $article->getSlug(),
                    )
                ),
                'previous_article' => $previousArticle ?? null,
                'next_article' => $nextArticle ?? null,
                'form' => $form->createView()
            ]
        );
    }
}
