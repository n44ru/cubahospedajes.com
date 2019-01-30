<?php

namespace AppBundle\Controller\Backend;


use AppBundle\Entity\Casa;
use AppBundle\Entity\Imagenes;
use AppBundle\Entity\Testimonios;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Tests\CacheWarmer\TestCacheWarmer;

class TestimoniosController extends Controller
{
    /**
     * @Route("/admin/testimonios", name="testimonios_ver")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $testimonios = $em->getRepository('AppBundle:Testimonios')->findAll();
        $casas = $em->getRepository('AppBundle:Casa')->findAll();
        $puntos = $em->getRepository('AppBundle:Puntos')->findAll();
        if ($request->request->count() > 1) {
            if($request->request->get('comentario_insert'))
            {
                $id_casa = $request->request->get('select_casas');
                $id_punto = $request->request->get('select_puntos');
                $nombre = $request->request->get('nombre');
                $rating = $request->request->get('rating');
                $comentarios = $request->request->get('comentario_insert');
                $activo = $request->request->get('activo');
                $option = $request->request->get('option');
                //
                $test = new Testimonios();
                if($option=='casas')
                {
                    $casa_object = $em->getRepository('AppBundle:Casa')->find($id_casa);
                    $test->setCasaid($casa_object);
                    $test->setPuntosid(null);
                }
                else {
                    $punto_object = $em->getRepository('AppBundle:Puntos')->find($id_punto);
                    $test->setCasaid(null);
                    $test->setPuntosid($punto_object);
                }
                $test->setNombre($nombre);
                $test->setRating($rating);
                $test->setComentario($comentarios);
                $test->setActivo($activo);
                // Escribir la fecha del dia.
                $test->setFecha(date("d/m/y"));
                $em->persist($test);
                $em->flush();
                //
                return $this->redirectToRoute('testimonios_ver');
            }
            if($request->request->get('id'))
            {
                $id = $request->request->get('id');
                $nombre = $request->request->get('nombre');
                $rating = $request->request->get('rating');
                $comentarios = $request->request->get('comentario');
                $activo = $request->request->get('activo');
                $test = $em->getRepository('AppBundle:Testimonios')->find($id);
                $test->setNombre($nombre);
                $test->setRating($rating);
                $test->setComentario($comentarios);
                $test->setActivo($activo);
                $test->setFecha(Date('d-m-y'));
                $em->persist($test);
                $em->flush();
                //
                return $this->redirectToRoute('testimonios_ver');
            }
        }
        return $this->render('backend/testimonios/ver.html.twig', array('testimonios' => $testimonios, 'casas'=> $casas, 'puntos'=> $puntos));

    }
    /**
     * @Route("/admin/testimonios/{id}", name="testimonios_eliminar")
     */
    public function EliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $testimonios = $em->getRepository('AppBundle:Testimonios')->find($id);
        $em->remove($testimonios);
        $em->flush();
        return $this->redirectToRoute('testimonios_ver');
    }
    /**
     * @Route("/admin/testimonios/activar/{id}", name="testimonios_activar")
     */
    public function ActivarAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $s = $em->getRepository('AppBundle:Testimonios')->find($id);
        $s->setActivo('Si');
        $em->persist($s);
        $em->flush();
        return $this->redirectToRoute('testimonios_ver');
    }
}