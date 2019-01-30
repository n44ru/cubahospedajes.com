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
            if($request->request->get('coordenadas'))
            {
                $id_casa = $request->request->get('select_casas');
                $id_punto = $request->request->get('select_puntos');
                $coordenadas = $request->request->get('coordenadas');
                //
                $coord = new Coordenadas();
                if($id_casa!=null)
                {
                    $casa_object = $em->getRepository('AppBundle:Casa')->find($id_casa);
                    $nombre=$casa_object->getNombre();
                    $coord->setCasaid($casa_object);
                    $coord->setPuntosid(null);
                }
                else {
                    $punto_object = $em->getRepository('AppBundle:Puntos')->find($id_punto);
                    $nombre=$punto_object->getNombre();
                    $coord->setCasaid(null);
                    $coord->setPuntosid($punto_object);
                }
                $coord->setCoordenadas($coordenadas);
                $em->persist($coord);
                $em->flush();
                //
                return $this->redirectToRoute('coord_ver');
            }
            if($request->request->get('coordenadas_editar'))
            {
                /*$id_casa = $request->request->get('select_casas');
                $id_punto = $request->request->get('select_puntos');*/
                //
                $coordenadas = $request->request->get('coordenadas_editar');
                $id = $request->request->get('id');
                $coord = $em->getRepository('AppBundle:Coordenadas')->find($id);
                //
                $coord->setCoordenadas($coordenadas);
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