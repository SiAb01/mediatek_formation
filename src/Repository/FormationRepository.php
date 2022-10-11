<?php

namespace App\Repository;

use App\Entity\Formation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Formation>
 *
 * @method Formation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Formation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Formation[]    findAll()
 * @method Formation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Formation::class);
    }

    public function add(Formation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Formation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>FormationRepository.php</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<style type="text/css">
<!--
body {color: #000000; background-color: #ffffff; font-family: monospace}
pre {color: #000000; background-color: #ffffff; font-family: monospace}
table {color: #000000; background-color: #e9e8e2; font-family: monospace}
.ST0 {font-family: monospace; font-weight: bold}
.comment {color: #969696}
.keyword {color: #0000e6}
.variable {color: #6d3206}
.ST1 {color: #969696; background-color: #eceba3}
.string {color: #ce7b00}
-->
</style>
</head>
<body>
<table width="100%"><tr><td align="center">C:\wamp64\www\mediatekformation\src\Repository\FormationRepository.php</td></tr></table>
<pre>
    <span class="comment">/*</span>
     <span class="comment">* Retourne toutes les formations triées sur un champ</span>
     <span class="comment">* @param type $champ</span>
     <span class="comment">* @param type $ordre</span>
     <span class="comment">* @param type $table si $champ dans une autre table</span>
     <span class="comment">* @return Formation[]</span>
     <span class="comment">*</span> 
     <span class="comment">*/</span>
     
    <span class="keyword">public</span> <span class="keyword">function</span> <span class="ST0">findAllOrderBy</span>(<span class="variable">$champ</span>, <span class="variable">$ordre</span>, <span class="variable">$table</span>=<span class="string">&quot;&quot;</span>): <span class="keyword">array</span>{
        <span class="keyword">if</span>(<span class="variable">$table</span>==<span class="string">&quot;&quot;</span>){
            <span class="keyword">return</span> <span class="variable">$this</span>-&gt;createQueryBuilder(<span class="string">&#39;f&#39;</span>)
                    -&gt;orderBy(<span class="string">&#39;f.&#39;</span>.<span class="variable">$champ</span>, <span class="variable">$ordre</span>)
                    -&gt;getQuery()
                    -&gt;getResult();
        }<span class="keyword">else</span>{
            <span class="keyword">return</span> <span class="variable">$this</span>-&gt;createQueryBuilder(<span class="string">&#39;f&#39;</span>)
                    -&gt;join(<span class="string">&#39;f.&#39;</span>.<span class="variable">$table</span>, <span class="string">&#39;t&#39;</span>)
                    -&gt;orderBy(<span class="string">&#39;t.&#39;</span>.<span class="variable">$champ</span>, <span class="variable">$ordre</span>)
                    -&gt;getQuery()
                    -&gt;getResult();            
        }
    }

    
    
   <span class="comment">/*</span><span class="comment"> public function findAllOrderByChamp($champ ,$ordre , $table = &quot;&quot;) : array{</span>
      
        <span class="comment">return $this-&gt;createQueryBuilder(&#39;f&#39;)</span>
                    <span class="comment">-&gt;orderBy(&#39;f.&#39;.$champ, $ordre)</span>
                    <span class="comment">-&gt;getQuery()</span>
                    <span class="comment">-&gt;getResult();</span>
    <span class="comment">}</span>
    
    
     <span class="comment">public function findAllOrderByJoinTable($champ ,$ordre, $table ) : array{</span>
     <span class="ST1">return $this-&gt;createQueryBuilder(&#39;f&#39;)</span>
                    <span class="ST1">-&gt;join(&#39;f.&#39;.$table, &#39;t&#39;)</span>
                    <span class="ST1">-&gt;orderBy(&#39;t.&#39;.$champ, $ordre)</span>
                    <span class="ST1">-&gt;getQuery()</span>
                    <span class="ST1">-&gt;getResult();</span> 
     <span class="comment">}</span>
        
</pre></body>
</html>
 
    /**
     * Enregistrements dont un champ contient une valeur
     * ou tous les enregistrements si la valeur est vide
     * @param type $champ
     * @param type $valeur
     * @param type $table si $champ dans une autre table
     * @return Formation[]
     */
    public function findByContainValue($champ, $valeur, $table=""): array{
        if($valeur==""){
            return $this->findAll();
        }
        if($table==""){
            return $this->createQueryBuilder('f')
                    ->where('f.'.$champ.' LIKE :valeur')
                    ->orderBy('f.publishedAt', 'DESC')
                    ->setParameter('valeur', '%'.$valeur.'%')
                    ->getQuery()
                    ->getResult();            
        }else{
            return $this->createQueryBuilder('f')
                    ->join('f.'.$table, 't')                    
                    ->where('t.'.$champ.' LIKE :valeur')
                    ->orderBy('f.publishedAt', 'DESC')
                    ->setParameter('valeur', '%'.$valeur.'%')
                    ->getQuery()
                    ->getResult();                   
        }       
    }    
    
    /**
     * Retourne les n formations les plus récentes
     * @param type $nb
     * @return Formation[]
     */
    public function findAllLasted($nb) : array {
        return $this->createQueryBuilder('f')
                ->orderBy('f.publishedAt', 'DESC')
                ->setMaxResults($nb)     
                ->getQuery()
                ->getResult();
    }    
    
    /**
     * Retourne la liste des formations d'une playlist
     * @param type $idPlaylist
     * @return array
     */
    public function findAllForOnePlaylist($idPlaylist): array{
        return $this->createQueryBuilder('f')
                ->join('f.playlist', 'p')
                ->where('p.id=:id')
                ->setParameter('id', $idPlaylist)
                ->orderBy('f.publishedAt', 'ASC')   
                ->getQuery()
                ->getResult();        
    }
    
}
