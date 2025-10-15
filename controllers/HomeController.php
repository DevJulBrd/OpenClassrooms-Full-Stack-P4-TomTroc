<?php
class HomeController
{
    public function showHome(): void
    {
        $view = new View('TomTroc');
        $view->render('home', []);
    }
}
