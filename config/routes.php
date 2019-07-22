<?php

/**
 * @SWG\Info(title="Direction API", version="v1")
 */
return function (\Zend\Expressive\Application $app): void {

    /**
     * @SWG\Get(
     *     path="/api/v1/rebuy",
     *     @SWG\Response(response="200", description="An example resource"),
     *     @SWG\Response(response="400", description="An error ...")
     * )
     */
    $app->get('/docs', function () {
        $swagger = \Swagger\scan(__DIR__);
        return new \Zend\Diactoros\Response\JsonResponse($swagger);
    });

    $app->get('/dev/info', $app->getContainer()->get(\Direction\Http\Action\Dev::class));
    
    $app->post('/api/v1/routes', $app->getContainer()->get(\Direction\Http\Action\GetRouteAction::class));
    $app->post('/api/v1/directions', $app->getContainer()->get(\Direction\Http\Action\GetDirectionAction::class));
    $app->post('/api/v1/direction/price', $app->getContainer()->get(\Direction\Http\Action\GetDirectionPriceAction::class));

};
