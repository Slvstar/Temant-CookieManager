<?php declare(strict_types=1);

namespace Temant\CookieManager {
    use DateTime;
    use DateInterval;

    /**
     * Cookie Management Utility Class
     *
     * Offers a comprehensive suite of methods to facilitate the handling of HTTP cookies in a secure and efficient manner. 
     * This class abstracts away the complexities associated with cookie management, providing straightforward functionalities 
     * to set, get, check the existence of, and delete cookies with various security options including HttpOnly and Secure flags, 
     * as well as support for the SameSite attribute to enhance protection against Cross-Site Request Forgery (CSRF) attacks.
     *
     * Key Features:
     * - Easy setting of cookies with extensive options for path, domain, security, and more.
     * - Secure retrieval of cookie values, mitigating the risk of unauthorized access.
     * - Utility functions to check the existence of cookies and delete them, enhancing control over client-side storage.
     * - Implementation of modern best practices for cookie security, including default support for Secure, HttpOnly, and SameSite attributes.
     *
     * Usage:
     * The class provides static methods that can be invoked without needing to instantiate the class, simplifying its usage in various contexts
     * within a PHP application. Whether managing user sessions, storing temporary data, or implementing remember-me functionalities,
     * this utility class serves as a robust foundation for cookie-related operations.
     */
    final class CookieManager implements CookieManagerInterface
    {
        /**
         * @inheritDoc
         */
        public static function set(string $name, string $value, int $expires = 0, string $path = '/', string $domain = '', bool $secure = true, bool $httponly = true, SameSiteEnum $samesite = SameSiteEnum::Lax): bool
        {
            $options = [
                'expires' => $expires,
                'path' => $path,
                'domain' => $domain,
                'secure' => $secure,
                'httponly' => $httponly,
                'samesite' => $samesite->value
            ];
            return setcookie($name, $value, $options);
        }

        /**
         * @inheritDoc
         */
        public static function get(string $name): ?string
        {
            return $_COOKIE[$name] ?? null;
        }

        /**
         * @inheritDoc
         */
        public static function has(string $name): bool
        {
            return isset ($_COOKIE[$name]);
        }

        /**
         * @inheritDoc
         */
        public static function delete(
            string $name,
            string $path = '/',
            string $domain = '',
            bool $secure = true,
            bool $httponly = true,
            SameSiteEnum $samesite = SameSiteEnum::Lax
        ): bool {
            if (self::has($name)) {
                $options = [
                    'expires' => time() - 3600,
                    'path' => $path,
                    'domain' => $domain,
                    'secure' => $secure,
                    'httponly' => $httponly,
                    'samesite' => $samesite->value
                ];
                setcookie($name, '', $options);
                unset($_COOKIE[$name]);
                return true;
            }
            return false;
        }

        /**
         * @inheritDoc
         */
        public static function list(string $pattern = ''): array
        {
            $cookiesList = [];
            foreach ($_COOKIE as $name => $value) {
                if (empty ($pattern) || preg_match($pattern, $name)) {
                    $cookiesList[$name] = $value;
                }
            }
            return $cookiesList;
        }

        /**
         * @inheritDoc
         */
        public static function extendLifetime(string $name, int $additionalTime): bool
        {
            if (self::has($name)) {
                $value = (string) self::get($name);

                $expires = (new DateTime())
                    ->add(new DateInterval("PT{$additionalTime}S"))
                    ->getTimestamp();

                return self::set($name, $value, $expires);
            }
            return false;
        }
    }
}