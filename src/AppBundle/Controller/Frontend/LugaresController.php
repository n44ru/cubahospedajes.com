<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LugaresController extends Controller
{
    /**
     * @Route("/places/all/{_locale}", name="casas_todas")
     * defaults={"_locale"="es"},
     * requirements={"_locale"="(es|en)"}
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dest = $em->getRepository('AppBundle:Destinos')->findAll();
        //Enviar Datos para los Recomendados
        $recom = $em->getRepository('AppBundle:Recomendados')->findAll();
        // Buscando todas las imagenes de casas.
        $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.casaid >0 ');
        $img_casas = $query->getResult();
        // Buscando todas las imagenes de puntos.
        $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.puntosid >0 ');
        $img_puntos = $query->getResult();
        //
        $this->meta_tag_global();
        return $this->render('frontend/lugares/lugares.html.twig', array('destinos'=>$dest, 'recomendados'=>$recom, 'img_casas'=>$img_casas, 'img_puntos'=>$img_puntos));
    }
    /**
     * @Route("/{_locale}/dynamic/sub", name="sub_dynamic")
     * defaults={"_locale"="es"},
     * requirements={"_locale"="(es|en)"}
     */
    public function subAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $destino = $request->request->get('destino');
        $query1 = $em->createQuery('SELECT p FROM AppBundle:Destinos p WHERE p.nombre = ?1 ');
        $query1->setParameter(1, $destino);
        $dest = $query1->getResult();
        $query = $em->createQuery('SELECT p FROM AppBundle:Subdestinos p WHERE p.destinoid = ?1 ');
        $query->setParameter(1, $dest[0]->getId());
        $sub = $query->getResult();
        return $this->render('frontend/lugares/dinamico/subdestinos.html.twig', array('subdestinos'=>$sub));
    }
    /**
     * @Route("/places/{dest}/{subdest}/{name}/{_locale}", name="puntos_cercanias")
     * defaults={"_locale"="es"},
     * requirements={"_locale"="(es|en)"}
     */
    public function cercaniasAction(Request $request, $dest, $subdest, $name)
    {
        $em = $this->getDoctrine()->getManager();
        $slug_back_dest = $this->get('app.slugger')->back($dest);
        $slug_back_subdest = $this->get('app.slugger')->back($subdest);
        $slug_back_name = $this->get('app.slugger')->back($name);
        //
        $el = $this->get('app.queryhelper')->getPoi($slug_back_dest, $slug_back_subdest, $slug_back_name);
        // buscando todas las casa con el text.
        $query = $em->createQuery('SELECT p FROM AppBundle:Casa p WHERE p.subdestinosid = ?1 AND p.activa = ?2');
        $query->setParameter(1, $el->getSubdestinosid()->getId());
        $query->setParameter(2, 'Si');
        $casas = $query->getResult();
        // buscando todos los puntos con el text.
        $query = $em->createQuery('SELECT p FROM AppBundle:Puntos p WHERE p.subdestinosid = ?1');
        $query->setParameter(1, $el->getSubdestinosid()->getId());
        $puntos = $query->getResult();
        // Buscando todas las imagenes de casas.
        $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.casaid >0 ');
        $img_casas = $query->getResult();
        // Buscando todas las imagenes de puntos.
        $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.puntosid >0 ');
        $img_puntos = $query->getResult();
        // Coordenadas
        $query2 = $em->createQuery('SELECT p FROM AppBundle:Coordenadas p WHERE p.puntosid = ?1 ');
        $query2->setParameter(1, $el->getId());
        $coo = $query2->getResult();
        if(count($coo)>0){
            $coo = $coo[0];
        }
        // Detect the locale and make the translation.
        $has=false;
        $locale = $request->getLocale();
        $query = $em->createQuery('SELECT p.id FROM AppBundle:Idiomas p WHERE p.idioma = ?1');
        $query->setParameter(1, $locale);
        $localeid = $query->getResult();
        $traduccion=array();
        //
        if($localeid != null)
        {
            $query2 = $em->createQuery('SELECT p FROM AppBundle:Traducciones p WHERE p.puntosid = ?1 AND p.idiomasid = ?2');
            $query2->setParameter(1, $el->getId());
            $query2->setParameter(2, $localeid[0]['id']);
            $traduccion = $query2->getResult();
            if($traduccion!=null)
            {
                $has=true;
            }
        }
        if($has==true){
            $el->setNombre($traduccion[0]->getTexto1());
            $el->setDireccion($traduccion[0]->getTexto2());
            $el->setTexto($traduccion[0]->getTexto3());
            $el->setMetatitle($traduccion[0]->getTexto4());
            $el->setMetadesc($traduccion[0]->getTexto5());
            $el->setMetakeyword($traduccion[0]->getTexto5());
        }
        // enviar las META.
        $this->meta_tag_puntos($el);
        // Ver si es casa o poi para el boton reserva.
        $this->get('twig')->addGlobal('book_btn', 'No');
        return $this->render('frontend/puntos/puntos.html.twig', array('casas'=>$casas, 'puntos'=> $puntos, 'img_casas'=>$img_casas, 'img_puntos'=>$img_puntos, 'punto'=>$el,'coo' => $coo));
    }
    // Funcion para las inyectar META TAGS.
    public function meta_tag_global(){
        $em = $this->getDoctrine()->getManager();
        $config = $em->getRepository('AppBundle:Settings')->find(1);
        $this->get('twig')->addGlobal('global_title', $config->getWebtitulo());
        $this->get('twig')->addGlobal('global_description', $config->getWebdesc());
        $this->get('twig')->addGlobal('global_keywords', $config->getWebkeywords());
    }
    public function meta_tag_puntos($puntos){
        $this->get('twig')->addGlobal('global_title', $puntos->getMetatitle());
        $this->get('twig')->addGlobal('global_description', $puntos->getMetadesc());
        $this->get('twig')->addGlobal('global_keywords', $puntos->getMetakeyword());
    }
}