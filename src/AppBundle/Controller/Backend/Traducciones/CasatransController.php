<?php

namespace AppBundle\Controller\Backend\Traducciones;

use AppBundle\Entity\Idiomas;
use AppBundle\Entity\Traducciones;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CasatransController extends Controller
{
    /**
     * @Route("/admin/trans/casa", name="casatrans_ver")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        // Alertas del Admin.
        $alertas = $em->getRepository('AppBundle:Alertas')->find(1);
         // Buscar todas las traducciones que sean casas.
        $query = $em->createQuery('SELECT p FROM AppBundle:Traducciones p WHERE p.casaid >= 1 ');
        $casastrans = $query->getResult();
        // Buscar todas las casas
        $casas_todas = $em->getRepository('AppBundle:Casa')->findAll();
        // Buscar todos los idiomas
        $idiomas_todos = $em->getRepository('AppBundle:Idiomas')->findAll();
        //
        if ($request->request->count() >= 1) {
            if($request->request->get('nombre'))
            {
                $nombre = $request->request->get('nombre');
                $direccion = $request->request->get('direccion');
                $texto = $request->request->get('texto');
                $metatitle = $request->request->get('metatitle');
                $metadesc = $request->request->get('metadesc');
                $metakeyword = $request->request->get('metakeyword');
                $reglas = $request->request->get('reglas');
                // Relacion con Idioma
                $idioma = $request->request->get('idioma');
                $idioma_object = $em->getRepository('AppBundle:Idiomas')->find($idioma);
                // Relacion con Casa
                $casaid = $request->request->get('casaid');
                $casa_object = $em->getRepository('AppBundle:Casa')->find($casaid);
                //
                $e = new Traducciones();
                $e->setTexto1($nombre);
                $e->setTexto2($direccion);
                $e->setTexto3($texto);
                $e->setTexto4($reglas);
                $e->setTexto5($metatitle);
                $e->setTexto6($metadesc);
                $e->setTexto7($metakeyword);
                $e->setIdiomasid($idioma_object);
                $e->setCasaid($casa_object);
                //
                $em->persist($e);
                $em->flush();
                //
                return $this->redirectToRoute('casatrans_ver');
            }
            if($request->request->get('nombre_editar'))
            {
                $id= $request->request->get('id');
                $e = $em->getRepository('AppBundle:Traducciones')->find($id);
                //
                $nombre = $request->request->get('nombre_editar');
                $direccion = $request->request->get('direccion');
                $texto = $request->request->get('texto');
                $metatitle = $request->request->get('metatitle');
                $metadesc = $request->request->get('metadesc');
                $metakeyword = $request->request->get('metakeyword');
                $reglas = $request->request->get('reglas');
                // Relacion con Idioma
                $e->setTexto1($nombre);
                $e->setTexto2($direccion);
                $e->setTexto3($texto);
                $e->setTexto4($reglas);
                $e->setTexto5($metatitle);
                $e->setTexto6($metadesc);
                $e->setTexto7($metakeyword);
                //
                $em->persist($e);
                $em->flush();
                //
                return $this->redirectToRoute('casatrans_ver');
            }
        }
        return $this->render('backend/idiomas/casatrans.html.twig', array('casastrans' => $casastrans,'casas'=> $casas_todas, 'idiomas'=> $idiomas_todos, 'alertas'=> $alertas));
    }
    /**
     * @Route("/admin/trans/casas/eliminar/{id}", name="casatrans_eliminar")
     */
    public function EliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $e = $em->getRepository('AppBundle:Traducciones')->find($id);
        $em->remove($e);
        $em->flush();
        return $this->redirectToRoute('casatrans_ver');
    }
}