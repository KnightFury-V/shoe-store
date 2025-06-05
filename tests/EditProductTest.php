<?php

use PHPUnit\Framework\TestCase;

class EditProductTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        // Set up a mock database connection
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Create a mock table for products
        $this->pdo->exec("
            CREATE TABLE tblProducts (
                ProductID INTEGER PRIMARY KEY AUTOINCREMENT,
                CategoryID INTEGER NOT NULL,
                ProductName TEXT UNIQUE NOT NULL,
                Description TEXT,
                Price DECIMAL(10,2) NOT NULL,
                Size TEXT,
                ImagePath TEXT,
                Stock INTEGER DEFAULT 0
            )
        ");

        // Insert a sample product
        $this->pdo->exec("
            INSERT INTO tblProducts (CategoryID, ProductName, Description, Price, Size, ImagePath, Stock)
            VALUES (1, 'Running Shoes', 'Comfortable shoes for running', 59.99, '10', 'runningshoes.jpg', 50)
        ");
    }

    public function testEditProductSuccess()
    {
        // Simulate editing a product
        $newData = [
            'ProductName' => 'Updated Running Shoes',
            'Description' => 'Updated description',
            'Price' => 69.99,
            'Size' => '11',
            'Stock' => 40
        ];
        $stmt = $this->pdo->prepare("UPDATE tblProducts SET ProductName = ?, Description = ?, Price = ?, Size = ?, Stock = ? WHERE ProductName = 'Running Shoes'");
        $stmt->execute(array_values($newData));

        // Verify the product was updated
        $stmt = $this->pdo->prepare("SELECT ProductName, Description, Price, Size, Stock FROM tblProducts WHERE ProductName = ?");
        $stmt->execute([$newData['ProductName']]);
        $updatedProduct = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals($newData, $updatedProduct, "Product should be updated successfully.");
    }

    public function testEditProductNonExistent()
    {
        // Simulate editing a non-existent product
        $stmt = $this->pdo->prepare("UPDATE tblProducts SET ProductName = 'NonExistent' WHERE ProductName = 'NonExistent'");
        $stmt->execute();

        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM tblProducts WHERE ProductName = 'NonExistent'");
        $stmt->execute();
        $exists = $stmt->fetchColumn();

        $this->assertEquals(0, $exists, "Non-existent product should not be updated.");
    }

    protected function tearDown(): void
    {
        // Clean up the mock database
        $this->pdo = null;
    }
}