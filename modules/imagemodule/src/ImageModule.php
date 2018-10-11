<?php
/**
 * image module for Craft CMS 3.x.
 *
 * Generates a image with the glide pluin
 *
 * @see      https://bravoure.nl
 *
 * @copyright Copyright (c) 2018 Bravoure
 */

namespace modules\imagemodule;

use Craft;
use yii\base\Event;
use yii\base\Module;
use craft\web\UrlManager;

use craft\i18n\PhpMessageSource;
use craft\events\RegisterUrlRulesEvent;

/**
 * @author    Bravoure
 *
 * @since     1.0.0
 */
class ImageModule extends Module
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this module class so that it can be accessed via
     * ImageModule::$instance.
     *
     * @var ImageModule
     */
    public static $instance;

    // Public Methods
    // =========================================================================

    /**
     * {@inheritdoc}
     */
    public function __construct($id, $parent = null, array $config = [])
    {
        Craft::setAlias('@modules/imagemodule', $this->getBasePath());
        $this->controllerNamespace = 'modules\imagemodule\controllers';

        // Translation category
        $i18n = Craft::$app->getI18n();
        /* @noinspection UnSafeIsSetOverArrayInspection */
        if (! isset($i18n->translations[$id]) && ! isset($i18n->translations[$id . '*'])) {
            $i18n->translations[$id] = [
                'class' => PhpMessageSource::class,
                'sourceLanguage' => 'en-US',
                'basePath' => '@modules/imagemodule/translations',
                'forceTranslation' => true,
                'allowOverrides' => true,
            ];
        }

        parent::__construct($id, $parent, $config);
    }

    public function init()
    {
        // Register our site routes
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['img/<dirName:[^\/]+>/<fileName:[^\/]+>'] = '/image-module/image/serve';
            }
        );

        Craft::info(
            Craft::t(
                'image-module',
                '{name} module loaded',
                ['name' => 'image']
            ),
            __METHOD__
        );
    }
}
