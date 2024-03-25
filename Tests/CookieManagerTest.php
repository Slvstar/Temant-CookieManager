<?php

namespace Temant\CookieManager\Tests {
    use PHPUnit\Framework\TestCase;
    use Temant\CookieManager\CookieManager;
    use Temant\CookieManager\SameSiteEnum;

    class CookieManagerTest extends TestCase
    {
        /**
         * Sets up a clean environment before each test.
         */
        protected function setUp(): void
        {
            parent::setUp();
            $_COOKIE = [];
        }

        /**
         * Tests setting a cookie successfully and retrieving its value.
         */
        public function testSetCookieSuccessfully(): void
        {
            $this->assertTrue(CookieManager::set('test', 'value', time() + 3600));
            $_COOKIE['test'] = 'value';
            $this->assertEquals('value', CookieManager::get('test'));
        }

        /**
         * Tests retrieving the value of an existing cookie.
         */
        public function testGetCookieValue(): void
        {
            $_COOKIE['test'] = 'value';
            $this->assertEquals('value', CookieManager::get('test'));
        }

        /**
         * Tests attempting to retrieve a non-existent cookie.
         */
        public function testGetNonExistentCookie(): void
        {
            $this->assertNull(CookieManager::get('nonexistent'));
        }

        /**
         * Tests checking the existence of a cookie that is present.
         */
        public function testHasCookieReturnsTrue(): void
        {
            $_COOKIE['exists'] = 'yes';
            $this->assertTrue(CookieManager::has('exists'));
        }

        /**
         * Tests checking the existence of a cookie that is not present.
         */
        public function testHasCookieReturnsFalse(): void
        {
            $this->assertFalse(CookieManager::has('does_not_exist'));
        }

        /**
         * Tests the deletion of an existing cookie.
         */
        public function testDeleteExistingCookie(): void
        {
            $_COOKIE['delete'] = 'me';
            $this->assertTrue(CookieManager::delete('delete'));
            $this->assertArrayNotHasKey('delete', $_COOKIE);
        }

        /**
         * Tests attempting to delete a non-existent cookie.
         */
        public function testDeleteNonExistentCookie(): void
        {
            $this->assertFalse(CookieManager::delete('nonexistent'));
        }

        /**
         * Tests setting a cookie with various options and ensures they are applied.
         */
        public function testSetCookieWithOptions(): void
        {
            $this->assertTrue(CookieManager::set('options_test', 'value', time() + 3600, '/path', 'domain.com', false, false, SameSiteEnum::Strict));
            $_COOKIE['options_test'] = 'value';
            $this->assertEquals('value', CookieManager::get('options_test'));
        }

        /**
         * Tests listing all cookies and filtering them by a pattern.
         */
        public function testListCookiesWithPattern(): void
        {
            $_COOKIE['test1'] = 'value1';
            $_COOKIE['test2'] = 'value2';
            $_COOKIE['mycookie'] = 'value3';

            $filteredCookies = CookieManager::list('/^test/');
            $this->assertCount(2, $filteredCookies); // Asserting that only 2 cookies match the pattern
            $this->assertArrayHasKey('test1', $filteredCookies);
            $this->assertArrayHasKey('test2', $filteredCookies);
        }

        /**
         * Tests extending the lifetime of an existing cookie.
         */
        public function testExtendCookieLifetime(): void
        {
            $_COOKIE['extend'] = 'value';

            $additionalTime = 3600;
            $this->assertTrue(CookieManager::extendLifetime('extend', $additionalTime));

            $this->assertEquals('value', CookieManager::get('extend'));
        }
    }
}