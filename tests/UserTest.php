<?php

use PHPUnit\Framework\TestCase;

use Controller\UserController;

use Model\User;

class UserTest extends TestCase
{
    private $userController;

    private $mockUserModel;

    public function setUp(): void {
        $this->mockUserModel = $this->createMock(User::class);

        $this->userController = new UserController($this->mockUserModel);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_create_user() {
        $this->mockUserModel->method('registerUser')->willReturn(true);

        $userResult = $this->userController->createUser('Maria', 'maria@email.com', '123456');

        return $this->assertTrue($userResult);

    }

      #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_not_create_user_with_invalid_credentials() {
        $this->mockUserModel->method('registerUser')->willReturn(false);

        $userResult = $this->userController->createUser('', 'email_invalido', ''); // Dados inválidos

         $this->assertFalse($userResult);

    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_sign_in() {
        $this->mockUserModel->method('getUserByEmail')->willReturn([
            "id"=> 1,
            "user_fullname" => "Maria",
            "email"=> "maria@email.com",
            "password"=> password_hash("123456", PASSWORD_DEFAULT)
        ]);
        $userResult = $this->userController->login('maria@email.com', '123456');

        $this->assertNotFalse($userResult);

        $this->assertEquals(1, $_SESSION['usuario_id']);
        $this->assertEquals('Maria', $_SESSION['user_fullname']);
        $this->assertEquals('maria@email.com', $_SESSION['email']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shouldnt_login_with_invalid_credentials() {
        $this->mockUserModel->method('getUserByEmail')->willReturn([
            "id"=> 1,
            "user_fullname" => "Maria",
            "email"=> "maria@email.com",
            "password"=> password_hash("123456", PASSWORD_DEFAULT)
        ]);
        $userResult = $this->userController->login('maria@email.com', password_hash('12345', PASSWORD_DEFAULT));

        $this->assertFalse($userResult);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_check_user_by_email() {
        $this->mockUserModel->method('getUserByEmail')->willReturn([
            "id"=> 1,
            "user_fullname" => "Maria",
            "email"=> "maria@email.com",
            "password"=> '$2y$10$JFcVAE4zupbqoKZfqRpusOf82HkL/R4yeE.9QXCGGb5'
        ]);

        $userResult = $this->userController->checkUserByEmail('maria@email.com');

        $this->assertNotNull($userResult);

        $this->assertEquals('maria@email.com', $userResult['email']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_verify_if_is_logged_in()
    {
        $_SESSION['usuario_id'] = 1;

        $userResult = $this->userController->isLoggedIn();

        $this->assertTrue($userResult);
    }
}
?>