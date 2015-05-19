<?php

/**
 * File: Browser.php
 * Author: Chris Schuld (http://chrisschuld.com/)
 * Last Modified: July 4th, 2014
 *
 * @version 2.0.0
 * @package PegasusPHP
 *
 * Copyright (C) 2008-2010 Chris Schuld  (chris@chrisschuld.com)
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of
 * the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details at:
 * http://www.gnu.org/copyleft/gpl.html
 *
 *
 * Typical Usage:
 *
 *   $browser = new Browser();
 *   if( $browser->getBrowser() == Browser::BROWSER_FIREFOX && $browser->getVersion() >= 2 ) {
 *    echo 'You have FireFox version 2 or greater';
 *   }
 *
 * User Agents Sampled from: http://www.useragentstring.com/
 *
 * This implementation is based on the original work from Gary White
 * http://apptools.com/phptools/browser/
 */

namespace MASNathan\Browser;

use Gemabit\String\String;

class Browser
{
    protected $userAgent;
    protected $originalUserAgentString;
    protected $browserName     = self::BROWSER_UNKNOWN;
    protected $browserVersion  = self::VERSION_UNKNOWN;
    protected $aolVersion      = self::VERSION_UNKNOWN;
    protected $platform        = self::PLATFORM_UNKNOWN;
    protected $operatingSystem = self::OPERATING_SYSTEM_UNKNOWN;
    protected $isAol      = false;
    protected $isMobile   = false;
    protected $isTablet   = false;
    protected $isRobot    = false;
    protected $isFacebook = false;

    const BROWSER_UNKNOWN          = 'unknown';
    const VERSION_UNKNOWN          = 'unknown';
    const PLATFORM_UNKNOWN         = 'unknown';
    const OPERATING_SYSTEM_UNKNOWN = 'unknown';

    const BROWSER_AMAYA        = 'Amaya'; // http://www.w3.org/Amaya/
    const BROWSER_ANDROID      = 'Android'; // http://www.android.com/
    const BROWSER_BINGBOT      = 'Bing Bot'; // http://en.wikipedia.org/wiki/Bingbot
    const BROWSER_BLACKBERRY   = 'BlackBerry'; // http://www.blackberry.com/
    const BROWSER_CHROME       = 'Chrome'; // http://www.google.com/chrome
    const BROWSER_CURL         = 'cURL'; // https://en.wikipedia.org/wiki/CURL
    const BROWSER_FIREBIRD     = 'Firebird'; // http://www.ibphoenix.com/
    const BROWSER_FIREFOX      = 'Firefox'; // http://www.mozilla.com/en-US/firefox/firefox.html
    const BROWSER_GALEON       = 'Galeon'; // http://galeon.sourceforge.net/ (DEPRECATED)
    const BROWSER_GOOGLEBOT    = 'GoogleBot'; // http://en.wikipedia.org/wiki/Googlebot
    const BROWSER_ICAB         = 'iCab'; // http://www.icab.de/
    const BROWSER_ICECAT       = 'IceCat'; // http://en.wikipedia.org/wiki/GNU_IceCat
    const BROWSER_ICEWEASEL    = 'Iceweasel'; // http://www.geticeweasel.org/
    const BROWSER_IE           = 'Internet Explorer'; // http://www.microsoft.com/ie/
    const BROWSER_IPAD         = 'iPad'; // http://apple.com
    const BROWSER_IPHONE       = 'iPhone'; // http://apple.com
    const BROWSER_IPOD         = 'iPod'; // http://apple.com
    const BROWSER_KONQUEROR    = 'Konqueror'; // http://www.konqueror.org/
    const BROWSER_LYNX         = 'Lynx'; // http://en.wikipedia.org/wiki/Lynx
    const BROWSER_MOZILLA      = 'Mozilla'; // http://www.mozilla.com/en-US/
    const BROWSER_MSN          = 'MSN Browser'; // http://explorer.msn.com/
    const BROWSER_MSNBOT       = 'MSN Bot'; // http://search.msn.com/msnbot.htm
    const BROWSER_NETPOSITIVE  = 'NetPositive'; // http://en.wikipedia.org/wiki/NetPositive (DEPRECATED)
    const BROWSER_NETSCAPE_NAVIGATOR = 'Netscape Navigator'; // http://browser.netscape.com/ (DEPRECATED)
    const BROWSER_NOKIA        = 'Nokia Browser'; // * all other WAP-based browsers on the Nokia Platform
    const BROWSER_NOKIA_S60    = 'Nokia S60 OSS Browser'; // http://en.wikipedia.org/wiki/Web_Browser_for_S60
    const BROWSER_OMNIWEB      = 'OmniWeb'; // http://www.omnigroup.com/applications/omniweb/
    const BROWSER_OPERA        = 'Opera'; // http://www.opera.com/
    const BROWSER_OPERA_MINI   = 'Opera Mini'; // http://www.opera.com/mini/
    const BROWSER_PHOENIX      = 'Phoenix'; // http://en.wikipedia.org/wiki/History_of_Mozilla_Firefox (DEPRECATED)
    const BROWSER_POCKET_IE    = 'Pocket Internet Explorer'; // http://en.wikipedia.org/wiki/Internet_Explorer_Mobile
    const BROWSER_SAFARI       = 'Safari'; // http://apple.com
    const BROWSER_SHIRETOKO    = 'Shiretoko'; // http://wiki.mozilla.org/Projects/shiretoko
    const BROWSER_SLURP        = 'Yahoo! Slurp'; // http://en.wikipedia.org/wiki/Yahoo!_Slurp
    const BROWSER_W3CVALIDATOR = 'W3C Validator'; // http://validator.w3.org/
    const BROWSER_WEBTV        = 'WebTV'; // http://www.webtv.net/pc/
    const BROWSER_WGET         = 'Wget'; // https://en.wikipedia.org/wiki/Wget

    const PLATFORM_ANDROID     = 'Android';
    const PLATFORM_APPLE       = 'Apple';
    const PLATFORM_BEOS        = 'BeOS';
    const PLATFORM_BLACKBERRY  = 'BlackBerry';
    const PLATFORM_FREEBSD     = 'FreeBSD';
    const PLATFORM_IPAD        = 'iPad';
    const PLATFORM_IPHONE      = 'iPhone';
    const PLATFORM_IPOD        = 'iPod';
    const PLATFORM_LINUX       = 'Linux';
    const PLATFORM_NETBSD      = 'NetBSD';
    const PLATFORM_NOKIA       = 'Nokia';
    const PLATFORM_OPENBSD     = 'OpenBSD';
    const PLATFORM_OPENSOLARIS = 'OpenSolaris';
    const PLATFORM_OS2         = 'OS/2';
    const PLATFORM_SUNOS       = 'SunOS';
    const PLATFORM_WINDOWS     = 'Windows';
    const PLATFORM_WINDOWS_CE  = 'Windows CE';


    public function __construct($userAgent = null)
    {
        if (!$userAgent) {
            $userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
        }

        $this->originalUserAgentString = $userAgent;
        $this->userAgent = new String($this->originalUserAgentString);

        $this->userAgent->toLower();

        $this->checkPlatform();
        $this->checkBrowsers();
        $this->checkForAol();
    }

    /**
     * Returns a formatted string with a summary of the details of the browser.
     * @return string formatted string with a summary of the browser
     */
    public function __toString()
    {
        $template = new String('<b>Browser Name:</b> {0}<br /><b>Browser Version:</b> {1}<br /><b>Browser User Agent String:</b> {2}<br /><b>Platform:</b> {3}<br />');

        return $template->format($this->getBrowser(), $this->getVersion(), $this->getUserAgent(), $this->getPlatform())->toString();
    }

    /**
     * Check to see if the specific browser is valid
     * @param string $browserName
     * @return bool True if the browser is the specified browser
     */
    public function isBrowser($browserName)
    {
        return (0 == strcasecmp($this->browserName, trim($browserName)));
    }

    /**
     * The name of the browser.  All return types are from the class contants
     * @return string Name of the browser
     */
    public function getBrowser()
    {
        return $this->browserName;
    }

    /**
     * Set the name of the browser
     * @param $browser string The name of the Browser
     */
    public function setBrowser($browser)
    {
        $this->browserName = $browser;
    }

    /**
     * The name of the platform.  All return types are from the class contants
     * @return string Name of the browser
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * Set the name of the platform
     * @param string $platform The name of the Platform
     */
    protected function setPlatform($platform)
    {
        $this->platform = $platform;
    }

    /**
     * Returns the name of the OS
     * @return string OS Name
     */
    public function getOperatingSystem()
    {
        return $this->operatingSystem;
    }

    /**
     * Sets the name of the OS
     * @param string $os OS Name
     */
    protected function setOperatingSystem($os)
    {
        $this->operatingSystem = $os;
    }

    /**
     * The version of the browser.
     * @return string Version of the browser (will only contain alpha-numeric characters and a period)
     */
    public function getVersion()
    {
        return $this->browserVersion;
    }

    /**
     * Set the version of the browser
     * @param string $version The version of the Browser
     */
    public function setVersion($version)
    {
        $this->browserVersion = preg_replace('/[^0-9,.,a-z,A-Z-]/', '', $version);
    }

    /**
     * The version of AOL.
     * @return string Version of AOL (will only contain alpha-numeric characters and a period)
     */
    public function getAolVersion()
    {
        return $this->aolVersion;
    }

    /**
     * Set the version of AOL
     * @param string $version The version of AOL
     */
    public function setAolVersion($version)
    {
        $this->aolVersion = preg_replace('/[^0-9,.,a-z,A-Z]/', '', $version);
    }

    /**
     * Is the browser from AOL?
     * @return boolean True if the browser is from AOL otherwise false
     */
    public function isAol()
    {
        return $this->isAol;
    }

    /**
     * Is the browser from a mobile device?
     * @return boolean True if the browser is from a mobile device otherwise false
     */
    public function isMobile()
    {
        return $this->isMobile;
    }

    /**
     * Is the browser from a tablet device?
     * @return boolean True if the browser is from a tablet device otherwise false
     */
    public function isTablet()
    {
        return $this->isTablet;
    }

    /**
     * Is the browser from a robot (ex Slurp,GoogleBot)?
     * @return boolean True if the browser is from a robot otherwise false
     */
    public function isRobot()
    {
        return $this->isRobot;
    }

    /**
    * Is the browser from facebook?
    * @return boolean True if the browser is from facebook otherwise false
    */
    public function isFacebook()
    {
        return $this->isFacebook;
    }

    /**
     * Set the browser to be from AOL
     * @param $isAol
     */
    public function setAol($isAol)
    {
        $this->isAol = $isAol;
    }

    /**
     * Set the Browser to be mobile
     * @param boolean $value is the browser a mobile browser or not
     */
    protected function setMobile($isMobile)
    {
        $this->isMobile = $isMobile;
    }

    /**
     * Set the Browser to be tablet
     * @param boolean $value is the browser a tablet browser or not
     */
    protected function setTablet($isTablet)
    {
        $this->isTablet = $isTablet;
    }

    /**
     * Set the Browser to be a robot
     * @param boolean $value is the browser a robot or not
     */
    protected function setRobot($isRobot)
    {
        $this->isRobot = $isRobot;
    }

    /**
     * Set the Browser to be a Facebook request
     * @param boolean $value is the browser a robot or not
     */
    protected function setFacebook($isFacebook)
    {
        $this->isFacebook = $isFacebook;
    }

    /**
     * Get the user agent value in use to determine the browser
     * @return string The user agent from the HTTP header
     */
    public function getUserAgent()
    {
        return $this->originalUserAgentString;
    }

    /**
     * Used to determine if the browser is actually "chromeframe"
     * @since 1.7
     * @return boolean True if the browser is using chromeframe
     */
    public function isChromeFrame()
    {
        return $this->userAgent->contains('chromeframe');
    }

    /**
     * Protected routine to determine the browser type
     * @return boolean True if the browser was detected otherwise false
     */
    protected function checkBrowsers()
    {
        return (
            // WebTV is strapped onto Internet Explorer so we must check for WebTV before IE
            $this->checkBrowserWebTv() ||
            $this->checkBrowserInternetExplorer() ||
            // Opera must be checked before FireFox due to the odd user agents used in
            // some older versions of Opera
            $this->checkBrowserOpera() ||
            // (deprecated) Galeon is based on Firefox and needs to be tested before
            // Firefox is tested
            $this->checkBrowserGaleon() ||
            // Netscape 9+ is based on Firefox so Netscape checks before FireFox are necessary
            $this->checkBrowserNetscapeNavigator9Plus() ||
            // IceCat is a free software rebranding of the Mozilla Firefox web browser
            // distributed by the GNU Project. That way it needs to be tested before
            // Firefox is tested, same goes to Iceweasel
            $this->checkBrowserIceCat() ||
            $this->checkBrowserIceweasel() ||
            $this->checkBrowserFirefox() ||
            $this->checkBrowserChrome() ||
            // OmniWeb is based on Safari so OmniWeb check must occur before Safari
            $this->checkBrowserOmniWeb() ||

            // common mobile
            $this->checkBrowserAndroid() ||
            $this->checkBrowseriPad() ||
            $this->checkBrowseriPod() ||
            $this->checkBrowseriPhone() ||
            $this->checkBrowserBlackBerry() ||
            $this->checkBrowserNokia() ||

            // common bots
            $this->checkBrowserGoogleBot() ||
            $this->checkBrowserMSNBot() ||
            $this->checkBrowserBingBot() ||
            $this->checkBrowserSlurp() ||

            // check for facebook external hit when loading URL
            $this->checkFacebookExternalHit() ||

            // the iCab Browser needs to be checked before Safari due to it's later versions
            $this->checkBrowserIcab() ||
            // WebKit base check (post mobile and others)
            $this->checkBrowserSafari() ||

            // everyone else
            $this->checkBrowserNetPositive() ||
            $this->checkBrowserFirebird() ||
            $this->checkBrowserKonqueror() ||
            $this->checkBrowserPhoenix() ||
            $this->checkBrowserAmaya() ||
            $this->checkBrowserLynx() ||
            $this->checkBrowserShiretoko() ||
            $this->checkBrowserW3CValidator() ||
            $this->checkBrowserCurl() ||
            $this->checkBrowserWget() ||
            $this->checkBrowserMozilla() /* Mozilla is such an open standard that you must check it last */
        );
    }

    /**
     * Determine if the browser is Amaya or not (last updated 2.0.0)
     * @return boolean True if the browser is Amaya otherwise false
     */
    protected function checkBrowserAmaya()
    {
        if (!$version = $this->getVersionFromUserAgentString('amaya')) {
            return false;
        }
        
        $this->setVersion($version);
        $this->setBrowser(self::BROWSER_AMAYA);
        return true;
    }

    /**
     * Determine if the browser is Android or not (last updated 2.0.0)
     * @return boolean True if the browser is Android otherwise false
     */
    protected function checkBrowserAndroid()
    {
        if (!$this->userAgent->contains('android')) {
            return false;
        }

        $tmp = explode(' ', stristr($this->userAgent, 'android'));

        if (isset($tmp[1])) {
            $version = explode(' ', $tmp[1]);
            $this->setVersion(reset($version));
        }

        if ($this->userAgent->contains('mobile')) {
            $this->setMobile(true);
        } else {
            $this->setTablet(true);
        }

        $this->setBrowser(self::BROWSER_ANDROID);
        return true;
    }
    
    /**
     * Determine if the browser is the BingBot or not (last updated 2.0.0)
     * @return boolean True if the browser is the BingBot otherwise false
     */
    protected function checkBrowserBingBot()
    {
        if (!$version = $this->getVersionFromUserAgentString('bingbot')) {
            return false;
        }
        
        $this->setVersion($version);
        $this->setBrowser(self::BROWSER_BINGBOT);
        $this->setRobot(true);
        return true;
    }

    /**
     * Determine if the user is using a BlackBerry (last updated 1.7)
     * @return boolean True if the browser is the BlackBerry browser otherwise false
     */
    protected function checkBrowserBlackBerry()
    {
        if (stripos($this->userAgent, 'blackberry') !== false) {
            $aresult = explode("/", stristr($this->userAgent, "BlackBerry"));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion($aversion[0]);
                $this->setBrowser(self::BROWSER_BLACKBERRY);
                $this->setMobile(true);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is Chrome or not (last updated 2.0.0)
     * @return boolean True if the browser is Chrome otherwise false
     */
    protected function checkBrowserChrome()
    {
        if (!$version = $this->getVersionFromUserAgentString('chrome')) {
            return false;
        }
        
        $this->setVersion($version);
        $this->setBrowser(self::BROWSER_CHROME);

        // Check if it's not on desktop
        if ($this->userAgent->contains('android')) {
            if ($this->userAgent->contains('mobile')) {
                $this->setMobile(true);
            } else {
                $this->setTablet(true);
            }
        }
        return true;
    }

    /**
     * Determine if the browser is cURL or not (last updated 2.0.0)
     * @return boolean True if the browser is cURL otherwise false
     */
    protected function checkBrowserCurl()
    {
        if (!$version = $this->getVersionFromUserAgentString('curl')) {
            return false;
        }
        
        $this->setVersion($version);
        $this->setBrowser(self::BROWSER_CURL);
        return true;
    }

    /**
     * Determine if the browser is Firebird or not (last updated 2.0.0)
     * @return boolean True if the browser is Firebird otherwise false
     */
    protected function checkBrowserFirebird()
    {
        if (!$version = $this->getVersionFromUserAgentString('firebird')) {
            return false;
        }
        
        $this->setVersion($version);
        $this->setBrowser(self::BROWSER_FIREBIRD);
        return true;
    }

    /**
     * Determine if the browser is Firefox or not (last updated 2.0.0)
     * @return boolean True if the browser is Firefox otherwise false
     */
    protected function checkBrowserFirefox()
    {
        if ($this->userAgent->contains('safari')) {
            return false;
        }

        if (!$this->userAgent->contains('firefox')) {
            return false;
        }

        if ($version = $this->getVersionFromUserAgentString('firefox')) {
            $this->setVersion($version);
        }

        $this->setBrowser(self::BROWSER_FIREFOX);

        // Check if it's not on desktop
        if ($this->userAgent->contains('android')) {
            if ($this->userAgent->contains('mobile')) {
                $this->setMobile(true);
            } else {
                $this->setTablet(true);
            }
        }
        return true;
    }

    /**
     * Determine if the browser is Galeon or not (last updated 2.0.0)
     * @return boolean True if the browser is Galeon otherwise false
     */
    protected function checkBrowserGaleon()
    {
        if (!$version = $this->getVersionFromUserAgentString('galeon')) {
            return false;
        }
        
        $this->setVersion($version);
        $this->setBrowser(self::BROWSER_GALEON);
        return true;
    }

    /**
     * Determine if the browser is the GoogleBot or not (last updated 2.0.0)
     * @return boolean True if the browser is the GoogletBot otherwise false
     */
    protected function checkBrowserGoogleBot()
    {
        if (!$version = $this->getVersionFromUserAgentString('googlebot')) {
            return false;
        }
        
        $this->setVersion($version);
        $this->setBrowser(self::BROWSER_GOOGLEBOT);
        $this->setRobot(true);
        return true;
    }

    /**
     * Determine if the browser is iCab or not (last updated 2.0.0)
     * @return boolean True if the browser is iCab otherwise false
     */
    protected function checkBrowserIcab()
    {
        if (!$this->userAgent->contains('icab')) {
            return false;
        }

        preg_match_all('/icab\/(.+?)(?=\s|$)/s', $this->userAgent, $versions);
        $versions = end($versions);

        if (!count($versions)) {
            preg_match_all('/icab\s(.+?)(?=\s|$)/s', $this->userAgent, $versions);
            $versions = end($versions);
        }

        if (!count($versions)) {
            return false;
        }

        $this->setVersion(end($versions));
        $this->setBrowser(self::BROWSER_ICAB);
        return true;
    }

    /**
     * Determine if the browser is Ice Cat or not (http://en.wikipedia.org/wiki/GNU_IceCat) (last updated 2.0.0)
     * @return boolean True if the browser is Ice Cat otherwise false
     */
    protected function checkBrowserIceCat()
    {
        if (!$version = $this->getVersionFromUserAgentString('icecat')) {
            return false;
        }
        
        $this->setVersion($version);
        $this->setBrowser(self::BROWSER_ICECAT);
        return true;
    }

    /**
     * Determine if the browser is Firefox or not (last updated 2.0.0)
     * @return boolean True if the browser is Firefox otherwise false
     */
    protected function checkBrowserIceweasel()
    {
        if (!$version = $this->getVersionFromUserAgentString('iceweasel')) {
            return false;
        }
        
        $this->setVersion($version);
        $this->setBrowser(self::BROWSER_ICEWEASEL);
        return true;
    }

    /**
     * Determine if the browser is Internet Explorer or not (last updated 2.0.0)
     * @return boolean True if the browser is Internet Explorer otherwise false
     */
    protected function checkBrowserInternetExplorer()
    {
        //  Test for IE11
        if ($this->userAgent->contains('trident/7.0; rv:11.0')) {
            $this->setBrowser(self::BROWSER_IE);
            $this->setVersion('11.0');
            return true;
        }
        // Test for v1 - v1.5 IE
        if ($this->userAgent->contains('microsoft internet explorer')) {
            $this->setBrowser(self::BROWSER_IE);
            $this->setVersion('1.0');

            $aresult = stristr($this->userAgent, '/');
            if (preg_match('/308|425|426|474|0b1/i', $aresult)) {
                $this->setVersion('1.5');
            }
            return true;
        }
        // Test for versions > 1.5
        if ($this->userAgent->contains('msie') && !$this->userAgent->contains('opera')) {
            // See if the browser is the odd MSN Explorer
            if ($this->userAgent->contains('msnb')) {
                $aresult = explode(' ', stristr(str_replace(';', '; ', $this->userAgent), 'msn'));
                if (isset($aresult[1])) {
                    $this->setBrowser(self::BROWSER_MSN);
                    $this->setVersion(str_replace(array('(', ')', ';'), '', $aresult[1]));
                    return true;
                }
            }

            $aresult = explode(' ', stristr(str_replace(';', '; ', $this->userAgent), 'msie'));
            if (isset($aresult[1])) {
                $this->setBrowser(self::BROWSER_IE);
                $this->setVersion(str_replace(array('(', ')', ';'), '', $aresult[1]));
                if ($this->userAgent->contains('iemobile')) {
                    $this->setBrowser(self::BROWSER_POCKET_IE);
                    $this->setMobile(true);
                }
                return true;
            }
        }
        // Test for versions > IE 10
        if ($this->userAgent->contains('trident')) {
            $this->setBrowser(self::BROWSER_IE);
            $result = explode('rv:', $this->userAgent);
            if (isset($result[1])) {
                $this->setVersion(preg_replace('/[^0-9.]+/', '', $result[1]));
            }
            return true;
        }
        // Test for Pocket IE
        if ($this->userAgent->contains('mspie') || $this->userAgent->contains('pocket')) {
            $aresult = explode(' ', stristr($this->userAgent, 'mspie'));
            if (isset($aresult[1])) {
                $this->setPlatform(self::PLATFORM_WINDOWS_CE);
                $this->setBrowser(self::BROWSER_POCKET_IE);
                $this->setMobile(true);

                if (stripos($this->userAgent, 'mspie') !== false) {
                    $this->setVersion($aresult[1]);
                } else {
                    $aversion = explode('/', $this->userAgent);
                    if (isset($aversion[1])) {
                        $this->setVersion($aversion[1]);
                    }
                }
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is Konqueror or not (last updated 2.0.0)
     * @return boolean True if the browser is Konqueror otherwise false
     */
    protected function checkBrowserKonqueror()
    {
        if (!$version = $this->getVersionFromUserAgentString('konqueror')) {
            return false;
        }
        
        $this->setVersion($version);
        $this->setBrowser(self::BROWSER_KONQUEROR);
        return true;
    }

    /**
     * Determine if the browser is Lynx or not (last updated 2.0.0)
     * @return boolean True if the browser is Lynx otherwise false
     */
    protected function checkBrowserLynx()
    {
        if (!$version = $this->getVersionFromUserAgentString('lynx')) {
            return false;
        }
        
        $this->setVersion($version);
        $this->setBrowser(self::BROWSER_LYNX);
        return true;
    }

    /**
     * Determine if the browser is Mozilla or not (last updated 2.0.0)
     * @return boolean True if the browser is Mozilla otherwise false
     */
    protected function checkBrowserMozilla()
    {
        if (stripos($this->userAgent, 'mozilla') !== false && preg_match('/rv:[0-9].[0-9][a-b]?/i', $this->userAgent) && stripos($this->userAgent, 'netscape') === false) {
            $aversion = explode(' ', stristr($this->userAgent, 'rv:'));
            preg_match('/rv:(.*?)\)/', $this->userAgent, $aversion);
            $this->setVersion(str_replace('rv:', '', $aversion[1]));
            $this->setBrowser(self::BROWSER_MOZILLA);
            return true;
        } else if (stripos($this->userAgent, 'mozilla') !== false && preg_match('/rv:[0-9]\.[0-9]/i', $this->userAgent) && stripos($this->userAgent, 'netscape') === false) {
            $aversion = explode('', stristr($this->userAgent, 'rv:'));
            $this->setVersion(str_replace('rv:', '', $aversion[0]));
            $this->setBrowser(self::BROWSER_MOZILLA);
            return true;
        } else if (stripos($this->userAgent, 'mozilla') !== false && preg_match('/mozilla\/([^ ]*)/i', $this->userAgent, $matches) && stripos($this->userAgent, 'netscape') === false) {
            $this->setVersion($matches[1]);
            $this->setBrowser(self::BROWSER_MOZILLA);
            return true;
        }
        return false;
    }

    /**
     * Determine if the browser is the MSNBot or not (last updated 2.0.0)
     * @return boolean True if the browser is the MSNBot otherwise false
     */
    protected function checkBrowserMSNBot()
    {
        if (!$version = $this->getVersionFromUserAgentString('msnbot')) {
            return false;
        }
        
        $this->setVersion($version);
        $this->setBrowser(self::BROWSER_MSNBOT);
        return true;
    }

    /**
     * Determine if the browser is NetPositive or not (last updated 2.0.0)
     * @return boolean True if the browser is NetPositive otherwise false
     */
    protected function checkBrowserNetPositive()
    {
        if (!$version = $this->getVersionFromUserAgentString('netpositive')) {
            return false;
        }
        
        $this->setVersion($version);
        $this->setBrowser(self::BROWSER_NETPOSITIVE);
        return true;
    }

    /**
     * Determine if the browser is Netscape Navigator 9+ or not (last updated 2.0.0)
     * NOTE: (http://browser.netscape.com/ - Official support ended on March 1st, 2008)
     * @return boolean True if the browser is Netscape Navigator 9+ otherwise false
     */
    protected function checkBrowserNetscapeNavigator9Plus()
    {
        if ($this->userAgent->contains('firefox')) {
            if (!$this->userAgent->contains('navigator')) {
                return false;
            }

            preg_match_all('/Navigator\/(.+?)(?=\s|$)/s', $this->originalUserAgentString, $versions);
            $versions = end($versions);

            if (!count($versions)) {
                return false;
            }
        } else {
            if (!$this->userAgent->contains('netscape')) {
                return false;
            }

            preg_match_all('/Netscape\/(.+?)(?=\s|$)/s', $this->originalUserAgentString, $versions);
            $versions = end($versions);

            if (!count($versions)) {
                return false;
            }
        }
        
        $this->setVersion(end($versions));
        $this->setBrowser(self::BROWSER_NETSCAPE_NAVIGATOR);
        return true;
    }

    /**
     * Determine if the browser is the W3C Validator or not (last updated 1.7)
     * @return boolean True if the browser is the W3C Validator otherwise false
     */
    protected function checkBrowserW3CValidator()
    {
        if (stripos($this->userAgent, 'W3C-checklink') !== false) {
            $aresult = explode('/', stristr($this->userAgent, 'W3C-checklink'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion($aversion[0]);
                $this->setBrowser(self::BROWSER_W3CVALIDATOR);
                return true;
            }
        } else if (stripos($this->userAgent, 'W3C_Validator') !== false) {
            // Some of the Validator versions do not delineate w/ a slash - add it back in
            $ua = str_replace("W3C_Validator ", "W3C_Validator/", $this->userAgent);
            $aresult = explode('/', stristr($ua, 'W3C_Validator'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion($aversion[0]);
                $this->setBrowser(self::BROWSER_W3CVALIDATOR);
                return true;
            }
        } else if (stripos($this->userAgent, 'W3C-mobileOK') !== false) {
            $this->setBrowser(self::BROWSER_W3CVALIDATOR);
            $this->setMobile(true);
            return true;
        }
        return false;
    }

    /**
     * Determine if the browser is the Yahoo! Slurp Robot or not (last updated 1.7)
     * @return boolean True if the browser is the Yahoo! Slurp Robot otherwise false
     */
    protected function checkBrowserSlurp()
    {
        if (stripos($this->userAgent, 'slurp') !== false) {
            $aresult = explode('/', stristr($this->userAgent, 'slurp'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion($aversion[0]);
                $this->setBrowser(self::BROWSER_SLURP);
                $this->setRobot(true);
                $this->setMobile(false);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is Opera or not (last updated 1.7)
     * @return boolean True if the browser is Opera otherwise false
     */
    protected function checkBrowserOpera()
    {
        if (stripos($this->userAgent, 'opera mini') !== false) {
            $resultant = stristr($this->userAgent, 'opera mini');
            if (preg_match('/\//', $resultant)) {
                $aresult = explode('/', $resultant);
                if (isset($aresult[1])) {
                    $aversion = explode(' ', $aresult[1]);
                    $this->setVersion($aversion[0]);
                }
            } else {
                $aversion = explode(' ', stristr($resultant, 'opera mini'));
                if (isset($aversion[1])) {
                    $this->setVersion($aversion[1]);
                }
            }
            $this->setBrowser(self::BROWSER_OPERA_MINI);
            $this->setMobile(true);
            return true;
        } else if (stripos($this->userAgent, 'opera') !== false) {
            $resultant = stristr($this->userAgent, 'opera');
            if (preg_match('/Version\/(1*.*)$/', $resultant, $matches)) {
                $this->setVersion($matches[1]);
            } else if (preg_match('/\//', $resultant)) {
                $aresult = explode('/', str_replace("(", " ", $resultant));
                if (isset($aresult[1])) {
                    $aversion = explode(' ', $aresult[1]);
                    $this->setVersion($aversion[0]);
                }
            } else {
                $aversion = explode(' ', stristr($resultant, 'opera'));
                $this->setVersion(isset($aversion[1]) ? $aversion[1] : "");
            }
            if (stripos($this->userAgent, 'Opera Mobi') !== false) {
                $this->setMobile(true);
            }
            $this->setBrowser(self::BROWSER_OPERA);
            return true;
        } else if (stripos($this->userAgent, 'OPR') !== false) {
            $resultant = stristr($this->userAgent, 'OPR');
            if (preg_match('/\//', $resultant)) {
                $aresult = explode('/', str_replace("(", " ", $resultant));
                if (isset($aresult[1])) {
                    $aversion = explode(' ', $aresult[1]);
                    $this->setVersion($aversion[0]);
                }
            }
            if (stripos($this->userAgent, 'Mobile') !== false) {
                $this->setMobile(true);
            }
            $this->setBrowser(self::BROWSER_OPERA);
            return true;
        }
        return false;
    }

    /**
     * Determine if the browser is WebTv or not (last updated 1.7)
     * @return boolean True if the browser is WebTv otherwise false
     */
    protected function checkBrowserWebTv()
    {
        if (stripos($this->userAgent, 'webtv') !== false) {
            $aresult = explode('/', stristr($this->userAgent, 'webtv'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion($aversion[0]);
                $this->setBrowser(self::BROWSER_WEBTV);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is OmniWeb or not (last updated 1.7)
     * @return boolean True if the browser is OmniWeb otherwise false
     */
    protected function checkBrowserOmniWeb()
    {
        if (stripos($this->userAgent, 'omniweb') !== false) {
            $aresult = explode('/', stristr($this->userAgent, 'omniweb'));
            $aversion = explode(' ', isset($aresult[1]) ? $aresult[1] : "");
            $this->setVersion($aversion[0]);
            $this->setBrowser(self::BROWSER_OMNIWEB);
            return true;
        }
        return false;
    }

    /**
     * Determine if the browser is Phoenix or not (last updated 1.7)
     * @return boolean True if the browser is Phoenix otherwise false
     */
    protected function checkBrowserPhoenix()
    {
        if (stripos($this->userAgent, 'Phoenix') !== false) {
            $aversion = explode('/', stristr($this->userAgent, 'Phoenix'));
            if (isset($aversion[1])) {
                $this->setVersion($aversion[1]);
                $this->setBrowser(self::BROWSER_PHOENIX);
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the browser is Shiretoko or not (https://wiki.mozilla.org/Projects/shiretoko) (last updated 1.7)
     * @return boolean True if the browser is Shiretoko otherwise false
     */
    protected function checkBrowserShiretoko()
    {
        if (stripos($this->userAgent, 'Mozilla') !== false && preg_match('/Shiretoko\/([^ ]*)/i', $this->userAgent, $matches)) {
            $this->setVersion($matches[1]);
            $this->setBrowser(self::BROWSER_SHIRETOKO);
            return true;
        }
        return false;
    }

    /**
     * Determine if the browser is Nokia or not (last updated 1.7)
     * @return boolean True if the browser is Nokia otherwise false
     */
    protected function checkBrowserNokia()
    {
        if (preg_match("/Nokia([^\/]+)\/([^ SP]+)/i", $this->userAgent, $matches)) {
            $this->setVersion($matches[2]);
            if (stripos($this->userAgent, 'Series60') !== false || strpos($this->userAgent, 'S60') !== false) {
                $this->setBrowser(self::BROWSER_NOKIA_S60);
            } else {
                $this->setBrowser(self::BROWSER_NOKIA);
            }
            $this->setMobile(true);
            return true;
        }
        return false;
    }

    /**
     * Determine if the browser is Wget or not (last updated 2.0.0)
     * @return boolean True if the browser is Wget otherwise false
     */
    protected function checkBrowserWget()
    {
        if (!$version = $this->getVersionFromUserAgentString('wget')) {
            return false;
        }
        
        $this->setVersion($version);
        $this->setBrowser(self::BROWSER_WGET);
        return true;
    }

    /**
     * Determine if the browser is Safari or not (last updated 1.7)
     * @return boolean True if the browser is Safari otherwise false
     */
    protected function checkBrowserSafari()
    {
        if (stripos($this->userAgent, 'Safari') !== false && stripos($this->userAgent, 'iPhone') === false && stripos($this->userAgent, 'iPod') === false) {
            $aresult = explode('/', stristr($this->userAgent, 'Version'));
            if (isset($aresult[1])) {
                $aversion = explode(' ', $aresult[1]);
                $this->setVersion($aversion[0]);
            } else {
                $this->setVersion(self::VERSION_UNKNOWN);
            }
            $this->setBrowser(self::BROWSER_SAFARI);
            return true;
        }
        return false;
    }

    /**
     * Detect if URL is loaded from FacebookExternalHit
     * @return boolean True if it detects FacebookExternalHit otherwise false
     */
    protected function checkFacebookExternalHit()
    {
        if (stristr($this->userAgent, 'FacebookExternalHit')) {
            $this->setRobot(true);
            $this->setFacebook(true);
            return true;
        }
        return false;
    }

    /**
     * Detect if URL is being loaded from internal Facebook browser
     * @return boolean True if it detects internal Facebook browser otherwise false
     */
    protected function checkForFacebookIos()
    {
        if (stristr($this->userAgent, 'FBIOS')) {
            $this->setFacebook(true);
            return true;
        }
        return false;
    }

    /**
     * Detect Version for the Safari browser on iOS devices
     * @return boolean True if it detects the version correctly otherwise false
     */
    protected function getSafariVersionOnIos()
    {
        $aresult = explode('/', stristr($this->userAgent, 'Version'));
        if (isset($aresult[1])) {
            $aversion = explode(' ', $aresult[1]);
            $this->setVersion($aversion[0]);
            return true;
        }
        return false;
    }

    /**
     * Detect Version for the Chrome browser on iOS devices
     * @return boolean True if it detects the version correctly otherwise false
     */
    protected function getChromeVersionOnIos()
    {
        $aresult = explode('/', stristr($this->userAgent, 'CriOS'));
        if (isset($aresult[1])) {
            $aversion = explode(' ', $aresult[1]);
            $this->setVersion($aversion[0]);
            $this->setBrowser(self::BROWSER_CHROME);
            return true;
        }
        return false;
    }

    /**
     * Determine if the browser is iPhone or not
     * @return boolean True if the browser is iPhone otherwise false
     */
    protected function checkBrowseriPhone()
    {
        if (stripos($this->userAgent, 'iPhone') !== false) {
            $this->setVersion(self::VERSION_UNKNOWN);
            $this->setBrowser(self::BROWSER_IPHONE);
            $this->getSafariVersionOnIos();
            $this->getChromeVersionOnIos();
            $this->checkForFacebookIos();
            $this->setMobile(true);
            return true;
        }
        return false;
    }

    /**
     * Determine if the browser is iPad or not
     * @return boolean True if the browser is iPad otherwise false
     */
    protected function checkBrowseriPad()
    {
        if (stripos($this->userAgent, 'iPad') !== false) {
            $this->setVersion(self::VERSION_UNKNOWN);
            $this->setBrowser(self::BROWSER_IPAD);
            $this->getSafariVersionOnIos();
            $this->getChromeVersionOnIos();
            $this->checkForFacebookIos();
            $this->setTablet(true);
            return true;
        }
        return false;
    }

    /**
     * Determine if the browser is iPod or not
     * @return boolean True if the browser is iPod otherwise false
     */
    protected function checkBrowseriPod()
    {
        if (stripos($this->userAgent, 'iPod') !== false) {
            $this->setVersion(self::VERSION_UNKNOWN);
            $this->setBrowser(self::BROWSER_IPOD);
            $this->getSafariVersionOnIos();
            $this->getChromeVersionOnIos();
            $this->checkForFacebookIos();
            $this->setMobile(true);
            return true;
        }
        return false;
    }

    /**
     * Determine the user's platform
     */
    protected function checkPlatform()
    {
        if ($this->userAgent->contains('windows')) {
            return $this->setPlatform(self::PLATFORM_WINDOWS);
        }
        if ($this->userAgent->contains('ipad')) {
            return $this->setPlatform(self::PLATFORM_IPAD);
        }
        if ($this->userAgent->contains('ipod')) {
            return $this->setPlatform(self::PLATFORM_IPOD);
        }
        if ($this->userAgent->contains('iphon')) {
            return $this->setPlatform(self::PLATFORM_IPHONE);
        }
        if ($this->userAgent->contains('mac')) {
            return $this->setPlatform(self::PLATFORM_APPLE);
        }
        if ($this->userAgent->contains('android')) {
            return $this->setPlatform(self::PLATFORM_ANDROID);
        }
        if ($this->userAgent->contains('linux')) {
            return $this->setPlatform(self::PLATFORM_LINUX);
        }
        if ($this->userAgent->contains('nokia')) {
            return $this->setPlatform(self::PLATFORM_NOKIA);
        }
        if ($this->userAgent->contains('blackberry')) {
            return $this->setPlatform(self::PLATFORM_BLACKBERRY);
        }
        if ($this->userAgent->contains('freebsd')) {
            return $this->setPlatform(self::PLATFORM_FREEBSD);
        }
        if ($this->userAgent->contains('openbsd')) {
            return $this->setPlatform(self::PLATFORM_OPENBSD);
        }
        if ($this->userAgent->contains('netbsd')) {
            return $this->setPlatform(self::PLATFORM_NETBSD);
        }
        if ($this->userAgent->contains('opensolaris')) {
            return $this->setPlatform(self::PLATFORM_OPENSOLARIS);
        }
        if ($this->userAgent->contains('sunos')) {
            return $this->setPlatform(self::PLATFORM_SUNOS);
        }
        if ($this->userAgent->contains('os\/2')) {
            return $this->setPlatform(self::PLATFORM_OS2);
        }
        if ($this->userAgent->contains('beos')) {
            return $this->setPlatform(self::PLATFORM_BEOS);
        }
        if ($this->userAgent->contains('win')) {
            return $this->setPlatform(self::PLATFORM_WINDOWS);
        }
    }

    /**
     * Determine if the user is using an AOL User Agent (last updated 1.7)
     * @return boolean True if the browser is from AOL otherwise false
     */
    protected function checkForAol()
    {
        if ($this->userAgent->contains('aol')) {
            $aversion = explode(' ', stristr($this->userAgent, 'aol'));
            if (isset($aversion[1])) {
                $this->setAol(true);
                $this->setAolVersion(preg_replace('/[^0-9\.a-z]/i', '', $aversion[1]));
                return true;
            }
        }
        return false;
    }

    /**
     * Parses the user agent string based on the browser key name and returns
     * the version if there is anything compatible (last updated 2.0.0)
     * @param  string $browserKey Browser Key name
     * @return bool|string If there's no match returns false, otherwise returns the version
     */
    protected function getVersionFromUserAgentString($browserKey)
    {
        if (!$this->userAgent->contains(strtolower($browserKey))) {
            return false;
        }

        $regexExpression = sprintf('/%s\/(.+?)(?=\s|$)/s', strtolower($browserKey));
        preg_match_all($regexExpression, $this->userAgent, $versions);
        $versions = end($versions);

        if (!count($versions)) {
            return false;
        }

        return end($versions);
    }
}
