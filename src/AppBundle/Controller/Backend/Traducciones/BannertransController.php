<?php

namespace AppBundle\Controller\Backend\Traducciones;

use AppBundle\Entity\Idiomas;
use AppBundle\Entity\Traducciones;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BannertransController extends Controller
{
    /**
     * @Route("/admin/trans/banner", name="bannertrans_ver")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        // Alertas del Admin.
        $alertas = $em->getRepository('AppBundle:Alertas')->find(1);
         // Buscar todas las traducciones que sean casas.
        $query = $em->createQuery('SELECT p FROM AppBundle:Traducciones p WHERE p.bannerid >= 1');
        $banner = $query->getResult();
        // Buscar todas los Banners
        $banner_todos = $em->getRepository('AppBundle:Banner')->findAll();
        // Buscar todos los idiomas
        $idiomas_todos = $em->getRepository('AppBundle:Idiomas')->findAll();
        //
        if ($request->request->count() >= 1) {
            if($request->request->get('titulo'))
            {
                $titulo = $request->request->get('titulo');
                $direccion = $request->request->get('direccion');
                $desc = $request->request->get('desc');
                $texto = $request->request->get('texto');
                // Relacion con Idioma
                $idioma = $request->request->get('idioma');
                $idioma_object = $em->getRepository('AppBundle:Idiomas')->find($idioma);
                // Relacion con Banner
                $bannerid = $request->request->get('bannerid');
                $banner_obj = $em->getRepository('AppBundle:Banner')->find($bannerid);
                //Traducciones
//                $b = translate($titulo, 'es', 'en');
//                var_dump($b);
//                die;
                //
                $e = new Traducciones();
                $e->setTexto1($titulo);
                $e->setTexto2($desc);
                $e->setTexto3($direccion);
                $e->setTexto4($texto);
                $e->setIdiomasid($idioma_object);
                $e->setBannerid($banner_obj);
                //
                $em->persist($e);
                $em->flush();
                //
                return $this->redirectToRoute('bannertrans_ver');
            }
            if($request->request->get('titulo_editar'))
            {
                $id= $request->request->get('id');
                $e = $em->getRepository('AppBundle:Traducciones')->find($id);
                //
                $titulo = $request->request->get('titulo_editar');
                $direccion = $request->request->get('direccion');
                $desc = $request->request->get('desc');
                $texto = $request->request->get('texto');
                // Relacion con Idioma
                $e->setTexto1($titulo);
                $e->setTexto2($desc);
                $e->setTexto3($direccion);
                $e->setTexto4($texto);
                //
                $em->persist($e);
                $em->flush();
                //
                return $this->redirectToRoute('bannertrans_ver');
            }
        }
        return $this->render('backend/idiomas/bannertrans.html.twig', array('trans' => $banner,'banner_todos'=> $banner_todos, 'idiomas'=> $idiomas_todos, 'alertas'=> $alertas));
    }
    /**
     * @Route("/admin/trans/banner/eliminar/{id}", name="bannertrans_eliminar")
     */
    public function EliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $e = $em->getRepository('AppBundle:Traducciones')->find($id);
        $em->remove($e);
        $em->flush();
        return $this->redirectToRoute('bannertrans_ver');
    }
}