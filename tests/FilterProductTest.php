<?php

use PHPUnit\Framework\TestCase;

class FilterProductTest extends TestCase
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
            (2, 'Casual Shoes', 'Stylish casual shoes', 39.99, '9', 'casualshoes.jpg', 30),
            (3, 'Formal Shoes', 'Elegant formal shoes', 79.99, '11', 'formalshoes.jpg', 20)
        ");
    }

    public function testFilterProductsByPriceRange()
    {
        // Simulate filtering products by price range
        $minPrice = 40;
        $maxPrice = 80;
        $stmt = $this->pdo->prepare("SELECT * FROM tblProducts WHERE Price BETWEEN ? AND ?");
        $stmt->execute([$minPrice, $maxPrice]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->assertCount(2, $products, "Should retrieve products within the price range.");
    }

    public function testFilterProductsByCategory()
    {
        // Simulate filtering products by category
        $categoryID = 1;
        $stmt = $this->pdo->prepare("SELECT * FROM tblProducts WHERE CategoryID = ?");
        $stmt->execute([$categoryID]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->assertCount(1, $products, "Should retrieve products in the specified category.");
    }

    protected function tearDown(): void
    {
        $this->pdo = null;
    }
}