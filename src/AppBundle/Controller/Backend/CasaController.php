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
            if($nombre = $request->request->get('nombre'))
            {
                $s=null;
                //Controlando las relaciones
                if($request->request->get('subdestino'))
                {
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
                $precio= $request->request->get('precio');
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
                // Insertando relaciones
                if($request->request->get('subdestino'))
                {
                    $casa->setSubdestinosid($s);
                }
                else{$casa->setSubdestinosid(null);}
                // Insertando la keyword de subdestinos
                $casa->setKeywords(strtolower($s->getNombre()));
                $em->persist($casa);
                $em->flush();
                //
                // Controlar las imagenes subidas
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
                        $images[$i] = UPLOADPATH.$nombre.'/'.$_FILES['myfiles']['name'][$i];
                        move_uploaded_file($_FILES['myfiles']['tmp_name'][$i], UPLOADPATH . $nombre.'/'.$_FILES['myfiles']['name'][$i]);
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

                // Lo mismo pero para imagenes VR.
                if (!file_exists(UPLOADPATH . $nombre.'/VR')) {
                    mkdir(UPLOADPATH . $nombre.'/VR');
                }
                $imagesvr = array('','','');
                if($_FILES['myfilesvr'] != null) {
                    for ($i = 0; $i < count($_FILES['myfilesvr']['name']); $i++) {
                        $imagesvr[$i] = UPLOADPATH.$nombre.'/VR/'.$_FILES['myfilesvr']['name'][$i];
                        move_uploaded_file($_FILES['myfilesvr']['tmp_name'][$i], UPLOADPATH . $nombre.'/VR/'.$_FILES['myfilesvr']['name'][$i]);
                    }
                }
                if($imagesvr[0]!=null)
                    $img->setImagenvr1($imagesvr[0]);
                if($imagesvr[1]!=null)
                    $img->setImagenvr2($imagesvr[1]);
                if($imagesvr[2]!=null)
                    $img->setImagenvr3($imagesvr[2]);
                //
                $img->setCasaid($casa);
                $em->persist($img);
                $em->flush();
                //
                return $this->redirectToRoute('casa_ver');
            }
            if($nombre = $request->request->get('nombre_editar'))
            {
                //Controlando las relaciones
                if($request->request->get('subdestino'))
                {
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
                $precio= $request->request->get('precio');
                //
                $casa->setNombre($nombre);
                $casa->setDireccion($direccion);
                $casa->setResponsable($responsable);
                $casa->setTelefono($telefono);
                $casa->setCorreo($correo);
                $casa->setActiva($activa);
                $casa->setTexto($texto);
                $casa->setPrecio($precio);
                // Insertando relaciones
                if($request->request->get('subdestino'))
                {
                    $casa->setSubdestinosid($s);
                }
                else{$casa->setSubdestinosid(null);}
                //
                $em->persist($casa);
                $em->flush();
                // Controlar las imagenes subidas
                //Imagenes
                $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.casaid = ?1 ');
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

                // Lo mismo pero para imagenes VR.
                if (!file_exists(UPLOADPATH . $nombre.'/VR')) {
                    mkdir(UPLOADPATH . $nombre.'/VR');
                }
                $imagesvr = array('','','');
                if($_FILES['myfilesvr'] != null) {
                    for ($i = 0; $i < count($_FILES['myfilesvr']['name']); $i++) {
                        if($_FILES['myfilesvr']['name'][$i]!= null) { // Fix para imagenes vacias.
                            $imagesvr[$i] = UPLOADPATH . $nombre . '/VR/' . $_FILES['myfilesvr']['name'][$i];
                            move_uploaded_file($_FILES['myfilesvr']['tmp_name'][$i], UPLOADPATH . $nombre . '/VR/' . $_FILES['myfilesvr']['name'][$i]);
                        }
                    }
                }
                if($imagesvr[0]!=null)
                    $img->setImagenvr1($imagesvr[0]);
                if($imagesvr[1]!=null)
                    $img->setImagenvr2($imagesvr[1]);
                if($imagesvr[2]!=null)
                    $img->setImagenvr3($imagesvr[2]);
                //
                //$img->setCasaid($casa);
                $em->persist($img);
                $em->flush();
                //
                return $this->redirectToRoute('casa_ver');
            }
        }
        return $this->render('backend/casas/ver.html.twig', array('casas' => $casas, 'destinos'=>$destinos, 'subdestinos'=>$subdestinos, 'imagenes'=>$imagenes));
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