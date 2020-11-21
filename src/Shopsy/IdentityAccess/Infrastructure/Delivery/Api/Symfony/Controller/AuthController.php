<?php


namespace App\Shopsy\IdentityAccess\Infrastructure\Delivery\Api\Symfony\Controller;


use App\Common\Application\Bus\CommandBus;
use App\Common\Application\Bus\HandlerNotFoundException;
use App\Common\Application\Bus\QueryBus;
use App\Shopsy\IdentityAccess\Application\Command\SignUpUserCommand;
use App\Shopsy\IdentityAccess\Domain\Model\UserEmailNotUniqueException;
use App\Shopsy\IdentityAccess\Domain\Model\UserUsernameNotUniqueException;
use App\Shopsy\IdentityAccess\Infrastructure\Delivery\Api\Symfony\Dto\UserSignUpDto;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class AuthController extends BaseController
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var QueryBus
     */
    private $queryBus;

    /**
     * UsersController constructor.
     *
     * @param CommandBus $commandBus
     * @param QueryBus $queryBus
     */
    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    /**
     * @Route("/auth/signUp", name="auth_sign_up", methods={"POST"})
     * @ParamConverter("userSignUpDto", class="App\Shopsy\IdentityAccess\Infrastructure\Delivery\Api\Symfony\Dto\UserSignUpDto")
     *
     * @param UserSignUpDto $userSignUpDto
     *
     * @return JsonResponse
     *
     * @throws HandlerNotFoundException
     */
    public function signUp(UserSignUpDto $userSignUpDto)
    {
//        try {

            $signUpUserCommand = new SignUpUserCommand(
                $userSignUpDto->fullName,
                $userSignUpDto->username,
                $userSignUpDto->email,
                $userSignUpDto->password
            );
//        try{
            $this->commandBus->handle($signUpUserCommand);
//        }catch(\Exception $e){
//            var_dump($e->getMessage());
//        }


            return new JsonResponse(['success' => true], JsonResponse::HTTP_OK);

//        } catch (UserUsernameNotUniqueException|UserEmailNotUniqueException $e) {
//            return new JsonResponse([
//                'violations' => [
//                    [
//                        'propertyPath' => '',
//                        'message' => $e->getMessage()
//                    ]
//                ]],
//                JsonResponse::HTTP_BAD_REQUEST
//            );
//        } catch (Exception $e) {
//            return new JsonResponse(
//                ['message' => JsonResponse::$statusTexts[JsonResponse::HTTP_INTERNAL_SERVER_ERROR]],
//                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
//            );
//        }
    }
}