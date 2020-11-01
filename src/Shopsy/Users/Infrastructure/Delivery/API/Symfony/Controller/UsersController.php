<?php

namespace App\Shopsy\Users\Infrastructure\Delivery\API\Symfony\Controller;

use App\Shared\Application\Service\TransactionalApplicationService;
use App\Shopsy\Users\Application\DataTransformer\ArrayUserDataTransformer;
use App\Shopsy\Users\Application\Service\SignInUserRequest;
use App\Shopsy\Users\Application\Service\SignInUserService;
use App\Shopsy\Users\Application\Service\SignUpUserRequest;
use App\Shopsy\Users\Application\Service\SignUpUserService;
use App\Shopsy\Users\Domain\Model\Authentication;
use App\Shopsy\Users\Domain\Model\UserAlreadyExistsException;
use App\Shopsy\Users\Domain\Model\UserNotExistsException;
use League\OAuth2\Server\Exception\OAuthServerException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    /**
     * @var TransactionalApplicationService
     */
    private $transactionalApplicationService;

    /**
     * @var SignUpUserService
     */
    private $signUpUserService;

    /**
     * @var SignInUserService
     */
    private $signInUserService;


    /**
     * UsersController constructor.
     *
     * @param TransactionalApplicationService $transactionalApplicationService
     * @param SignUpUserService $signUpUserService
     * @param SignInUserService $signInUserService
     */
    public function __construct(TransactionalApplicationService $transactionalApplicationService, SignUpUserService $signUpUserService, SignInUserService $signInUserService)
    {
        $this->transactionalApplicationService = $transactionalApplicationService;
        $this->signUpUserService = $signUpUserService;
        $this->signInUserService = $signInUserService;
    }

    /**
     * @Route("/signUp", name="users_sign_up", methods={"POST"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function signUp(Request $request)
    {
        $response = [
            'success' => false,
            'message' => 'Request could not be processed.',
            'statusCode' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
        ];

        try {

            $signUpUserRequest = new SignUpUserRequest(
                $request->get('firstName'),
                $request->get('lastName'),
                $request->get('email'),
                $request->get('password')
            );

            $user = $this->transactionalApplicationService->execute(function () use ($signUpUserRequest) {
                return $this->signUpUserService->execute($signUpUserRequest);
            });

            $response = [
                'success' => true,
                'message' => 'Request processed successfully.',
                'data' => $user,
                'statusCode' => JsonResponse::HTTP_CREATED
            ];

        } catch (UserAlreadyExistsException $e) {
            $response['message'] = 'User already exists.';
            $response['statusCode'] = JsonResponse::HTTP_BAD_REQUEST;
        } catch (\Exception $e) {
            $response['message'] = 'Request could not be processed.';
            $response['statusCode'] = JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
        }

        return new JsonResponse($response, $response['statusCode']);
    }

    /**
     * @Route("/signIn", name="users_sign_in", methods={"POST"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     */
    public function signIn(Request $request)
    {
        $response = [
            'success' => false,
            'message' => 'Request could not be processed.',
            'statusCode' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR
        ];

        try {

            $signInUserRequest = new SignInUserRequest(
                $request->get('email'),
                $request->get('password')
            );

            $user = $this->transactionalApplicationService->execute(function () use ($signInUserRequest) {
                return $this->signInUserService->execute($signInUserRequest);
            });

            $response = [
                'success' => true,
                'message' => 'Request processed successfully.',
                'data' => $user,
                'statusCode' => JsonResponse::HTTP_OK
            ];

        } catch (OAuthServerException $e) {
            $response = [
                'success' => true,
                'message' => 'Login request could not be processed.',
                'data' => $e->getPayload(),
                'statusCode' => $e->getHttpStatusCode()
            ];
        } catch (UserNotExistsException $e) {
            $response['statusCode'] = JsonResponse::HTTP_BAD_REQUEST;
            $response['message'] = 'User does not exists.';
        } catch (\Exception $e) {
            $response['statusCode'] = JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
            $response['message'] = 'Request could not be processed.';
        }

        return new JsonResponse($response, $response['statusCode']);
    }
}
