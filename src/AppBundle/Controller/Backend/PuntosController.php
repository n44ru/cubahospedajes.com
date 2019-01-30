<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\Puntos;
use AppBundle\Entity\Imagenes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PuntosController extends Controller
{
    /**
     * @Route("/admin/puntos", name="puntos_ver")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $puntos = $em->getRepository('AppBundle:Puntos')->findAll();
        $destinos = $em->getRepository('AppBundle:Destinos')->findAll();
        $subdestinos = $em->getRepository('AppBundle:Subdestinos')->findAll();
        // Obtener todas las imagenes de puntos.
        $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.puntosid >= 1 ');
        $imagenes = $query->getResult();
        if ($request->request->count() > 1) {
            if($request->request->get('nombre'))
            {
                //Controlando las relaciones
                if($request->request->get('subdestino'))
                {
                    $sub_id = $request->request->get('subdestino');
                    $s = $em->getRepository('AppBundle:Subdestinos')->find($sub_id);
                }
                $nombre = $request->request->get('nombre');
                $direccion = $request->request->get('direccion');
                $texto = $request->request->get('texto');
                $portada = $request->request->get('portada');
                $metatitle = $request->request->get('metatitle');
                $metadesc = $request->request->get('metadesc');
                $metakeyword = $request->request->get('metakeyword');
                // Recoger el tag de las imagenes.
                $tags = $request->request->get('tags');
                //Si las meta estan vacias autogenerarlas.
                if($metatitle==null)
                {
                    $metatitle=$nombre;
                }
                if($metadesc==null)
                {
                    $metadesc=$nombre;
                }
                if($metakeyword==null)
                {
                    // Ver que keywords incluir aqui.
                    $destino=$s->getDestinoid();
                    $metakeyword=$s->getNombre().','.$destino->getNombre();
                }
                //
                $puntos = new Puntos();
                $puntos->setNombre($nombre);
                $puntos->setDireccion($direccion);
                $puntos->setTexto($texto);
                $puntos->setMetatitle($metatitle);
                $puntos->setMetadesc($metadesc);
                $puntos->setMetakeyword($metakeyword);
                $puntos->setPortada($portada);
                // Insertando relaciones
                if($request->request->get('subdestino'))
                {
                    $puntos->setSubdestinosid($s);
                }
                else{$puntos->setSubdestinosid(null);}
                //
                $em->persist($puntos);
                $em->flush();
                // Controlar las imagenes subidas
                // nombre del punto.
                $nombre= $puntos->getNombre();
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
                        $img->setPuntosid($puntos);
                        $em->persist($img);
                        $em->flush();
                    }
                }
                else{
                    $img = new Imagenes();
                    $img->setImagen('images/noimage/no.png');
                    $img->setTags($tags);
                    $img->setPuntosid($puntos);
                    $em->persist($img);
                    $em->flush();
                }
            }
            if($request->request->get('nombre_editar'))
            {
                //Controlando las relaciones
                if($request->request->get('subdestino'))
                {
                    $sub_id = $request->request->get('subdestino');
                    $s = $em->getRepository('AppBundle:Subdestinos')->find($sub_id);
                }
                $id = $request->request->get('id');
                $puntos = $em->getRepository('AppBundle:Puntos')->find($id);
                //
                $nombre = $request->request->get('nombre_editar');
                $direccion = $request->request->get('direccion');
                $texto = $request->request->get('texto');
                $portada = $request->request->get('portada');
                $metatitle = $request->request->get('metatitle');
                $metadesc = $request->request->get('metadesc');
                $metakeyword = $request->request->get('metakeyword');
                // Recoger el tag de las imagenes.
                $tags = $request->request->get('tags');
                //Si las meta estan vacias autogenerarlas.
                if($metatitle==null)
                {
                    $metatitle=$nombre;
                }
                if($metadesc==null)
                {
                    $metadesc=$texto;
                }
                if($metakeyword==null)
                {
                    // Ver que keywords incluir aqui.
                    $destino=$s->getDestinoid();
                    $metakeyword=$s->getNombre().','.$destino->getNombre();
                }
                //
                $puntos->setNombre($nombre);
                $puntos->setDireccion($direccion);
                $puntos->setTexto($texto);
                $puntos->setPortada($portada);
                $puntos->setMetatitle($metatitle);
                $puntos->setMetadesc($metadesc);
                $puntos->setMetakeyword($metakeyword);
                // Insertando relaciones
                if($request->request->get('subdestino'))
                {
                    $puntos->setSubdestinosid($s);
                }
                else{$puntos->setSubdestinosid(null);}
                //
                $em->persist($puntos);
                $em->flush();
                //
                $nombre= $puntos->getNombre();
                define('UPLOADPATH', 'images/uploads/');
                if (!file_exists(UPLOADPATH . $nombre)) {
                    mkdir(UPLOADPATH . $nombre);
                }
                $query = $em->createQuery('SELECT p FROM AppBundle:Imagenes p WHERE p.puntosid = ?1 ');
                $query->setParameter(1, $id);
                $img_temp = $query->getResult();
                // Recoger todas las imagenes del post.
                if (strlen($_FILES['myfiles']['name'][0]) > 0) {
                    //Si es una image none borrarla.
                    if($img_temp[0]->getImagen() == 'images/noimage/no.png')
                    {
                        $delete = $em->getRepository('AppBundle:Imagenes')->find($img_temp[0]->getId());
                        $em->remove($delete);
                        $em->flush();
                    }
                    for ($i = 0; $i < count($_FILES['myfiles']['name']); $i++) {
                        $img = new Imagenes();
                        move_uploaded_file($_FILES['myfiles']['tmp_name'][$i], UPLOADPATH . $nombre . '/' . $_FILES['myfiles']['name'][$i]);
                        //Insertando una nueva Imagen.
                        $img->setImagen(UPLOADPATH . $nombre . '/' . $_FILES['myfiles']['name'][$i]);
                        $img->setTags($tags);
                        $img->setPuntosid($puntos);
                        $em->persist($img);
                        $em->flush();
                    }
                }
                elseif (count($img_temp)==0)
                {
                    $img = new Imagenes();
                    $img->setImagen('images/noimage/no.png');
                    $img->setTags($tags);
                    $img->setPuntosid($puntos);
                    $em->persist($img);
                    $em->flush();
                }
            }
            return $this->redirectToRoute('puntos_ver');
        }
        return $this->render('backend/puntos/ver.html.twig', array('puntos' => $puntos, 'imagenes'=>$imagenes, 'destinos'=>$destinos, 'subdestinos'=>$subdestinos));
    }
    /**
     * @Route("/admin/puntos/eliminar/{id}", name="puntos_eliminar")
     */
    public function EliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $puntos = $em->getRepository('AppBundle:Puntos')->find($id);
        $em->remove($puntos);
        $em->flush();
        return $this->redirectToRoute('puntos_ver');
    }
}