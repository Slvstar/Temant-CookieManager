<?php declare(strict_types=1);

namespace Temant\CookieManager {
    /**
     * Cookie Management Interface
     *
     * Defines the contract for cookie management functionalities, ensuring consistency and reliability
     * in handling cookies across different implementations.
     */
    interface CookieManagerInterface
    {
        /**
         * Sets a cookie with enhanced options.
         * 
         * @param string $name Name of the cookie.
         * @param string $value Cookie value.
         * @param int $expires Expiration time (Unix timestamp); 0 indicates a session cookie.
         * @param string $path Path where the cookie is accessible; default is '/' for entire domain.
         * @param string $domain Domain scope for the cookie; prefix with '.' for subdomains.
         * @param bool $secure Set true to transmit cookie over HTTPS only.
         * @param bool $httponly Set true to make cookie HTTP-only, mitigating XSS risk.
         * @param SameSiteEnum $samesite Sets SameSite policy: 'None', 'Lax', or 'Strict'.
         *
         * @return bool True on success, false on failure.
         */
        public static function set(
            string $name,
            string $value,
            int $expires = 0,
            string $path = '/',
            string $domain = '',
            bool $secure = true,
            bool $httponly = true,
            SameSiteEnum $samesite = SameSiteEnum::Lax
        ): bool;

        /**
         * Retrieves the value of a specified cookie.
         * 
         * @param string $name The name of the cookie.
         *
         * @return ?string The value of the cookie if set; otherwise, NULL.
         */
        public static function get(string $name): ?string;

        /**
         * Checks whether a specified cookie exists.
         * 
         * @param string $name The name of the cookie to check.
         *
         * @return bool TRUE if the cookie exists, otherwise FALSE.
         */
        public static function has(string $name): bool;

        /**
         * Deletes a specified cookie by setting its expiration time in the past.
         * 
         * @param string $name The name of the cookie to delete.
         *
         * @return bool TRUE on successful deletion, FALSE if the cookie doesn't exist.
         */
        public static function delete(string $name): bool;

        /**
         * Lists all available cookies or those matching a specified pattern.
         *
         * @param string $pattern (Optional) Pattern to match cookie names against.
         *
         * @return string[] Associative array of cookies where keys are cookie names and values are cookie values.
         */
        public static function list(string $pattern = ''): array;

        /**
         * Extends the expiration time of an existing cookie.
         *
         * @param string $name Name of the cookie.
         * @param int $additionalTime Additional time in seconds to extend the cookie's life.
         *
         * @return bool True on success, false on failure or if the cookie doesn't exist.
         */
        public static function extendLifetime(string $name, int $additionalTime): bool;
    }
}