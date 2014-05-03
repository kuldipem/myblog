<?php

namespace MyBlog\Front\AssetsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MyBlogFrontAssetsBundle:Default:index.html.twig', array('name' => $name));
    }
}
