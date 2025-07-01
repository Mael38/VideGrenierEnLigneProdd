<?php

// Définir la constante pour indiquer que nous sommes en mode test
define('PHPUNIT_RUNNING', true);

use PHPUnit\Framework\TestCase;
use App\Utility\Upload;

class UploadTest extends TestCase
{
    private $testUploadDir;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Créer un dossier temporaire pour les tests
        $this->testUploadDir = sys_get_temp_dir() . '/test_uploads_' . uniqid();
        if (!is_dir($this->testUploadDir)) {
            mkdir($this->testUploadDir, 0777, true);
        }
        
        // Changer le répertoire de travail pour les tests
        chdir($this->testUploadDir);
        
        // Créer le dossier storage
        if (!is_dir($this->testUploadDir . '/storage')) {
            mkdir($this->testUploadDir . '/storage', 0777, true);
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        
        // Nettoyer les fichiers de test
        if (is_dir($this->testUploadDir)) {
            $this->deleteDirectory($this->testUploadDir);
        }
    }

    private function deleteDirectory($dir)
    {
        if (!is_dir($dir)) {
            return;
        }

        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            is_dir($path) ? $this->deleteDirectory($path) : unlink($path);
        }
        rmdir($dir);
    }

    public function testUploadFileWithMissingFile()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Aucun fichier n'a été uploadé");

        $file = [
            'tmp_name' => '',
            'name' => '',
            'size' => 0,
            'error' => UPLOAD_ERR_NO_FILE
        ];

        Upload::uploadFile($file, 'test');
    }

    public function testUploadFileWithError()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Erreur lors de l'upload du fichier:");

        $file = [
            'tmp_name' => 'some_temp_file',
            'name' => 'test.jpg',
            'size' => 1000,
            'error' => UPLOAD_ERR_PARTIAL
        ];

        Upload::uploadFile($file, 'test');
    }

    public function testUploadFileWithInvalidExtension()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("This file extension is not allowed");

        // Créer un fichier temporaire
        $tempFile = tempnam($this->testUploadDir, 'test');
        file_put_contents($tempFile, 'test content');

        $file = [
            'tmp_name' => $tempFile,
            'name' => 'test.txt',
            'size' => 12,
            'error' => UPLOAD_ERR_OK
        ];

        Upload::uploadFile($file, 'test');
    }

    public function testUploadFileWithLargeSize()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("File exceeds maximum size");

        // Créer un fichier temporaire
        $tempFile = tempnam($this->testUploadDir, 'test');
        file_put_contents($tempFile, 'test content');

        $file = [
            'tmp_name' => $tempFile,
            'name' => 'test.jpg',
            'size' => 5000000, // 5MB
            'error' => UPLOAD_ERR_OK
        ];

        Upload::uploadFile($file, 'test');
    }

    public function testUploadFileSuccess()
    {
        // Créer un fichier temporaire valide
        $tempFile = tempnam($this->testUploadDir, 'test');
        file_put_contents($tempFile, 'test image content');

        $file = [
            'tmp_name' => $tempFile,
            'name' => 'test.jpg',
            'size' => 18,
            'error' => UPLOAD_ERR_OK
        ];

        $result = Upload::uploadFile($file, 'test_article');

        $this->assertEquals('test_article.jpg', $result);
        
        // Vérifier que le fichier a été créé dans le bon répertoire
        $expectedPath = getcwd() . '/storage/test_article.jpg';
        $this->assertFileExists($expectedPath);
    }
}
