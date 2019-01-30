<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\Casa;
use AppBundle\Entity\Coordenadas;
use AppBundle\Entity\Imagenes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CoordenadasController extends Controller
{
    /**
     * @Route("/admin/coord", name="coord_ver")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $coo = $em->getRepository('AppBundle:Coordenadas')->findAll();
        $casas = $em->getRepository('AppBundle:Casa')->findAll();
        $puntos = $em->getRepository('AppBundle:Puntos')->findAll();
        if ($request->request->count() >= 1) {
            if($request->request->get('latitud'))
            {
                $id_casa = $request->request->get('select_casas');
                $id_punto = $request->request->get('select_puntos');
                $option = $request->request->get('option');
                $lat = $request->request->get('latitud');
                $long = $request->request->get('longitud');
                //
                $coord = new Coordenadas();
                if($option=='casas')
                {
                    $casa_object = $em->getRepository('AppBundle:Casa')->find($id_casa);
                    $coord->setCasaid($casa_object);
                    $coord->setPuntosid(null);
                }
                else {
                    $punto_object = $em->getRepository('AppBundle:Puntos')->find($id_punto);
                    $coord->setCasaid(null);
                    $coord->setPuntosid($punto_object);
                }
                $coord->setLatitud($lat);
                $coord->setLongitud($long);
                $em->persist($coord);
                $em->flush();
                //
                return $this->redirectToRoute('coord_ver');
            }
            if($request->request->get('latitud_editar'))
            {
                /*$id_casa = $request->request->get('select_casas');
                $id_punto = $request->request->get('select_puntos');*/
                //
                $lat = $request->request->get('latitud_editar');
                $long = $request->request->get('longitud');
                $id = $request->request->get('id');
                $coord = $em->getRepository('AppBundle:Coordenadas')->find($id);
                //

                $coord->setLatitud($lat);
                $coord->setLongitud($long);
                $em->persist($coord);
                $em->flush();
                //
                return $this->redirectToRoute('coord_ver');
            }
        }
        return $this->render('backend/coordenadas/ver.html.twig', array('coo' => $coo, 'casas'=>$casas, 'puntos'=>$puntos));
    }
    /**
     * @Route("/admin/coord/eliminar/{id}", name="coord_eliminar")
     */
    public function EliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $coord = $em->getRepository('AppBundle:Coordenadas')->find($id);
        $em->remove($coord);
        $em->flush();
        return $this->redirectToRoute('coord_ver');
    }
}