<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\Recomendados;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class RecomendadosController extends Controller
{
    /**
     * @Route("/admin/recomendados", name="recomendados_ver")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $recomend = $em->getRepository('AppBundle:Recomendados')->findAll();
        $casas = $em->getRepository('AppBundle:Casa')->findAll();
        $puntos = $em->getRepository('AppBundle:Puntos')->findAll();
        if ($request->request->count() >= 1) {
            if($request->request->get('peso'))
            {
                $id_casa = $request->request->get('select_casas');
                $id_punto = $request->request->get('select_puntos');
                //$r = $request->request->get('recomendado');
                $p = $request->request->get('peso');
                //
                $option = $request->request->get('option');
                $recom = new Recomendados();
                if($option=='casas'){
                    $casa_object = $em->getRepository('AppBundle:Casa')->find($id_casa);
                    $recom->setCasaid($casa_object);
                    $recom->setPuntosid(null);
                }
                else {
                    $punto_object = $em->getRepository('AppBundle:Puntos')->find($id_punto);
                    $recom->setCasaid(null);
                    $recom->setPuntosid($punto_object);
                }
                //$recom->setRecomendado($r);
                $recom->setPeso($p);
                $em->persist($recom);
                $em->flush();
                //
                return $this->redirectToRoute('recomendados_ver');
            }
            if($request->request->get('peso_editar'))
            {

                //$r = $request->request->get('recomendado');
                $p = $request->request->get('peso_editar');
                $id = $request->request->get('id');
                $recom = $em->getRepository('AppBundle:Recomendados')->find($id);
                //
                //$recom->setRecomendado($r);
                $recom->setPeso($p);
                $em->persist($recom);
                $em->flush();
                //
                return $this->redirectToRoute('recomendados_ver');
            }
        }
        return $this->render('backend/recomendados/ver.html.twig', array('recomendados' => $recomend, 'casas'=>$casas, 'puntos'=>$puntos));
    }
    /**
     * @Route("/admin/recomendados/eliminar/{id}", name="recomendados_eliminar")
     */
    public function EliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $r = $em->getRepository('AppBundle:Recomendados')->find($id);
        $em->remove($r);
        $em->flush();
        return $this->redirectToRoute('recomendados_ver');
    }
}