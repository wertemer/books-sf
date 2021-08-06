<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\DateTime;
use App\Entity\Genres;

class BookFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author', TextType::class,array(
                'label' => 'Автор',
            ))
            ->add('name',TextType::class,array(
                'label' => 'Название',
            ))
            ->add('cdate',DateType::class,array(
                'label' => 'Год выпуска',
                'widget' => 'single_text',
            ))
            ->add('fgenre',EntityType::class,array(
		'label' => 'Жанр',
		'class' => Genres::class,
		'choice_label' => 'name'
            ))
            ->add('save', SubmitType::class,array('label'=>'Cохранить'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
