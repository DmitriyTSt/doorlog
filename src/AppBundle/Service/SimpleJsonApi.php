<?php
/**
 * Created by PhpStorm.
 * User: dmitriyt
 * Date: 18.04.18
 * Time: 16:13
 */

namespace AppBundle\Service;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SimpleJsonApi
{
    public static function jsonEncode($obj) {
        $encoders = array(new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);

        $serializer = new Serializer($normalizers, $encoders);

        $obj_json = $serializer->serialize($obj, 'json');
        return $obj_json;
    }

    public static function createResponse($json) {
        $response = new Response($json);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public static function createResponseObj($obj) {
        return self::createResponse(self::jsonEncode($obj));
    }
}