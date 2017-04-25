<?php

namespace NewsletterBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use NewsletterBundle\Entity\Article;

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

    public function getArticleAction($article)
    {
        $article = new Article("test title", "test body");
        return $article;
    }


    public function getArticlesAction()
    {
        $newses = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();
        return $newses;
    }

}