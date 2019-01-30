<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LugaresController extends Controller
{
    /**
     * @Route("/lugares/todos", name="casas_todas")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dest = $em->getRepository('AppBundle:Destinos')->findAll();
        return $this->render('frontend/lugares/lugares.html.twig', array('destinos'=>$dest));
    }
    /**
     * @Route("/dynamic/sub", name="sub_dynamic")
     */
    public function subAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $destino = $request->request->get('destino');
        $query = $em->createQuery('SELECT p FROM AppBundle:Subdestinos p WHERE p.destinoid = ?1 ');
        $query->setParameter(1, $destino);
        $sub = $query->getResult();
        return $this->render('frontend/lugares/dinamico/subdestinos.html.twig', array('subdestinos'=>$sub));
    }
    /**
     * @Route("/dynamic/sub/results", name="sub_dynamic_two")
     */
    public function subtwoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $sub = $request->request->get('subdestinos');
        // buscando todas las casa con el el id.
        $query = $em->createQuery('SELECT p FROM AppBundle:Casa p WHERE p.subdestinosid = ?1 ');
        $query->setParameter(1, $sub);
        $casas = $query->getResult();
        // buscando todos los puntos con el el id.
        $query = $em->createQuery('SELECT p FROM AppBundle:Puntos p WHERE p.subdestinosid = ?1 ');
        $query->setParameter(1, $sub);
        $puntos = $query->getResult();
        // Buscando todas las imagenes de casas.
        $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.casaid >0 ');
        $img_casas = $query->getResult();
        // Buscando todas las imagenes de puntos.
        $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.puntosid >0 ');
        $img_puntos = $query->getResult();
        return $this->render('frontend/lugares/dinamico/resultados.html.twig', array('casas'=>$casas, 'puntos'=> $puntos, 'img_casas'=>$img_casas, 'img_puntos'=>$img_puntos));
    }
    /**
     * @Route("/dynamic/text/results", name="text_dynamic")
     */
    public function textAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $sub = $request->request->get('subdestinos');
        $text = $request->request->get('texto');
        // buscando todas las casa con el text.
        $query = $em->createQuery('SELECT p FROM AppBundle:Casa p WHERE p.subdestinosid = ?1 AND p.nombre LIKE ?2');
        $query->setParameter(1, $sub);
        $query->setParameter(2, '%' . $text . '%');
        $casas = $query->getResult();
        // buscando todos los puntos con el text.
        $query = $em->createQuery('SELECT p FROM AppBundle:Puntos p WHERE p.subdestinosid = ?1 AND p.nombre LIKE ?2');
        $query->setParameter(1, $sub);
        $query->setParameter(2, '%' . $text . '%');
        $puntos = $query->getResult();
        // Buscando todas las imagenes de casas.
        $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.casaid >0 ');
        $img_casas = $query->getResult();
        // Buscando todas las imagenes de puntos.
        $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.puntosid >0 ');
        $img_puntos = $query->getResult();
        return $this->render('frontend/lugares/dinamico/resultados.html.twig', array('casas'=>$casas, 'puntos'=> $puntos, 'img_casas'=>$img_casas, 'img_puntos'=>$img_puntos));
    }
    /**
     * @Route("/puntosdeinteres/{id}/{subid}", name="puntos_cercanias")
     */
    public function cercaniasAction(Request $request, $id, $subid)
    {
        $em = $this->getDoctrine()->getManager();
        $el = $em->getRepository('AppBundle:Puntos')->find($id);
        // buscando todas las casa con el text.
        $query = $em->createQuery('SELECT p FROM AppBundle:Casa p WHERE p.subdestinosid = ?1');
        $query->setParameter(1, $subid);
        $casas = $query->getResult();
        // buscando todos los puntos con el text.
        $query = $em->createQuery('SELECT p FROM AppBundle:Puntos p WHERE p.subdestinosid = ?1');
        $query->setParameter(1, $subid);
        $puntos = $query->getResult();
        // Buscando todas las imagenes de casas.
        $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.casaid >0 ');
        $img_casas = $query->getResult();
        // Buscando todas las imagenes de puntos.
        $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.puntosid >0 ');
        $img_puntos = $query->getResult();
        return $this->render('frontend/puntos/puntos.html.twig', array('casas'=>$casas, 'puntos'=> $puntos, 'img_casas'=>$img_casas, 'img_puntos'=>$img_puntos, 'punto'=>$el));
    }
}