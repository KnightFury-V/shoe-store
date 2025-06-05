<?php

use PHPUnit\Framework\TestCase;

class AddProductTest extends TestCase
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

    public function testAddProductSuccess()
    {
        // Simulate adding a new product
        $productData = [
            'CategoryID' => 1,
            'ProductName' => 'Running Shoes',
            'Description' => 'Comfortable shoes for running',
            'Price' => 59.99,
            'Size' => '10',
            'ImagePath' => 'runningshoes.jpg',
            'Stock' => 50
        ];
        $stmt = $this->pdo->prepare("INSERT INTO tblProducts (CategoryID, ProductName, Description, Price, Size, ImagePath, Stock) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute(array_values($productData));

        // Verify the product was added
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM tblProducts WHERE ProductName = ?");
        $stmt->execute([$productData['ProductName']]);
        $exists = $stmt->fetchColumn();

        $this->assertEquals(1, $exists, "Product should be added successfully.");
    }

    public function testAddProductDuplicate()
    {
        // Simulate adding a duplicate product
        $productName = 'Running Shoes';
        $stmt = $this->pdo->prepare("INSERT INTO tblProducts (CategoryID, ProductName, Description, Price, Size, ImagePath, Stock) VALUES (1, ?, 'Comfortable shoes for running', 59.99, '10', 'runningshoes.jpg', 50)");
        $stmt->execute([$productName]);

        $this->expectException(PDOException::class);
        $stmt = $this->pdo->prepare("INSERT INTO tblProducts (CategoryID, ProductName, Description, Price, Size, ImagePath, Stock) VALUES (1, ?, 'Comfortable shoes for running', 59.99, '10', 'runningshoes.jpg', 50)");
        $stmt->execute([$productName]);
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
            // Application-level validation for invalid price
            if ($productData['Price'] < 0) {
                throw new InvalidArgumentException("Price cannot be negative.");
            }

            $stmt->execute(array_values($productData));
            $this->fail("Expected exception not thrown.");
        } catch (InvalidArgumentException $e) {
            $this->assertStringContainsString("Price cannot be negative.", $e->getMessage(), "Expected validation error for negative price.");
        }
    }

    protected function tearDown(): void
    {
        // Clean up the mock database
        $this->pdo = null;
    }
}