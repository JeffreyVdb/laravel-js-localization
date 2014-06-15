<?php
namespace JeffreyVdb\JsLocalization;

use Cache;
use Config;
use Lang;
use JeffreyVdb\JsLocalization\Facades\JsLocalizationHelper;

class CachingService
{
    
    /**
     * The key used to cache the JSON encoded messages.
     *
     * @var string
     */
    const CACHE_KEY = 'jslocalization';

    public function getSectionKeyName($section, $v)
    {
        return self::CACHE_KEY . ':' . $section . ':' . $v;
    }

    /**
     * Returns the cached messages (already JSON encoded).
     * Creates the neccessary cache item if neccessary.
     *
     * @return string JSON encoded messages object.
     */
    public function getMessagesJson ($section)
    {
        $cacheKey = $this->getSectionKeyName($section, 'json');
        if (!Cache::has($cacheKey)) {
            $this->refreshMessageCache($section);
        }
        
        return Cache::get($cacheKey);
    }

    /**
     * Refreshs the cache item containing the JSON encoded
     * messages object.
     * Fires the 'JsLocalization.refresh' event.
     *
     * @return void
     */
    public function refreshMessageCache ($section)
    {
        JsLocalizationHelper::triggerRegisterMessages();

        $messageKeys = $this->getMessageKeys($section);
        $translatedMessages = array();

        foreach ($messageKeys as $key) {
            $translatedMessages[$key] = Lang::get($key);
        }

        Cache::forever($this->getSectionKeyName($section, 'json'), 
            json_encode($translatedMessages));
        Cache::forever($this->getSectionKeyName($section, 'stamp'), time());
    }

    /**
     * Returns the UNIX timestamp of the last
     * refreshMessageCache() call.
     *
     * @return UNIX timestamp
     */
    public function getLastRefreshTimestamp ($section)
    {
        return Cache::get($this->getSectionKeyName($section, 'stamp'));
    }

    /**
     * Returns the message keys of all messages
     * that are supposed to be sent to the browser.
     *
     * @return array Array of message keys.
     */
    protected function getMessageKeys ($section)
    {
        $allMessages = [];
        $keys = [$section];
        if (Config::get('jslocalization::default') == true && $section !== 'default') {
            array_unshift($keys, 'default');
        }

        foreach ($keys as $k) {
            $messageKeys = Config::get('jslocalization::export.' . $k);
            if (! $messageKeys) {
                continue;
            }
            $messageKeys = JsLocalizationHelper::resolveMessageKeyArray($messageKeys);
            $allMessages = array_unique(array_merge($messageKeys, $allMessages));
        }

        return $allMessages;
    }
}