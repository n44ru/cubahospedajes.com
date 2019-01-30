<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\Banner;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BannerController extends Controller
{
    /**
     * @Route("/admin/banner", name="banner_ver")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $puntos = $em->getRepository('AppBundle:Banner')->findAll();
        if ($request->request->count() > 1) {
            if($request->request->get('titulo'))
            {
                $titulo = $request->request->get('titulo');
                $desc = $request->request->get('descripcion');
                $direccion = $request->request->get('direccion');
                $precio = $request->request->get('precio');
                $texto = $request->request->get('texto');
                //
                define('UPLOADPATH', 'images/banner/');
                if (!file_exists(UPLOADPATH . $titulo)) {
                    mkdir(UPLOADPATH . $titulo);}
                $file1 = $_FILES['f1']['name'];
                $target1 = UPLOADPATH . '/'.$titulo. '/' . $file1;
                move_uploaded_file($_FILES['f1']['tmp_name'], $target1);
                //
                $banner = new Banner();
                $banner->setTitulo($titulo);
                $banner->setDescripcion($desc);
                $banner->setDireccion($direccion);
                $banner->setPrecio($precio);
                $banner->setTexto($texto);
                if($file1!=null) {
                    $banner->setImagen($target1);
                }
                //
                $em->persist($banner);
                $em->flush();
            }
            if($request->request->get('titulo_editar'))
            {
                $id = $request->request->get('id');
                $banner = $em->getRepository('AppBundle:Banner')->find($id);
                $titulo = $request->request->get('titulo_editar');
                $desc = $request->request->get('descripcion');
                $direccion = $request->request->get('direccion');
                $precio = $request->request->get('precio');
                $texto = $request->request->get('texto');
                //
                define('UPLOADPATH', 'images/banner/');
                if (!file_exists(UPLOADPATH . $titulo)) {
                    mkdir(UPLOADPATH . $titulo);}
                $file1 = $_FILES['f1']['name'];
                $target1 = UPLOADPATH . '/'.$titulo. '/' . $file1;
                move_uploaded_file($_FILES['f1']['tmp_name'], $target1);
                //
                $banner->setTitulo($titulo);
                $banner->setDescripcion($desc);
                $banner->setDireccion($direccion);
                $banner->setPrecio($precio);
                $banner->setTexto($texto);
                if($file1!=null) {
                    $banner->setImagen($target1);
                }
                //
                $em->persist($banner);
                $em->flush();
            }

            return $this->redirectToRoute('banner_ver');
        }
        return $this->render('backend/banner/ver.html.twig', array('puntos' => $puntos));
    }
    /**
     * @Route("/admin/banner/eliminar/{id}", name="banner_eliminar")
     */
    public function EliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $banner = $em->getRepository('AppBundle:Banner')->find($id);
        $em->remove($banner);
        $em->flush();
        return $this->redirectToRoute('banner_ver');
    }
}