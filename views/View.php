<?php

namespace App\Views;

use App\Models\Repositories\MessageRepository;

class View
{
    private string $title;

    public function __construct(string $title) 
    {
        $this->title = $title;
    }

    /**
     * Affiche la page complète (layout + vue).
     *
     * @param string $viewName Nom de la vue (sans .php)
     * @param array  $params   Variables passées à la vue
     */
    public function render(string $viewName, array $params = []) : void 
    {
        // Résout le chemin de la vue
        $viewPath = $this->buildViewPath($viewName);
        
        // $content sera utilisé dans le layout principal
        $content = $this->_renderViewFromTemplate($viewPath, $params);
        $title   = $this->title;

        // 🔹 Nombre de messages non lus dans le header
        $unreadCount = 0;
        if (!empty($_SESSION['user_id'])) {
            $messageRepo = new MessageRepository();
            $unreadCount = $messageRepo->countUnread((int)$_SESSION['user_id']);
        }

        if (!file_exists(MAIN_VIEW_PATH)) {
            throw new \RuntimeException("Layout introuvable: " . MAIN_VIEW_PATH);
        }

        ob_start();
        require MAIN_VIEW_PATH;   // le layout utilise $title, $content, $unreadCount
        echo ob_get_clean();
    }

    /**
     * Construit le chemin complet de la vue.
     */
    private function buildViewPath(string $viewName) : string
    {
        // petite sécurité
        $viewName = ltrim($viewName, '/');
        if (strpos($viewName, '..') !== false) {
            throw new \RuntimeException('Chemin de vue invalide');
        }

        $path = TEMPLATE_VIEW_PATH . $viewName . '.php';
        if (!file_exists($path)) {
            throw new \RuntimeException("Vue introuvable: " . $path);
        }
        return $path;
    }

    /**
     * Rendu d’un template de vue en injectant les paramètres.
     */
    private function _renderViewFromTemplate(string $viewPath, array $params = []) : string
    {
        if (!empty($params)) {
            extract($params, EXTR_OVERWRITE);
        }

        ob_start();
        require $viewPath;
        return ob_get_clean();
    }
}
