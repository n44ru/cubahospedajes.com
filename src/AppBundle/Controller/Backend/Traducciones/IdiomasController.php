<?php

namespace AppBundle\Controller\Backend\Traducciones;

use AppBundle\Entity\Idiomas;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class IdiomasController extends Controller
{
    /**
     * @Route("/admin/idiomas", name="idiomas_ver")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        // Alertas del Admin.
        $alertas = $em->getRepository('AppBundle:Alertas')->find(1);
        //
        $e = $em->getRepository('AppBundle:Idiomas')->findAll();
        if ($request->request->count() >= 1) {
            if($request->request->get('idioma'))
            {
                $i = $request->request->get('idioma');
                //
                $e = new Idiomas();
                $e->setIdioma($i);
                //
                $em->persist($e);
                $em->flush();
                //
                return $this->redirectToRoute('idiomas_ver');
            }
            if($request->request->get('idioma_editar'))
            {
                $id= $request->request->get('id');
                $e = $em->getRepository('AppBundle:Idiomas')->find($id);
                $i = $request->request->get('idioma_editar');
                //
                $e->setIdioma($i);
                //
                $em->persist($e);
                $em->flush();
                //
                return $this->redirectToRoute('idiomas_ver');
            }
        }
        return $this->render('backend/idiomas/ver.html.twig', array('e' => $e, 'alertas'=> $alertas));
    }
    /**
     * @Route("/admin/idiomas/eliminar/{id}", name="idiomas_eliminar")
     */
    public function EliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $e = $em->getRepository('AppBundle:Idiomas')->find($id);
        $em->remove($e);
        $em->flush();
        return $this->redirectToRoute('idiomas_ver');
    }
}