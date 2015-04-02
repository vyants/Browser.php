<?php
/**
 * @covers Browser
 */
class BrowserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param $user_agent
     * @param $expected_browser
     * @param $expected_version
     *
     * @dataProvider dpUserAgents
     */
    public function testBrowserDetectedCorrectly($user_agent, $expected_browser, $expected_version)
    {
        $browser = new Browser($user_agent);
        $this->assertEquals($expected_browser, $browser->getBrowser());
        $this->assertEquals($expected_version, $browser->getVersion());
    }

    public function dpUserAgents()
    {
        return array(
            // Amaya
            array("amaya/11.3.1 libwww/5.4.1", Browser::BROWSER_AMAYA, '11.3.1'),
            array("amaya/11.2 libwww/5.4.0", Browser::BROWSER_AMAYA, '11.2'),
            array("amaya/11.1 libwww/5.4.0", Browser::BROWSER_AMAYA, '11.1'),
            array("amaya/10.1 libwww/5.4.0", Browser::BROWSER_AMAYA, '10.1'),
            array("amaya/10 libwww/5.4.0", Browser::BROWSER_AMAYA, '10'),
            array("amaya/9.55 libwww/5.4.0", Browser::BROWSER_AMAYA, '9.55'),
            array("amaya/9.54 libwww/5.4.0", Browser::BROWSER_AMAYA, '9.54'),
            array("amaya/9.52 libwww/5.4.0", Browser::BROWSER_AMAYA, '9.52'),
            array("amaya/9.51 libwww/5.4.0", Browser::BROWSER_AMAYA, '9.51'),
            array("amaya/8.8.5 libwww/5.4.0", Browser::BROWSER_AMAYA, '8.8.5'),
            array("amaya/11.2 amaya/5.4.0", Browser::BROWSER_AMAYA, '5.4.0'),
            array("amaya/11.1 amaya/5.4.0", Browser::BROWSER_AMAYA, '5.4.0'),
            // Android
            array("Mozilla/5.0 (Linux; U; Android 4.0.3; ko-kr; LG-L160L Build/IML74K) AppleWebkit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30", Browser::BROWSER_ANDROID, '4.0.3'),
            array("Mozilla/5.0 (Linux; U; Android 4.0.3; de-ch; HTC Sensation Build/IML74K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30", Browser::BROWSER_ANDROID, '4.0.3'),
            array("Mozilla/5.0 (Linux; U; Android 2.3; en-us) AppleWebKit/999+ (KHTML, like Gecko) Safari/999.9", Browser::BROWSER_ANDROID, '2.3'),
            array("Mozilla/5.0 (Linux; U; Android 2.3.5; zh-cn; HTC_IncredibleS_S710e Build/GRJ90) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1", Browser::BROWSER_ANDROID, '2.3.5'),
            array("Mozilla/5.0 (Linux; U; Android 2.3.5; en-us; HTC Vision Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1", Browser::BROWSER_ANDROID, '2.3.5'),
            array("Mozilla/5.0 (Linux; U; Android 2.3.4; fr-fr; HTC Desire Build/GRJ22) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1", Browser::BROWSER_ANDROID, '2.3.4'),
            array("Mozilla/5.0 (Linux; U; Android 2.3.4; en-us; T-Mobile myTouch 3G Slide Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1", Browser::BROWSER_ANDROID, '2.3.4'),
            array("Mozilla/5.0 (Linux; U; Android 2.3.3; zh-tw; HTC_Pyramid Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1", Browser::BROWSER_ANDROID, '2.3.3'),
            array("Mozilla/5.0 (Linux; U; Android 2.3.3; zh-tw; HTC_Pyramid Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari", Browser::BROWSER_ANDROID, '2.3.3'),
            array("Mozilla/5.0 (Linux; U; Android 2.3.3; zh-tw; HTC Pyramid Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1", Browser::BROWSER_ANDROID, '2.3.3'),
            array("Mozilla/5.0 (Linux; U; Android 2.3.3; ko-kr; LG-LU3000 Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1", Browser::BROWSER_ANDROID, '2.3.3'),
            array("Mozilla/5.0 (Linux; U; Android 2.3.3; en-us; HTC_DesireS_S510e Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1", Browser::BROWSER_ANDROID, '2.3.3'),
            array("Mozilla/5.0 (Linux; U; Android 2.3.3; en-us; HTC_DesireS_S510e Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile", Browser::BROWSER_ANDROID, '2.3.3'),
            array("Mozilla/5.0 (Linux; U; Android 2.3.3; de-de; HTC Desire Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1", Browser::BROWSER_ANDROID, '2.3.3'),
            array("Mozilla/5.0 (Linux; U; Android 2.3.3; de-ch; HTC Desire Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1", Browser::BROWSER_ANDROID, '2.3.3'),
            array("Mozilla/5.0 (Linux; U; Android 2.2; fr-lu; HTC Legend Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1", Browser::BROWSER_ANDROID, '2.2'),
            array("Mozilla/5.0 (Linux; U; Android 2.2; en-sa; HTC_DesireHD_A9191 Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1", Browser::BROWSER_ANDROID, '2.2'),
            array("Mozilla/5.0 (Linux; U; Android 2.2.1; fr-fr; HTC_DesireZ_A7272 Build/FRG83D) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1", Browser::BROWSER_ANDROID, '2.2.1'),
            array("Mozilla/5.0 (Linux; U; Android 2.2.1; en-gb; HTC_DesireZ_A7272 Build/FRG83D) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1", Browser::BROWSER_ANDROID, '2.2.1'),
            array("Mozilla/5.0 (Linux; U; Android 2.2.1; en-ca; LG-P505R Build/FRG83) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1", Browser::BROWSER_ANDROID, '2.2.1'),
            // Bing Bot
            array("Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)", Browser::BROWSER_BINGBOT, '2.0'),
            array("Mozilla/5.0 (compatible; bingbot/2.0 +http://www.bing.com/bingbot.htm)", Browser::BROWSER_BINGBOT, '2.0'),
            // BlackBerry
            array("Mozilla/5.0 (BlackBerry; U; BlackBerry 9900; en) AppleWebKit/534.11+ (KHTML, like Gecko) Version/7.1.0.346 Mobile Safari/534.11+", Browser::BROWSER_BLACKBERRY, '534.11'),
            array("Mozilla/5.0 (BlackBerry; U; BlackBerry 9860; en-US) AppleWebKit/534.11+ (KHTML, like Gecko) Version/7.0.0.254 Mobile Safari/534.11+", Browser::BROWSER_BLACKBERRY, '534.11'),
            array("Mozilla/5.0 (BlackBerry; U; BlackBerry 9850; en-US) AppleWebKit/534.11+ (KHTML, like Gecko) Version/7.0.0.254 Mobile Safari/534.11+", Browser::BROWSER_BLACKBERRY, '534.11'),
            array("Mozilla/5.0 (BlackBerry; U; BlackBerry 9850; en-US) AppleWebKit/534.11+ (KHTML, like Gecko) Version/7.0.0.115 Mobile Safari/534.11+", Browser::BROWSER_BLACKBERRY, '534.11'),
            array("Mozilla/5.0 (BlackBerry; U; BlackBerry 9850; en) AppleWebKit/534.11+ (KHTML, like Gecko) Version/7.0.0.254 Mobile Safari/534.11+", Browser::BROWSER_BLACKBERRY, '534.11'),
            array("Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; zh-TW) AppleWebKit/534.8+ (KHTML, like Gecko) Version/6.0.0.448 Mobile Safari/534.8+", Browser::BROWSER_BLACKBERRY, '534.8'),
            array("Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; zh-TW) AppleWebKit/534.1+ (KHTML, like Gecko) Version/6.0.0.246 Mobile Safari/534.1+", Browser::BROWSER_BLACKBERRY, '534.1'),
            array("Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; tr) AppleWebKit/534.1+ (KHTML, like Gecko) Version/6.0.0.246 Mobile Safari/534.1+", Browser::BROWSER_BLACKBERRY, '534.1'),
            array("Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; it) AppleWebKit/534.8+ (KHTML, like Gecko) Version/6.0.0.668 Mobile Safari/534.8+", Browser::BROWSER_BLACKBERRY, '534.8'),
            array("Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; fr) AppleWebKit/534.1+ (KHTML, like Gecko) Version/6.0.0.246 Mobile Safari/534.1+", Browser::BROWSER_BLACKBERRY, '534.1'),
            array("Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; en-US) AppleWebKit/534.8+ (KHTML, like Gecko) Version/6.0.0.701 Mobile Safari/534.8+", Browser::BROWSER_BLACKBERRY, '534.8'),
            array("Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; en-US) AppleWebKit/534.8+ (KHTML, like Gecko) Version/6.0.0.466 Mobile Safari/534.8+", Browser::BROWSER_BLACKBERRY, '534.8'),
            array("Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; en-US) AppleWebKit/534.8+ (KHTML, like Gecko) Version/6.0.0.450 Mobile Safari/534.8+", Browser::BROWSER_BLACKBERRY, '534.8'),
            array("Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; en-US) AppleWebKit/534.8+ (KHTML, like Gecko) Version/6.0.0.448 Mobile Safari/534.8+", Browser::BROWSER_BLACKBERRY, '534.8'),
            array("Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; en-US) AppleWebKit/534.8+ (KHTML, like Gecko) Version/6.0.0.446 Mobile Safari/534.8+", Browser::BROWSER_BLACKBERRY, '534.8'),
            array("Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; en-US) AppleWebKit/534.1+ (KHTML, like Gecko) Version/6.0.0.201 Mobile Safari/534.1+", Browser::BROWSER_BLACKBERRY, '534.1'),
            array("Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; en-US) AppleWebKit/534.1+ (KHTML, like Gecko)", Browser::BROWSER_BLACKBERRY, '534.1'),
            array("Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; en-GB) AppleWebKit/534.1+ (KHTML, like Gecko) Version/6.0.0.337 Mobile Safari/534.1+", Browser::BROWSER_BLACKBERRY, '534.1'),
            array("Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; en) AppleWebKit/534.8+ (KHTML, like Gecko) Version/6.0.0.448 Mobile Safari/534.8+", Browser::BROWSER_BLACKBERRY, '534.8'),
            array("Mozilla/5.0 (BlackBerry; U; BlackBerry 9700; pt) AppleWebKit/534.8+ (KHTML, like Gecko) Version/6.0.0.546 Mobile Safari/534.8+", Browser::BROWSER_BLACKBERRY, '534.8'),
            // Chrome
            array("Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36", Browser::BROWSER_CHROME, '41.0.2228.0'),
            array("Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2227.1 Safari/537.36", Browser::BROWSER_CHROME, '41.0.2227.1'),
            array("Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2227.0 Safari/537.36", Browser::BROWSER_CHROME, '41.0.2227.0'),
            array("Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2227.0 Safari/537.36", Browser::BROWSER_CHROME, '41.0.2227.0'),
            array("Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2226.0 Safari/537.36", Browser::BROWSER_CHROME, '41.0.2226.0'),
            array("Mozilla/5.0 (Windows NT 6.4; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2225.0 Safari/537.36", Browser::BROWSER_CHROME, '41.0.2225.0'),
            array("Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2225.0 Safari/537.36", Browser::BROWSER_CHROME, '41.0.2225.0'),
            array("Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2224.3 Safari/537.36", Browser::BROWSER_CHROME, '41.0.2224.3'),
            array("Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36", Browser::BROWSER_CHROME, '37.0.2062.124'),
            array("Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2049.0 Safari/537.36", Browser::BROWSER_CHROME, '37.0.2049.0'),
            array("Mozilla/5.0 (Windows NT 4.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2049.0 Safari/537.36", Browser::BROWSER_CHROME, '37.0.2049.0'),
            array("Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.67 Safari/537.36", Browser::BROWSER_CHROME, '36.0.1985.67'),
            array("Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.67 Safari/537.36", Browser::BROWSER_CHROME, '36.0.1985.67'),
            array("Mozilla/5.0 (X11; OpenBSD i386) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36", Browser::BROWSER_CHROME, '36.0.1985.125'),
            array("Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1944.0 Safari/537.36", Browser::BROWSER_CHROME, '36.0.1944.0'),
            array("Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.3319.102 Safari/537.36", Browser::BROWSER_CHROME, '35.0.3319.102'),
            array("Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.2309.372 Safari/537.36", Browser::BROWSER_CHROME, '35.0.2309.372'),
            array("Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.2117.157 Safari/537.36", Browser::BROWSER_CHROME, '35.0.2117.157'),
            array("Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.47 Safari/537.36", Browser::BROWSER_CHROME, '35.0.1916.47'),
            array("Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1866.237 Safari/537.36", Browser::BROWSER_CHROME, '34.0.1866.237'),
            array("Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.137 Safari/4E423F", Browser::BROWSER_CHROME, '34.0.1847.137'),
            array("Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.116 Safari/537.36 Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.10", Browser::BROWSER_CHROME, '34.0.1847.116'),
            array("Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.517 Safari/537.36", Browser::BROWSER_CHROME, '33.0.1750.517'),
            array("Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1667.0 Safari/537.36", Browser::BROWSER_CHROME, '32.0.1667.0'),
            array("Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1664.3 Safari/537.36", Browser::BROWSER_CHROME, '32.0.1664.3'),
            array("Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1664.3 Safari/537.36", Browser::BROWSER_CHROME, '32.0.1664.3'),
            array("Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.16 Safari/537.36", Browser::BROWSER_CHROME, '31.0.1650.16'),
            array("Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1623.0 Safari/537.36", Browser::BROWSER_CHROME, '31.0.1623.0'),
            array("Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.17 Safari/537.36", Browser::BROWSER_CHROME, '30.0.1599.17'),
            // Curl
            array("curl/7.9.8 (i686-pc-linux-gnu) libcurl 7.9.8 (OpenSSL 0.9.6b) (ipv6 enabled)", Browser::BROWSER_CURL, '7.9.8'),
            array("curl/7.8 (i386-redhat-linux-gnu) libcurl 7.8 (OpenSSL 0.9.6b) (ipv6 enabled)", Browser::BROWSER_CURL, '7.8'),
            array("curl/7.7.x (i386--freebsd4.3) libcurl 7.7.x (SSL 0.9.6) (ipv6 enabled)", Browser::BROWSER_CURL, '7.7.x'),
            array("curl/7.7.2 (powerpc-apple-darwin6.0) libcurl 7.7.2 (OpenSSL 0.9.6b)", Browser::BROWSER_CURL, '7.7.2'),
            array("curl/7.21.4 (universal-apple-darwin11.0) libcurl/7.21.4 OpenSSL/0.9.8r zlib/1.2.5", Browser::BROWSER_CURL, '7.21.4'),
            array("curl/7.21.3 (x86_64-unknown-linux-gnu) libcurl/7.21.3 OpenSSL/1.0.0c zlib/1.2.5", Browser::BROWSER_CURL, '7.21.3'),
            array("curl/7.21.3 (x86_64-redhat-linux-gnu) libcurl/7.21.3 NSS/3.13.1.0 zlib/1.2.5 libidn/1.19 libssh2/1.2.7", Browser::BROWSER_CURL, '7.21.3'),
            array("curl/7.21.2 (i386-pc-win32) libcurl/7.21.2 OpenSSL/0.9.8o zlib/1.2.5", Browser::BROWSER_CURL, '7.21.2'),
            array("curl/7.21.1 (i686-pc-linux-gnu) libcurl/7.21.1 OpenSSL/1.0.0a zlib/1.2.5", Browser::BROWSER_CURL, '7.21.1'),
            array("curl/7.21.0 (x86_64-pc-linux-gnu) libcurl/7.21.0 OpenSSL/0.9.8o zlib/1.2.3.4 libidn/1.18 libssh2/1.2.5", Browser::BROWSER_CURL, '7.21.0'),
            array("curl/7.21.0 (x86_64-pc-linux-gnu) libcurl/7.21.0 OpenSSL/0.9.8o zlib/1.2.3.4 libidn/1.18", Browser::BROWSER_CURL, '7.21.0'),
            array("curl/7.21.0 (x86_64-pc-linux-gnu) libcurl/7.21.0 OpenSSL/0.9.8o zlib/1.2.3.4 libidn/1.15 libssh2/1.2.5", Browser::BROWSER_CURL, '7.21.0'),
            array("curl/7.21.0 (x86_64-apple-darwin10.2.0) libcurl/7.21.0 OpenSSL/1.0.0a zlib/1.2.5 libidn/1.19", Browser::BROWSER_CURL, '7.21.0'),
            array("curl/7.21.0 (i686-pc-linux-gnu) libcurl/7.21.0 OpenSSL/0.9.8o zlib/1.2.3.4 libidn/1.18", Browser::BROWSER_CURL, '7.21.0'),
            array("curl/7.21.0 (i486-pc-linux-gnu) libcurl/7.21.0 OpenSSL/0.9.8o zlib/1.2.3.4 libidn/1.18 libssh2/1.2.6", Browser::BROWSER_CURL, '7.21.0'),
            array("curl/7.20.0 (i686-pc-linux-gnu) libcurl/7.20.0 OpenSSL/0.9.8n zlib/1.2.4", Browser::BROWSER_CURL, '7.20.0'),
            array("curl/7.20.0 (i386-apple-darwin9.8.0) libcurl/7.20.0 OpenSSL/0.9.8m zlib/1.2.3 libidn/1.16", Browser::BROWSER_CURL, '7.20.0'),
            // FireBird
            array("Mozilla/5.0 (Windows; U; Windows NT 6.1; x64; fr; rv:1.9.2.13) Gecko/20101203 Firebird/3.6.13", Browser::BROWSER_FIREBIRD, '3.6.13'),
            array("Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.6b) Gecko/20031212 Firebird/0.8", Browser::BROWSER_FIREBIRD, '0.8'),
            array("Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.6a) Gecko/20031002 Firebird/0.7", Browser::BROWSER_FIREBIRD, '0.7'),
            array("Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.5) Gecko/20031007 Firebird/0.7", Browser::BROWSER_FIREBIRD, '0.7'),
            array("Mozilla/5.0 (Windows; U; Windows NT 5.1; de-DE; rv:1.5) Gecko/20031007 Firebird/0.7", Browser::BROWSER_FIREBIRD, '0.7'),
            array("Mozilla/5.0 (Windows; U; Win98; en-US; rv:1.5) Gecko/20031007 Firebird/0.7", Browser::BROWSER_FIREBIRD, '0.7'),
            array("Mozilla/5.0 (Windows; U; Win95; en-US; rv:1.5) Gecko/20031007 Firebird/0.7", Browser::BROWSER_FIREBIRD, '0.7'),
            array("Mozilla/5.0 (Macintosh; U; PPC Mac OS X Mach-O; en-US; rv:1.5) Gecko/20031026 Firebird/0.7", Browser::BROWSER_FIREBIRD, '0.7'),
            array("Mozilla/5.0 (X11; U; SunOS sun4u; en-US; rv:1.5a) Gecko/20030729 Mozilla Firebird/0.6.1", Browser::BROWSER_FIREBIRD, '0.6.1'),
            array("Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.5a) Gecko/20030728 Mozilla Firebird/0.6.1", Browser::BROWSER_FIREBIRD, '0.6.1'),
            array("Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.5a) Gecko/20030728 Mozilla Firebird/0.6.1", Browser::BROWSER_FIREBIRD, '0.6.1'),
            array("Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.5b) Gecko/20030819 Mozilla Firebird/0.6.1", Browser::BROWSER_FIREBIRD, '0.6.1'),
            array("Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.5a) Gecko/20030728 Mozilla Firebird/0.6.1", Browser::BROWSER_FIREBIRD, '0.6.1'),
            array("Mozilla/5.0 (Windows; U; Windows NT 5.1; de-DE; rv:1.5a) Gecko/20030728 Mozilla Firebird/0.6.1", Browser::BROWSER_FIREBIRD, '0.6.1'),
            array("Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.5a) Gecko/20030728 Mozilla Firebird/0.6.1", Browser::BROWSER_FIREBIRD, '0.6.1'),
            array("Mozilla/5.0 (Windows; U; Windows NT 5.0; de-DE; rv:1.5a) Gecko/20030728 Mozilla Firebird/0.6.1", Browser::BROWSER_FIREBIRD, '0.6.1'),
            array("Mozilla/5.0 (Windows; U; Win98; de-DE; rv:1.5a) Gecko/20030728 Mozilla Firebird/0.6.1", Browser::BROWSER_FIREBIRD, '0.6.1'),
            array("Mozilla/5.0 (X11; U; SunOS sun4u; en-US; rv:1.4b) Gecko/20030517 Mozilla Firebird/0.6", Browser::BROWSER_FIREBIRD, '0.6'),
            array("Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.4b) Gecko/20030630 Mozilla Firebird/0.6", Browser::BROWSER_FIREBIRD, '0.6'),
            array("Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.4b) Gecko/20030607 Mozilla Firebird/0.6", Browser::BROWSER_FIREBIRD, '0.6'),
            array("Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.4b) Gecko/20030516 Mozilla Firebird/0.6", Browser::BROWSER_FIREBIRD, '0.6'),
            array("Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.4b) Gecko/20030505 Mozilla Firebird/0.6", Browser::BROWSER_FIREBIRD, '0.6'),
            array("Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.4a) Gecko/20030425 Mozilla Firebird/0.6", Browser::BROWSER_FIREBIRD, '0.6'),
            array("Mozilla/5.0 (Windows; U; WinNT4.0; en-US; rv:1.4b) Gecko/20030610 Mozilla Firebird/0.6", Browser::BROWSER_FIREBIRD, '0.6'),
            array("Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:x.xx) Gecko/20030504 Mozilla Firebird/0.6", Browser::BROWSER_FIREBIRD, '0.6'),
            array("Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.5a) Gecko/20030702 Mozilla Firebird/0.6", Browser::BROWSER_FIREBIRD, '0.6'),
            array("Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.5a) Gecko/20030630 Mozilla Firebird/0.6", Browser::BROWSER_FIREBIRD, '0.6'),
            array("Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.4b) Gecko/20030615 Mozilla Firebird/0.6", Browser::BROWSER_FIREBIRD, '0.6'),
            array("Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.4b) Gecko/20030516 Mozilla Firebird/0.6", Browser::BROWSER_FIREBIRD, '0.6'),
            array("Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.4b) Gecko/20030503 Mozilla Firebird/0.6", Browser::BROWSER_FIREBIRD, '0.6'),
            array("Mozilla/5.0 (Windows; U; Windows NT 5.1; de-DE; rv:1.4b) Gecko/20030516 Mozilla Firebird/0.6", Browser::BROWSER_FIREBIRD, '0.6'),
            array("Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4b) Gecko/20030516 Mozilla Firebird/0.6", Browser::BROWSER_FIREBIRD, '0.6'),
            array("Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4b) Gecko/20030514 Mozilla Firebird/0.6", Browser::BROWSER_FIREBIRD, '0.6'),
            array("Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4b) Gecko/20030504 Mozilla Firebird/0.6", Browser::BROWSER_FIREBIRD, '0.6'),
            array("Mozilla/5.0 (Windows; U; Windows NT 5.0; de-DE; rv:1.4b) Gecko/20030516 Mozilla Firebird/0.6", Browser::BROWSER_FIREBIRD, '0.6'),
            array("Mozilla/5.0 (Windows; U; Win98; en-US; rv:1.4b) Gecko/20030516 Mozilla Firebird/0.6", Browser::BROWSER_FIREBIRD, '0.6'),
            array("Mozilla/5.0 (Windows; U; Win98; de-DE; rv:1.4b) Gecko/20030516 Mozilla Firebird/0.6", Browser::BROWSER_FIREBIRD, '0.6'),


            array("Wget/1.16 (darwin14.0.0)", Browser::BROWSER_WGET, '1.16'),
            

            //array("Mozilla", Browser::BROWSER_CHROME, '2228'),
        );
    }
}
