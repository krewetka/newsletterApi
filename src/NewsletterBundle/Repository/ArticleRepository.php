<?php

namespace NewsletterBundle\Repository;

use Doctrine\ORM\EntityRepository;


class ArticleRepository extends EntityRepository
{

    public function add($entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }


    public function remove($entity)
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }


    public function save($entity)
    {
        $this->getEntityManager()->flush($entity);
    }

    public function getAllArticles()
    {
        $articles = $this->findAll();

        return $articles;
    }

}
