<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Gallery;

class GaleriaController extends Controller
{
    /**
     * @Route("/galeria", name="gallery_front")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $gall = $em->getRepository('AppBundle:Imagegallery')->findAll();
        $full = $em->getRepository('AppBundle:Gallery')->findAll();
        // Enviar todas las etiquetas sin repetir.
        $array_tag = array();
        for ($i=0;$i<count($gall);$i++)
        {
            $temp= $gall[$i]->getTags();
            if(!array_search($temp, $array_tag))
            {
                $array_tag[$i]= array('tags'=>$temp);
            }
        }
        return $this->render('frontend/galeria/galeria.html.twig', array('gallery'=>$full, 'tags'=>$array_tag));
    }
}