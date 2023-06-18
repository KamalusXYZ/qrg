<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<Question>
 *
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    public function save(Question $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Question $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return Question[] Returns an array of Question objects
    */
   public function findToValidQuestion(): array
   {
       return $this->createQueryBuilder('q')
           ->where('q.valid = :val')
           ->setParameter('val', false)
           ->andWhere('q.checked = :val2')
           ->setParameter('val2', false)
           ->orderBy('q.id', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }

         /**
    * @return Question[] Returns an array of Question objects
    */
    public function findMyQuestions($user): array
    {
               
        return $this->createQueryBuilder('q')
        ->where(':val MEMBER OF q.users')
        ->setParameter('val', $user)
        ->orderBy('q.checked', 'ASC')
        ->getQuery()
        ->getResult();
    }

      /**
    * @return Question[] Returns an array of Question objects
    */
    public function findMyQuestionsPending($user): array
    {
               
        return $this->createQueryBuilder('q')
        ->andWhere(':val MEMBER OF q.users')
        ->setParameter('val', $user)
        ->andWhere('q.checked = :val2')
        ->setParameter('val2', false)
        ->orderBy('q.id', 'DESC')
        ->getQuery()
        ->getResult();
    }

          /**
    * @return Question[] Returns an array of Question objects
    */
    public function findMyQuestionsValid($user): array
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.user = :val')
            ->setParameter('val', $user)
            ->andWhere('q.valid = :val2')
            ->setParameter('val2', true)
            ->orderBy('q.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

              /**
    * @return Question[] Returns an array of Question objects
    */
    public function findMyQuestionsDenied($user): array
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.user = :val')
            ->setParameter('val', $user)
            ->andWhere('q.denied = :val3')
            ->setParameter('val3', true)
            ->orderBy('q.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

                  /**
    * @return Question[] Returns an array of Question objects
    */
    public function findRandomQuestion(INT $nb,INT $idUser): array
    {
        $resultRaw = 
         $this->createQueryBuilder('q')
        ->join('q.users', 'u')
        ->where('q.valid = :val2')
        ->setParameter('val2', true)
        ->andWhere('u.id != :id')
        ->setParameter('id', $idUser)
        ->getQuery()
        ->getResult();

        $result = [];
        if(count($resultRaw) >= $nb){
            $randKey = array_rand($resultRaw, $nb);

            foreach($randKey as $key){
                array_push($result, $resultRaw[$key]);
            }
            shuffle($result);
        }

    return $result;
    }

//    public function findOneBySomeField($value): ?Question
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
