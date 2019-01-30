<?php

namespace AppBundle\Controller\Backend\ManytoMany;

use AppBundle\Entity\CasaEtiqueta;
use AppBundle\Entity\Correosestados;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CorreoEstadosController extends Controller
{
    /**
     * @Route("/admin/correoestados", name="correoestados_ver")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        // Alertas del Admin.
        $alertas = $em->getRepository('AppBundle:Alertas')->find(1);
        //
        $c = $em->getRepository('AppBundle:Correos')->findAll();
        $e = $em->getRepository('AppBundle:Estados')->findAll();
        $todos = $em->getRepository('AppBundle:Correosestados')->findAll();
        if ($request->request->count() > 1) {
                $correo = $request->request->get('correoid');
                $estado = $request->request->get('estadoid');

                $c = $em->getRepository('AppBundle:Correos')->find($correo);
                $e = $em->getRepository('AppBundle:Estados')->find($estado);

                $ce = new Correosestados();
                $ce->setCorreosid($c);
                $ce->setEstadosid($e);
                //
                $em->persist($ce);
                $em->flush();
                //
                return $this->redirectToRoute('correoestados_ver');
        }
        return $this->render('backend/correoestados/ver.html.twig', array('estados' => $e, 'correos'=> $c, 'todos'=>$todos, 'alertas'=> $alertas));
    }
    /**
     * @Route("/admin/correoestado/eliminar/{id}", name="correoestado_eliminar")
     */
    public function EliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $c = $em->getRepository('AppBundle:Correosestados')->find($id);
        $em->remove($c);
        $em->flush();
        return $this->redirectToRoute('correoestados_ver');
    }
    /**
     * @Route("/admin/correo/estado", name="correoestado_dinamico")
     */
    public function correoestadodinamicoAction(Request $request)
    {
        $id_estado = $request->request->get('id_estado');
        $id_r = $request->request->get('id_r');
/*        var_dump($id_estado);
        die;*/
        //
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT p FROM AppBundle:Correosestados p WHERE p.estadosid ='.$id_estado);
        //
        $estado = $em->getRepository('AppBundle:Estados')->find($id_estado);
        $config = $em->getRepository('AppBundle:Settings')->find(1);
        $correoestados = $query->getResult();
        //
        $c = $em->getRepository('AppBundle:Prereservas')->find($id_r);
        return $this->render('backend/reservas/dinamico/correo.html.twig', array('correoestados'=> $correoestados, 'pre'=>$c, 'estado'=>$estado, 'config'=>$config));
    }
    /**
     * @Route("/admin/correo/dd", name="dd")
     */
    public function dsAction(Request $request)
    {
        $id_mail = $request->request->get('id_mail');
        $id_r = $request->request->get('id_r');
        $em = $this->getDoctrine()->getManager();
        $correo = $em->getRepository('AppBundle:Correos')->find($id_mail);
        $c = $em->getRepository('AppBundle:Prereservas')->find($id_r);
        return $this->render('backend/reservas/dinamico/dd.html.twig', array('correo'=> $correo, 'pre'=> $c));
    }
}