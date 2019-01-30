<?php
/**
 * Created by PhpStorm.
 * User: carlosmanuel
 * Date: 6/26/17
 * Time: 10:07 a.m.
 */

namespace AppBundle\Utils;


class Slugger
{
    // Aqui añades los carateres especiales que quieras que se no se conviertan el la url.
    public function slugify($string) {
        return preg_replace(
            '/[^a-z0-9áéíóúñ#]/', '-', strtolower(trim(strip_tags($string)))
        ); }

    public function back($string) {
        return preg_replace(
            '/[-]/', ' ', strtolower(trim(strip_tags($string)))
        ); }
}