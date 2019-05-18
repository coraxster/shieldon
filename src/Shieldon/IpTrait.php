<?php declare(strict_types=1);
/*
 * This file is part of the Shieldon package.
 *
 * (c) Terry L. <contact@terryl.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Shieldon;

use function substr;
use function gethostbyaddr;

/**
 * Ip
 */
trait IpTrait
{
    /**
     * IP address.
     *
     * @var string
     */
    private $ip = '';

    /**
     * The RDNS recond of the Robot's IP address.
     * This is the most important value because that most popular search engines' IP can be resolved to 
     * their domain name, except Baidu.
     *
     * @var string
     */
    private $ipResolvedHostname = '';

    /**
     * Set an IP address. 
     * If you want to deal with the proxy and CDN IPs.
     *
     * @param string $ip
     *
     * @return void
     */
    public function setIp(string $ip = ''): void
    {
        if (empty($ip)) {
            $this->ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $this->ip = $ip;
        }

        // Check if your IP is from localhost, perhpas your are in development environment?
        if (
            (substr($this->ip, 0 , 8) === '192.168.') || 
            (substr($this->ip, 0 , 6) === '127.0.')
        ) {
            $this->setRdns('localhost');
        } else {
            $this->setRdns(gethostbyaddr($this->ip));
        }
    }

    /**
     * Set a RDNS record for the check.
     *
     * @param string $rdns Reserve DNS record for that IP address.
     * 
     * @return void
     */
    public function setRdns($rdns): void
    {
        $this->ipResolvedHostname = $rdns;
    }
}