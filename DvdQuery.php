<?php

namespace Database\Query;

require './Database.php';

class DvdQuery extends \Database {
  private $dvds;
  private $dvdSearchTitle;

  public function titleContains($title) {
    $sql = "
      SELECT dvds.title, dvds.id, ratings.rating_name
      FROM dvds
      INNER JOIN ratings
      ON dvds.rating_id = ratings.id
      WHERE dvds.title LIKE ?
    ";

    $this->dvdSearchTitle = $title;

    $statement = self::$pdo->prepare($sql);
    $like = '%' . $this->dvdSearchTitle . '%';
    $statement->bindParam(1, $like);
    $statement->execute();
    $this->dvds = $statement->fetchAll(\PDO::FETCH_OBJ);
  }

  public function orderByTitle() {
    $sql = "
      SELECT dvds.title, dvds.id, ratings.rating_name
      FROM dvds
      INNER JOIN ratings
      ON dvds.rating_id = ratings.id
      WHERE dvds.title LIKE ?
      ORDER BY dvds.title
    ";

    $statement = self::$pdo->prepare($sql);
    $like = '%' . $this->dvdSearchTitle . '%';
    $statement->bindParam(1, $like);
    $statement->execute();
    $this->dvds = $statement->fetchAll(\PDO::FETCH_OBJ);
  }

  public function find() {
    return $this->dvds;
  }

}
