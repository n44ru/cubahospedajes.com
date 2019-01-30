<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Prereservas;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Reservas;

class FrontendController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $banner = $em->getRepository('AppBundle:Banner')->findAll();
        // Ver peticiones de busquedas.
        if ($request->request->count() > 1) {
            // Si la peticion viene de index.
                $texto = $request->request->get('texto');
                // Falta implementar las fechas.
                $fecha_llegada = $request->request->get('fecha1');
                $fecha_salida = $request->request->get('fecha2');
                $guest = $request->request->get('guest');
                // Relacion de Casa con  Imagenes - CAMBIAR AQUI LA SOLUCION TEMP.
                $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.casaid >= 1 ');
                $img = $query->getResult();
                //
                $query = $em->createQuery('SELECT p FROM AppBundle:Casa p WHERE p.keywords LIKE ?1 OR p.nombre LIKE ?2 AND p.activa= ?3');
                $query->setParameter(1, '%' . $texto . '%');
                $query->setParameter(2, '%' . $texto . '%');
                $query->setParameter(3, 'Si');
                $casa = $query->getResult();
                //
                return $this->render('frontend/busquedas/resultados.html.twig', array('casas' => $casa, 'imagenes' => $img));
        }
        return $this->render('frontend/portada/index.html.twig', array('banner'=>$banner));
    }
    /**
     * @Route("/detalles/{id}", name="detalles_casa")
     */
    public function detallesAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $casa = $em->getRepository('AppBundle:Casa')->find($id);
        // Seleccionar todas sus relaciones
        // Relacion de Casa con  Imagenes
        $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.casaid = ?1 ');
        $query->setParameter(1, $id);
        $img = $query->getResult();
        // Relacion de Casa con  Coordenadas
        $query2 = $em->createQuery('SELECT p FROM AppBundle:Coordenadas p WHERE p.casaid = ?1 ');
        $query2->setParameter(1, $id);
        $coo = $query2->getResult();
        // Relacion de Casa con  Etiquetas
        $query3 = $em->createQuery('SELECT p FROM AppBundle:CasaEtiqueta p WHERE p.casaid = ?1 ');
        $query3->setParameter(1, $id);
        $etiquetas = $query3->getResult();
        // Relacion de Casa con  Habitaciones
        $query4 = $em->createQuery('SELECT p FROM AppBundle:Habitaciones p WHERE p.casaid = ?1 ');
        $query4->setParameter(1, $id);
        $hab = $query4->getResult();
        // Todas las imageens de habitaciones
        $query5 = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.habitacionesid >= 1 ');
        $img_hab = $query5->getResult();
        // Determinar Cercania. Este es Temporal. ****
        $id_subdestinos = $casa->getSubdestinosid()->getId();
        $query7 = $em->createQuery('SELECT p FROM AppBundle:Casa p WHERE p.subdestinosid = ?1 AND p.id <> ?2');
        $query7->setParameter(1, $id_subdestinos);
        $query7->setParameter(2, $id);
        $near = $query7->getResult();
        //
        $query8 = $em->createQuery('SELECT p FROM AppBundle:Puntos p WHERE p.subdestinosid = ?1');
        $query8->setParameter(1, $id_subdestinos);
        $sitios = $query8->getResult();
        // Todas las imagenes de Casas. Cambiar la direccion de las relaciones en La habana.
        $query9 = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.casaid >= 1 ');
        $img_todas_casas = $query9->getResult();
        $query10 = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.puntosid >= 1 ');
        $img_todas_puntos = $query10->getResult();
        /* Cuando me hacen una reserva */
        if ($request->request->count() > 1)
        {
            $id = $request->request->get('casaid');
            $nombre = $request->request->get('nombre');
            $pais = $request->request->get('pais');
            $email = $request->request->get('email');
            $phone = $request->request->get('phone');
            $fechallegada = $request->request->get('fecha1');
            $fechasalida = $request->request->get('fecha2');
            $horallegada = $request->request->get('horallegada');
            $datosvuelo = $request->request->get('datosvuelo');
            $personas = $request->request->get('personas');
            $habitaciones = $request->request->get('habitaciones');
            $comentarios = $request->request->get('comentarios');
            // Consulta
            $lacasa = $em->getRepository('AppBundle:Casa')->find($id);
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
            $reserva->setCanthab($habitaciones);
            $reserva->setComentario($comentarios);
            $reserva->setAccion('Prereserva');
            $reserva->setCasaid($lacasa);
            //
            $em->persist($reserva);
            $em->flush();

        }
        /* */
        return $this->render('frontend/busquedas/detalles.html.twig', array('casa'=>$casa, 'imagenes'=>$img, 'coo'=>$coo, 'etiquetas'=>$etiquetas, 'habitaciones'=>$hab, 'img_hab'=>$img_hab, 'casas_cercanas'=>$near, 'sitios_cercanos'=>$sitios ,'img_todas'=>$img_todas_casas,'img_todas_puntos'=>$img_todas_puntos ));
    }
    /**
     * @Route("/order/", name="order_dinamico")
     */
    public function dinamicoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //
        $texto = $request->request->get('texto');
        // Falta implementar las fechas.
        $fecha1 = $request->request->get('fecha1');
        $fecha2 = $request->request->get('fecha2');
        $guest = $request->request->get('guest');
        $op = $request->request->get('operation');
        // Ver el orden.
        $mode = $request->request->get('mode');
        // Relacion de Casa con  Imagenes - CAMBIAR AQUI LA SOLUCION TEMP.
        $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.casaid >= 1 ');
        $img = $query->getResult();
        //
        if($op=="name")
        {
            $query = $em->createQuery('SELECT p FROM AppBundle:Casa p WHERE p.keywords LIKE ?7 OR p.nombre LIKE ?1 AND p.capacidad >= ?2 AND p.activa = ?6 ORDER BY p.nombre '.$mode.'');
        }
        else if($op=="price")
        {
            $query = $em->createQuery('SELECT p FROM AppBundle:Casa p WHERE p.keywords LIKE ?7 OR p.nombre LIKE ?1 AND p.capacidad >= ?2 AND p.activa = ?6 ORDER BY p.precio '.$mode.'');
        }
        else if($op=="rooms")
        {
            $query = $em->createQuery('SELECT p FROM AppBundle:Casa p p.keywords LIKE ?7 OR WHERE p.nombre LIKE ?1 AND p.capacidad >= ?2 AND p.activa = ?6 ORDER BY p.cuartos '.$mode.'');
        }
        $query->setParameter(1, '%' . $texto . '%');
        $query->setParameter(2, $guest);
        $query->setParameter(6, 'Si');
        $query->setParameter(7, '%' . $texto . '%');
        $casa = $query->getResult();
        //
        return $this->render('frontend/busquedas/dinamico/busqueda.html.twig', array('casas'=>$casa, 'imagenes'=>$img));
    }
    /**
     * @Route("/advanced/", name="advanced_dinamico")
     */
    public function advancedAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //
        $fecha_llegada = $request->request->get('fecha1');
        $fecha_salida = $request->request->get('fecha2');
        $guest = $request->request->get('guest');
        $texto = $request->request->get('texto_adv');
        $cuartos = $request->request->get('cuartos');
        $precio_min = $request->request->get('precio_min');
        $precio_max = $request->request->get('precio_max');
        // Relacion de Casa con  Imagenes - CAMBIAR AQUI LA SOLUCION TEMP.
        $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.casaid >= 1 ');
        $img = $query->getResult();
        //
        $query = $em->createQuery('SELECT p FROM AppBundle:Casa p WHERE p.nombre LIKE ?1 AND p.capacidad >= ?2 AND p.cuartos >= ?3 AND p.precio >= ?4 AND p.precio <= ?5 AND p.activa = ?6');
        $query->setParameter(1, '%' . $texto . '%');
        $query->setParameter(2, $guest);
        $query->setParameter(3, $cuartos);
        $query->setParameter(4, $precio_min);
        $query->setParameter(5, $precio_max);
        $query->setParameter(6, 'Si');
        $casa = $query->getResult();
        return $this->render('frontend/busquedas/dinamico/busqueda.html.twig', array('casas'=>$casa, 'imagenes'=>$img));
    }


}