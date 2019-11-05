<?php

namespace micro\controllers;

use micro\controllers\Actions\Position\Create;
use micro\controllers\Actions\Position\Index;
use micro\controllers\Actions\Position\Update;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

/**
 * Class ApiController
 * @package micro\controllers
 */
class PositionController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public $enableCsrfValidation = false;

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'verbFilter' => [
                'class' => VerbFilter::class,
                'actions' => $this->verbs(),
            ],
        ];
    }

    /**
     * Устанавливает список поддерживаемых HTTP команд
     * @return array
     */
    protected function verbs(): array
    {
        return [
            'index' => ['GET'],
            'create' => ['POST'],
            'update' => ['PUT'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'index' => Index::class,
            'create' => Create::class,
            'update' => Update::class,
        ];
    }
}
