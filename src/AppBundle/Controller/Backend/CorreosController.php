<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\Correos;
use AppBundle\Entity\Etiquetas;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CorreosController extends Controller
{
    /**
     * @Route("/admin/correos", name="correos_ver")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $e = $em->getRepository('AppBundle:Correos')->findAll();
        if ($request->request->count() > 1) {
            if($request->request->get('titulo'))
            {
                $titulo = $request->request->get('titulo');
                $asunto = $request->request->get('asunto');
                $contenido1 = $request->request->get('contenido1');
                $contenido2 = $request->request->get('contenido2');
                $contenido3 = $request->request->get('contenido3');
                //
                $e = new Correos();
                $e->setTitulo($titulo);
                $e->setAsunto($asunto);
                $e->setMsgcliente($contenido1);
                $e->setMsghostal($contenido2);
                $e->setMsgadmins($contenido3);
                //
                $em->persist($e);
                $em->flush();
                //
                return $this->redirectToRoute('correos_ver');
            }
            if($request->request->get('titulo_editar'))
            {
                $id= $request->request->get('id');
                $e = $em->getRepository('AppBundle:Correos')->find($id);
                //
                $titulo = $request->request->get('titulo_editar');
                $asunto = $request->request->get('asunto');
                $contenido1 = $request->request->get('contenido1');
                $contenido2 = $request->request->get('contenido2');
                $contenido3 = $request->request->get('contenido3');
                //
                $e->setTitulo($titulo);
                $e->setAsunto($asunto);
                $e->setMsgcliente($contenido1);
                $e->setMsghostal($contenido2);
                $e->setMsgadmins($contenido3);
                //
                $em->persist($e);
                $em->flush();
                //
                return $this->redirectToRoute('correos_ver');
            }
        }
        return $this->render('backend/correos/ver.html.twig', array('e' => $e));
    }
    /**
     * @Route("/admin/correos/eliminar/{id}", name="correos_eliminar")
     */
    public function EliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $e = $em->getRepository('AppBundle:Correos')->find($id);
        $em->remove($e);
        $em->flush();
        return $this->redirectToRoute('correos_ver');
    }
}