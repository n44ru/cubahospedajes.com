<?php
/**
 * Created by PhpStorm.
 * User: carlosmanuel
 * Date: 6/23/17
 * Time: 3:53 p.m.
 */

namespace AppBundle\EventListener;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Doctrine\ORM\EntityManager;
use Presta\SitemapBundle\Service\SitemapListenerInterface;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;

class SitemapListener implements SitemapListenerInterface
{
    private $router;
    protected $em;

    public function __construct(RouterInterface $router, EntityManager $em)
    {
        $this->router = $router;
        $this->em = $em;
    }

    public function populateSitemap(SitemapPopulateEvent $event)
    {
        $section = $event->getSection();
        if (is_null($section)) {
            // Generando todas las casa de la base de datos.
            $houses = $this->getHouseids();
            for($i=0;$i<count($houses);$i++){
                $this->populate_detalles_casa($event,'detalles_casa',$houses[$i]->getSubdestinosid()->getDestinoid()->getNombre(),$houses[$i]->getSubdestinosid()->getNombre(),$houses[$i]->getNombre(),'es');
                $this->populate_detalles_casa($event,'detalles_casa',$houses[$i]->getSubdestinosid()->getDestinoid()->getNombre(),$houses[$i]->getSubdestinosid()->getNombre(),$houses[$i]->getNombre(),'en');
            }
            // Generando todos los puntos de interes de la base de datos.
            $poi = $this->getPoiids();
            for($i=0;$i<count($poi);$i++){
                $this->populate_detalles_poi($event,'puntos_cercanias',$poi[$i]->getSubdestinosid()->getDestinoid()->getNombre(),$poi[$i]->getSubdestinosid()->getNombre(),$poi[$i]->getNombre(),'es');
                $this->populate_detalles_poi($event,'puntos_cercanias',$poi[$i]->getSubdestinosid()->getDestinoid()->getNombre(),$poi[$i]->getSubdestinosid()->getNombre(),$poi[$i]->getNombre(),'en');
            }
            //Generando las rutas estaticas.
            $this->populate_statics($event,'homepage', 'es');
            $this->populate_statics($event,'homepage', 'en');
            $this->populate_statics($event,'casas_todas', 'es');
            $this->populate_statics($event,'casas_todas', 'en');
            $this->populate_statics($event,'poi_todos', 'es');
            $this->populate_statics($event,'poi_todos', 'en');
            $this->populate_statics($event,'gallery_front', 'es');
            $this->populate_statics($event,'gallery_front', 'en');
            $this->populate_statics($event,'registro', 'es');
            $this->populate_statics($event,'registro', 'en');
        }
    }
    public function getHouseids(){
        return $this->em->getRepository('AppBundle:Casa')->findAll();
    }
    public function getPoiids(){
        return $this->em->getRepository('AppBundle:Puntos')->findAll();
    }
    public function populate_detalles_casa($event,$route, $p1,$p2,$p3,$lang){
        //get absolute homepage url
        $params = array('dest'=>$p1, 'subdest'=>$p2, 'name'=>$p3, '_locale'=>$lang);
        $url = $this->router->generate($route, $params, UrlGeneratorInterface::ABSOLUTE_URL);
        //add homepage url to the urlset named default
        $event->getUrlContainer()->addUrl(
            new UrlConcrete(
                $url,
                new \DateTime(),
                UrlConcrete::CHANGEFREQ_HOURLY,
                1
            ),
            'apartamentos_para_rentar'
        );
    }
    public function populate_detalles_poi($event,$route, $p1,$p2,$p3,$lang){
        //get absolute homepage url
        $params = array('dest'=>$p1, 'subdest'=>$p2, 'name'=>$p3, '_locale'=>$lang);
        $url = $this->router->generate($route, $params, UrlGeneratorInterface::ABSOLUTE_URL);
        //add homepage url to the urlset named default
        $event->getUrlContainer()->addUrl(
            new UrlConcrete(
                $url,
                new \DateTime(),
                UrlConcrete::CHANGEFREQ_HOURLY,
                1
            ),
            'lugares_de_interes'
        );
    }
    public function populate_statics($event, $route, $lang){
        //get absolute homepage url
        $params = array('_locale'=>$lang);
        $url = $this->router->generate($route, $params, UrlGeneratorInterface::ABSOLUTE_URL);
        //add homepage url to the urlset named default
        $event->getUrlContainer()->addUrl(
            new UrlConcrete(
                $url,
                new \DateTime(),
                UrlConcrete::CHANGEFREQ_HOURLY,
                0.7
            ),
            'rutas_estaticas'
        );
    }
}