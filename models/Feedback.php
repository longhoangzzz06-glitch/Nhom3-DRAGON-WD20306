<?php
class Feedback
{
    private $db;



    public function __construct($db) {
        $this->db = $db;   // <-- phải gán DB vào thuộc tính
    }

    public function getAll($limit, $offset)
    {
        $sql = "SELECT * FROM feedback ORDER BY id DESC LIMIT $limit OFFSET $offset";
        return $this->db->query($sql)->fetchAll();
    }

    public function countAll()
    {
        return $this->db->query("SELECT COUNT(*) AS total FROM feedback")->fetch()['total'];
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM feedback WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $sql = "INSERT INTO feedback(tour_id, customer_name, customer_phone, rating_tour, rating_service, rating_guide, comment, image)
                VALUES(:tour_id, :name, :phone, :rtour, :rservice, :rguide, :comment, :image)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'tour_id'  => $data['tour_id'],
            'name'     => $data['customer_name'],
            'phone'    => $data['customer_phone'],
            'rtour'    => $data['rating_tour'],
            'rservice' => $data['rating_service'],
            'rguide'   => $data['rating_guide'],
            'comment'  => $data['comment'],
            'image'    => $data['image']
        ]);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE feedback SET 
                    tour_id = :tour_id,
                    customer_name = :name,
                    customer_phone = :phone,
                    rating_tour = :rtour,
                    rating_service = :rservice,
                    rating_guide = :rguide,
                    comment = :comment,
                    image = :image
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'tour_id'  => $data['tour_id'],
            'name'     => $data['customer_name'],
            'phone'    => $data['customer_phone'],
            'rtour'    => $data['rating_tour'],
            'rservice' => $data['rating_service'],
            'rguide'   => $data['rating_guide'],
            'comment'  => $data['comment'],
            'image'    => $data['image'],
            'id'       => $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM feedback WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
