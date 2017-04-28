<?php

namespace NewsletterBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use NewsletterBundle\Entity\Article;
use FOS\RestBundle\View\View ;
use NewsletterBundle\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\View as AnnotationView;
use Symfony\Component\HttpFoundation\Response;


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
     * @AnnotationView
     * @ApiDoc(
     *  description="Returns all articles",
     *  statusCodes={
     *         200="Returned when successful",
     *   }
     * )
     */
    public function getArticlesAction()
    {
        $articles = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        return $articles;
    }

    /**
     * @AnnotationView
     * @ApiDoc(
     *  description="Creates article",
     *  input="NewsletterBundle\Form\ArticleType",
     *  statusCodes={
     *         201="Returned when successfully created",
     *         400="Returned in case of error"
     *    }
     * )
     */
    public function postArticleAction(Request $request){

        $article = new Article();

       return $this->processForm($article, $request);

    }

    /**
     * @AnnotationView
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
     *      404="Returned when the article is not found"
     * },
     * input="NewsletterBundle\Form\ArticleType"
     * )
     */
    public function  putArticleAction(Article $article, Request $request){

        return $this->processForm($article, $request);
    }

    /**
     * @AnnotationView(statusCode=204)
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
        $this->removeAndFlush($article);
    }

    private function processForm(Article $article, Request $request)
    {

        $statusCode = $article->isNew() ? 201 : 204;

        $form = $this->createForm(ArticleType::class, $article, array('method' => $request->getMethod()));

        $form->handleRequest($request);

       //$form->submit( $request->request->all());

        if ( $form->isSubmitted() && $form->isValid()) {

            $this->persistAndFlush($article);

            $response = new Response();
            $response->setStatusCode($statusCode);

            if (201 === $statusCode) {
                $response->headers->set('Location',
                    $this->generateUrl(
                        'get_article', array('article' => $article->getId()),
                        true // absolute
                    )
                );
            }

            return $response;
        }

        return View::create($form, 400);
    }

    /**
     * @param Article $article
     */
    private function persistAndFlush(Article $article)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($article);
        $manager->flush();
    }

    /**
     * @param Article $article
     */
    public function removeAndFlush(Article $article)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($article);
        $manager->flush();
    }


}