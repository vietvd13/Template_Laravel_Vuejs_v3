<?php
namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\Session;
use Faker\Factory as Faker;
class LoginTest extends TestCase
{
    use RefreshDatabase;
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
    }

    public function tearDown() : void
    {
        parent::tearDown();
    }

    /**
     * A basic unit test example 1.
     *
     * @return void
     */
     /** @test */
    public function testLoginSuccessfully()
    {
        // Session::start();
        $response = $this->call('POST','api/auth/login', [
            'user_name' => 'test@gmail.com',
            'password' => '123456',
            '_token' => csrf_token()
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testLoginNotHavePassword()
    {
        // Session::start();
        $response = $this->postJson( 'api/auth/login', [
            'user_name' => 'test@gmail.com',
            'password' => '',
            '_token' => csrf_token()
        ]);
        $this->assertEquals(422, $response->decodeResponseJson()['code']);
    }
    public function testUserCanViewLogin()
    {
        $response = $this->get('api/auth/login');

        $response->assertStatus(200);
        // $response->assertViewIs('auth.login')->assertSee('Login');
    }
    public function testLoginNotHaveParams()
    {
        // Session::start();
        $response = $this->postJson('api/auth/login', [
            'user_name' => '',
            'password' => '',
            '_token' => csrf_token()
        ]);
        $this->assertEquals(422, $response->decodeResponseJson()['code']);
    }
    public function testLoginWrongPassword()
    {
        // Session::start();
        $response = $this->postJson( 'api/auth/login', [
            'user_name' => 'test@gmail.com',
            'password' => '1',
            '_token' => csrf_token()
        ]);
        $this->assertEquals(401, $response->decodeResponseJson()['code']);
    }
    public function testLoginWrongTypeEmail()
    {
        // Session::start();
        $response = $this->postJson( 'api/auth/login', [
            'user_name' => 'testgmail.com',
            'password' => '123456',
            '_token' => csrf_token()
        ]);
        $this->assertEquals(422, $response->decodeResponseJson()['code']);
        // $this->assertEquals(302, $response->getStatusCode());
    }
    public function testLoginNotHaveEmailOrPhoneNumber()
    {
        // Session::start();
        $response = $this->postJson('api/auth/login', [
            'user_name' => '',
            'password' => '123456',
            '_token' => csrf_token()
        ]);
        $this->assertEquals(422, $response->decodeResponseJson()['code']);
    }
    public function testRegisterSuccessfully()
    {
        $response = $this->call('POST', 'api/auth/register', [
            'name' => 'Nguyen Van A',
            'phone' => '09123123123',
            'email' => 'thanhgiangss2@gmail.com',
            'shop_name' => 'Coofe',
            'province_id' => '1',
            'password' => 'google123',
            'password_confirmation' => 'google123',
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testRegisterFillWrongPasswordConfirmation()
    {
        $response = $this->postJson('api/auth/register', [
            'name' => 'Nguyen Van A',
            'phone' => '09123123123',
            'email' => 'thanhgiangss2@gmail.com',
            'shop_name' => 'Coofe',
            'province_id' => '1',
            'password' => 'google123',
            'password_confirmation' => 'google',
        ]);
        $this->assertEquals(422, $response->decodeResponseJson()['code']);
    }
    public function testRegisterFillWrongPhoneNumber()
    {
        $response = $this->postJson('api/auth/register', [
            'name' => 'Nguyen Van A',
            'phone' => '0912abc',
            'email' => 'thanhgiangss2@gmail.com',
            'shop_name' => 'Coofe',
            'province_id' => '1',
            'password' => 'google123',
            'password_confirmation' => 'google123',
        ]);
        $this->assertEquals(422, $response->decodeResponseJson()['code']);
    }
    public function testRegisterEmailHaveBeenUse()
    {
        $response = $this->postJson('api/auth/register', [
            'name' => 'Nguyen Van A',
            'phone' => '012341234',
            'email' => 'test@gmail.com',
            'shop_name' => 'Coofe',
            'province_id' => '1',
            'password' => 'google123',
            'password_confirmation' => 'google123',
        ]);
        if($response->getStatusCode() !== 302)
        $this->assertEquals(422, $response->decodeResponseJson()['code']);
    }
}