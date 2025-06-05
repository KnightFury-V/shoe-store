<?php

use PHPUnit\Framework\TestCase;

class ViewProductTest extends TestCase
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

        // Insert sample products
        $this->pdo->exec("
            INSERT INTO tblProducts (CategoryID, ProductName, Description, Price, Size, ImagePath, Stock)
            VALUES 
            (1, 'Running Shoes', 'Comfortable shoes for running', 59.99, '10', 'runningshoes.jpg', 50),
            (2, 'Casual Shoes', 'Stylish casual shoes', 39.99, '9', 'casualshoes.jpg', 30)
        ");
    }

    public function testViewAllProducts()
    {
        // Simulate viewing all products
        $stmt = $this->pdo->prepare("SELECT * FROM tblProducts");
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->assertCount(2, $products, "Should retrieve all products.");
    }

    protected function tearDown(): void
    {
        $this->pdo = null;
    }
}