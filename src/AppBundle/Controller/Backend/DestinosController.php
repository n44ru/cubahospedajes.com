<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\Destinos;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DestinosController extends Controller
{
    /**
     * @Route("/admin/destinos", name="destinos_ver")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $destinos = $em->getRepository('AppBundle:Destinos')->findAll();
        // Controlar las peticiones del los modals.
        if ($request->request->count() >= 1) {
            if ($request->request->get('nombre')) {
                $nombre = $request->request->get('nombre');
                $dest = new Destinos();
                $dest->setNombre($nombre);
                //
                $em->persist($dest);
                $em->flush();
                //
                return $this->redirectToRoute('destinos_ver');
            }
            if ($request->request->get('nombre_editar')) {
                $nombre = $request->request->get('nombre_editar');
                $id = $request->request->get('id');
                $dest = $em->getRepository('AppBundle:Destinos')->find($id);
                $dest->setNombre($nombre);
                //
                $em->persist($dest);
                $em->flush();
                //
                return $this->redirectToRoute('destinos_ver');
            }

        }
        return $this->render('backend/destinos/ver.html.twig', array('destinos' => $destinos));
    }

    /**
     * @Route("/admin/destinos/eliminar/{id}", name="destinos_eliminar")
     */
    public function EliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $puntos = $em->getRepository('AppBundle:Destinos')->find($id);
        $em->remove($puntos);
        $em->flush();
        return $this->redirectToRoute('destinos_ver');
    }
}