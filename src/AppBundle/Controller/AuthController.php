<?php
/**
 * Created by PhpStorm.
 * User: dmitriyt
 * Date: 18.04.18
 * Time: 16:08
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Device;
use AppBundle\Entity\User;
use AppBundle\Service\SimpleJsonApi;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends Controller
{
    /**
     * Login by password
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/api/login/", name="api_security_login", methods={"POST"})
     */
    public function loginAction(Request $request)
    {
        $content = $request->getContent();
        $json = json_decode($content, true);
        if (!$json) {
            throw new Exception('поле email не задано');
        }
        if (array_key_exists('data', $json)) {
            if (array_key_exists("email", $json['data'])) {
                if (array_key_exists("password", $json['data'])) {
                    $em = $this->getDoctrine()->getManager();
                    $user = $em->getRepository(User::class)->findOneBy(['email' => $json['data']['email']]);
                    if ($user) {
                        $encoder = $this->get('security.password_encoder');
                        if ($user->getPassword() == $encoder->encodePassword($user, $json['data']["password"])) {
                            $device = new Device($user);
                            $em->persist($device);
                            $em->flush();
                            $json = SimpleJsonApi::jsonEncode($device->getApikey());
                            return SimpleJsonApi::createResponse($json);
                        }
                        throw new Exception('Пароль не верен');
                    }
                    throw new Exception('Пользователь не найден');
                }
                throw new Exception('поле password не задано');
            }
            throw new Exception('поле email не задано');
        }
        throw new Exception('поле data не задано');
    }

    /**
     * Reset password
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/api/reset-password/", name="api_security_reset_password", methods={"POST"})
     */
    public function resetPassword(Request $request)
    {
        $content = $request->getContent();
        $json = json_decode($content, true);
        if (!$json) {
            throw new Exception('поле email не задано');
        }
        if (array_key_exists('data', $json)) {
            if (array_key_exists("email", $json['data'])) {
                $em = $this->getDoctrine()->getManager();
                /** @var User $user */
                $user = $em->getRepository(User::class)->findOneBy(['email' => $json['data']['email']]);
                if ($user) {
                    $user->setPassword(mt_rand(10000, 99999));
                    $response = SimpleJsonApi::createResponseObj($user);
                    $encoder = $this->get('security.password_encoder');
                    $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
                    $em->persist($user);
                    $em->flush();
                    return $response;
                }
                throw new Exception('Пользователь не найден');
            }
            throw new Exception('поле email не задано');
        }
        throw new Exception('поле data не задано');
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/api/me/", name="api_security_auth", methods={"GET"})
     */
    public function meAction(Request $request)
    {
        if ($request->headers->get('apikey') == null) {
            throw new Exception('header apikey не задан');
        }
        /** @var Device $device */
        $device = $this->getDoctrine()->getManager()->getRepository(Device::class)->findOneBy([
            'apikey' => $request->headers->get('apikey')
        ]);
        if ($device == null) {
            throw new Exception('такой apikey не существует');
        }
        return SimpleJsonApi::createResponseObj($device->getUser());
    }

    /**
     * Reset password
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/api/update-password/", name="api_security_update_password", methods={"POST"})
     */
    public function updatePassword(Request $request)
    {
        if ($request->headers->get('apikey') == null) {
            throw new Exception('Ошибка авторизации');
        }
        $content = $request->getContent();
        $json = json_decode($content, true);
        if (!$json) {
            throw new Exception('поля не заполнены');
        }
        if (array_key_exists('data', $json)) {
            if (array_key_exists("email", $json['data'])) {
                if (array_key_exists("oldpass", $json['data'])) {
                    if (array_key_exists("password", $json['data'])) {
                        $em = $this->getDoctrine()->getManager();
                        $user = $em->getRepository(User::class)->findOneBy(['email' => $json['data']['email']]);
                        if ($user) {
                            $encoder = $this->get('security.password_encoder');
                            $old_pass = $encoder->encodePassword($user, $json['data']['oldpass']);
                            if ($old_pass == $user->getPassword()) {
                                $user->setPassword($encoder->encodePassword($user, $json['data']['password']));
                                $em->persist($user);
                                $em->flush();
                                return SimpleJsonApi::createResponseObj($user);
                            }
                            throw new Exception('Старый пароль неверен');
                        }
                        throw new Exception('Пользователь не найден');
                    }
                    throw new Exception('поле password не задано');
                }
                throw new Exception('поле oldpass не задано');
            }
            throw new Exception('поле email не задано');
        }
        throw new Exception('поле data не задано');
    }
}