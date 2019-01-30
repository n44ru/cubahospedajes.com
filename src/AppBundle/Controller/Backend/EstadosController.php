<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\Correos;
use AppBundle\Entity\Estados;
use AppBundle\Entity\Etiquetas;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EstadosController extends Controller
{
    /**
     * @Route("/admin/estados", name="estados_ver")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $e = $em->getRepository('AppBundle:Estados')->findAll();
        if ($request->request->count() >= 1) {
            if($request->request->get('estado'))
            {
                $estado = $request->request->get('estado');
                //
                $e = new Estados();
                $e->setEstado($estado);
                $em->persist($e);
                $em->flush();
                //
                return $this->redirectToRoute('estados_ver');
            }
            if($request->request->get('estado_editar'))
            {
                $id= $request->request->get('id');
                $e = $em->getRepository('AppBundle:Estados')->find($id);
                $estado = $request->request->get('estado_editar');
                //
                $e->setEstado($estado);
                $em->persist($e);
                $em->flush();
                //
                return $this->redirectToRoute('estados_ver');
            }
        }
        return $this->render('backend/estados/ver.html.twig', array('e' => $e));
    }
    /**
     * @Route("/admin/estados/eliminar/{id}", name="estados_eliminar")
     */
    public function EliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $e = $em->getRepository('AppBundle:Estados')->find($id);
        $em->remove($e);
        $em->flush();
        return $this->redirectToRoute('estados_ver');
    }
}