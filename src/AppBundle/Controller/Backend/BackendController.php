<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\Reservasestados;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BackendController extends Controller
{
    /**
     * @Route("/admin/dashboard", name="dashboard")
     */
    public function backendAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //
        $estados = $em->getRepository('AppBundle:Estados')->findAll();
        //
        //$pre = $em->getRepository('AppBundle:Prereservas')->findAll();
        //
        $today = date("d/m/y");
        //
        $today= $this->get('app.convertdate')->date_format($today);
        $ayer = date('d/m/y', mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')));
        $ayer= $this->get('app.convertdate')->date_format($ayer);

        //Proxima semana. Reservas Proximas.
        //$man = date('d/m/y', mktime(0, 0, 0, date('m'), date('d') + 7, date('Y')));

        $query1 = $em->createQuery('SELECT p FROM AppBundle:Prereservas p WHERE p.fechallegada = ?1 ');
        $query1->setParameter(1, $ayer);
        $reservas_ayer = $query1->getResult();

        $query_man = $em->createQuery('SELECT p FROM AppBundle:Prereservas p WHERE p.fechallegada > ?1 ');
        $query_man->setParameter(1, $today);
        $todas_futuras = $query_man->getResult();

        $this->get('twig')->addGlobal('fecha_hoy', $today);
        $this->get('twig')->addGlobal('fecha_ayer', $ayer);

        $query3 = $em->createQuery('SELECT p FROM AppBundle:Prereservas p WHERE p.fechallegada = ?1 ');
        $query3->setParameter(1, $today);
        $reservas_hoy = $query3->getResult();
        //
        $config = $em->getRepository('AppBundle:Settings')->find(1);
        // Si me cambian un estado desde el backend.
        if ($request->request->count() > 1) {
            $this->reservaAction($request);
        }
        //SOLUTION FOR CRONS.
        $query2 = $em->createQuery('SELECT p FROM AppBundle:Prereservas p WHERE p.fechasalida <= ?1');
        $query2->setParameter(1, $today);
        $reservas_upgrade = $query2->getResult();
        //
        if($reservas_upgrade!=null) {
            $query2 = $em->createQuery('SELECT p FROM AppBundle:Estados p WHERE p.estado = ?1');
            $query2->setParameter(1, 'Confirmada');
            $confirm = $query2->getResult();
            //
            $query2 = $em->createQuery('SELECT p FROM AppBundle:Estados p WHERE p.estado = ?1');
            $query2->setParameter(1, 'Exitosa');
            $exito = $query2->getResult();
            //
            $query2 = $em->createQuery('SELECT p FROM AppBundle:Prereservas p WHERE p.estadosid = ?1');
            $query2->setParameter(1, $confirm[0]->getId());
            $todas_por_estados = $query2->getResult();
            //
            for ($i = 0; $i < count($todas_por_estados); $i++) {
                for ($j = 0; $j < count($reservas_upgrade); $j++) {
                    if ($todas_por_estados[$i]->getId() == $reservas_upgrade[$j]->getId()) {
                        // Obtener su relacion con estados para actualizarla.
                        $query2 = $em->createQuery('SELECT p FROM AppBundle:Prereservas p WHERE p.id = ?1');
                        $query2->setParameter(1, $todas_por_estados[$i]->getId());
                        $found = $query2->getResult();
                        $found[0]->setEstadosid($exito[0]);
                        $em->persist($found[0]);
                        $em->flush();
                        // Ver el estado que correo tiene asociado.
                        $query2 = $em->createQuery('SELECT p FROM AppBundle:Correosestados p WHERE p.estadosid = ?1');
                        $query2->setParameter(1, $exito[0]->getId());
                        $estado_id = $query2->getResult();
                        //
                        $query2 = $em->createQuery('SELECT p FROM AppBundle:Correos p WHERE p.id = ?1');
                        $query2->setParameter(1, $estado_id[0]->getCorreosid());
                        $correo_exito = $query2->getResult();
                        // Send the Email.
                        $data = array(
                            'email_cliente' => $reservas_upgrade[$j]->getEmail(),
                            'email_hostal' => $reservas_upgrade[$j]->getCasaid()->getCorreo(),
                            'email_destino' => $reservas_upgrade[$j]->getCasaid()->getSubdestinosid()->getEmail(),
                            'email_global' => $config->getEmailglobal(),
                            'msgcliente' => $correo_exito[0]->getMsgcliente(),
                            'msghostal' => $correo_exito[0]->getMsghostal(),
                            'msgadmin' => $correo_exito[0]->getMsgAdmins(),
                            'asunto' => $correo_exito[0]->getAsunto());
                        $this->SendMail($data);
                    }
                }
            }
        }

        return $this->render('backend/dashboard/dashboard.html.twig', array('reservas_ayer' => $reservas_ayer, 'reservas_man' => $todas_futuras, 'reservas_hoy' => $reservas_hoy, 'config' => $config, 'estados' => $estados));
    }

    // Identico al de reservas controller.
    public function reservaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('id');
        //$mail_id = $request->request->get('mail_id');
        $id_estado = $request->request->get('id_estado');
        $estadoobject = $em->getRepository('AppBundle:Estados')->find($id_estado);

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
