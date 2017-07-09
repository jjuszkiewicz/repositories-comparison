<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class CompareRepositoriesType  extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('repositoryName', TextType::class,
            ['constraints' => [
                new NotBlank(),
                new Regex('/^[a-zA-Z0-9\-]+\/[a-zA-Z0-9\-]+$/'),
                new Length(['min' =>3]),
            ]])
            ->add('repositoryNameSecond', TextType::class,
            ['constraints' => [
                new NotBlank(),
                new Regex('/^[a-zA-Z0-9\-]+\/[a-zA-Z0-9\-]+$/'),
                new Length(['min' =>3]),
            ]]);
    }
}
