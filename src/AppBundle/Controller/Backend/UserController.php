<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;



class UserController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'frontend/login/login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error' => $error,
            )
        );
    }
    /**
     * @Route("/logout", name="user_logout")
     */
    public function logoutAction(Request $request)
    {
    }

    /**
     * @Route("/admin/users", name="admin_users")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAll();
        if($request->request->count() > 1)
        {
            if($request->request->get('id'))
            {
                $id = $request->request->get('id');
                $user = $em->getRepository('AppBundle:User')->find($id);
                $name= $request->request->get('nombre');
                $p1 = $request->request->get('p1');
                $p2 = $request->request->get('p2');
                $rol = $request->request->get('roles');
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                if ($p1 != null) {
//                $password = $encoder->encodePassword($p1, $user->getSalt());
                    //
                    if($p1 != $p2)
                    {
                        return $this->redirectToRoute('admin_user_error');
                    }
                    else{
                        $new_password = $encoder->encodePassword($p2, $user->getSalt());
                        $user->setPassword($new_password);
                        $user->setUsername($name);
                        $user->setRole($rol);
                        //
                        $em->persist($user);
                        $em->flush();
                        return $this->redirectToRoute('admin_users');
                    }
                }
            }
            else{
                $name= $request->request->get('nombre');
                $p1 = $request->request->get('p1');
                $p2 = $request->request->get('p2');
                $rol = $request->request->get('roles');
                $factory = $this->get('security.encoder_factory');
                $user = new User();
                $encoder = $factory->getEncoder($user);
                if ($p1 != null) {
//                $password = $encoder->encodePassword($p1, $user->getSalt());
                    //
                    if($p1 != $p2)
                    {
                        return $this->redirectToRoute('admin_user_error');
                    }
                    else{
                        $new_password = $encoder->encodePassword($p2, $user->getSalt());
                        $user->setPassword($new_password);
                        $user->setUsername($name);
                        $user->setRole($rol);
                        //
                        $em->persist($user);
                        $em->flush();
                        return $this->redirectToRoute('admin_users');
                    }
                }
            }

        }
        return $this->render('backend/usuarios/ver.html.twig', array('user' => $users));
    }
    /**
     * @Route("/admin/user/error", name="admin_user_error")
     */
    public function errorAction(Request $request)
    {
        return $this->render('backend/usuarios/error.html.twig');
    }
    /**
     * @Route("/admin/user/delete/{id}", name="usuario_eliminar")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('admin_users');
    }
}