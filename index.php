<?php
require 'db.php';
class DummyHandler
{
    private $curl;
    private $dummyLink;

    public function __construct() {
        $this->curl = curl_init();
        $this->dummyLink = "https://dummyjson.com/";
    }

    function getProduct($productName) {
        $productLink = $this->dummyLink . "products/search?q=" . $productName;

        return $this->httpRequest($productLink, CURLOPT_RETURNTRANSFER, "");
    }

    function addProduct($title) {
        $addProductLink = $this->dummyLink . "products/add";
        $postData = array(
            'title' => $title,
        );

        echo $this->httpRequest($addProductLink, CURLOPT_POST, $postData);
    }

    function httpRequest($link, $method, $data) {
        curl_reset($this->curl);
        curl_setopt($this->curl, CURLOPT_URL, $link);
        curl_setopt($this->curl, $method, true);

        if ($method == CURLOPT_POST) {
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        }
        
        $response = curl_exec($this->curl);

        if(curl_errno($this->curl)){
            echo 'Ошибка cURL: ' . curl_error($this->curl);
        }

        return $response;
    }
}

$dummyHandler = new DummyHandler();

print_r($dummyHandler->addProduct("iphone"));
echo '<br>';
$data = json_decode($dummyHandler->getProduct("iphone"));
print_r($data);


echo '<br><br>';
$db = new DBHandler();

echo '<br>';
print_r($db->getAllProducts());
echo '<br>';
$db->addProduct($data->products[0]);
echo '<br>';
print_r($db->getAllProducts());
?>