<?php

use PHPUnit\Framework\TestCase;

class TestAddProductInvalidPrice extends TestCase
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
                Price DECIMAL(10,2) NOT NULL CHECK (Price >= 0),
                Size TEXT,
                ImagePath TEXT,
                Stock INTEGER DEFAULT 0
            )
        ");
    }

    public function testAddProductInvalidPrice()
    {
        $productData = [
            'CategoryID' => 1,
            'ProductName' => 'Invalid Price Product',
            'Description' => 'Product with invalid price',
            'Price' => -10.00, // Invalid price
            'Size' => '10',
            'ImagePath' => 'invalidprice.jpg',
            'Stock' => 50
        ];
        $stmt = $this->pdo->prepare("INSERT INTO tblProducts (CategoryID, ProductName, Description, Price, Size, ImagePath, Stock) VALUES (?, ?, ?, ?, ?, ?, ?)");

        try {
            $stmt->execute(array_values($productData));
            echo "Inserted product with invalid price.\n"; // Debug statement
            $this->fail("Expected exception not thrown.");
        } catch (PDOException $e) {
            echo "Exception message: " . $e->getMessage() . "\n"; // Debug statement
            $this->assertStringContainsString("CHECK constraint failed", $e->getMessage(), "Expected CHECK constraint error.");
        }
    }

    protected function tearDown(): void
    {
        // Clean up the mock database
        $this->pdo = null;
    }
}