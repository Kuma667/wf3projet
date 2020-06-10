<?php

namespace App\Form;

use App\Entity\Annonces;
use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\CategoriesRepository;


class AnnoncesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('prix')
            ->add('ville')
            ->add('categorie', EntityType::class, [
				'class' => Categories::class,
				'choice_label' => 'nom',
				'query_builder' => function (CategoriesRepository $er) {
					return $er->createQueryBuilder('c')
            ->orderBy('c.nom', 'ASC');
    },
			])
            ->add('images', FileType::class,[
				'required' => false,
				'label' => false,
                'mapped' => false,
                'multiple' => true 
			])
            ->add('premium', CheckboxType::class, [
				'label' => 'Passer le produit en premium (5 photos, produit mis en avant)',
				'required' => false
			])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonces::class,
        ]);
    }
}
