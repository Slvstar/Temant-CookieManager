<?php declare(strict_types=1);

namespace Temant\CookieManager {
    /**
     * Enum for SameSite cookie attribute values.
     * 
     * Specifies the cookie's SameSite attribute, providing control over cookie 
     * sending behavior with cross-site requests. This helps mitigate CSRF attacks.
     */
    enum SameSiteEnum: string
    {
        /**
         * Lax: Cookies are not sent on normal cross-site subrequests (e.g., loading images),
         * but are sent when a user is navigating to the origin site (i.e., when following a link).
         */
        case Lax = 'Lax';

        /**
         * Strict: Cookies will only be sent in a first-party context and not be sent along with 
         * requests initiated by third-party websites.
         */
        case Strict = 'Strict';

        /**
         * None: Cookies will be sent in all contexts, i.e., in responses to both first-party 
         * and cross-origin requests. If `SameSite=None` is set, the cookie `Secure` attribute 
         * must also be set (or the cookie will be blocked).
         */
        case None = 'None';
    }
}