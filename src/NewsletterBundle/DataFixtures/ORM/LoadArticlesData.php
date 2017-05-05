<?php

namespace NewsletterBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NewsletterBundle\Entity\Article;

class LoadArticlesData implements FixtureInterface
{
public function load(ObjectManager $manager)
{

    $article = new Article();
    $article->setBody("test body");
    $article->setTitle("test title");

    $manager->persist($article);
    $manager->flush();

    $article = new Article();
    $article->setBody("test body 2");
    $article->setTitle("test title 2");

    $manager->persist($article);
    $manager->flush();

    $article = new Article();
    $article->setBody("test body 3");
    $article->setTitle("test title 3");

    $manager->persist($article);
    $manager->flush();
    }
}