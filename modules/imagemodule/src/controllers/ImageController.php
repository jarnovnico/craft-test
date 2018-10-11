<?php
/**
 * Image module for Craft CMS 3.x.
 *
 * Generates an image with the Glide plugin
 *
 * @see      https://bravoure.nl
 *
 * @copyright Copyright (c) 2018 Bravoure
 */

namespace modules\imagemodule\controllers;

use Craft;
use craft\web\Controller;
use League\Glide\ServerFactory;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

/**
     * Image Controller.
     *
     * @author    Bravoure
     *
     * @since     1.0.0
     */
    class ImageController extends Controller
    {
        // Protected Properties
        // =========================================================================

        /**
         * @var bool|array Allows anonymous access to this controller's actions.
         *                 The actions must be in 'kebab-case'
         */
        protected $allowAnonymous = ['serve'];

        // Public Methods
        // =========================================================================

        public function actionServe($dirName, $fileName)
        {
            $dir = $dirName;
            $img = $fileName;
            $root = Craft::getAlias('@root');
            $cache = $root . '/storage/cache/';
            $source = $root . '/storage/uploads/';
            $request = Craft::$app->getRequest();
            $queryParams = $this->getQueryParams($request);

            if (! file_exists($source . '/' . $dir . '/' . $img)) {
                http_response_code(404);
                exit('Image not found');
            }

            // Setup Glide server
            $server = ServerFactory::create([
                'source' => $source,
                'cache' => $cache,
                'watermarks' => new Filesystem(new Local($root . '/storage/watermarks/')),
            ]);

            try {
                $server->outputImage($dir . '/' . $img, $queryParams);
                // Exit after output to stop craft from loading further. Image module should be on top.
                exit;
            } catch (\Exception  $e) {
                return $e->getMessage();
            }
        }

        protected function getQueryParams($request)
        {
            $queryParams = $request->getQueryParams();

            if (isset($queryParams['fit'])) {
                $fitParams = explode('-', $queryParams['fit']);

                if (isset($fitParams[0]) && 'crop' == $fitParams[0]) {
                    if (isset($fitParams[1]) && isset($fitParams[2])) {
                        $fitParams[1] = round($fitParams[1]);
                        $fitParams[2] = round($fitParams[2]);
                    }

                    $queryParams['fit'] = implode('-', $fitParams);
                }
            }

            return $queryParams;
        }
    }
