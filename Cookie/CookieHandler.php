<?php

declare(strict_types=1);

/*
 * This file is part of the ConnectHolland CookieConsentBundle package.
 * (c) Connect Holland.
 */

namespace ConnectHolland\CookieConsentBundle\Cookie;

use ConnectHolland\CookieConsentBundle\Enum\CookieNameEnum;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

class CookieHandler
{
    /**
     * @var Response
     */
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * Save chosen cookie categories in cookies.
     */
    public function save(array $categories): void
    {
        $this->saveCookie(CookieNameEnum::COOKIE_CONSENT_NAME, date('r'));

        foreach ($categories as $category => $permitted) {
            $this->saveCookie(CookieNameEnum::getCookieCategoryName($category), $permitted);
        }
    }

    /**
     * Add cookie to response headers.
     */
    protected function saveCookie(string $name, string $value): void
    {
        $this->response->headers->setCookie(
            new Cookie($name, $value, 0, '/', null, null, true, true)
        );
    }
}
