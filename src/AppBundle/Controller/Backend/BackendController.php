<?php

namespace AppBundle\Controller\Backend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BackendController extends Controller
{
    /**
     * @Route("/admin/dashboard", name="dashboard")
     */
    public function backendAction(Request $request)
    {
        return $this->render('backend/dashboard/dashboard.html.twig');
    }
}
