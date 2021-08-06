<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\ORM\Tools\Pagination\Paginator;

use App\Entity\Genres;
use App\Entity\Books;

class BooksController extends AbstractController
{
    #[Route('/books', name: '/books')]
    public function index(Request $request): Response
    {
        $gid=$request->get('gid');
        $em = $this->getDoctrine()->getManager();
        $query=$em->createQueryBuilder();
        if(is_null($gid)||!is_numeric($gid)){
            $query->select('b')
                ->from(Books::class,'b')
                ->leftJoin(Genres::class,'g','WITH','b.fGenre=g.id');
            $books=$query->getQuery();
        } else {
            $genre=$this->getDoctrine()
                ->getRepository(Genres::class)
                ->findOneBy(['id'   => $gid ]);
            $query->select('b')
                ->from(Books::class,'b')
                ->leftJoin(Genres::class,'g','WITH','b.fGenre=g.id')
                ->where('b.fGenre=:gid')
                ->setParameter('gid', $gid);
            $books=$query->getQuery();
        }
        $items = $this->getDoctrine()
            ->getRepository(Books::class)
            ->findAll();
        $cnt=count($items);
        $qb = $em->createQueryBuilder();
        $qb->select('g.id', 'g.name','count(b.id) as cnt')
            ->from(Genres::class,'g')
            ->leftJoin(Books::class, 'b','WITH','b.fGenre=g.id')
            ->groupBy('g.id','g.name');
        $query1 = $qb->getQuery();
        //print_r($query);
        return $this->render('books/index.html.twig', [
            'title' => 'Книги',
            'books' => $books->getResult(),
            'query' => $query1->getResult(),
            'cnt'   => $cnt,
        ]);
    }
    #[Route('/books/add-book', name: 'add-books')]
    public function add(Request $request): Response 
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('App\Form\BookFormType');
        $form->handleRequest($request);
        $data=$form->getData();
        if(isset($data)){
            if($data['cdate']->format('d.m.Y')<=date('d.m.Y')){
                $d=$data['cdate'];
                $genres=$this->getDoctrine()
                    ->getRepository(Genres::class)
                    ->findOneBy(['id'=> $data['fgenre']]);
                $book=new Books();
                $book->setAuthor($data['author']);
                $book->setDate($d);
                $book->setName($data['name']);
                $book->setFGenres($genres);
                $em->persist($book);
                $em->flush();
                $this->addFlash(
                    'notice',
                    'Книга добавлена.'
                );
                return $this->redirectToRoute('books');
            }
        } else {
            $this->addFlash(
                'notice',
                'Дата издания не должна быть больше текущей'
            );
        }
        return $this->render('books/add-book.html.twig',[
            'title' => 'Новая книга',
            'form'  => $form->createView(),
        ]);
    }
    #[Route('/books/edit-book', name:'edit-books')]
    public function edit(Request $request): Response 
    {
        $id=$request->get('id');
        $em=$this->getDoctrine()->getManager();
        $book=$this->getDoctrine()
            ->getRepository(Books::class)
            ->findOneBy(['id'   => $id]);
        $form = $this->createForm('App\Form\BookFormType');//
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $data=$form->getData();
            print($data['cdate']->format('d.m.Y'));
            if(isset($data)){
                if($data['cdate']->format('d.m.Y')<=date('d.m.Y')){
                    $d=$data['cdate'];
                    $genres=$this->getDoctrine()
                        ->getRepository(Genres::class)
                        ->findOneBy(['id'=> $data['fgenre']]);
                    $b=new Books();
                    $b->setAuthor($data['author']);
                    $b->setDate($d);
                    $b->setName($data['name']);
                    $b->setFGenres($genres);
                    $em->persist($b);
                    $em->flush();
                    return $this->redirectToRoute('books');
                } else {
                    $this->addFlash(
                        'notice',
                        'Дата издания не должна быть больше текущей'
                    );
                }
            }
        }else{
            //Заполняем форму
            $form->get('author')->setData($book->getAuthor());
            $form->get('name')->setData($book->getName());
            if($book->getDate()){
                $form->get('cdate')->setData($book->getDate());
            }
            $form->get('fgenre')->setData($book->getFGenres());
        }
        return $this->render('books/edit-book.html.twig', [
            'title' => 'Редактирование Книги',
            'form'  => $form->createView(),
        ]);
    }
    #[Route('/books/del-book',name:'del-books')]
    public function del(Request $request): Response 
    {
        $id=$request->get('id');
        $em=$this->getDoctrine()->getManager();
        $book=$this->getDoctrine()
            ->getRepository(Books::class)
            ->findOneBy(['id'   => $id]);
        if($book){
            $em->remove($book);
            $em->flush();
        }
        $books=$this->getDoctrine()
            ->getRepository(Books::class)
            ->findAll();        
        return $this->render('books/index.html.twig', [
            'title' => 'Книги',
            'books' => $books,
        ]);
    }
}
