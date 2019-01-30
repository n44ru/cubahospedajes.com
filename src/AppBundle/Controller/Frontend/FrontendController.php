<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Prereservas;
use AppBundle\Entity\Testimonios;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Frontend\Validator;

class FrontendController extends Controller
{
    /**
     * @Route("/{_locale}", name="homepage"),
     * defaults={"_locale"="es"},
     * requirements={"_locale"="(es|en)"}
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $banner = $em->getRepository('AppBundle:Banner')->findAll();
        // Destinos Recomendados por peso.
        $query_r = $em->createQuery('SELECT p FROM AppBundle:Recomendados p ORDER BY p.peso DESC ');
        $recomend = $query_r->getResult();
        // Todas las img
        $query_i = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.casaid >= 1 ');
        $img_casa = $query_i->getResult();
        $query_p = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.puntosid >= 1 ');
        $img_puntos = $query_p->getResult();
        // Enviar datos para el Select2.
        $destinos = $em->getRepository('AppBundle:Destinos')->findAll();
        $subdestinos = $em->getRepository('AppBundle:Subdestinos')->findAll();
        // Seleccionar los Puntos que son portada
        $puntos_portada = $em->createQuery('SELECT p FROM AppBundle:Puntos p WHERE p.portada = ?1 ');
        $puntos_portada->setParameter(1, 'Si');
        $puntos_p = $puntos_portada->getResult();
        // Seleccionar las casas para comparar.
        $casas_todas = $em->getRepository('AppBundle:Casa')->findAll();
        // Seleccionar los testimonios
        $test = $em->createQuery('SELECT p FROM AppBundle:Testimonios p WHERE p.activo = ?1 ');
        $test->setParameter(1, 'Si');
        $testimonios = $test->getResult();
        // Detectar el local y traducir.
        $has = false;
        $locale = $request->getLocale();
        $query = $em->createQuery('SELECT p.id FROM AppBundle:Idiomas p WHERE p.idioma = ?1');
        $query->setParameter(1, $locale);
        $localeid = $query->getResult();
        $traduccion = array();
        //
        if ($localeid != null) {
            $has = array();
            $t = 0;
            $j = 0;
            for ($i = 0; $i < count($banner); $i++) {
                $query2 = $em->createQuery('SELECT p FROM AppBundle:Traducciones p WHERE p.bannerid = ?1 AND p.idiomasid = ?2');
                $query2->setParameter(1, $banner[$i]->getId());
                $query2->setParameter(2, $localeid[0]['id']);
                $traduccion[$t] = $query2->getResult();
                if ($traduccion[$t] != null) {
                    $has[$t] = true;
                    $j++;
                } else {
                    $has[$t] = false;
                }
                $t++;
            }
        }
        for ($i = 0; $i < count($traduccion); $i++) {
            if ($has[$i] == true) {
                $banner[$i]->setTitulo($traduccion[$i][0]->getTexto1());
                $banner[$i]->setDescripcion($traduccion[$i][0]->getTexto2());
                $banner[$i]->setDireccion($traduccion[$i][0]->getTexto3());
                $banner[$i]->setTexto($traduccion[$i][0]->getTexto4());
            }
        }
        $this->meta_tag_global();
        return $this->render('frontend/portada/index.html.twig', array('banner' => $banner, 'recomendados' => $recomend, 'img_casas' => $img_casa, 'img_puntos' => $img_puntos, 'poi' => $puntos_p, 'casas' => $casas_todas, 'subdestinos' => $subdestinos, 'destinos' => $destinos, 'test' => $testimonios));
    }

    /**
     * @Route("/apartments/{dest}/{subdest}/{name}/{_locale}", name="detalles_casa"),
     * defaults={"_locale"="es"},
     * requirements={"_locale"="(es|en)"}
     */
    public function detallesAction(Request $request, $name, $dest, $subdest)
    {
        $em = $this->getDoctrine()->getManager();
        $locale = $request->getLocale();
        $slug_back_dest = $this->get('app.slugger')->back($dest);
        $slug_back_subdest = $this->get('app.slugger')->back($subdest);
        $slug_back_name = $this->get('app.slugger')->back($name);
        //
        $casa = $this->get('app.queryhelper')->getCasa($slug_back_dest, $slug_back_subdest, $slug_back_name);
        $id = $casa->getId();
        // get Config to get the global email.
        $config = $em->getRepository('AppBundle:Settings')->find(1);
        // Seleccionar todas sus relaciones
        // Relacion de Casa con  Imagenes
        $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.casaid = ?1 ');
        $query->setParameter(1, $id);
        $img = $query->getResult();
        // Relacion de Casa con  Coordenadas
        $query2 = $em->createQuery('SELECT p FROM AppBundle:Coordenadas p WHERE p.casaid = ?1 ');
        $query2->setParameter(1, $id);
        $coo = $query2->getResult();
        if (count($coo) > 0) {
            $coo = $coo[0];
        }
        // Relacion de Casa con  Etiquetas
        $query3 = $em->createQuery('SELECT p FROM AppBundle:CasaEtiqueta p WHERE p.casaid = ?1 ');
        $query3->setParameter(1, $id);
        $etiquetas = $query3->getResult();
        // Determinar Cercania. Este es Temporal. ****
        $id_subdestinos = $casa->getSubdestinosid()->getId();
        $query7 = $em->createQuery('SELECT p FROM AppBundle:Casa p WHERE p.subdestinosid = ?1 AND p.id <> ?2 AND p.activa= ?3 ');
        $query7->setParameter(1, $id_subdestinos);
        $query7->setParameter(2, $id);
        $query7->setParameter(3, 'Si');
        $near = $query7->getResult();
        //
        $query8 = $em->createQuery('SELECT p FROM AppBundle:Puntos p WHERE p.subdestinosid = ?1');
        $query8->setParameter(1, $id_subdestinos);
        $sitios = $query8->getResult();
        // Todas las imagenes de Casas.
        $query9 = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.casaid >= 1 ');
        $img_todas_casas = $query9->getResult();
        $query10 = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.puntosid >= 1 ');
        $img_todas_puntos = $query10->getResult();
        // Testimonios
        $testimonios = $em->getRepository('AppBundle:Testimonios')->findAll();
        /* Cuando me hacen una reserva */
        if ($request->request->count() > 1) {
            if ($request->request->get('casaid')) {
                //google recaptcha implementation.
//                if ($request->request->get('g-recaptcha-response')) {
//                    $response = $request->request->get('g-recaptcha-response');
//                    //your site secret key
//                    $secret = '6LejqScUAAAAAFbT_1ye4P63jH9x3nWLDN4DPjU5';
//                    //get verify response data
//                    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $response);
//                    $responseData = json_decode($verifyResponse);
//                    if (!$responseData->success) {
//                        return $this->render('frontend/errors/google.html.twig');
//                    }
//                } else {
//                    return $this->render('frontend/errors/google.html.twig');
//                }
                // End.
                $id = $request->request->get('casaid');
                $nombre = $request->request->get('nombre');
                $pais = $request->request->get('pais');
                $email = $request->request->get('email');
                $phone = $request->request->get('phone');
                $fecha_raw = $request->request->get('fecha1');
                // Llamando al servicio que me convierte la fecha
                $result = $this->get('app.convertdate')->convert($fecha_raw);
                $fechallegada = $result['fecha1'];
                $fechasalida = $result['fecha2'];
                //Fix
                $fechallegada= $this->get('app.convertdate')->date_format($fechallegada);
                $fechasalida= $this->get('app.convertdate')->date_format($fechasalida);
                //
                $horallegada = $request->request->get('horallegada');
                $datosvuelo = $request->request->get('datosvuelo');
                $personas = $request->request->get('guest');
                $hab = $request->request->get('habitaciones');
                $comentarios = $request->request->get('comentarios');
                // Consulta
                $lacasa = $em->getRepository('AppBundle:Casa')->find($id);
                // Insertar el estado pendiente que es siempre el 1ero de los estados en al bd.
                $query11 = $em->createQuery('SELECT p FROM AppBundle:Estados p WHERE p.estado LIKE ?1 ');
                $query11->setParameter(1, '%pendiente%');
                $estado = $query11->getResult();
                //
                $reserva = new Prereservas();
                $reserva->setNombre($nombre);
                $reserva->setPais($pais);
                $reserva->setEmail($email);
                $reserva->setTelefono($phone);
                $reserva->setFechallegada($fechallegada);
                $reserva->setFechasalida($fechasalida);
                $reserva->setHorallegada($horallegada);
                $reserva->setDatosvuelo($datosvuelo);
                $reserva->setCantpersonas($personas);
                $reserva->setCanthab($hab);
                $reserva->setComentario($comentarios);
                $reserva->setCasaid($lacasa);
                $reserva->setEstadosid($estado[0]);
                // Crear la Alerta
                $alerta = $em->getRepository('AppBundle:Alertas')->find(1);
                $alerta->setReservas($alerta->getReservas() + 1);
                $em->persist($alerta);
                $em->flush();
                //
                $em->persist($reserva);
                $em->flush();
                // Persist el url de la casa en cada busqueda.
                $casa_url = $em->getRepository("AppBundle:Casa")->find($id);
                $casa_url->setUrl('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                $em->persist($casa_url);
                $em->flush();

                // Ver que E-Mail tiene asociado el estado.
                $query11 = $em->createQuery('SELECT p FROM AppBundle:Correosestados p WHERE p.estadosid = ?1 ');
                $query11->setParameter(1, $estado[0]->getId());
                $correoestados = $query11->getResult();
                $correo = $em->getRepository('AppBundle:Correos')->find($correoestados[0]->getCorreosid());
                // Call the email function.
                $this->sendmail($reserva, $lacasa, $config, $correo, $locale);
                // Enviar la pagina de reserva correcta.
                $this->meta_tag_global();
                $this->get('twig')->addGlobal('coo', '');
                $this->get('twig')->addGlobal('book_btn', 'No');
                return $this->render('frontend/busquedas/exito.html.twig', array('casa' => $lacasa, 'img' => $img_todas_casas, 'reserva' => $reserva));

            }
            // Cuando me hacen un comentario
            if ($request->request->get('comentarios_t')) {
                //google recaptcha implementation.
                if ($request->request->get('g-recaptcha-response')) {
                    $response = $request->request->get('g-recaptcha-response');
                    //your site secret key
                    $secret = '6LejqScUAAAAAFbT_1ye4P63jH9x3nWLDN4DPjU5';
                    //get verify response data
                    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $response);
                    $responseData = json_decode($verifyResponse);
                    if (!$responseData->success) {
                        return $this->render('frontend/errors/google.html.twig');
                    }
                } else {
                    return $this->render('frontend/errors/google.html.twig');
                }
                $name = $request->request->get('nombre_t');
                $comment = $request->request->get('comentarios_t');
                $rating = $request->request->get('input-1');
                $id = $request->request->get('casaid_test');
                $lacasa = $em->getRepository('AppBundle:Casa')->find($id);
                $testimonio = new Testimonios();
                $testimonio->setNombre($name);
                $testimonio->setComentario($comment);
                $testimonio->setActivo('No');
                $testimonio->setRating($rating);
                $testimonio->setCasaid($lacasa);
                $testimonio->setFecha(date("d/m/y"));
                $em->persist($testimonio);
                $em->flush();
                // Crear la Alerta
                $alerta = $em->getRepository('AppBundle:Alertas')->find(1);
                $alerta->setTestimonios($alerta->getTestimonios() + 1);
                $em->persist($alerta);
                $em->flush();

            }
        }
        // Detect the locale and make the translation.
        $has = false;
        $query = $em->createQuery('SELECT p.id FROM AppBundle:Idiomas p WHERE p.idioma = ?1');
        $query->setParameter(1, $locale);
        $localeid = $query->getResult();
        $traduccion = array();
        //
        if ($localeid != null) {
            $query2 = $em->createQuery('SELECT p FROM AppBundle:Traducciones p WHERE p.casaid = ?1 AND p.idiomasid = ?2');
            $query2->setParameter(1, $id);
            $query2->setParameter(2, $localeid[0]['id']);
            $traduccion = $query2->getResult();
            if ($traduccion != null) {
                $has = true;
            }
        }
        if ($has == true) {
            $casa->setNombre($traduccion[0]->getTexto1());
            $casa->setDireccion($traduccion[0]->getTexto2());
            $casa->setTexto($traduccion[0]->getTexto3());
            $casa->setReglas($traduccion[0]->getTexto4());
            $casa->setMetatitle($traduccion[0]->getTexto5());
            $casa->setMetadesc($traduccion[0]->getTexto6());
            $casa->setMetakeyword($traduccion[0]->getTexto7());
        }
        // enviar las META.
        $this->meta_tag_house($casa);
        // Ver si es casa o poi para el boton reserva.
        $this->get('twig')->addGlobal('book_btn', 'Si');
        return $this->render('frontend/busquedas/detalles.html.twig', array('casa' => $casa, 'imagenes' => $img, 'coo' => $coo, 'etiquetas' => $etiquetas, 'casas_cercanas' => $near, 'sitios_cercanos' => $sitios, 'img_todas' => $img_todas_casas, 'img_todas_puntos' => $img_todas_puntos, 'testimonios' => $testimonios));
    }

    // Handle the data and send the email.
    public function sendmail($reserva, $lacasa, $config, $correo, $lang)
    {
        $email_cliente = $reserva->getEmail();
        $email_hostal = $lacasa->getCorreo();
        $email_admin1 = $lacasa->getSubdestinosid()->getEmail();
        $email_admin2 = $config->getEmailglobal();
        // Fix - Asuntos distintos para cada uno en dos idiomas.
        if ($lang == 'es') {
            $asunto_cliente = "Solicitud de reserva enviada a " . $lacasa->getNombre() . " en " . $lacasa->getSubdestinosid()->getNombre() .
                ", " . $lacasa->getSubdestinosid()->getDestinoid()->getNombre() . " - CubaHospedajes.com";
            $asunto_hostal = "Solicitud de reserva - " . $lacasa->getNombre() . " - CubaHospedajes.com";
            $asunto_admin = $lacasa->getId() . " - Solicitud de reserva - " . $lacasa->getNombre() . " en " . $lacasa->getSubdestinosid()->getNombre() .
                ", " . $lacasa->getSubdestinosid()->getDestinoid()->getNombre() . " - CubaHospedajes.com";
        } else {
            $asunto_cliente = "Book sent to " . $lacasa->getNombre() . " in " . $lacasa->getSubdestinosid()->getNombre() .
                ", " . $lacasa->getSubdestinosid()->getDestinoid()->getNombre() . " - CubaHospedajes.com";
            $asunto_hostal = "Solicitud de reserva - " . $lacasa->getNombre() . " - CubaHospedajes.com";
            $asunto_admin = $lacasa->getId() . " - Solicitud de reserva - " . $lacasa->getNombre() . " en " . $lacasa->getSubdestinosid()->getNombre() .
                ", " . $lacasa->getSubdestinosid()->getDestinoid()->getNombre() . " - CubaHospedajes.com";
        }
        $mensaje_cliente = $correo->getMsgcliente();
        $mensaje_hostal = $correo->getMsghostal();
        $mensaje_admins = $correo->getMsgadmins();
        // Remplazando los datos por los reales.
        // Cliente
        $mensaje_cliente = str_replace("[nombre]", $reserva->getNombre(), $mensaje_cliente);
        // Hostal
        $mensaje_hostal = str_replace("[nombre]", $reserva->getNombre(), $mensaje_hostal);
        $mensaje_hostal = str_replace("[fechallegada]", $reserva->getFechallegada(), $mensaje_hostal);
        $mensaje_hostal = str_replace("[fechasalida]", $reserva->getFechasalida(), $mensaje_hostal);
        $mensaje_hostal = str_replace("[canthab]", $reserva->getCanthab(), $mensaje_hostal);
        $mensaje_hostal = str_replace("[cantpersonas]", $reserva->getCantpersonas(), $mensaje_hostal);
        // Admins
        $mensaje_admins = str_replace("[nombre]", $reserva->getNombre(), $mensaje_admins);
        $mensaje_admins = str_replace("[casa]", $lacasa->getNombre(), $mensaje_admins);
        $mensaje_admins = str_replace("[fechallegada]", $reserva->getFechallegada(), $mensaje_admins);
        $mensaje_admins = str_replace("[fechasalida]", $reserva->getFechasalida(), $mensaje_admins);
        $mensaje_admins = str_replace("[canthab]", $reserva->getCanthab(), $mensaje_admins);
        $mensaje_admins = str_replace("[cantpersonas]", $reserva->getCantpersonas(), $mensaje_admins);
        $mensaje_admins = str_replace("[horallegada]", $reserva->getHorallegada(), $mensaje_admins);
        $mensaje_admins = str_replace("[datosvuelo]", $reserva->getDatosvuelo(), $mensaje_admins);
        $mensaje_admins = str_replace("[email]", $reserva->getEmail(), $mensaje_admins);
        $mensaje_admins = str_replace("[telefono]", $reserva->getTelefono(), $mensaje_admins);
        $mensaje_admins = str_replace("[comentario]", $reserva->getComentario(), $mensaje_admins);
        // Fix casa
        $mensaje_admins = str_replace("[casadireccion]", $reserva->getCasaid()->getDireccion(), $mensaje_admins);
        $mensaje_admins = str_replace("[casaresponsable]", $reserva->getCasaid()->getResponsable(), $mensaje_admins);
        $mensaje_admins = str_replace("[casatelefono]", $reserva->getCasaid()->getTelefono(), $mensaje_admins);
        $mensaje_admins = str_replace("[casacorreo]", $reserva->getCasaid()->getCorreo(), $mensaje_admins);
        $mensaje_admins = str_replace("[casatexto]", $reserva->getCasaid()->getTexto(), $mensaje_admins);
        $mensaje_admins = str_replace("[casaprecio]", $reserva->getCasaid()->getPrecio(), $mensaje_admins);
        $mensaje_admins = str_replace("[casacuartos]", $reserva->getCasaid()->getCuartos(), $mensaje_admins);
        $mensaje_admins = str_replace("[casacapacidad]", $reserva->getCasaid()->getCapacidad(), $mensaje_admins);
        $mensaje_admins = str_replace("[casabath]", $reserva->getCasaid()->getBath(), $mensaje_admins);
        $mensaje_admins = str_replace("[casareglas]", $reserva->getCasaid()->getReglas(), $mensaje_admins);
        // URL del hostal.
        $mensaje_admins = str_replace("[url]", $_SERVER['HTTP_HOST'] . '/' . $_SERVER['REQUEST_URI'], $mensaje_admins);


        $cabeceras = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $cabeceras .= 'From: ' . $email_admin1 . "\r\n";

        // 1er Email para el cliente.
        mail($email_cliente, $asunto_cliente, $mensaje_cliente, $cabeceras);
        // 2do Email para el hostal
        mail($email_hostal, $asunto_hostal, $mensaje_hostal, $cabeceras);
        // 3er Email para los admins.
        if ($email_admin1 != $email_admin2) {
            $cabeceras .= 'Cc: ' . $email_admin2 . "\r\n";
            mail($email_admin1, $asunto_admin, $mensaje_admins, $cabeceras);
        } else {
            mail($email_admin2, $asunto_admin, $mensaje_admins, $cabeceras);
        }
    }

    /**
     * @Route("/{_locale}/points_of_interests/all", name="poi_todos")
     * defaults={"_locale"="es"},
     * requirements={"_locale"="(es|en)"}
     */
    public function poiAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query_i = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.casaid >= 1 ');
        $img_casa = $query_i->getResult();
        $query_p = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.puntosid >= 1 ');
        $img_puntos = $query_p->getResult();
        // Seleccionar los Puntos que son portada
        $poi = $em->getRepository('AppBundle:Puntos')->findAll();
        // Seleccionar las casas para comparar.
        $casas_todas = $em->getRepository('AppBundle:Casa')->findAll();
        $this->meta_tag_global();
        $this->get('twig')->addGlobal('coo', '');
        // Ver si es casa o poi para el boton reserva.
        $this->get('twig')->addGlobal('book_btn', 'No');
        return $this->render('frontend/portada/vertodos.html.twig', array('img_puntos' => $img_puntos, 'img_casas' => $img_casa, 'poi' => $poi, 'casas' => $casas_todas));
    }

    // Funcion para las inyectar META TAGS.
    public function meta_tag_global()
    {
        $em = $this->getDoctrine()->getManager();
        $config = $em->getRepository('AppBundle:Settings')->find(1);
        $this->get('twig')->addGlobal('global_title', $config->getWebtitulo());
        $this->get('twig')->addGlobal('global_description', $config->getWebdesc());
        $this->get('twig')->addGlobal('global_keywords', $config->getWebkeywords());
    }

    public function meta_tag_house($house)
    {
        $this->get('twig')->addGlobal('global_title', $house->getMetatitle());
        $this->get('twig')->addGlobal('global_description', $house->getMetadesc());
        $this->get('twig')->addGlobal('global_keywords', $house->getMetakeyword());
    }
}