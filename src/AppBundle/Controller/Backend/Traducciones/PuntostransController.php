<?php

namespace AppBundle\Controller\Backend\Traducciones;

use AppBundle\Entity\Idiomas;
use AppBundle\Entity\Traducciones;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PuntostransController extends Controller
{
    /**
     * @Route("/admin/trans/puntos", name="puntostrans_ver")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        // Alertas del Admin.
        $alertas = $em->getRepository('AppBundle:Alertas')->find(1);
         // Buscar todas las traducciones que sean casas.
        $query = $em->createQuery('SELECT p FROM AppBundle:Traducciones p WHERE p.puntosid >= 1 ');
        $puntostrans = $query->getResult();
        // Buscar todas los Puntos
        $puntos_todos = $em->getRepository('AppBundle:Puntos')->findAll();
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
                // Relacion con Idioma
                $idioma = $request->request->get('idioma');
                $idioma_object = $em->getRepository('AppBundle:Idiomas')->find($idioma);
                // Relacion con Casa
                $puntoid = $request->request->get('puntoid');
                $casa_object = $em->getRepository('AppBundle:Puntos')->find($puntoid);
                //
                $e = new Traducciones();
                $e->setTexto1($nombre);
                $e->setTexto2($direccion);
                $e->setTexto3($texto);
                $e->setTexto4($metatitle);
                $e->setTexto5($metadesc);
                $e->setTexto6($metakeyword);
                $e->setIdiomasid($idioma_object);
                $e->setPuntosid($casa_object);
                //
                $em->persist($e);
                $em->flush();
                //
                return $this->redirectToRoute('puntostrans_ver');
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
                // Relacion con Idioma
                $e->setTexto1($nombre);
                $e->setTexto2($direccion);
                $e->setTexto3($texto);
                $e->setTexto4($metatitle);
                $e->setTexto5($metadesc);
                $e->setTexto6($metakeyword);
                //
                $em->persist($e);
                $em->flush();
                //
                return $this->redirectToRoute('puntostrans_ver');
            }
        }
        return $this->render('backend/idiomas/puntostrans.html.twig', array('puntostrans' => $puntostrans,'puntos'=> $puntos_todos, 'idiomas'=> $idiomas_todos, 'alertas'=> $alertas));
    }
    /**
     * @Route("/admin/trans/puntos/eliminar/{id}", name="puntostrans_eliminar")
     */
    public function EliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $e = $em->getRepository('AppBundle:Traducciones')->find($id);
        $em->remove($e);
        $em->flush();
        return $this->redirectToRoute('puntostrans_ver');
    }
}