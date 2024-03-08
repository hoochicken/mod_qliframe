<?php

defined('_JEXEC') or die;

class ModQliframeCachier
{

    const SESSION_KEY_QLIFRAME = 'qliframeCache';

    public static function memorize(string $url)
    {
        $domain = static::getDomain($url);
        static::initSession();
        static::setUrlInSession($domain);
    }

    public static function forget(string $url = '')
    {
        static::resetSession($url);
    }

    private static function resetSession()
    {
        $_SESSION[static::SESSION_KEY_QLIFRAME] = [];
    }

    private static function setUrlInSession($key, $value = true)
    {
        static::initSession();
        $_SESSION[static::SESSION_KEY_QLIFRAME][$key] = $value;
    }

    public static function isAlreadyMemorized(string $url)
    {
        $domain = static::getDomain($url);
        return isset($_SESSION[ModQliframeCachier::SESSION_KEY_QLIFRAME]) && isset($_SESSION[ModQliframeCachier::SESSION_KEY_QLIFRAME][$domain]);
    }

    private static function getDomain(string $url)
    {
        $parts = parse_url($url);
        return sprintf('%s://%s', $parts['scheme'] ?? '', $parts['host'] ?? '');
    }

    private static function initSession()
    {
        if (isset($_SESSION[static::SESSION_KEY_QLIFRAME])) {
            return;
        }
        static::resetSession();
    }
}