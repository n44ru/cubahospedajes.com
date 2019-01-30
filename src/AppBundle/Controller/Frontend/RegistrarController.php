<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Casa;
use AppBundle\Entity\CasaEtiqueta;
use AppBundle\Entity\Coordenadas;
use AppBundle\Entity\Imagenes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RegistrarController extends Controller
{
    /**
     * @Route("/{_locale}/register/step/1", name="registro")
     * defaults={"_locale"="es"},
     * requirements={"_locale"="(es|en)"}
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dest = $em->getRepository('AppBundle:Subdestinos')->findAll();
        $this->meta_tag_global();
        if ($request->request->count() > 1) {
            //google recaptcha implementation.
            if($request->request->get('g-recaptcha-response'))
            {
                $response = $request->request->get('g-recaptcha-response');
                //your site secret key
                $secret = '6LejqScUAAAAAFbT_1ye4P63jH9x3nWLDN4DPjU5';
                //get verify response data
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$response);
                $responseData = json_decode($verifyResponse);
                if(!$responseData->success){
                    return $this->render('frontend/errors/google.html.twig');
                }
            }
            else{
                return $this->render('frontend/errors/google.html.twig');
            }
            // End.
            $destino = $request->request->get('destino');
            $nombre = $request->request->get('nombre');
            $direccion = $request->request->get('direccion');
            $responsable = $request->request->get('responsable');
            $telefono = $request->request->get('telefono');
            $correo = $request->request->get('correo');
            //$activa = $request->request->get('activa');
            $texto = $request->request->get('texto');
            $precio = $request->request->get('precio');
            $capacidad = $request->request->get('capacidad');
            $cuartos = $request->request->get('cuartos');
            $bath = $request->request->get('bath');
            $reglas = $request->request->get('reglas');
            $precioofertas = $request->request->get('precioofertas');

            // La casa no estara activa.
            $casa = new Casa();
            $casa->setNombre($nombre);
            $casa->setDireccion($direccion);
            $casa->setResponsable($responsable);
            $casa->setTelefono($telefono);
            $casa->setCorreo($correo);
            $casa->setTexto($texto);
            $casa->setPrecio($precio);
            $casa->setCapacidad($capacidad);
            $casa->setCuartos($cuartos);
            $casa->setBath($bath);
            $casa->setPreciooferta($precioofertas);
            $casa->setReglas($reglas);
            $casa->setActiva('No');
            $dest = $em->getRepository('AppBundle:Subdestinos')->find($destino);
            $casa->setSubdestinosid($dest);
            //Keywords de la casa registrada para la busqueda.
            $casa->setKeywords($dest->getNombre() . ' , ' . $dest->getDestinoid()->getNombre());
            // META
            $metatitle = $nombre;
            $metadesc = substr($texto, 20);
            $destinoid = $dest->getDestinoid();
            $metakeyword = $dest->getNombre() . ', ' . $destinoid->getNombre();
            $casa->setMetatitle($metatitle);
            $casa->setMetadesc($metadesc);
            $casa->setMetakeyword($metakeyword);
            // END META
            $em->persist($casa);
            $em->flush();
            // Crear la Alerta
            $alerta = $em->getRepository('AppBundle:Alertas')->find(1);
            $alerta->setCasasinactivas($alerta->getCasasinactivas() + 1);
            $em->persist($alerta);
            $em->flush();
            //
            return $this->redirectToRoute('registro_two', array('id'=>$casa->getId()));
        }
        return $this->render('frontend/registrar/registrar.html.twig', array('destinos' => $dest));
    }

    /**
     * @Route("/{_locale}/{id}/register/step/2", name="registro_two")
     * defaults={"_locale"="es"},
     * requirements={"_locale"="(es|en)"}
     */
    public function twoAction(Request $request, $id)
    {
            $em = $this->getDoctrine()->getManager();
            $casa = $em->getRepository('AppBundle:Casa')->find($id);
            $tags = $em->getRepository('AppBundle:Etiquetas')->findAll();
            if ($request->request->count() > 0) {
                // Capturar todas las etiquetas.
                for ($i = 0; $i < 100; $i++) {
                    $casatags = new CasaEtiqueta();
                    $current_tag = $request->request->get('et' . $i);
                    if ($current_tag) {
                        $casatags->setCasaid($casa);
                        $tag = $em->getRepository('AppBundle:Etiquetas')->find($current_tag);
                        $casatags->setEtiquetasid($tag);
                        $em->persist($casatags);
                        $em->flush();
                    }
                }
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
                        $img->setCasaid($casa);
                        $em->persist($img);
                        $em->flush();
                    }
                } else {
                    $img = new Imagenes();
                    $img->setImagen('images/noimage/no.png');
                    $img->setCasaid($casa);
                    $em->persist($img);
                    $em->flush();
                }
                return $this->redirectToRoute('registro_three', array('id'=> $id));

            }
            $this->meta_tag_global();
            return $this->render('frontend/registrar/registrar_two.html.twig', array('tags' => $tags));
        }

    /**
     * @Route("/{_locale}/{id}/register/step/3", name="registro_three")
     * defaults={"_locale"="es"},
     * requirements={"_locale"="(es|en)"}
     */
    public function threeAction(Request $request, $id)
    {
            $em = $this->getDoctrine()->getManager();
            $casa = $em->getRepository('AppBundle:Casa')->find($id);
            if ($request->request->count() > 0) {
                //Obtener las coordenas del mapa.
                $lat = $request->request->get('Lat');
                $long = $request->request->get('Long');
                // Fetch coordenadas
                $coo = new Coordenadas();
                $coo->setLatitud($lat);
                $coo->setLongitud($long);
                $coo->setCasaid($casa);
                $em->persist($coo);
                $em->flush();
                return $this->redirectToRoute('mensaje');
            }
            $this->meta_tag_global();
            return $this->render('frontend/registrar/registrar_three.html.twig');
    }

    /**
     * @Route("/{_locale}/register/successful", name="mensaje")
     * defaults={"_locale"="es"},
     * requirements={"_locale"="(es|en)"}
     */
    public function mensajeAction()
    {
        $this->meta_tag_global();
        return $this->render('frontend/registrar/mensaje.html.twig');
    }

    public function meta_tag_global()
    {
        $em = $this->getDoctrine()->getManager();
        $config = $em->getRepository('AppBundle:Settings')->find(1);
        $this->get('twig')->addGlobal('global_title', $config->getWebtitulo());
        $this->get('twig')->addGlobal('global_description', $config->getWebdesc());
        $this->get('twig')->addGlobal('global_keywords', $config->getWebkeywords());
    }
}