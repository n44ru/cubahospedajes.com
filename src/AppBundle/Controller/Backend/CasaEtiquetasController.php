<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\CasaEtiqueta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CasaEtiquetasController extends Controller
{
    /**
     * @Route("/admin/casas/{id}/etiquetas", name="ce_ver")
     */
    public function indexAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $casa_object = $em->getRepository('AppBundle:Casa')->find($id);
        $etiquetas = $em->getRepository('AppBundle:Etiquetas')->findAll();
        if ($request->request->count() >= 1) {
            $query = $em->createQuery('DELETE FROM AppBundle:CasaEtiqueta p WHERE p.id>0');
            $query->getResult();
            //
            $x = 0;
            for ($i = 1; $i <= $request->request->count(); $i++) {
                while ($request->request->get('et' . $x) == null) {
                    $x++;
                }
                $id_etiqueta = $request->request->get('et' . $x);
                //
                $etiqueta_object = $em->getRepository('AppBundle:Etiquetas')->find($id_etiqueta);
                $e = new CasaEtiqueta();
                //
                $e->setCasaid($casa_object);
                $e->setEtiquetasid($etiqueta_object);
                //
                $em->persist($e);
                $em->flush();
                $x++;
            }
        }
        $casa_object = $em->getRepository('AppBundle:Casa')->find($id);
        $query = $em->createQuery('SELECT p FROM AppBundle:CasaEtiqueta p WHERE p.casaid = ?1 ');
        $query->setParameter(1, $id);
        $casa_etiquetas = $query->getResult();
        return $this->render('backend/casas/etiquetas/ver.html.twig', array('etiquetas' => $etiquetas, 'ce' => $casa_etiquetas, 'casa' => $casa_object));
    }
    /**
     * @Route("/admin/casas/{casaid}/etiquetas/eliminar/{id}", name="ce_eliminar")
     */
    public
    function EliminarAction($id, $casaid)
    {
        $em = $this->getDoctrine()->getManager();
        $linea = $em->getRepository('AppBundle:CasaEtiqueta')->find($id);
        $em->remove($linea);
        $em->flush();
        return $this->redirectToRoute('ce_ver', array('id' => $casaid));
    }
}