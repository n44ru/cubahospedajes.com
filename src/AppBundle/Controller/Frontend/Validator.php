<?php

namespace AppBundle\Controller\Frontend;


class Validator
{
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = strip_tags($data);
        return $data;
    }

    function getAllHouses($em, $dest, $sub, $text)
    {
        //Seleccionar el destino.
        $query = $em->createQuery('SELECT p FROM AppBundle:Destinos p WHERE p.nombre = ?1 ');
        $query->setParameter(1, $dest);
        $destinos = $query->getResult();
        //Seleccionar el subdestino.
        $query2 = $em->createQuery('SELECT p FROM AppBundle:Subdestinos p WHERE p.destinoid = ?1 and p.nombre = ?2');
        $query2->setParameter(1, $destinos[0]->getId());
        $query2->setParameter(2, $sub);
        $subdestinos = $query2->getResult();
        //
        $query3 = $em->createQuery('SELECT p FROM AppBundle:Casa p WHERE p.subdestinosid = ?1 and p.nombre LIKE ?2 and p.activa = ?3');
        $query3->setParameter(1, $subdestinos[0]->getId());
        $query3->setParameter(2, '%' . $text . '%');
        $query3->setParameter(3, 'Si');
        return $query3->getResult();
    }

    function getAllPoints($em, $dest, $sub, $text)
    {
        //Seleccionar el destino.
        $query = $em->createQuery('SELECT p FROM AppBundle:Destinos p WHERE p.nombre = ?1 ');
        $query->setParameter(1, $dest);
        $destinos = $query->getResult();
        //Seleccionar el subdestino.
        $query2 = $em->createQuery('SELECT p FROM AppBundle:Subdestinos p WHERE p.destinoid = ?1 and p.nombre = ?2');
        $query2->setParameter(1, $destinos[0]->getId());
        $query2->setParameter(2, $sub);
        $subdestinos = $query2->getResult();
        //
        $query3 = $em->createQuery('SELECT p FROM AppBundle:Puntos p WHERE p.subdestinosid = ?1 and p.nombre LIKE ?2 and p.texto LIKE ?2');
        $query3->setParameter(1, $subdestinos[0]->getId());
        $query3->setParameter(2, '%' . $text . '%');
        return $query3->getResult();
    }

    function getHouses($texto, $guest, $em)
    {
        $type = substr($texto, 0, 1);
        $text = substr($texto, 2, strlen($texto));

        $casas = array();
        if ($type == 'd') {
            //Seleccionar el destino.
            $query = $em->createQuery('SELECT p FROM AppBundle:Destinos p WHERE p.nombre = ?1 ');
            $query->setParameter(1, $text);
            $destinos = $query->getResult();
            //Seleccionar el subdestino.
            $query2 = $em->createQuery('SELECT p FROM AppBundle:Subdestinos p WHERE p.destinoid = ?1 ');
            $query2->setParameter(1, $destinos[0]->getId());
            $subdestinos = $query2->getResult();
            //Si hay mas de 1 subdestinos para el Destino.
            $x = 0;
            for ($i = 0; $i < count($subdestinos); $i++) {
                $query3 = $em->createQuery('SELECT p FROM AppBundle:Casa p WHERE p.subdestinosid = ?1 and p.capacidad >= ?2 and p.activa = ?3');
                $query3->setParameter(1, $subdestinos[$i]->getId());
                $query3->setParameter(2, $guest);
                $query3->setParameter(3, 'Si');
                $results = $query3->getResult();
                for ($j = 0; $j < count($results); $j++) {
                    $casas[$x] = $results[$j];
                    $x++;
                }
            }
        } else if ($type == 's') {
            //Seleccionar el subdestino.
            $query = $em->createQuery('SELECT p FROM AppBundle:Subdestinos p WHERE p.nombre = ?1 ');
            $query->setParameter(1, $text);
            $subdestinos = $query->getResult();
            //Seleccionar las casas basadas en ese subdestino y los demas parametros.
            $query3 = $em->createQuery('SELECT p FROM AppBundle:Casa p WHERE p.subdestinosid = ?1 and p.capacidad >= ?2 and p.activa = ?3');
            $query3->setParameter(1, $subdestinos[0]->getId());
            $query3->setParameter(2, $guest);
            $query3->setParameter(3, 'Si');
            $casas = $query3->getResult();
        } else if ($type == 'c') {
            //Seleccionar las casas basadas en el nombre y los demas parametros.
            $query3 = $em->createQuery('SELECT p FROM AppBundle:Casa p WHERE p.nombre = ?1 and p.capacidad >= ?2 and p.activa = ?3');
            $query3->setParameter(1, $text);
            $query3->setParameter(2, $guest);
            $query3->setParameter(3, 'Si');
            $casas = $query3->getResult();
        }
        return $casas;
    }

    function getReservas($em, $fecha_llegada, $fecha_salida)
    {
        $usados = array();
        $query2 = $em->createQuery('SELECT p FROM AppBundle:Prereservas p WHERE p.fechallegada >= ?1 AND p.fechasalida <= ?2');
        $query2->setParameter(1, $fecha_llegada);
        $query2->setParameter(2, $fecha_salida);
        $posibles = $query2->getResult();

        for ($i = 0; $i < count($posibles); $i++) {
            $usados[$i] = array('ocupadaid' => $posibles[$i]->getCasaid()->getId(), 'fecha1' => $posibles[$i]->getFechallegada(), 'fecha2' => $posibles[$i]->getFechasalida());
        }
        return $usados;
    }

    function orderHouses($texto, $guest, $em, $op, $mode, $min, $max, $room)
    {
        $type = substr($texto, 0, 1);
        $text = substr($texto, 2, strlen($texto));

        $casas = array();
        if ($type == 'd') {
            //Seleccionar el destino.
            $query = $em->createQuery('SELECT p FROM AppBundle:Destinos p WHERE p.nombre = ?1 ');
            $query->setParameter(1, $text);
            $destinos = $query->getResult();
            //Seleccionar el subdestino.
            $query2 = $em->createQuery('SELECT p FROM AppBundle:Subdestinos p WHERE p.destinoid = ?1 ');
            $query2->setParameter(1, $destinos[0]->getId());
            $subdestinos = $query2->getResult();
            //Si hay mas de 1 subdestinos para el Destino.
            $x = 0;
            for ($i = 0; $i < count($subdestinos); $i++) {
                $query3 = $em->createQuery('SELECT p FROM AppBundle:Casa p WHERE p.subdestinosid = ?1 and p.capacidad >= ?2 and p.activa = ?3 and p.precio >= ?4 and p.precio <= ?5 and p.cuartos >= ?6');
                $query3->setParameter(1, $subdestinos[$i]->getId());
                $query3->setParameter(2, $guest);
                $query3->setParameter(3, 'Si');
                $query3->setParameter(4, $min);
                $query3->setParameter(5, $max);
                $query3->setParameter(6, $room);
                $results = $query3->getResult();
                for ($j = 0; $j < count($results); $j++) {
                    $casas[$x] = $results[$j];
                    $x++;
                }
            }
        } else if ($type == 's') {
            //Seleccionar el subdestino.
            $query = $em->createQuery('SELECT p FROM AppBundle:Subdestinos p WHERE p.nombre = ?1 ');
            $query->setParameter(1, $text);
            $subdestinos = $query->getResult();
            $query3 = $em->createQuery('SELECT p FROM AppBundle:Casa p WHERE p.subdestinosid = ?1 and p.capacidad >= ?2 and p.activa = ?3 and p.precio >= ?4 and p.precio <= ?5 and p.cuartos >= ?6');
            $query3->setParameter(1, $subdestinos[0]->getId());
            $query3->setParameter(2, $guest);
            $query3->setParameter(3, 'Si');
            $query3->setParameter(4, $min);
            $query3->setParameter(5, $max);
            $query3->setParameter(6, $room);
            $casas = $query3->getResult();
        } else if ($type == 'c') {
            $query3 = $em->createQuery('SELECT p FROM AppBundle:Casa p WHERE p.nombre = ?1 and p.capacidad >= ?2 and p.activa = ?3 and p.precio >= ?4 and p.precio <= ?5 and p.cuartos >= ?6');
            $query3->setParameter(1, $text);
            $query3->setParameter(2, $guest);
            $query3->setParameter(3, 'Si');
            $query3->setParameter(4, $min);
            $query3->setParameter(5, $max);
            $query3->setParameter(6, $room);
            $casas = $query3->getResult();
        }
        if ($op == "name") {
            for ($i = 0; $i < count($casas); $i++) {
                $menor = $i;
                for ($j = $i + 1; $j < count($casas); $j++) {
                    if (strtolower($casas[$j]->getNombre() < strtolower($casas[$menor]->getNombre()))) {
                        $menor = $j;
                    }
                }
                $temp = $casas[$i];
                $casas[$i] = $casas[$menor];
                $casas[$menor] = $temp;
            }
            if ($mode == 'DESC') {
                $casas = array_reverse($casas);
            }
        }
        if ($op == "price") {
            for ($i = 0; $i < count($casas); $i++) {
                $menor = $i;
                for ($j = $i + 1; $j < count($casas); $j++) {
                    if ($casas[$j]->getPrecio() < $casas[$menor]->getPrecio()) {
                        $menor = $j;
                    }
                }
                $temp = $casas[$i];
                $casas[$i] = $casas[$menor];
                $casas[$menor] = $temp;
            }
            if ($mode == 'DESC') {
                $casas = array_reverse($casas);
            }
        }
        if ($op == "rooms") {
            for ($i = 0; $i < count($casas); $i++) {
                $menor = $i;
                for ($j = $i + 1; $j < count($casas); $j++) {
                    if ($casas[$j]->getCuartos() < $casas[$menor]->getCuartos()) {
                        $menor = $j;
                    }
                }
                $temp = $casas[$i];
                $casas[$i] = $casas[$menor];
                $casas[$menor] = $temp;
            }
            if ($mode == 'DESC') {
                $casas = array_reverse($casas);
            }
        }
        return $casas;
    }

    function getAdvancedHouses($texto, $guest, $cuartos, $preciomin, $preciomax, $em)
    {
        $type = substr($texto, 0, 1);
        $text = substr($texto, 2, strlen($texto));

        $casas = array();
        if ($type == 'd') {
            //Seleccionar el destino.
            $query = $em->createQuery('SELECT p FROM AppBundle:Destinos p WHERE p.nombre = ?1 ');
            $query->setParameter(1, $text);
            $destinos = $query->getResult();
            //Seleccionar el subdestino.
            $query2 = $em->createQuery('SELECT p FROM AppBundle:Subdestinos p WHERE p.destinoid = ?1 ');
            $query2->setParameter(1, $destinos[0]->getId());
            $subdestinos = $query2->getResult();
            //Si hay mas de 1 subdestinos para el Destino.
            $x = 0;
            for ($i = 0; $i < count($subdestinos); $i++) {
                $query3 = $em->createQuery('SELECT p FROM AppBundle:Casa p WHERE p.subdestinosid = ?1 and p.capacidad >= ?2 and p.activa = ?3 and p.cuartos >= ?4 and p.precio >= ?5 and p.precio <= ?6');
                $query3->setParameter(1, $subdestinos[$i]->getId());
                $query3->setParameter(2, $guest);
                $query3->setParameter(3, 'Si');
                $query3->setParameter(4, $cuartos);
                $query3->setParameter(5, $preciomin);
                $query3->setParameter(6, $preciomax);
                $results = $query3->getResult();
                for ($j = 0; $j < count($results); $j++) {
                    $casas[$x] = $results[$j];
                    $x++;
                }
            }
        } else if ($type == 's') {
            //Seleccionar el subdestino.
            $query = $em->createQuery('SELECT p FROM AppBundle:Subdestinos p WHERE p.nombre = ?1 ');
            $query->setParameter(1, $text);
            $subdestinos = $query->getResult();
            //Seleccionar las casas basadas en ese subdestino y los demas parametros.
            $query3 = $em->createQuery('SELECT p FROM AppBundle:Casa p WHERE p.subdestinosid = ?1 and p.capacidad >= ?2 and p.activa = ?3 and p.cuartos >= ?4 and p.precio >= ?5 and p.precio <= ?6');
            $query3->setParameter(1, $subdestinos[0]->getId());
            $query3->setParameter(2, $guest);
            $query3->setParameter(3, 'Si');
            $query3->setParameter(4, $cuartos);
            $query3->setParameter(5, $preciomin);
            $query3->setParameter(6, $preciomax);
            $casas = $query3->getResult();
        } else if ($type == 'c') {
            //Seleccionar las casas basadas en el nombre y los demas parametros.
            $query3 = $em->createQuery('SELECT p FROM AppBundle:Casa p WHERE p.nombre = ?1 and p.capacidad >= ?2 and p.activa = ?3 and p.cuartos >= ?4 and p.precio >= ?5 and p.precio <= ?6');
            $query3->setParameter(1, $text);
            $query3->setParameter(2, $guest);
            $query3->setParameter(3, 'Si');
            $query3->setParameter(4, $cuartos);
            $query3->setParameter(5, $preciomin);
            $query3->setParameter(6, $preciomax);
            $casas = $query3->getResult();
        }
        return $casas;
    }
}