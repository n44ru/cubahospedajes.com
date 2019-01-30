<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\Gallery;
use AppBundle\Entity\Imagegallery;
use AppBundle\Entity\Imagenes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GalleryController extends Controller
{
    /**
     * @Route("/admin/gallery", name="gallery_ver")
     */
    public function indexAction(Request $request)
    {
        define('UPLOADPATH', 'images/uploads/gallery/');
        $em = $this->getDoctrine()->getManager();
        $all = $em->getRepository('AppBundle:Gallery')->findAll();
        //
        $casas = $em->getRepository('AppBundle:Casa')->findAll();
        $puntos = $em->getRepository('AppBundle:Puntos')->findAll();
        if ($request->request->count() >= 1) {
            if($request->request->get('tag'))
            {
                $tag = $request->request->get('tag');
                /* Obtener el ultimo id para las imagenes.
                $last_id = $em->createQuery('SELECT MAX(p.id) FROM AppBundle:Imagegallery p ');
                if ($last_id == null || $last_id < 1)
                    $last_id = 1; */

                $id_casa = $request->request->get('select_casas');
                $id_punto = $request->request->get('select_puntos');
                //
                $img = new Imagegallery();
                if ($id_casa != null) {
                    $casa_object = $em->getRepository('AppBundle:Casa')->find($id_casa);
                    $img->setCasaid($casa_object);
                    $img->setPuntosid(null);
                } else {
                    $punto_object = $em->getRepository('AppBundle:Puntos')->find($id_punto);
                    $img->setCasaid(null);
                    $img->setPuntosid($punto_object);
                }
                if (!file_exists(UPLOADPATH)) {
                    mkdir(UPLOADPATH);
                }
                $file1 = $_FILES['image']['name'];
                $target = UPLOADPATH . $file1;
                move_uploaded_file($_FILES['image']['tmp_name'], $target);

                if ($file1 != null)
                    $img->setUrl($target);
                $img->setTags($tag);
                $em->persist($img);
                $em->flush();
                // Introducir a la Gallery.
                $gallery = new Gallery();
                $gallery->setImagegalleryid($img);
                $em->persist($gallery);
                $em->flush();
                return $this->redirectToRoute("gallery_ver");
            }
            if($request->request->get('id'))
            {
                $id = $request->request->get('id');
                $tag = $request->request->get('tag_edit');
                //
                $img = $em->getRepository('AppBundle:Imagegallery')->find($id);
                if (!file_exists(UPLOADPATH)) {
                    mkdir(UPLOADPATH);
                }
                $file1 = $_FILES['image']['name'];
                $target = UPLOADPATH . $file1;
                move_uploaded_file($_FILES['image']['tmp_name'], $target);

                if ($file1 != null)
                    $img->setUrl($target);
                $img->setTags($tag);
                $em->persist($img);
                $em->flush();
                return $this->redirectToRoute("gallery_ver");
            }

        }
        return $this->render('backend/galeria/ver.html.twig', array('gallery' => $all, 'casas'=>$casas, 'puntos'=>$puntos));
    }

    /**
     * @Route("/admin/galeria/eliminar/eliminar/{id}", name="gallery_eliminar")
     */
    public function EliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $img = $em->getRepository('AppBundle:Imagegallery')->find($id);
        $em->remove($img);
        $em->flush();
        return $this->redirectToRoute('gallery_ver');
    }
}