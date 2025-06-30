<?php

namespace App\Controllers;

use App\Models\Articles;
use App\Utility\Upload;
use \Core\View;

/**
 * Product controller
 */
class Product extends \Core\Controller
{

    /**
     * Affiche la page d'ajout
     * @return void
     */
    public function indexAction()
    {

        if(isset($_POST['submit'])) {

            try {
                $f = $_POST;

                // TODO: Validation

                $f['user_id'] = $_SESSION['user']['id'];
                $id = Articles::save($f);

                // Vérifier si un fichier a été uploadé
                if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK && !empty($_FILES['picture']['tmp_name'])) {
                    $pictureName = Upload::uploadFile($_FILES['picture'], $id);
                    Articles::attachPicture($id, $pictureName);
                }
                // Si pas de fichier, continuer sans image (l'image est optionnelle)

                header('Location: /product/' . $id);
            } catch (\Exception $e){
                    var_dump($e);
            }
        }

        View::renderTemplate('Product/Add.html');
    }

    /**
     * Affiche la page d'un produit
     * @return void
     */
    public function showAction()
    {
        $id = $this->route_params['id'];

        try {
            Articles::addOneView($id);
            $suggestions = Articles::getSuggest();
            $article = Articles::getOne($id);
        } catch(\Exception $e){
            var_dump($e);
        }

        View::renderTemplate('Product/Show.html', [
            'article' => $article[0],
            'suggestions' => $suggestions
        ]);
    }

    /**
     * Traiter le formulaire de contact sur la page produit
     * @return void
     */
    public function contactAction()
    {
        $productId = $this->route_params['id'];
        $message = '';
        $success = false;

        if (isset($_POST['submit_contact'])) {
            try {
                $name = $_POST['contact_name'] ?? '';
                $email = $_POST['contact_email'] ?? '';
                $messageText = $_POST['contact_message'] ?? '';

                // Validation basique
                if (empty($name) || empty($email) || empty($messageText)) {
                    throw new \Exception('Tous les champs sont requis');
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new \Exception('Adresse email invalide');
                }

                // Récupérer les informations du produit et du vendeur
                $article = Articles::getOne($productId);
                if (!$article) {
                    throw new \Exception('Produit non trouvé');
                }

                $sellerEmail = $article[0]['email'];
                $productName = $article[0]['name'];

                // Envoyer l'email (simulation pour l'instant)
                $emailSent = $this->sendContactEmail($sellerEmail, $name, $email, $messageText, $productName);

                if ($emailSent) {
                    $message = 'Votre message a été envoyé avec succès !';
                    $success = true;
                } else {
                    throw new \Exception('Erreur lors de l\'envoi du message');
                }

            } catch (\Exception $e) {
                $message = $e->getMessage();
            }
        }

        // Redirection vers la page produit avec le message
        $article = Articles::getOne($productId);
        $suggestions = Articles::getSuggest();

        View::renderTemplate('Product/Show.html', [
            'article' => $article[0],
            'suggestions' => $suggestions,
            'contact_message' => $message,
            'contact_success' => $success
        ]);
    }

    /**
     * Envoyer un email de contact (simulation)
     * @param string $toEmail
     * @param string $fromName
     * @param string $fromEmail
     * @param string $message
     * @param string $productName
     * @return bool
     */
    private function sendContactEmail($toEmail, $fromName, $fromEmail, $message, $productName)
    {
        // Pour l'instant, on simule l'envoi d'email
        // En production, on utiliserait une vraie bibliothèque d'email comme PHPMailer
        
        $subject = "Demande de contact pour: " . $productName;
        $body = "
            Nouvelle demande de contact pour votre annonce '{$productName}'

            De: {$fromName} ({$fromEmail})
            Message:
            {$message}

            Vous pouvez répondre directement à cette adresse: {$fromEmail}
        ";

        // Log de l'email pour debug (en prod, remplacer par un vrai envoi)
        error_log("EMAIL SIMULÉ - To: {$toEmail}, Subject: {$subject}, Body: {$body}");
        
        // Simuler un succès pour les tests
        return true;
    }
}
