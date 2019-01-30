<?php
/**
 * Created by PhpStorm.
 * User: carlosmanuel
 * Date: 6/27/17
 * Time: 5:34 p.m.
 */

namespace AppBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class PaginateController extends Controller
{
    /**
     * @Route("/search/{_locale}", name="search")
     * defaults={"_locale"="es"},
     * requirements={"_locale"="(es|en)"}
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $destinos = $em->getRepository('AppBundle:Destinos')->findAll();
        $subdestinos = $em->getRepository('AppBundle:Subdestinos')->findAll();
        $casas_todas = $em->getRepository('AppBundle:Casa')->findAll();
        $texto_raw = $request->get('text');
        $guest = $request->get('guest');
        $fecha_raw = $request->get('date');
        $validator = new Validator();
        $texto = $validator->test_input($texto_raw);
        $result=$this->get('app.convertdate')->convert($fecha_raw);
        $fecha_llegada = $result['fecha1'];
        $fecha_salida = $result['fecha2'];
        // Fix de las fechas
        $fecha_llegada= $this->get('app.convertdate')->date_format($fecha_llegada);
        $fecha_salida= $this->get('app.convertdate')->date_format($fecha_salida);
        //
        $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.casaid >= 1 ');
        $img = $query->getResult();
        // Obteniendo todas las casas segun parametros.
        $casas = $validator->getHouses($texto, $guest,$em);
        //Obteniendo todas las casas reservadas.
        $usados = $validator->getReservas($em,$fecha_llegada,$fecha_salida);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $casas, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            14/*limit per page*/
        );
        //
        if ($casas != null) {
            $this->meta_tag_global();
            return $this->render('frontend/busquedas/resultados.html.twig', array('casas' => $pagination, 'imagenes' => $img, 'reservadas' => $usados, 'subdestinos'=>$subdestinos, 'destinos'=> $destinos, 'casas_todas'=> $casas_todas));
        } else {
            $this->meta_tag_global();
            return $this->render('frontend/busquedas/notfound.html.twig');
        }
    }
    /**
     * @Route("/search/advanced/{_locale}", name="search_advanced")
     * defaults={"_locale"="es"},
     * requirements={"_locale"="(es|en)"}
     */
    public function advancedAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $destinos = $em->getRepository('AppBundle:Destinos')->findAll();
        $subdestinos = $em->getRepository('AppBundle:Subdestinos')->findAll();
        $casas_todas = $em->getRepository('AppBundle:Casa')->findAll();
        $fecha_raw = $request->get('date');
        // Llamando al servicio que me convierte la fecha
        $result=$this->get('app.convertdate')->convert($fecha_raw);
        $fecha_llegada = $result['fecha1'];
        $fecha_salida = $result['fecha2'];
        // Fix de las fechas
        $fecha_llegada= $this->get('app.convertdate')->date_format($fecha_llegada);
        $fecha_salida= $this->get('app.convertdate')->date_format($fecha_salida);
        //
        $guest = $request->get('guest');
        $texto = $request->get('text');
        $cuartos = $request->get('room');
        $precio_min = $request->get('min_price');
        $precio_max = $request->get('max_price');
        // Relacion de Casa con  Imagenes - CAMBIAR AQUI LA SOLUCION TEMP.
        $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.casaid >= 1 ');
        $img = $query->getResult();
        //
        $valid = new Validator();
//        $two = array('texto_raw'=> $texto, 'texto_ok' => substr($texto, 2, strlen($texto)));
        $casas = $valid->getAdvancedHouses($texto,$guest,$cuartos,$precio_min,$precio_max,$em);
        // Buscar las casas reservadas.
        $usados = $valid->getReservas($em,$fecha_llegada,$fecha_salida);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $casas, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            14/*limit per page*/
        );
        if ($casas != null) {
            $this->meta_tag_global();
            return $this->render('frontend/busquedas/resultados.html.twig', array('casas' => $pagination, 'imagenes' => $img, 'reservadas' => $usados, 'subdestinos'=>$subdestinos, 'destinos'=>$destinos, 'casas_todas'=> $casas_todas));
        } else {
            $this->meta_tag_global();
            return $this->render('frontend/busquedas/notfound.html.twig');
        }
    }
    /**
     * @Route("/search/filter/{_locale}", name="search_filter")
     * defaults={"_locale"="es"},
     * requirements={"_locale"="(es|en)"}
     */
    public function filterAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $destinos = $em->getRepository('AppBundle:Destinos')->findAll();
        $subdestinos = $em->getRepository('AppBundle:Subdestinos')->findAll();
        $casas_todas = $em->getRepository('AppBundle:Casa')->findAll();
        $fecha_raw = $request->get('date');
        // Llamando al servicio que me convierte la fecha
        $result=$this->get('app.convertdate')->convert($fecha_raw);
        $fecha_llegada = $result['fecha1'];
        $fecha_salida = $result['fecha2'];
        //
        $guest = $request->get('guest');
        $texto = $request->get('text');
        $cuartos = $request->get('room');
        $precio_min = $request->get('min_price');
        $precio_max = $request->get('max_price');
        //
        $op = $request->get('sort');
        $mode = $request->get('mode');
        //
        $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.casaid >= 1 ');
        $img = $query->getResult();
        //
        $valid = new Validator();
        $two = array('texto_raw'=> $texto, 'texto_ok' => substr($texto, 2, strlen($texto)));
        $casas = $valid->orderHouses($texto,$guest,$em,$op,$mode,$precio_min,$precio_max,$cuartos);
        // Buscar las casas reservadas.
        $usados = $valid->getReservas($em,$fecha_llegada,$fecha_salida);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $casas, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            14/*limit per page*/
        );
        // Mandando los detalles de nuevo
        if ($casas != null) {
            $this->meta_tag_global();
            return $this->render('frontend/busquedas/resultados.html.twig', array('casas' => $pagination, 'imagenes' => $img, 'reservadas' => $usados, 'subdestinos'=>$subdestinos,'destinos'=>$destinos, 'textos'=>$two, 'casas_todas'=> $casas_todas));
        } else {
            $this->meta_tag_global();
            return $this->render('frontend/busquedas/notfound.html.twig');
        }
    }
    // Este es para los lugares.
    /**
     * @Route("/search/places/{_locale}", name="search_places")
     * defaults={"_locale"="es"},
     * requirements={"_locale"="(es|en)"}
     */
    public function placesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $validator = new Validator();
        $destinos = $em->getRepository('AppBundle:Destinos')->findAll();
        $dest = $request->get('dest');
        $sub = $request->get('subdest');
        $text = $request->get('text');
        $casas = $validator->getAllHouses($em,$dest, $sub, $text);
        $puntos = $validator->getAllPoints($em,$dest,$sub, $text);
        // Buscando todas las imagenes de casas.
        $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.casaid >0 ');
        $img_casas = $query->getResult();
        // Buscando todas las imagenes de puntos.
        $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.puntosid >0 ');
        $img_puntos = $query->getResult();
        //
        $paginator  = $this->get('knp_paginator');
        if(count($casas)>12){
        $pagination_houses = $paginator->paginate(
            $casas, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            12/*limit per page*/
        );
            $this->get('twig')->addGlobal('paginate_houses', 'Si');
        }else{
            $this->get('twig')->addGlobal('paginate_houses', 'No');
            $pagination_houses= $casas;
        }
        if(count($puntos)>12){
        $pagination_places = $paginator->paginate(
            $puntos, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            12/*limit per page*/
        );
            $this->get('twig')->addGlobal('paginate_places', 'Si');
        }else{
            $pagination_places= $puntos;
            $this->get('twig')->addGlobal('paginate_places', 'No');
        }
        $this->meta_tag_global();
        return $this->render('frontend/lugares/resultados.html.twig', array('destinos'=>$destinos,'casas'=>$pagination_houses, 'puntos'=> $pagination_places, 'img_casas'=>$img_casas, 'img_puntos'=>$img_puntos));
    }
    public function meta_tag_global()
    {
        $em = $this->getDoctrine()->getManager();
        $config = $em->getRepository('AppBundle:Settings')->find(1);
        $this->get('twig')->addGlobal('global_title', $config->getWebtitulo());
        $this->get('twig')->addGlobal('global_description', $config->getWebdesc());
        $this->get('twig')->addGlobal('global_keywords', $config->getWebkeywords());
    }
}
