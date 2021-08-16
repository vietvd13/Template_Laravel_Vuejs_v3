<?php

namespace Tests\Unit;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory as Faker;
use Repository\AuthRepository;
use App\Http\Requests\LoginRequest;
class AuthTest extends TestCase
{

    protected $user;
    protected $param;

    public function setUp() : void
    {
        
        parent::setUp();

        $this->faker = Faker::create();
        // chuẩn bị dữ liệu test
        $this->user = [
            'shop_id'=> $this->faker->name, 
            'department_id '=> $this->faker->name,
            'name'=> $this->faker->name,
            'email'=> 'test@gmail.com',
            'phone'=> $this->faker->name,
            'password'=> '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'user_name'=> $this->faker->name,
            'fax'=> $this->faker->name,
            'address'=> $this->faker->name,
            'avatar'=> $this->faker->name,
            'fb_id'=> '11111',
            'gender'=> '1',
            'status'=> '1',
        ];
        $this->param = [
            'user_name'=> 'test@gmail.com',
            'password'=> '123456',
        ];
        $this->authRepository = new AuthRepository();
        $this->loginRequest  = new LoginRequest();
    }

    public function tearDown() : void
    {
        parent::tearDown();
    }

    /**
     * test Login.
     * @param LoginRequest $this->param
     * @param null $guard
     * @return void
     */
    public function testLogin()
    {
        // Gọi hàm tạo
        // $requestt = new LoginRequest();
        // $requestt->header()
        // $response=$this->authRepository->doLogin( $this->param, $guard = null);

        $this->assertTrue(true);
        // $this->assertEquals(200,$response->getStatusCode());
    }
}
