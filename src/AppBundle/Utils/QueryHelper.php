<?php
/**
 * Created by PhpStorm.
 * User: carlosmanuel
 * Date: 6/26/17
 * Time: 10:35 a.m.
 */

namespace AppBundle\Utils;

use Doctrine\ORM\EntityManager;

class QueryHelper
{
    protected $em;

    public function __construct(EntityManager $em)
    {

        $this->em = $em;
    }
    public function getCasa($dest, $subdest, $nombre){
        // Seleccionando el destino.
        $query = $this->em->createQuery('SELECT p FROM AppBundle:Destinos p WHERE p.nombre = ?1 ');
        $query->setParameter(1, $dest);
        $destinos = $query->getResult();
        // Seleccionando el Subdestino.
        $query2 = $this->em->createQuery('SELECT p FROM AppBundle:Subdestinos p WHERE p.nombre = ?1 and p.destinoid = ?2 ');
        $query2->setParameter(1, $subdest);
        $query2->setParameter(2, $destinos[0]->getId());
        $subdestinos = $query2->getResult();
        // Seleccionando la casa.
        $query3 = $this->em->createQuery('SELECT p FROM AppBundle:Casa p WHERE p.subdestinosid = ?1 and p.nombre = ?2 and p.activa = ?3');
        $query3->setParameter(1, $subdestinos[0]->getId());
        $query3->setParameter(2, $nombre);
        $query3->setParameter(3, 'Si');
        $results = $query3->getResult();
        return $results[0];
    }
    public function getPoi($dest, $subdest, $nombre){
        // Seleccionando el destino.
        $query = $this->em->createQuery('SELECT p FROM AppBundle:Destinos p WHERE p.nombre = ?1 ');
        $query->setParameter(1, $dest);
        $destinos = $query->getResult();
        // Seleccionando el Subdestino.
        $query2 = $this->em->createQuery('SELECT p FROM AppBundle:Subdestinos p WHERE p.nombre = ?1 and p.destinoid = ?2 ');
        $query2->setParameter(1, $subdest);
        $query2->setParameter(2, $destinos[0]->getId());
        $subdestinos = $query2->getResult();
        // Seleccionando la casa.
        $query3 = $this->em->createQuery('SELECT p FROM AppBundle:Puntos p WHERE p.subdestinosid = ?1 and p.nombre = ?2');
        $query3->setParameter(1, $subdestinos[0]->getId());
        $query3->setParameter(2, $nombre);
        $results = $query3->getResult();
        return $results[0];
    }
}