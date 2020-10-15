<?php

namespace RateInformer\Api\Controllers;

use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use RateInformer\Api\Models\Currency;

/**
 * @OA\OpenApi(
 *     openapi="3.0.2",
 *     @OA\Components(
 *         @OA\SecurityScheme(
 *             securityScheme="bearerAuth",
 *             type="http",
 *             scheme="bearer",
 *             bearerFormat="token"
 *         )
 *     ),
 *     @OA\Info(
 *         version="0.0.1",
 *         title="RateInformer API",
 *     ),
 * )
 */
class CurrencyController extends \yii\rest\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];

        return $behaviors;
    }

    /**
     * Возвращает список курсов валют.
     *
     * @OA\Get(
     *     path="/currencies",
     *     summary="Get currency rate list",
     *     operationId="currency-list",
     *     tags={"Currencies"},
     *     security={{"bearerAuth"={""}}},
     *     @OA\Parameter(
     *         description="Page number to display",
     *         in="query",
     *         name="page",
     *         required=false,
     *         @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfull currency rates list retreival",
     *         @OA\Header(
     *             header="X-Pagination-Current-Page",
     *             description="The number of returned page of the list",
     *             @OA\Schema(
     *                 type="int"
     *             )
     *         ),
     *         @OA\Header(
     *             header="X-Pagination-Page-Count",
     *             description="Quantity of pages in the list",
     *             @OA\Schema(
     *                 type="int"
     *             )
     *         ),
     *         @OA\Header(
     *             header="X-Pagination-Per-Page",
     *             description="Size of the list page",
     *             @OA\Schema(
     *                 type="int"
     *             )
     *         ),
     *         @OA\Header(
     *             header="X-Pagination-Total-Count",
     *             description="Quantity of elements in the list",
     *             @OA\Schema(
     *                 type="int"
     *             )
     *         ),
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="string"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="rate", type="number")
     *             )
     *         )
     *     )
     * )
     *
     * @return mixed
     */
    public function actionList()
    {
        $provider = new ActiveDataProvider([
            'query' => Currency::find()->asArray(),
            'pagination' => [
                'params'   => \Yii::$app->request->get(),
                'pageSize' => 10,
            ],
        ]);
        
        $result = $provider->getModels();
        $pagination = $provider->getPagination();
        $headers = \Yii::$app->response->headers;

        $headers->add('X-Pagination-Current-Page', $pagination->getPage() + 1);
        $headers->add('X-Pagination-Page-Count', $pagination->getPageCount());
        $headers->add('X-Pagination-Per-Page', $pagination->getPageSize());
        $headers->add('X-Pagination-Total-Count', $pagination->totalCount);
    
        return $result;
    }

    /**
     * Возвращает курс указанной валюты.
     *
     * @OA\Get(
     *     path="/currency/{id}",
     *     summary="Get currency rate",
     *     operationId="users-list",
     *     tags={"Currencies"},
     *     security={{"bearerAuth"={""}}},
     *     @OA\Parameter(
     *         description="ID of user to delete",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfull currency rate retreival",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="string"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="rate", type="number")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Currency not found"
     *     )
     * )
     *
     * @return mixed
     */
    public function actionView(string $id)
    {
        $currency = Currency::findOne($id);
        if ($currency) {
            return $currency;
        }

        throw new \yii\web\NotFoundHttpException('Requested currency not found');
    }

    /**
     * {@inheritdoc}
     */
    protected function verbs()
    {
        return [
            'list' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
        ];
    }
}
