<?php

namespace NewsletterBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use NewsletterBundle\Entity\Article;
use FOS\RestBundle\View\View;
use NewsletterBundle\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\View as AnnotationView;

class NewsletterController extends FOSRestController
{
    /**
     * @AnnotationView
     * @ApiDoc(
     *  description="Returns an article by id",
     *  requirements={
     *      {
     *          "name"="article",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="id of article to return"
     *      }
     *  },
     *  input="NewsletterBundle\Entity\Article",
     *  statusCodes={
     *         200="Returned when successful",
     *         404="Returned when the article is not found"
     *    }
     * )
     */
    public function getArticleAction(Article $article)
    {

        return $article;
    }

    /**
     * @ApiDoc(
     *  description="Returns all articles",
     *  statusCodes={
     *         200="Returned when successful",
     *   }
     * )
     */
    public function getArticlesAction()
    {
        $repository = $this->get('newsletter.entity.article_repository');
        $articles = $repository->getAllArticles();

        return $articles;
    }

    /**
     * @ApiDoc(
     *  description="Creates article",
     *  input="NewsletterBundle\Form\ArticleType",
     *  statusCodes={
     *         201="Returned when successfully created",
     *         400="Returned in case of error"
     *    }
     * )
     */
    public function postArticleAction(Request $request)
    {

        $article = new Article();

        $form = $this->processRequest($request, $article);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return View::create($form, 400);
        }

        $repository = $this->get('newsletter.entity.article_repository');
        $repository->add($article);

        $view = $this->view($article, 201);

        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *  description="Updates an article",
     *  requirements={
     *      {
     *          "name"="article",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="id of article to update"
     *      }
     *  },
     *  statusCodes={
     *      204="Returned when successfully updated",
     *      400="Returned in case of error",
     *      404="Returned when the article is not found"
     * },
     * input="NewsletterBundle\Form\ArticleType"
     * )
     */
    public function putArticleAction(Article $article, Request $request)
    {

        $form = $this->processRequest($request, $article);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, 400);
        }

        $repository = $this->get('newsletter.entity.article_repository');
        $repository->save($article);

        $view = $this->view($article, 200);

        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *  description="Delete article",
     *  requirements={
     *      {
     *          "name"="article",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="id of article to remove"
     *      }
     *  },
     *  statusCodes={
     *         204="Returned when successfully deleted",
     *         404="Returned when the article is not found"
     *    }
     * )
     */
    public function deleteArticleAction(Article $article)
    {

        $repo = $this->get('newsletter.entity.article_repository');

        $repo->remove($article);

        $view = $this->view(null, 204);

        return $this->handleView($view);
    }

    /**
     * @param Request $request
     * @param $article
     * @return \Symfony\Component\Form\Form
     */
    public function processRequest(Request $request, $article): \Symfony\Component\Form\Form
    {
        $form = $this->createForm(ArticleType::class, $article, array('method' => $request->getMethod()));

        $form->submit($request->request->all());

        //$form->handleRequest($request);

        return $form;
    }


}