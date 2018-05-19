<?php
namespace AppBundle\Repository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;


class UserRepository extends \Doctrine\ORM\EntityRepository implements UserLoaderInterface{

    public function loadUserByUsername($email){
        return $this->createQueryBuilder('u')
        ->where('email=:email')->setParameter('email',$email)
        ->getQuery()->getOneOrNullResult();
    }
}