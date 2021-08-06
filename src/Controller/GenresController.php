<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Genres;

class GenresController extends AbstractController
{
    #[Route('/genres', name: 'genres')]
    public function index(): Response
    {
        $genres=$this->getDoctrine()
            ->getRepository(Genres::class)
            ->findAll();
        return $this->render('genres/index.html.twig', [
            'title' => 'Жанры',
            'genres'    => $genres,
        ]);
    }
    #[Route('/genres/add-genre',name:'add-genre')]
    public function add(Request $request): Response
    {
        $form = $this->createForm('App\Form\GenreFormType');
	$form->handleRequest($request);
        return $this->render('genres/add-genre.html.twig',[
            'title'=>'Новый жанр',
            'form'  => $form->createView(),
        ]);
    }
    #[Route('/genres/edit-genre',name:'edit-genre')]
    public function edit(Request $request):Response
    {
        $id = $request->get('id');
        $name = $request->get('name');
        $form = $this->createForm('App\Form\GenreFormType');
	$form->handleRequest($request);
        return $this->render('genres/edit-genre.html.twig',[
            'title'=>'Изменить жанр',
            'form'  => $form->createView(),
            'name'  => $name,
            'id'    => $id,
        ]);
    }
    #[Route('/genres/editGenre',name:'edit-genres-ajax')]
    public function editGenre(Request $request): Response
    {
        $form_id = $request->get('id');
        $form_name = $request->get('name');
        $msg='';
        $em = $this->getDoctrine()->getManager();
        $genre=$this->getDoctrine()
            ->getRepository(Genres::class)
            ->findOneBy(['id'   => $form_id]);
        if($genre){
            $genre->setName($form_name);
            $em->persist($genre);
            $em->flush();
            $msg='Жанр изменен';
        } else {
            $msg='Жанр не найден';
        }
        return new JsonResponse($msg);
    }
    #[Route('/genres/addGenre',name:'add-genres-ajax')]
    public function addGenre(Request $request): Response
    {
        $form_data = $request->get('name');
        $genre=$this->getDoctrine()
            ->getRepository(Genres::class)
            ->findOneBy(['name'=>$form_data]);
        $msg='';
        if(!$genre){
            $em = $this->getDoctrine()->getManager();
            $genres=new Genres();
            $genres->setName($form_data);
            $em->persist($genres);
            $em->flush();
            $msg='Жанр добавлен';
        }else{
            $msg='Данный жанр уже есть';
        }
        return new JsonResponse($msg);
    }
    #[Route('/genres/deleteGenre',name:'delete-genres')]
    public function delete(Request $request) :Response
    {
        $id=$request->get('id');
        $em=$this->getDoctrine()->getManager();
        $genre=$this->getDoctrine()
            ->getRepository(Genres::class)
            ->findOneBy(['id'   => $id]);
        if($genre){
            $em->remove($genre);
            $em->flush();
        }
        $genres=$this->getDoctrine()
            ->getRepository(Genres::class)
            ->findAll();
        return $this->render('genres/index.html.twig', [
            'title' => 'Жанры',
            'genres'    => $genres,
        ]);
    }
}
