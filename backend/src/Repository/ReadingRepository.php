<?php

namespace App\Repository;

use App\Entity\Reading;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reading>
 */
class ReadingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reading::class);
    }

    public function countReadBooksAfterDate($user, \DateTime $startDate, ?string $genre = null, ?string $author = null): int
{
    $conn = $this->getEntityManager()->getConnection();
    $sql = 'SELECT COUNT(*) FROM reading WHERE user_id = :user AND reading_status = :status AND reading_end >= :startDate';
    $result = $conn->executeQuery($sql, ['user' => $user->getId(), 'startDate' => $startDate->format('Y-m-d'), 'status' => 'lu']);

    
    return (int) $result->fetchOne();
}

     public function countReadBooksByGenreAfterDate($user, $startDate, $genre)
{
    $conn = $this->getEntityManager()->getConnection();
    $sql = 'SELECT COUNT(*) 
            FROM reading r
            JOIN book b ON r.book_id = b.id
            JOIN book_genre bg ON b.id = bg.book_id
            JOIN genre g ON bg.genre_id = g.id
            WHERE r.user_id = :user 
            AND r.reading_status = :status
            AND r.reading_end >= :startDate
            AND g.genre_name LIKE :genre';
    $result = $conn->executeQuery($sql, [
        'user' => $user->getId(),
        'startDate' => $startDate->format('Y-m-d'), 
        'genre' => $genre, 
        'status' => 'lu']);
    return (int) $result->fetchOne();
}

     public function countReadBooksByAutorAfterDate($user, $startDate, $autor)
{
    $conn = $this->getEntityManager()->getConnection();
    $sql = 'SELECT COUNT(*) 
            FROM reading r
            JOIN book b ON r.book_id = b.id
            JOIN book_autor ba ON b.id = ba.book_id
            JOIN autor a ON ba.autor_id = a.id
            WHERE r.user_id = :user 
            AND r.reading_status = :status
            AND r.reading_end >= :startDate
            AND a.autor_name = :autor';
    $result = $conn->executeQuery($sql, ['user' => $user->getId(), 'startDate' => $startDate->format('Y-m-d'), 'autor' => $autor, 'status' => 'lu']);
    return (int) $result->fetchOne();
}

    public function findByUserWithBooks($user): array
{
    return $this->createQueryBuilder('r')
        ->select('r', 'b', 'g')
        ->join('r.book', 'b')
        ->leftJoin('b.genres', 'g')
        ->where('r.user = :user')
        ->setParameter('user', $user)
        ->getQuery()
        ->getResult();
}

    //    /**
    //     * @return Reading[] Returns an array of Reading objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Reading
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
