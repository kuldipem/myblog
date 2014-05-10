<?php

namespace MyBlog\Admin\ManageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MyBlogAdminManageBundle:Default:index.html.twig', array('name' => $name));
    }
}
