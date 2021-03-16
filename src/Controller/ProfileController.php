<?php

namespace App\Controller;

use App\Form\EditProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'profile')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig');
//        , [
//            'controller_name' => 'ProfileController',
//        ]);
    }

    /**
     * @Route ("/profile/edit", name="profile.edit")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editProfile(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('message','Profile Updated');
            return $this->redirectToRoute('profile');
        }

        return $this->render('profile/edit.html.twig', [
           'form' => $form->createView(),
        ]);
    }

    /**
     * @Route ("/profile/pass", name="profile.change.password")
     */
    public function changePass(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        if($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $old_pwd = $request->get('password-current');
            $new_pwd = $request->get('password-new');
            $new_pwd_confirm = $request->get('password-confirm');
//            $checkPass = true;
            $checkPass = $passwordEncoder->isPasswordValid($user, $old_pwd);

            if($new_pwd == $new_pwd_confirm){
                if($checkPass === true){
                    $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password-new')));
                    $em->flush();
                    $this->addFlash('message', "Password Changed Successfully" );
                    $this->getDoctrine()->getManager()->refresh($user);
                    return $this->redirectToRoute('profile');
                } else {
                    $this->addFlash('error', "Current password incorrect" );
                }
            } else {
                if($checkPass === true){
                    $this->addFlash('error', "new & confirm password don't match" );
                } else {
                    $this->addFlash('error', "Current password incorrect" );
                    $this->addFlash('error', "new & confirm password don't match" );
                }
            }

        }


        return $this->render('profile/password.html.twig');
    }
}
