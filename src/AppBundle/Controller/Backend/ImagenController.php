<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\Casa;
use AppBundle\Entity\Imagenes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ImagenController extends Controller
{
    /**
     * @Route("/admin/imagenes", name="imagen_ver")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $img = $em->getRepository('AppBundle:Imagenes')->findAll();
        $casas = $em->getRepository('AppBundle:Casa')->findAll();
        $puntos = $em->getRepository('AppBundle:Puntos')->findAll();
        //
        if ($request->request->count() >= 1) {
            if($request->request->get('select_casas') || $request->request->get('select_puntos'))
            {
                //
                $id_casa = $request->request->get('select_casas');
                $id_punto = $request->request->get('select_puntos');
                //
                $img = new Imagenes();
                if($id_casa!=null)
                {
                    $casa_object = $em->getRepository('AppBundle:Casa')->find($id_casa);
                    $nombre=$casa_object->getNombre();
                    $img->setCasaid($casa_object);
                    $img->setPuntosid(null);
                }
                else {
                    $punto_object = $em->getRepository('AppBundle:Puntos')->find($id_punto);
                    $nombre=$punto_object->getNombre();
                    $img->setCasaid(null);
                    $img->setPuntosid($punto_object);
                }
                define('UPLOADPATH', 'images/uploads/');
                if (!file_exists(UPLOADPATH . $nombre)) {
                    mkdir(UPLOADPATH . $nombre);
                }
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
                if($images[0]== 'images/uploads/'.$nombre.'/')
                    $img->setImagen1('images/noimage/no.png');

                //Fix por si no suben.
                if($images[0]== 'images/uploads/'.$nombre.'/'){
                    $img->setImagen1('images/noimage/no.png');
                }
                //
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

                //Fix por si no suben VR
                if($imagesvr[0]== 'images/uploads/'.$nombre.'/VR/')
                    $img->setImagenvr1('images/noimage/no.png');
                //
                $em->persist($img);
                $em->flush();
                //
                return $this->redirectToRoute('imagen_ver');
            }
            if($request->request->get('id'))
            {
                $id = $request->request->get('id');
                $img = $em->getRepository('AppBundle:Imagenes')->find($id);
                if ($_FILES) {

                    if($img->getcasaid() !=null)
                    {
                        $nombre=$img->getcasaid()->getNombre();
                    }
                    else {
                        $nombre=$img->getpuntosid()->getNombre();
                    }
                    define('UPLOADPATH', 'images/uploads/');
                    if (!file_exists(UPLOADPATH . $nombre)) {
                        mkdir(UPLOADPATH . $nombre);
                    }
                    $images = array(null,null,null,null,null);
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

                    // Lo mismo pera para imagenes VR.
                    if (!file_exists(UPLOADPATH . $nombre.'/VR')) {
                        mkdir(UPLOADPATH . $nombre.'/VR');
                    }
                    $imagesvr = array(null,null,null);
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
                    $em->persist($img);
                    $em->flush();
                    //
                    return $this->redirectToRoute('imagen_ver');
                }
            }
        }
        return $this->render('backend/imagenes/ver.html.twig', array('img' => $img, 'casas'=>$casas, 'puntos'=>$puntos));
    }
    /**
     * @Route("/admin/imagen/eliminar/{id}", name="imagen_eliminar")
     */
    public function EliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $img = $em->getRepository('AppBundle:Imagenes')->find($id);
        $em->remove($img);
        $em->flush();
        return $this->redirectToRoute('imagen_ver');
    }
}