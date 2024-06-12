<?php

namespace App\Models;

use PDO;

class EventModel extends SqlConnect {

    public function getAll() {
        $query = "SELECT * FROM evenements";
        $req = $this->db->prepare($query);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add(array $data) {
        $query = "
            INSERT INTO evenements (title, name, adress, description, numero, date, time)
            VALUES (:title, :name, :adress, :description, :numero, :date, :time)
        ";
        $req = $this->db->prepare($query);
        $req->execute($data);
    }

    public function delete(int $id) {
        $req = $this->db->prepare("DELETE FROM evenements WHERE id = :id");
        $req->execute(["id" => $id]);
    }

    public function get(int $id) {
        $req = $this->db->prepare("SELECT * FROM evenements WHERE id = :id");
        $req->execute(["id" => $id]);
        return $req->rowCount() > 0 ? $req->fetch(PDO::FETCH_ASSOC) : new stdClass();
    }

    public function getLast() {
        $req = $this->db->prepare("SELECT * FROM evenements ORDER BY id DESC LIMIT 1");
        $req->execute();
        return $req->rowCount() > 0 ? $req->fetch(PDO::FETCH_ASSOC) : new stdClass();
    }

    public function exists(string $title) {
        $req = $this->db->prepare("SELECT * FROM evenements WHERE title = :title");
        $req->execute(['title' => $title]);
        return $req->rowCount() > 0;
    }
}
