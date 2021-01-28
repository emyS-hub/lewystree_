<?php

namespace App\Form;

use App\Entity\Link;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('icon', TextType::class, [
                "label" => "Icône du lien",
                "attr" => [
                    "placeholder" => "Icône"
                ]
            ])
            ->add('title', TextType::class, [
                "label" => "Description du lien",
                "attr" => [
                    "placeholder" => "Description"
                ]
            ])
            ->add('url', TextType::class, [
                "label" => "Url du lien",
                "attr" => [
                    "placeholder" => "Url"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Link::class,
        ]);
    }
}
