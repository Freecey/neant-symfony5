<?php

namespace App\Controller\Profile;

use App\Form\EditProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\Session\Session;

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

    #[Route('/profile/mydata', name: 'profile.mydata')]
    public function mydata(): Response
    {
        return $this->render('profile/mydata.html.twig');
//        , [
//            'controller_name' => 'ProfileController',
//        ]);
    }

    #[Route('/profile/mydata/pdf', name: 'profile.mydata.pdf')]
    public function mydataPDF(): Response
    {
//        return $this->render('profile/mydatadl.html.twig');
        // dd($specifications);
        // instantiate and use the dompdf class

        $html = $this->renderView('profile/mydatadl.html.twig');

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        // dd($dompdf);
//        dd(date('Y-m-d_His'));
//        die();
        // Output the generated PDF to Browser
        $dompdf->stream("neant-be_myData__".date('Y-m-d_His').".pdf", [
            "Attachment" => true
        ]);
    }

    /**
     * @Route ("/profile/delete", name="profile.delete")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function deleteProfile(Request $request)
    {
        $user = $this->getUser();
//        $form = $this->createForm(EditProfileType::class, $user);
//
//        $form->handleRequest($request);


            if($this->isCsrfTokenValid('delete' . $this->getUser()->getId(), $request->get('_token') ))
            {
                if($request->get('confirmation') == 'confirm') {
                    $em = $this->getDoctrine()->getManager();
                    if( count($user->getArticles()) > 0 ) {
                        foreach ($user->getArticles() as $article) {
                            $em->remove($article);
                            $em->flush();
                        }
                        $this->addFlash('message','All Articles Deleted Successfully');
                    };
                    if( count($user->getComments()) > 0 ) {
                        foreach ($user->getComments() as $comment) {
                            $em->remove($comment);
                            $em->flush();
                        }
                        $this->addFlash('message','All Comments Deleted Successfully');
                    };

                    $em->remove($user);
                    $em->flush();
                    $session = new Session();
                    $session->invalidate();
                    $this->addFlash('message','Account Deleted Successfully');
                    return $this->redirectToRoute('home');
                }else {
                    $this->addFlash('error','type "confirm" to confirm your action');
                }
            }

        return $this->render('profile/delete.html.twig');
    }
}
