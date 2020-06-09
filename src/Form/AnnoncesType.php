<?php

namespace App\Form;

use App\Entity\Annonces;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class AnnoncesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('prix')
            ->add('ville')
            ->add('categorie', ChoiceType::class, [
				'choices' => [
					'Immobilier' => 0,
					'Véhicules' => 1,
					'Loisirs' => 2,
					'Mode' => 3,
					'Multimédia' => 4,
					'Mobilier' => 5,		
				],
			])
            ->add('photo', FileType::class,[
				'required' => true,
				'label' => 'Photo',
				'mapped' => false
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
