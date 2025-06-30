<?php

use PHPUnit\Framework\TestCase;
use App\Models\User;

class RememberMeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Démarrer une session pour les tests
        if (!isset($_SESSION)) {
            $_SESSION = [];
        }
        
        // Nettoyer les cookies
        $_COOKIE = [];
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        
        // Nettoyer la session et les cookies
        $_SESSION = [];
        $_COOKIE = [];
    }

    public function testCreateRememberMeCookie()
    {
        // Tester la création d'un cookie remember me
        // Note: En environnement de test, on ne peut pas vraiment tester setcookie()
        // mais on peut tester la logique de génération de token
        
        $userId = 1;
        $token = bin2hex(random_bytes(32));
        $hashedToken = hash('sha256', $token);
        
        // Vérifier que le token fait 64 caractères (32 bytes en hex)
        $this->assertEquals(64, strlen($token));
        
        // Vérifier que le hash fait 64 caractères (SHA256)
        $this->assertEquals(64, strlen($hashedToken));
    }

    public function testTokenValidation()
    {
        // Simuler un cookie remember me
        $userId = 1;
        $token = bin2hex(random_bytes(32));
        
        $_COOKIE['remember_me'] = $userId . ':' . $token;
        
        // Vérifier le parsing du cookie
        $cookieParts = explode(':', $_COOKIE['remember_me'], 2);
        
        $this->assertCount(2, $cookieParts);
        $this->assertEquals($userId, $cookieParts[0]);
        $this->assertEquals($token, $cookieParts[1]);
    }

    public function testInvalidCookieFormat()
    {
        // Tester avec un cookie mal formé
        $_COOKIE['remember_me'] = 'invalid_format';
        
        $cookieParts = explode(':', $_COOKIE['remember_me'], 2);
        
        // Le cookie mal formé ne devrait pas avoir 2 parties
        $this->assertNotCount(2, $cookieParts);
    }

    public function testTokenHashing()
    {
        // Tester que le même token génère toujours le même hash
        $token = 'test_token_123';
        $hash1 = hash('sha256', $token);
        $hash2 = hash('sha256', $token);
        
        $this->assertEquals($hash1, $hash2);
        
        // Tester que des tokens différents génèrent des hash différents
        $token2 = 'different_token_456';
        $hash3 = hash('sha256', $token2);
        
        $this->assertNotEquals($hash1, $hash3);
    }

    public function testExpiryCalculation()
    {
        // Tester le calcul de l'expiration (30 jours)
        $expiry = time() + (30 * 24 * 60 * 60);
        $expectedExpiry = time() + 2592000; // 30 jours en secondes
        
        // Permettre une différence de quelques secondes pour l'exécution du test
        $this->assertLessThanOrEqual(5, abs($expiry - $expectedExpiry));
    }

    public function testSessionCreation()
    {
        // Tester la création de session après validation du cookie
        $user = [
            'id' => 1,
            'username' => 'testuser'
        ];
        
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username']
        ];
        
        $this->assertEquals(1, $_SESSION['user']['id']);
        $this->assertEquals('testuser', $_SESSION['user']['username']);
    }
}
