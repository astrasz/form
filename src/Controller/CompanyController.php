<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Company;
use App\Entity\User;
use App\Form\CompanyType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 * @Route("/company")
 */
class CompanyController extends AbstractController
{
    /**
     * @Route("/",name="company_index",methods={"GET"})
     */
    public function index(SerializerInterface $serializer): Response
    {
        $companies = $this->getDoctrine()->getRepository(Company::class)->findAllCreatedByUsers();

        $json = $serializer->serialize(
            $companies, 
            'json', 
            ['groups'=>['company', 'user']]
        );
        
        //json response for REST API
        $response = new Response($json);
        $response->headers->set('Content-Type', 'application/json');

        return $response;


        //----------------------------------------------
        //$companies = $this->getDoctrine()->getRepository(Company::class)->findAll();
        // render in twig for testing
        // return $this->render('company/index.html.twig', [
        //     'companies' => $companies,
        // ]);
        //----------------------------------------------
    }


    /**
     * @Route("/new",name="company_new",methods={"GET", "POST"})
     */

    public function new(Request $request, EntityManagerInterface $em): Response
    {
        

        $user = new User();
        $company = new Company;
        $user->addCompany($company);



        $form=$this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {

            $user = $form->getData();
            
            //check user in database
            $savedUser = $em->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);

            //check companies in database and remove if any
            $companies = $user->getCompanies();

            $savedCompany=null;
            foreach($companies as $row)
            {
                $savedCompany = $em->getRepository(Company::class)->findOneBy(['nip' => $row->getNip()]);
                $savedCompany && $user->removeCompany($row);
                $this->addFlash(
                    'notice-already-saved',
                    'Firma o numerze NIP '. $row->getNip() . ' już istnieje w bazie'
                );
            }
            
            if($savedUser)
            {
                $userCompanies = $user->getCompanies();

                foreach($userCompanies as $userCompany)
                {
                    $user->removeCompany($userCompany);
                    $savedUser->addCompany($userCompany);
                }                
                $em->persist($savedUser);
            } else
            {
                $em->persist($user);
            }

            $em->flush();

            if(!$savedCompany){
                
            return $this->redirectToRoute('company_new');
            }
        }


        return $this->render('company/new.html.twig', [
            'form'=>$form->createView(),
        ]
        );
    }
}
