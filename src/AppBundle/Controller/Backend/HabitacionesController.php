<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\Habitaciones;
use AppBundle\Entity\Imagenes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HabitacionesController extends Controller
{
    /**
     * @Route("/admin/habitaciones", name="hab_ver")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //
        $casas = $em->getRepository('AppBundle:Casa')->findAll();
        $habs = $em->getRepository('AppBundle:Habitaciones')->findAll();
        //
        $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.habitacionesid >= 1 ');
        $imagenes = $query->getResult();
        //
        if ($request->request->count() > 1) {
            if($nombre = $request->request->get('capacidad'))
            {
                $capacidad = $request->request->get('capacidad');
                //$ocupada = $request->request->get('ocupada');
                $precio = $request->request->get('precio');
                $activa = $request->request->get('activa');
                $casa_id = $request->request->get('select_casas');
                $camas = $request->request->get('camas');
                $casa = $em->getRepository('AppBundle:Casa')->find($casa_id);
                $hab = new Habitaciones();
                $hab->setCapacidad($capacidad);
                //$hab->setOcupada($ocupada);
                $hab->setPrecio($precio);
                $hab->setActiva($activa);
                $hab->setCasaid($casa);
                $hab->setCamas($camas);
                // Actualizando los cuartos en casa.
                $cuartos = $casa->getCuartos() + 1;
                $casa->setCuartos($cuartos);
                // Actualizando el precio si es el menor.
                $precio_actual = $casa->getPrecio();
                if($precio_actual == 0 || $precio<$precio_actual)
                {
                    $casa->setPrecio($precio);
                }
                //
                // Actualizando la capacidad.
                $cap_actual = $casa->getCapacidad();
                $casa->setCapacidad($cap_actual+$capacidad);
                //
                $em->persist($hab);
                $em->flush();
                //
                //Imagenes
                $img = new Imagenes();
                // nombre de la casa.
                $nombre= $casa->getNombre();
                define('UPLOADPATH', 'images/uploads/');
                if (!file_exists(UPLOADPATH . $nombre)) {
                    mkdir(UPLOADPATH . $nombre);
                }
                // Recoger todas las imagenes del post.
                $images = array('','','','','');
                if($_FILES['myfiles'] != null) {
                    for ($i = 0; $i < count($_FILES['myfiles']['name']); $i++) {
                        if($_FILES['myfiles']['name'][$i]!= null) { // Fix para imagenes vacias.
                            $images[$i] = UPLOADPATH . $nombre . '/' . $_FILES['myfiles']['name'][$i];
                            move_uploaded_file($_FILES['myfiles']['tmp_name'][$i], UPLOADPATH . $nombre . '/' . $_FILES['myfiles']['name'][$i]);
                        }
                    }
                }
                if($images[0]!=null)
                    $img->setImagen1($images[0]);
                if($images[1]!=null)
                    $img->setImagen2($images[1]);
                if($images[2]!=null)
                    $img->setImagen3($images[2]);
                if($images[3]!=null)
                    $img->setImagen4($images[3]);
                if($images[4]!=null)
                    $img->setImagen5($images[4]);
                // Persistir datos
                $img->setHabitacionesid($hab);
                $em->persist($img);
                $em->flush();
                //
                return $this->redirectToRoute('hab_ver');
            }
            if($nombre = $request->request->get('capacidad_editar'))
            {
                $id = $request->request->get('id');
                $hab = $em->getRepository('AppBundle:Habitaciones')->find($id);
                $capacidad = $request->request->get('capacidad_editar');
                //$ocupada = $request->request->get('ocupada');
                $precio = $request->request->get('precio');
                $activa = $request->request->get('activa');
                $casa_id = $request->request->get('select_casas');
                $camas = $request->request->get('camas');
                $casa = $em->getRepository('AppBundle:Casa')->find($casa_id);
                //
                $hab->setCapacidad($capacidad);
                //$hab->setOcupada($ocupada);
                $hab->setPrecio($precio);
                $hab->setActiva($activa);
                $hab->setCasaid($casa);
                $hab->setCamas($camas);
                // Actualizando el precio si es el menor.
                $precio_actual = $casa->getPrecio();
                if($precio_actual == 0 || $precio<$precio_actual)
                {
                    $casa->setPrecio($precio);
                }
                $em->persist($hab);
                $em->flush();
                //Imagenes
                $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.habitacionesid = ?1 ');
                $query->setParameter(1, $id);
                $img_temp = $query->getResult();
                $img= $em->getRepository('AppBundle:Imagenes')->find($img_temp[0]->getId());
                // nombre de la casa.
                $nombre= $casa->getNombre();
                define('UPLOADPATH', 'images/uploads/');
                if (!file_exists(UPLOADPATH . $nombre)) {
                    mkdir(UPLOADPATH . $nombre);
                }
                // Recoger todas las imagenes del post.
                $images = array('','','','','');
                if($_FILES['myfiles'] != null) {
                    for ($i = 0; $i < count($_FILES['myfiles']['name']); $i++) {
                        if($_FILES['myfiles']['name'][$i]!= null) { // Fix para imagenes vacias.
                            $images[$i] = UPLOADPATH . $nombre . '/' . $_FILES['myfiles']['name'][$i];
                            move_uploaded_file($_FILES['myfiles']['tmp_name'][$i], UPLOADPATH . $nombre . '/' . $_FILES['myfiles']['name'][$i]);
                        }
                    }
                }
                if($images[0]!=null)
                    $img->setImagen1($images[0]);
                if($images[1]!=null)
                    $img->setImagen2($images[1]);
                if($images[2]!=null)
                    $img->setImagen3($images[2]);
                if($images[3]!=null)
                    $img->setImagen4($images[3]);
                if($images[4]!=null)
                    $img->setImagen5($images[4]);
                // Persistir datos
                //$img->setHabitacionesid($hab);
                $em->persist($img);
                $em->flush();
                //
                return $this->redirectToRoute('hab_ver');
            }
        }
        return $this->render('backend/habitaciones/ver.html.twig', array('casas' => $casas, 'hab'=>$habs, 'imagenes'=>$imagenes));
    }
    /**
     * @Route("/admin/habitaciones/eliminar/{id}", name="hab_eliminar")
     */
    public function EliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $linea = $em->getRepository('AppBundle:Habitaciones')->find($id);
        $em->remove($linea);
        $em->flush();
        return $this->redirectToRoute('hab_ver');
    }
}