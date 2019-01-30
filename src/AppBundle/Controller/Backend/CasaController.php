<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\Casa;
use AppBundle\Entity\Imagenes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CasaController extends Controller
{
    /**
     * @Route("/admin/casas", name="casa_ver")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //
        $casas = $em->getRepository('AppBundle:Casa')->findAll();
        $destinos = $em->getRepository('AppBundle:Destinos')->findAll();
        $subdestinos = $em->getRepository('AppBundle:Subdestinos')->findAll();
        // obtener todas las imagenes
        $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.casaid >= 1 ');
        $imagenes = $query->getResult();
        if ($request->request->count() > 1) {
            if ($nombre = $request->request->get('nombre')) {
                $s = null;
                //Controlando las relaciones
                if ($request->request->get('subdestino')) {
                    $sub_id = $request->request->get('subdestino');
                    $s = $em->getRepository('AppBundle:Subdestinos')->find($sub_id);
                }
                //
                $nombre = $request->request->get('nombre');
                $direccion = $request->request->get('direccion');
                $responsable = $request->request->get('responsable');
                $telefono = $request->request->get('telefono');
                $correo = $request->request->get('correo');
                $activa = $request->request->get('activa');
                $texto = $request->request->get('texto');
                $precio = $request->request->get('precio');
                $metatitle = $request->request->get('metatitle');
                $metadesc = $request->request->get('metadesc');
                $metakeyword = $request->request->get('metakeyword');
                // Los nuevos datos.
                $capacidad = $request->request->get('capacidad');
                $cuartos = $request->request->get('cuartos');
                $bath = $request->request->get('bath');
                $multiple = $request->request->get('multiple');
                // Recoger el tag de las imagenes.
                $tags = $request->request->get('tags');
                $precioofertas = $request->request->get('precioofertas');
                $reglas = $request->request->get('reglas');
                //Si las meta estan vacias autogenerarlas.
                if ($metatitle == null) {
                    $metatitle = $nombre;
                }
                if ($metadesc == null) {
                    if (count($texto) > 20) {
                        $metadesc = substr($texto, 20);
                    } else $metadesc = $texto;

                }
                if ($metakeyword == null) {
                    // Ver que keywords incluir aqui.
                    $destino = $s->getDestinoid();
                    $metakeyword = $s->getNombre() . ', ' . $destino->getNombre();
                }
                //
                $casa = new Casa();
                $casa->setNombre($nombre);
                $casa->setDireccion($direccion);
                $casa->setResponsable($responsable);
                $casa->setTelefono($telefono);
                $casa->setCorreo($correo);
                $casa->setActiva($activa);
                $casa->setTexto($texto);
                $casa->setPrecio($precio);
                $casa->setMetatitle($metatitle);
                $casa->setMetadesc($metadesc);
                $casa->setMetakeyword($metakeyword);
                // Los nuevos datos.
                $casa->setCapacidad($capacidad);
                $casa->setCuartos($cuartos);
                $casa->setBath($bath);
                $casa->setReservamultiple($multiple);
                $casa->setPreciooferta($precioofertas);
                $casa->setReglas($reglas);
                // Insertando relaciones
                if ($request->request->get('subdestino')) {
                    $casa->setSubdestinosid($s);
                } else {
                    $casa->setSubdestinosid(null);
                }
                // Insertando la keyword de subdestinos
//                $casa->setKeywords(strtolower($s->getNombre()));
                $casa->setKeywords($s->getNombre() . ' , ' . $s->getDestinoid()->getNombre());
                $em->persist($casa);
                $em->flush();
                //
                // Controlar las imagenes subidas
                // nombre de la casa.
                $nombre = $casa->getId();
                define('UPLOADPATH', 'images/uploads/');
                if (!file_exists(UPLOADPATH . $nombre)) {
                    mkdir(UPLOADPATH . $nombre);
                }
                // Recoger todas las imagenes del post.
                if (strlen($_FILES['myfiles']['name'][0]) > 0) {
                    for ($i = 0; $i < count($_FILES['myfiles']['name']); $i++) {
                        $img = new Imagenes();
                        move_uploaded_file($_FILES['myfiles']['tmp_name'][$i], UPLOADPATH . $nombre . '/' . $_FILES['myfiles']['name'][$i]);
                        //Insertando una nueva Imagen.
                        $img->setImagen(UPLOADPATH . $nombre . '/' . $_FILES['myfiles']['name'][$i]);
                        $img->setTags($tags);
                        $img->setCasaid($casa);
                        $em->persist($img);
                        $em->flush();
                    }
                } else {
                    $img = new Imagenes();
                    $img->setImagen('images/noimage/no.png');
                    $img->setTags($tags);
                    $img->setCasaid($casa);
                    $em->persist($img);
                    $em->flush();
                }
            }
            if ($nombre = $request->request->get('nombre_editar')) {
                //Controlando las relaciones
                if ($request->request->get('subdestino')) {
                    $sub_id = $request->request->get('subdestino');
                    $s = $em->getRepository('AppBundle:Subdestinos')->find($sub_id);
                }
                $id = $request->request->get('id');
                $casa = $em->getRepository('AppBundle:Casa')->find($id);
                $nombre = $request->request->get('nombre_editar');
                $direccion = $request->request->get('direccion');
                $responsable = $request->request->get('responsable');
                $telefono = $request->request->get('telefono');
                $correo = $request->request->get('correo');
                $activa = $request->request->get('activa');
                $texto = $request->request->get('texto');
                $precio = $request->request->get('precio');
                $metatitle = $request->request->get('metatitle');
                $metadesc = $request->request->get('metadesc');
                $metakeyword = $request->request->get('metakeyword');
                //
                $capacidad = $request->request->get('capacidad');
                $cuartos = $request->request->get('cuartos');
                $bath = $request->request->get('bath');
                $multiple = $request->request->get('multiple');
                // Recoger el tag de las imagenes.
                $tags = $request->request->get('tags');
                $precioofertas = $request->request->get('precioofertas');
                $reglas = $request->request->get('reglas');
                //Si las meta estan vacias autogenerarlas.
                if ($metatitle == null) {
                    $metatitle = $nombre;
                }
                if ($metadesc == null) {
                    $metadesc = $texto;
                }
                if ($metakeyword == null) {
                    // Ver que keywords incluir aqui.
                    $destino = $s->getDestinoid();
                    $metakeyword = $s->getNombre() . ',' . $destino->getNombre();
                }
                //
                $casa->setNombre($nombre);
                $casa->setDireccion($direccion);
                $casa->setResponsable($responsable);
                $casa->setTelefono($telefono);
                $casa->setCorreo($correo);
                $casa->setActiva($activa);
                $casa->setTexto($texto);
                $casa->setPrecio($precio);
                $casa->setMetatitle($metatitle);
                $casa->setMetadesc($metadesc);
                $casa->setMetakeyword($metakeyword);
                // Los nuevos datos.
                $casa->setCapacidad($capacidad);
                $casa->setCuartos($cuartos);
                $casa->setBath($bath);
                $casa->setReservamultiple($multiple);
                $casa->setPreciooferta($precioofertas);
                $casa->setReglas($reglas);
                // Insertando relaciones
                if ($request->request->get('subdestino')) {
                    $casa->setSubdestinosid($s);
                } else {
                    $casa->setSubdestinosid(null);
                }
                //
                $em->persist($casa);
                $em->flush();
                // Controlar las imagenes subidas
                $nombre = $casa->getId();
                define('UPLOADPATH', 'images/uploads/');
                if (!file_exists(UPLOADPATH . $nombre)) {
                    mkdir(UPLOADPATH . $nombre);
                }
                $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.casaid = ?1 ');
                $query->setParameter(1, $id);
                $img_temp = $query->getResult();
                // Recoger todas las imagenes del post.
                if (strlen($_FILES['myfiles']['name'][0]) > 0) {
                    //Si es una image none borrarla.
                    if(count($img_temp)>0) {
                        if ($img_temp[0]->getImagen() == 'images/noimage/no.png') {
                            $delete = $em->getRepository('AppBundle:Imagenes')->find($img_temp[0]->getId());
                            $em->remove($delete);
                            $em->flush();
                        }
                    }
                    for ($i = 0; $i < count($_FILES['myfiles']['name']); $i++) {
                        $img = new Imagenes();
                        move_uploaded_file($_FILES['myfiles']['tmp_name'][$i], UPLOADPATH . $nombre . '/' . $_FILES['myfiles']['name'][$i]);
                        //Insertando una nueva Imagen.
                        $img->setImagen(UPLOADPATH . $nombre . '/' . $_FILES['myfiles']['name'][$i]);
                        $img->setTags($tags);
                        $img->setCasaid($casa);
                        $em->persist($img);
                        $em->flush();
                    }
                } elseif (count($img_temp) == 0) {
                    $img = new Imagenes();
                    $img->setImagen('images/noimage/no.png');
                    $img->setTags($tags);
                    $img->setCasaid($casa);
                    $em->persist($img);
                    $em->flush();
                }
            }
            return $this->redirectToRoute('casa_ver');
        }
        return $this->render('backend/casas/ver.html.twig', array('casas' => $casas, 'destinos' => $destinos, 'subdestinos' => $subdestinos, 'imagenes' => $imagenes));
    }

    /**
     * @Route("/admin/casas/eliminar/{id}", name="casa_eliminar")
     */
    public function EliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $linea = $em->getRepository('AppBundle:Casa')->find($id);
        $em->remove($linea);
        $em->flush();
        return $this->redirectToRoute('casa_ver');
    }
}