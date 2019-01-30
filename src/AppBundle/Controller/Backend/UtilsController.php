<?php

namespace AppBundle\Controller\Backend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UtilsController extends Controller
{
    /**
     * @Route("/alertas/{alerta}", name="alertas_ver")
     */
    public function verAction(Request $request, $alerta)
    {
        $em = $this->getDoctrine()->getManager();
        $alertas_entity = $em->getRepository('AppBundle:Alertas')->find(1);
        if($alerta=='reservas'){
            $alertas_entity->setReservas('0');
            $em->persist($alertas_entity);
            $em->flush();
            return $this->redirectToRoute("reservas_ver");
        }
        if($alerta=='inactivas'){
            $alertas_entity->setcasasinactivas('0');
            $em->persist($alertas_entity);
            $em->flush();
            return $this->redirectToRoute("casa_inactivas");
        }
        if($alerta=='testimonios'){
            $alertas_entity->settestimonios('0');
            $em->persist($alertas_entity);
            $em->flush();
            return $this->redirectToRoute("testimonios_ver");
        }
    }

    /**
     * @Route("/admin/generar/url/todas", name="url_full")
     */
    public function fullAction()
    {
        $em = $this->getDoctrine()->getManager();
        $casa = $em->getRepository('AppBundle:Casa')->findAll();
        //
        for($i=0;$i<count($casa);$i++){
            $url = $this->createUrl($casa[$i]);
            $casa[$i]->setUrl($url);
            $em->persist($casa[$i]);
            $em->flush();
        }
        return $this->render('backend/url/response.html.twig');
    }
    /**
     * @Route("/admin/generar/url/nuevas", name="url_partial")
     */
    public function partialAction()
    {
        $em = $this->getDoctrine()->getManager();
        $casa = $em->getRepository('AppBundle:Casa')->findAll();
        //
        for($i=0;$i<count($casa);$i++){
            if($casa[$i]->getUrl() == null )
            {
                $url = $this->createUrl($casa[$i]);
                $casa[$i]->setUrl($url);
                $em->persist($casa[$i]);
                $em->flush();
            }

        }
        return $this->render('backend/url/response.html.twig');
    }

    // Este metodo crea la url basado en la que existe.
    public function createUrl($casa){
        $first='http://'.$_SERVER['HTTP_HOST'];

        //Cambiar aqui en cierto punto si quitas el 'web'
        $second='/web/apartments/';

        //vars
        $destino=$casa->getSubdestinosid()->getDestinoid()->getNombre();
        $subdestino=$casa->getSubdestinosid()->getNombre();
        $nombre=$casa->getNombre();

        //convertir a slug
        $destino = $this->get('app.slugger')->slugify($destino);
        $subdestino = $this->get('app.slugger')->slugify($subdestino);
        $nombre = $this->get('app.slugger')->slugify($nombre);


        $third=$destino.'/'.$subdestino.'/'.$nombre.'/es';

        return $first.$second.$third;
    }
}