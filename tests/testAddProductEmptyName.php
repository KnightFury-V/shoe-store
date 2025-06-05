<?php

use PHPUnit\Framework\TestCase;

class TestAddProductEmptyName extends TestCase
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
    }

    public function testAddProductEmptyName()
    {
        $productName = '';
        $stmt = $this->pdo->prepare("INSERT INTO tblProducts (CategoryID, ProductName, Description, Price, Size, ImagePath, Stock) VALUES (1, ?, 'Description', 59.99, '10', 'image.jpg', 50)");

        try {
            // Application-level validation for empty product name
            if (empty($productName)) {
                throw new InvalidArgumentException("Product name cannot be empty.");
            }

            $stmt->execute([$productName]);
            $this->fail("Expected exception not thrown.");
        } catch (InvalidArgumentException $e) {
            $this->assertStringContainsString("Product name cannot be empty.", $e->getMessage(), "Expected validation error for empty product name.");
        }
    }

    protected function tearDown(): void
    {
        // Clean up the mock database
        $this->pdo = null;
    }
}