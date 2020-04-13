<?php

namespace App\Form;

use App\Entity\Actor;
use App\Entity\Program;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('summary')
            ->add('category', null, ['choice_label' => 'name'])
            ->add('actors', EntityType::class, [
                'class' => Actor::class,
                'expanded' => true,
                'multiple' => true,
                'choice_label' => 'name',
                'by_reference' => false,
            ])
            ->add('posterFile', VichFileType::class, [
                'label' => 'Affiche',
                'required'      => false,
                'allow_delete'  => false,
                'download_uri' => false,
            ])
            ->add('poster', null, ['label' =>'file name'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Program::class,
        ]);
    }
}
