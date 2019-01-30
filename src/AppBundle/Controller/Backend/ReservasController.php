<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\Prereservas;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ReservasController extends Controller
{
    /**
     * @Route("/admin/reservas", name="reservas_ver")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //
        // Enviar todos los estados
        $estados = $em->getRepository('AppBundle:Estados')->findAll();
        $reservas_todas = $em->getRepository('AppBundle:Prereservas')->findAll();
        $casas_todas = $em->getRepository('AppBundle:Casa')->findAll();
        $config = $em->getRepository('AppBundle:Settings')->find(1);
        $operation = "";
        // Aqui va capturar el post.
        if ($request->request->count() >= 1) {
            // Controlar la busqueda
            if ($request->request->get('select_casas_insert')) {
                $id_casa = $request->request->get('select_casas_insert');
                $casa = $em->getRepository('AppBundle:Casa')->find($id_casa);
                //
                $estado = $request->request->get('estado');
                $estado_object = $em->getRepository('AppBundle:Estados')->find($estado);
                //
                $fecha_raw = $request->request->get('fecha1');
                // Llamando al servicio que me convierte la fecha
                $result=$this->get('app.convertdate')->convert($fecha_raw);
                $fecha1 = $result['fecha1'];
                $fecha2 = $result['fecha2'];
                //Fix de las fechas
                $fecha1= $this->get('app.convertdate')->date_format($fecha1);
                $fecha2= $this->get('app.convertdate')->date_format($fecha2);
                //
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
                $reservas->setFechasalida($fecha2);
                $reservas->setFechallegada($fecha1);
                $reservas->setCantpersonas($guest);
                $reservas->setCanthab($hab);
                $reservas->setNombre($nombre);
                $reservas->setEmail($email);
                $reservas->setTelefono($telefono);
                $reservas->setPais($pais);
                $reservas->setDatosvuelo($datosvuelo);
                $reservas->setHorallegada($horallegada);
                $reservas->setComentario($comentarios);
                $reservas->setEstadosid($estado_object);
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
                $estado = $request->request->get('estado');
                $estado_object = $em->getRepository('AppBundle:Estados')->find($estado);
                //
                $id_casa = $request->request->get('select_casas_edit');
                $casa = $em->getRepository('AppBundle:Casa')->find($id_casa);
                //
                $fecha1 = $request->request->get('fecha1');
                $fecha2 = $request->request->get('fecha2');
                //Fix de las fechas
                $fecha1= $this->get('app.convertdate')->date_format($fecha1);
                $fecha2= $this->get('app.convertdate')->date_format($fecha2);
                //
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
                $reservas->setFechasalida($fecha2);
                $reservas->setFechallegada($fecha1);
                $reservas->setCantpersonas($guest);
                $reservas->setCanthab($hab);
                $reservas->setNombre($nombre);
                $reservas->setEmail($email);
                $reservas->setTelefono($telefono);
                $reservas->setPais($pais);
                $reservas->setDatosvuelo($datosvuelo);
                $reservas->setHorallegada($horallegada);
                $reservas->setComentario($comentarios);
                $reservas->setEstadosid($estado_object);

                $em->persist($reservas);
                $em->flush();
                return $this->redirectToRoute("reservas_ver");
            }
            if ($request->request->get('id_estado')) {
                $this->reservaAction($request);
            }
            if ($request->request->get('finder')) {
                $reservas_todas = $this->filtroAction($request);
            }

        }
        return $this->render('backend/reservas/ver.html.twig', array('reservas' => $reservas_todas, 'casas' => $casas_todas, 'config' => $config, 'estados' => $estados));
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

    // Este es el metodo para el filtro dinamico.

    public function filtroAction($request)
    {
        $em = $this->getDoctrine()->getManager();
        //
        $estados = $request->request->get('estado');
        $nombre = $request->request->get('nombre');
        $pais = $request->request->get('pais');
        $email = $request->request->get('email');
        $fecha_raw = $request->request->get('fecha1');
        // Llamando al servicio que me convierte la fecha
        $fecha1 = null;
        $fecha2 = null;
        if($fecha_raw!= null)
        {
            $result=$this->get('app.convertdate')->convert($fecha_raw);
            $fecha1 = $result['fecha1'];
            $fecha2 = $result['fecha2'];
            // Fix de las fechas
            $fecha1= $this->get('app.convertdate')->date_format($fecha1);
            $fecha2= $this->get('app.convertdate')->date_format($fecha2);
            //
        }
        $hora = $request->request->get('hora');
        $guest = $request->request->get('guest');
        $rooms = $request->request->get('rooms');
        $datosvuelo = $request->request->get('datosvuelo');
        $telefono = $request->request->get('telefono');
        $comentarios = $request->request->get('comentarios');
        //
        $i = 0;
        $query = "SELECT p FROM AppBundle:Prereservas p";
        // Estados Fix.
        if ($i == 0 && $estados) {
            $query = $query . " WHERE p.estadosid = " . $estados;
            $i++;
        } else if ($i > 0 && $estados) {
            $query = $query . " AND p.estadosid = " . $estados;
        }
        //
        if ($i == 0 && $nombre) {
            $query = $query . " WHERE p.nombre LIKE '%" . $nombre . "%'";
            $i++;
        } else if ($i > 0 && $nombre) {
            $query = $query . " AND p.nombre LIKE '%" . $nombre . "%'";
        }
        //
        if ($i == 0 && $pais) {
            $query = $query . " WHERE p.pais LIKE '%" . $pais . "%'";
            $i++;
        } else if ($i > 0 && $pais) {
            $query = $query . " AND p.pais LIKE '%" . $pais . "%'";
        }
        //
        if ($i == 0 && $email) {
            $query = $query . " WHERE p.email LIKE '%" . $email . "%'";
            $i++;
        } else if ($i > 0 && $email) {
            $query = $query . " AND p.email LIKE '%" . $email . "%'";
        }
        // Fechas aqui.
        if ($i == 0 && $fecha1) {
            $query = $query . " WHERE p.fechallegada >= " . $fecha1 . " AND p.fechasalida <= ".$fecha2;
            $i++;
        } else if ($i > 0 && $fecha1) {
            $query = $query . " AND p.fechallegada >= " . $fecha1 . " AND p.fechasalida <= ".$fecha2;
        }
//        if ($i == 0 && $fecha2) {
//            $query = $query . " WHERE p.fechasalida >= '" . $fecha2 . "'";
//            $i++;
//        } else if ($i > 0 && $fecha2) {
//            $query = $query . " AND p.fechasalida >= '" . $fecha2 . "'";
//        }
        //
        if ($i == 0 && $hora) {
            $query = $query . " WHERE p.horallegada LIKE '%" . $hora . "%'";
            $i++;
        } else if ($i > 0 && $hora) {
            $query = $query . " AND p.horallegada LIKE '%" . $hora . "%'";
        }
        if ($i == 0 && $guest) {
            $query = $query . " WHERE p.cantpersonas >= " . $guest;
            $i++;
        } else if ($i > 0 && $guest) {
            $query = $query . " AND p.cantpersonas >= " . $guest;
        }
        if ($i == 0 && $rooms) {
            $query = $query . " WHERE p.canthab >= " . $rooms;
            $i++;
        } else if ($i > 0 && $rooms) {
            $query = $query . " AND p.canthab >= " . $rooms;
        }
        if ($i == 0 && $datosvuelo) {
            $query = $query . " WHERE p.datosvuelo LIKE '%" . $datosvuelo . "%'";
            $i++;
        } else if ($i > 0 && $datosvuelo) {
            $query = $query . " AND p.datosvuelo LIKE '%" . $datosvuelo . "%'";
        }
        if ($i == 0 && $telefono) {
            $query = $query . " WHERE p.telefono LIKE '%" . $telefono . "%'";
            $i++;
        } else if ($i > 0 && $telefono) {
            $query = $query . " AND p.telefono LIKE '%" . $telefono . "%'";
        }
        if ($i == 0 && $comentarios) {
            $query = $query . " WHERE p.comentario LIKE '%" . $comentarios . "%'";
            $i++;
        } else if ($i > 0 && $comentarios) {
            $query = $query . " AND p.comentario LIKE '%" . $comentarios . "%'";
        }
        $query_end = $em->createQuery($query);
        $filtro = $query_end->getResult();
        return $filtro;
    }
    // Identico al de reservas controller.
    public function reservaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('id');
        //$mail_id = $request->request->get('mail_id');
        $id_estado = $request->request->get('id_estado');
        $estadoobject = $em->getRepository('AppBundle:Estados')->find($id_estado);
        // Fix 25 de junio.
        $reservas = $em->getRepository('AppBundle:Prereservas')->find($id);
        $reservas->setEstadosid($estadoobject);
        $em->persist($reservas);
        $em->flush();
        //Ver si se envia o no.
        $sendemail = $request->request->get('sendemail');
        // Viendo a quien se le manda.
        $email_cliente = $request->request->get('ch_email_cliente');
        $email_hostal = $request->request->get('ch_email_casa');
        $email_destino = $request->request->get('ch_email_subdestino');
        $email_global = $request->request->get('ch_email_global');

        $msgcliente = $request->request->get('msgcliente');
        $msghostal = $request->request->get('msghostal');
        $msgadmins = $request->request->get('msgadmins');

        $asunto = $request->request->get('asunto');

        $data = array(
            'email_cliente' => $email_cliente,
            'email_hostal' => $email_hostal,
            'email_destino' => $email_destino,
            'email_global' => $email_global,
            'msgcliente' => $msgcliente,
            'msghostal' => $msghostal,
            'msgadmin' => $msgadmins,
            'asunto' => $asunto);
//        var_dump($sendemail);
//        die;
        if ($sendemail != null) {
            $this->SendMail($data);
        }
    }
    public function SendMail($data)
    {
        $cabeceras = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        if ($data['email_destino'] != null)
            $cabeceras .= 'From: ' . $data['email_destino'] . "\r\n";
        else {
            $cabeceras .= 'From: ' . $data['email_global'] . "\r\n";
        }
        // 1er Email para el cliente.
        if ($data['email_cliente'] != null) {
            mail($data['email_cliente'], $data['asunto'], $data['msgcliente'], $cabeceras);
        }
        // 2do Email para el hostal
        if ($data['email_hostal'] != null) {
            mail($data['email_hostal'], $data['asunto'], $data['msghostal'], $cabeceras);
        }
        // 3er Email para los admins.
        if ($data['email_destino'] != $data['email_global']) {
            $cabeceras .= 'Cc: ' . $data['email_global'] . "\r\n";
            if ($data['email_destino'] != null) {
                mail($data['email_destino'], $data['asunto'], $data['msgadmin'], $cabeceras);
            }
        } else {
            if ($data['email_global'] != null) {
                mail($data['email_global'], $data['asunto'], $data['msgadmin'], $cabeceras);
            }
        }
    }
}