<?php

namespace NewsletterBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use NewsletterBundle\Entity\Article;

class NewsletterController extends FOSRestController
{

    public function getArticleAction($article)
    {
        return array('hello' => 'world');
        //return $article;
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