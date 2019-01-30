<?php
/**
 * Created by PhpStorm.
 * User: carlosmanuel
 * Date: 6/25/17
 * Time: 11:35 a.m.
 */

namespace AppBundle\Utils;

use Doctrine\ORM\EntityManager;

class AdminAlertas
{
    protected $em;

    public function __construct(EntityManager $em)
    {

        $this->em = $em;
    }
    public function alertas(){
        $alertas = $this->em->getRepository('AppBundle:Alertas')->find(1);
        return $alertas;
    }
}