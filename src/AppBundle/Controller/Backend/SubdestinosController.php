<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\Subdestinos;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SubdestinosController extends Controller
{
    /**
     * @Route("/admin/subdestinos", name="subdestinos_ver")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $destinos = $em->getRepository('AppBundle:Destinos')->findAll();
        $subdestinos = $em->getRepository('AppBundle:Subdestinos')->findAll();

        // Controlar las peticiones del los modals.
        if ($request->request->count() >= 1) {
            if ($request->request->get('nombre')) {
                $nombre = $request->request->get('nombre');
                $destino_id = $request->request->get('select_destinos');
                $destinos = $em->getRepository('AppBundle:Destinos')->find($destino_id);
                $dest = new Subdestinos();
                $dest->setNombre($nombre);
                $dest->setDestinoid($destinos);
                //
                $em->persist($dest);
                $em->flush();
                //
                return $this->redirectToRoute('subdestinos_ver');
            }
            if ($request->request->get('nombre_editar')) {
                //
                $nombre = $request->request->get('nombre_editar');
                // id del subdestino, se coge del input hidden
                $id = $request->request->get('id');
                $dest = $em->getRepository('AppBundle:Subdestinos')->find($id);
                // id del destino del select.
                $destino_id = $request->request->get('select_destinos');
                $destinos = $em->getRepository('AppBundle:Destinos')->find($destino_id);
                //
                $dest->setNombre($nombre);
                $dest->setDestinoid($destinos);
                //
                $em->persist($dest);
                $em->flush();
                //
                return $this->redirectToRoute('subdestinos_ver');
            }

        }
        return $this->render('backend/subdestinos/ver.html.twig', array('destinos' => $destinos, 'subdestinos' => $subdestinos));
    }

    /**
     * @Route("/admin/subdestinos/eliminar/{id}", name="subdestinos_eliminar")
     */
    public function EliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $puntos = $em->getRepository('AppBundle:Subdestinos')->find($id);
        $em->remove($puntos);
        $em->flush();
        return $this->redirectToRoute('subdestinos_ver');
    }
}