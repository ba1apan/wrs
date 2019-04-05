<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Enum\UserEnum;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Validator\Constraints\ContainsLeaderInTeam;

class MemberType extends AbstractType
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $manager)
    {
        $this->entityManager = $manager;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $members = $this->entityManager
        ->getRepository(User::class)
        ->findBy([
            'status' => UserEnum::APPROVED,
        ]);
        
        $builder
        ->add('member_id', ChoiceType::class, [
            'choices' => $members,
            'choice_label' => function($members) {
                return $members->getEmail();
            },
            'choice_value' => 'id',
        ])
        ->add('is_leader', CheckboxType::class, [
            'value' => 'Is leader?',
            'required' => false,
            'constraints' => [
                new ContainsLeaderInTeam([
                    'team' => $options['team'],
                    'is_checked' => $options['is_checked'],
                ])
            ],
        ])
        ->add('save', SubmitType::class);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'team' => null,
            'is_checked' => false,
        ]);
    }
}