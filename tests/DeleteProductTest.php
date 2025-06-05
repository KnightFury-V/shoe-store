<?php

use PHPUnit\Framework\TestCase;

class DeleteProductTest extends TestCase
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

    public function testDeleteProductSuccess()
    {
        // Simulate deleting a product
        $stmt = $this->pdo->prepare("DELETE FROM tblProducts WHERE ProductName = ?");
        $stmt->execute(['Running Shoes']);

        // Verify the product was deleted
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM tblProducts WHERE ProductName = ?");
        $stmt->execute(['Running Shoes']);
        $exists = $stmt->fetchColumn();

        $this->assertEquals(0, $exists, "Product should be deleted successfully.");
    }

    public function testDeleteProductNonExistent()
    {
        // Simulate deleting a non-existent product
        $stmt = $this->pdo->prepare("DELETE FROM tblProducts WHERE ProductName = ?");
        $stmt->execute(['NonExistent']);

        // Verify no rows were affected
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM tblProducts");
        $stmt->execute();
        $count = $stmt->fetchColumn();

        $this->assertEquals(1, $count, "Non-existent product should not affect the database.");
    }

    protected function tearDown(): void
    {
        // Clean up the mock database
        $this->pdo = null;
    }
}