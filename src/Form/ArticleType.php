<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference', TextType::class,  ['disabled' => $options['is_edit']])
            ->add('libelle')
            ->add('prix')
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'designation'
                // 'multiple' => false,
                // 'expanded' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'is_edit' => false
        ]);
    }
}
