<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\Settings;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SettingsController extends Controller
{
    /**
     * @Route("/admin/config", name="config_ver")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $config = $em->getRepository('AppBundle:Settings')->find(1);
        if ($request->request->count() > 1) {
            $emailglobal = $request->request->get('global');
            $webtitulo = $request->request->get('webtitle');
            $webdesc = $request->request->get('webdesc');
            $webkeywords = $request->request->get('webkeyword');
            //
            $config->setWebtitulo($webtitulo);
            $config->setWebdesc($webdesc);
            $config->setWebkeywords($webkeywords);
            $config->setEmailglobal($emailglobal);
            //
            $em->persist($config);
            $em->flush();
            //
            return $this->redirectToRoute('config_ver');
        }
        return $this->render('backend/settings/ver.html.twig', array('config' => $config));
    }

}