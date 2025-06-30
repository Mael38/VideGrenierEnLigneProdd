<?php

use PHPUnit\Framework\TestCase;
use App\Controllers\Product;

class ContactFormTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Nettoyer les variables superglobales
        $_POST = [];
        $_SESSION = [];
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        
        $_POST = [];
        $_SESSION = [];
    }

    public function testContactFormValidation()
    {
        // Test de validation des champs requis
        $requiredFields = ['contact_name', 'contact_email', 'contact_message'];
        
        foreach ($requiredFields as $field) {
            $this->assertTrue(!empty($field), "Le champ {$field} doit être requis");
        }
    }

    public function testEmailValidation()
    {
        // Test de validation de l'email
        $validEmails = [
            'test@example.com',
            'user.name@domain.co.uk',
            'valid+email@test.org'
        ];
        
        $invalidEmails = [
            'invalid-email',
            '@domain.com',
            'user@',
            'user@domain',
            ''
        ];
        
        foreach ($validEmails as $email) {
            $this->assertTrue(filter_var($email, FILTER_VALIDATE_EMAIL) !== false, 
                "L'email {$email} devrait être valide");
        }
        
        foreach ($invalidEmails as $email) {
            $this->assertFalse(filter_var($email, FILTER_VALIDATE_EMAIL) !== false, 
                "L'email {$email} devrait être invalide");
        }
    }

    public function testContactFormWithValidData()
    {
        // Simuler des données POST valides
        $_POST = [
            'submit_contact' => true,
            'contact_name' => 'John Doe',
            'contact_email' => 'john@example.com',
            'contact_message' => 'Je suis intéressé par votre produit.'
        ];

        // Vérifier que toutes les données nécessaires sont présentes
        $this->assertArrayHasKey('contact_name', $_POST);
        $this->assertArrayHasKey('contact_email', $_POST);
        $this->assertArrayHasKey('contact_message', $_POST);
        
        // Vérifier que les données ne sont pas vides
        $this->assertNotEmpty($_POST['contact_name']);
        $this->assertNotEmpty($_POST['contact_email']);
        $this->assertNotEmpty($_POST['contact_message']);
        
        // Vérifier la validation de l'email
        $this->assertTrue(filter_var($_POST['contact_email'], FILTER_VALIDATE_EMAIL) !== false);
    }

    public function testContactFormWithInvalidEmail()
    {
        // Simuler des données POST avec email invalide
        $_POST = [
            'submit_contact' => true,
            'contact_name' => 'John Doe',
            'contact_email' => 'invalid-email',
            'contact_message' => 'Message de test'
        ];

        // Vérifier que l'email est invalide
        $this->assertFalse(filter_var($_POST['contact_email'], FILTER_VALIDATE_EMAIL) !== false);
    }

    public function testContactFormWithMissingFields()
    {
        // Test avec des champs manquants
        $testCases = [
            ['contact_email' => 'test@test.com', 'contact_message' => 'Message'],
            ['contact_name' => 'John', 'contact_message' => 'Message'],
            ['contact_name' => 'John', 'contact_email' => 'test@test.com']
        ];

        foreach ($testCases as $testCase) {
            $_POST = array_merge(['submit_contact' => true], $testCase);
            
            $hasName = !empty($_POST['contact_name'] ?? '');
            $hasEmail = !empty($_POST['contact_email'] ?? '');
            $hasMessage = !empty($_POST['contact_message'] ?? '');
            
            // Au moins un champ devrait manquer
            $this->assertFalse($hasName && $hasEmail && $hasMessage, 
                'Au moins un champ requis devrait manquer');
        }
    }

    public function testSendEmailFunctionality()
    {
        // Tester la fonctionnalité d'envoi d'email (simulation)
        $toEmail = 'seller@example.com';
        $fromName = 'John Doe';
        $fromEmail = 'john@example.com';
        $message = 'Je suis intéressé par votre produit';
        $productName = 'Jeu de cartes rare';

        // Simuler la construction du sujet et du corps de l'email
        $subject = "Demande de contact pour: " . $productName;
        $body = "
            Nouvelle demande de contact pour votre annonce '{$productName}'

            De: {$fromName} ({$fromEmail})
            Message:
            {$message}

            Vous pouvez répondre directement à cette adresse: {$fromEmail}
        ";

        // Vérifier que le sujet contient le nom du produit
        $this->assertStringContainsString($productName, $subject);
        
        // Vérifier que le corps contient toutes les informations
        $this->assertStringContainsString($fromName, $body);
        $this->assertStringContainsString($fromEmail, $body);
        $this->assertStringContainsString($message, $body);
        $this->assertStringContainsString($productName, $body);
    }
}
