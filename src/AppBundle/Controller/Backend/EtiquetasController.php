<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\Etiquetas;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EtiquetasController extends Controller
{
    /**
     * @Route("/admin/etiquetas", name="etiquetas_ver")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $e = $em->getRepository('AppBundle:Etiquetas')->findAll();
        if ($request->request->count() >= 1) {
            if($request->request->get('nombre'))
            {
                $nombre = $request->request->get('nombre');
                //
                $e = new Etiquetas();
                $e->setNombre($nombre);
                //
                $em->persist($e);
                $em->flush();
                //
                return $this->redirectToRoute('etiquetas_ver');
            }
            if($request->request->get('nombre_editar'))
            {
                $id= $request->request->get('id');
                $e = $em->getRepository('AppBundle:Etiquetas')->find($id);
                $nombre = $request->request->get('nombre_editar');
                //
                $e->setNombre($nombre);
                //
                $em->persist($e);
                $em->flush();
                //
                return $this->redirectToRoute('etiquetas_ver');
            }
        }
        return $this->render('backend/etiquetas/ver.html.twig', array('e' => $e));
    }
    /**
     * @Route("/admin/etiquetas/eliminar/{id}", name="etiquetas_eliminar")
     */
    public function EliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $e = $em->getRepository('AppBundle:Etiquetas')->find($id);
        $em->remove($e);
        $em->flush();
        return $this->redirectToRoute('etiquetas_ver');
    }
}