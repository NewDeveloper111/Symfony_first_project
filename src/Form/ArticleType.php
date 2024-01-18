<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Subcategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
	$builder
            ->add('title', null, ['label' => 'Название'])
            ->add('summary', null, ['label' => 'Краткое содержание'])
            ->add('content', null, ['label' => 'Содержание'])
            ->add('category', null, ['label' => 'Категория',])
            ->add('subcategory', EntityType::class, ['label' => 'Подкатегория',
		'class' => Subcategory::class,
		'group_by' => fn($subcategory) => $subcategory->getCategory() ?? 'Без категории'])
		//'group_by' => 'category'])
            ->add('users', null, ['label' => 'Авторы'])
            ->add('publicationDate', DateType::class, ['label' => 'Дата публикации',
		'widget' => 'single_text'])
            ->add('active', null, ['label' => 'Статья активна'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
