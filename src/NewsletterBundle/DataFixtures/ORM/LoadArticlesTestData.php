<?php

namespace NewsletterBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NewsletterBundle\Entity\Article;

class LoadArticlesTestData implements FixtureInterface
{
public function load(ObjectManager $manager)
{

    $article = new Article();
    $article->setBody("test body");
    $article->setTitle("test title");
    $article->setWeek(1);

    $manager->persist($article);
    $manager->flush();
    }
}
