<?php
/**
 * Created by PhpStorm.
 * User: carlosmanuel
 * Date: 6/23/17
 * Time: 7:02 p.m.
 */

namespace AppBundle\Controller\Backend;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Response;

class SitemapGenerateController extends Controller
{
    /**
     * @Route("/admin/generate_sitemap", name="generate_sitemap")
     */
    public function generateAction()
    {
        $em = $this->getDoctrine()->getManager();
        $kernel = $this->get('kernel');
        $application = new Application($kernel);
        $application->setAutoExit(false);
        $input = new ArrayInput(array(
            'command' => 'presta:sitemaps:dump'));
        $output = new BufferedOutput();
        $application->run($input, $output);
        // return the output, don't use if you used NullOutput()
        $content = $output->fetch();
        return $this->render('backend/sitemap/response.html.twig', array('contenido' => $content));
    }
}