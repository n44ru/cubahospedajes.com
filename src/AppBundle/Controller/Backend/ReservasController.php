<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\Prereservas;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ReservasController extends Controller
{
    /**
     * @Route("/admin/reservas", name="reservas_ver")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $reservas_todas = $em->getRepository('AppBundle:Prereservas')->findAll();
        $casas_todas = $em->getRepository('AppBundle:Casa')->findAll();
        // Aqui va capturar el post.
        if ($request->request->count() > 1) {
            if ($request->request->get('select_casas_insert')) {
                $id_casa = $request->request->get('select_casas_insert');
                $casa = $em->getRepository('AppBundle:Casa')->find($id_casa);
                //
                $fecha1 = $request->request->get('fecha1');
                $fecha2 = $request->request->get('fecha2');
                $guest = $request->request->get('guest');
                $hab = $request->request->get('hab');
                $nombre = $request->request->get('nombre');
                $email = $request->request->get('email');
                $telefono = $request->request->get('telefono');
                $pais = $request->request->get('pais');
                $datosvuelo = $request->request->get('datosvuelo');
                $horallegada = $request->request->get('horallegada');
                $comentarios = $request->request->get('comentarios');
                //
                $reservas = new Prereservas();
                $reservas->setCasaid($casa);
                $reservas->setFechasalida($fecha1);
                $reservas->setFechallegada($fecha2);
                $reservas->setCantpersonas($guest);
                $reservas->setCanthab($hab);
                $reservas->setNombre($nombre);
                $reservas->setEmail($email);
                $reservas->setTelefono($telefono);
                $reservas->setPais($pais);
                $reservas->setDatosvuelo($datosvuelo);
                $reservas->setHorallegada($horallegada);
                $reservas->setComentario($comentarios);
                $reservas->setAccion('Prereserva');
                //
                $em->persist($reservas);
                $em->flush();
                return $this->redirectToRoute("reservas_ver");
            }
            // Controlar priemro el id para la edicion.
            if ($request->request->get('select_casas_edit')) {
                $id = $request->request->get('id');
                $reservas = $em->getRepository('AppBundle:Prereservas')->find($id);
                //
                $id_casa = $request->request->get('select_casas_edit');
                $casa = $em->getRepository('AppBundle:Casa')->find($id_casa);
                //
                $fecha1 = $request->request->get('fecha1');
                $fecha2 = $request->request->get('fecha2');
                $guest = $request->request->get('guest');
                $hab = $request->request->get('hab');
                $nombre = $request->request->get('nombre');
                $email = $request->request->get('email');
                $telefono = $request->request->get('telefono');
                $pais = $request->request->get('pais');
                $datosvuelo = $request->request->get('datosvuelo');
                $horallegada = $request->request->get('horallegada');
                $comentarios = $request->request->get('comentarios');
                //
                $reservas->setCasaid($casa);
                $reservas->setFechasalida($fecha1);
                $reservas->setFechallegada($fecha2);
                $reservas->setCantpersonas($guest);
                $reservas->setCanthab($hab);
                $reservas->setNombre($nombre);
                $reservas->setEmail($email);
                $reservas->setTelefono($telefono);
                $reservas->setPais($pais);
                $reservas->setDatosvuelo($datosvuelo);
                $reservas->setHorallegada($horallegada);
                $reservas->setComentario($comentarios);

                $em->persist($reservas);
                $em->flush();
                return $this->redirectToRoute("reservas_ver");

            }
        }
        //
        return $this->render('backend/reservas/ver.html.twig', array('reservas' => $reservas_todas, 'casas'=>$casas_todas));
    }

    /**
     * @Route("/admin/reservas/eliminar/{id}", name="reservas_eliminar")
     */
    public function EliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reservas = $em->getRepository('AppBundle:Prereservas')->find($id);
        $em->remove($reservas);
        $em->flush();
        return $this->redirectToRoute('reservas_ver');
    }
}