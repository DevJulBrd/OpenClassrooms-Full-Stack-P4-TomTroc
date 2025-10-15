<?php
class View
{
    private string $title;

    public function __construct(string $title) 
    {
        $this->title = $title;
    }

    /**
     * Cette méthode retourne une page complète. 
     * @param string $viewPath : le chemin de la vue demandée par le controlleur. 
     * @param array $params : les paramètres que le controlleur a envoyé à la vue.
     * @return string
     */
    public function render(string $viewName, array $params = []) : void 
    {
        // On s'occupe de la vue envoyée
        $viewPath = $this->buildViewPath($viewName);
        
        // Les deux variables ci-dessous sont utilisées dans le "main.php" qui est le template principal.
        $content = $this->_renderViewFromTemplate($viewPath, $params);
        $title = $this->title;

        if (!file_exists(MAIN_VIEW_PATH)) {
            throw new RuntimeException("Layout introuvable: " . MAIN_VIEW_PATH);
        }

        ob_start();
        require(MAIN_VIEW_PATH);
        echo ob_get_clean();
    }

    /**
     * Cette méthode génère le contenu de la vue demandée en y injectant les paramètres.
     * @param string $viewPath : le chemin de la vue demandée par le controlleur. 
     * @param array $params : les paramètres que le controlleur a envoyé à la vue.
     * @return string
     */
    private function buildViewPath(string $viewName) : string
    {
        // sécurité + compat PHP < 8 (pas de str_contains)
        $viewName = ltrim($viewName, '/');
        if (strpos($viewName, '..') !== false) {
            throw new RuntimeException('Chemin de vue invalide');
        }

        $path = TEMPLATE_VIEW_PATH . $viewName . '.php';
        if (!file_exists($path)) {
            throw new RuntimeException("Vue introuvable: " . $path);
        }
        return $path;
    }

    /**
     * Cette méthode génère le contenu de la vue demandée en y injectant les paramètres.
     * @param string $viewPath : le chemin de la vue demandée par le controlleur. 
     * @param array $params : les paramètres que le controlleur a envoyé à la vue.
     * @return string
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