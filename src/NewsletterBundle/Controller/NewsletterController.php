<?php

namespace NewsletterBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use NewsletterBundle\Entity\Article;
use FOS\RestBundle\View\View;
use NewsletterBundle\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;

class NewsletterController extends FOSRestController
{

    /**
     * @ApiDoc(
     *  description="Returns a collection of Object",
     *  requirements={
     *      {
     *          "name"="article",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="id of article to return"
     *      }
     *  }
     * )
     * @param Article $article
     * @return Article
     */

    public function getArticleAction(Article $article)
    {
        return $article;
    }


    public function getArticlesAction()
    {
        $articles = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        return $articles;
    }

    public function postArticleAction(Request $request){

        $article = new Article();

       return $this->processForm($article, $request);

    }

    private function processForm(Article $article, Request $request)
    {

        $form = $this->createForm(ArticleType::class, $article, array('method' => 'POST'));

        //$form->handleRequest($request); //not submitting - why?

        $form->submit($request->request->all());

        if ( $form->isSubmitted() && $form->isValid()) {

            $this->persistAndFlush($article);

            return article;
        }

        return View::create($form, 400);
    }

    private function persistAndFlush(Article $article)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($article);
        $manager->flush();
    }


}