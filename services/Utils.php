<?php 

namespace App\Services;

class Utils
{
    public static function request(string $key, $default = null) {
        return $_REQUEST[$key] ?? $default;
    }

    public static function isPost(): bool {
        return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
    }

    public static function redirect(string $url): void {
        header("Location: $url");
        exit;
    }

    public static function requireAuth(): int {
        if (empty($_SESSION['user_id'])) {
            self::redirect('index.php?action=login');
        }
        return (int)$_SESSION['user_id'];
    }

    public static function humanDiff(\DateTimeInterface $from, \DateTimeInterface $to): string {
        $diff = $from->diff($to);
        $parts = [];
        if ($diff->y) $parts[] = $diff->y . ' an' . ($diff->y>1?'s':'');
        if ($diff->m) $parts[] = $diff->m . ' mois';
        if ($diff->d && !$diff->y && !$diff->m) $parts[] = $diff->d . ' jour' . ($diff->d>1?'s':'');
        if (!$parts) $parts[] = 'aujourd’hui';
        return implode(' ', $parts);
    }

}