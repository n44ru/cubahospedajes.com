<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Gallery;

class GaleriaController extends Controller
{
    /**
     * @Route("/gallery/{_locale}", name="gallery_front")
     * defaults={"_locale"="es"},
     * requirements={"_locale"="(es|en)"}
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT DISTINCT p.tags FROM AppBundle:Imagegallery p');
        $array_tag = $query->getResult();
        $full = $em->getRepository('AppBundle:Gallery')->findAll();
        $this->meta_tag_global();
        return $this->render('frontend/galeria/galeria.html.twig', array('gallery' => $full, 'tags' => $array_tag));
    }
    public function meta_tag_global(){
        $em = $this->getDoctrine()->getManager();
        $config = $em->getRepository('AppBundle:Settings')->find(1);
        $this->get('twig')->addGlobal('global_title', $config->getWebtitulo());
        $this->get('twig')->addGlobal('global_description', $config->getWebdesc());
        $this->get('twig')->addGlobal('global_keywords', $config->getWebkeywords());
    }
}