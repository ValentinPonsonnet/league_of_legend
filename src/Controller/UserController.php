<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }

    /**
     * @Route("/users", name="app_user")
     */
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('user/allAuthor.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/users/{user}", name="app_id")
     */
    public function edit(User $user, Request $request, UserPasswordEncoderInterface $encoder)
    {
        $form =$this->createForm(UserType::class, $user);

        $form->handleRequest(($request));

        if($form->isSubmitted() && $form->isValid())
        {
            if($user->getPlainPassword())
            {
                $pwd = $encoder->encodePassword($user, $user->getPlainPassword());
                    $user->setPassword($pwd);
            }
            $this->em->persist($user);
            $this->em->flush();
        }

        return $this->render('user/edit.html.twig', [
            'form' =>$form->createView(),
        ]);

    }
}
