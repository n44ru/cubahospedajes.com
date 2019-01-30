<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\Casa;
use AppBundle\Entity\Imagenes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class InactivasController extends Controller
{
    /**
     * @Route("/admin/casas/inactivas", name="casa_inactivas")
     */
    public function InactivasAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //
        $query = $em->createQuery('SELECT p FROM AppBundle:Casa p WHERE p.activa = ?1 ');
        $query->setParameter(1, 'No');
        $casas = $query->getResult();
        $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.casaid >= 1 ');
        $imagenes = $query->getResult();

        return $this->render('backend/casas/inactivas/ver.html.twig', array('casas' => $casas, 'imagenes' => $imagenes));
    }
    /**
     * @Route("/admin/casas/activar/{id}", name="casa_activar")
     */
    public function ActivarAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $s = $em->getRepository('AppBundle:Casa')->find($id);
        $s->setActiva('Si');
        $em->persist($s);
        $em->flush();
        return $this->redirectToRoute('casa_inactivas');
    }
    /**
     * @Route("/admin/casas/eliminar/inactivas/{id}", name="casa_inactivas_eliminar")
     */
    public function EliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $linea = $em->getRepository('AppBundle:Casa')->find($id);
        $em->remove($linea);
        $em->flush();
        return $this->redirectToRoute('casa_ver');
    }
}