<?php
class DBHandler
{
    private $db;

    public function __construct() {
        $this->db = new mysqli("localhost", "root", "", "dummydb");
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    function getAllProducts()
    {
        $sql = "SELECT * FROM products";
        $result = $this->db->query($sql);

        $products = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        return $products;
    }

    function addProduct($product) {
        $id = $product->id;
        $title = $product->title;
        $description = $product->description;
        $price = $product->price;
        $discountPercentage = $product->discountPercentage;
        $rating = $product->rating;
        $stock = $product->stock;
        $brand = $product->brand;
        $category = $product->category;
        $thumbnail = $product->thumbnail;
        $images = $product->images;
        $sql = "INSERT INTO products (id, title, description, price, discountPercentage, rating, stock, brand, category, thumbnail) VALUES (
            '$id',
            '$title',
            '$description',
            '$price',
            '$discountPercentage',
            '$rating',
            '$stock',
            '$brand',
            '$category',
            '$thumbnail'
            )";
        $this->db->query($sql);

        foreach ($images as $image) {
            $sql = "INSERT INTO images (product_id, url) VALUES (
                '$id',
                '$image'
                )";
            $this->db->query($sql);
        }
    }
}

?>