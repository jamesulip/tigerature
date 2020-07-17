<?php namespace Tests\Repositories;

use App\Models\device;
use App\Repositories\deviceRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class deviceRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var deviceRepository
     */
    protected $deviceRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->deviceRepo = \App::make(deviceRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_device()
    {
        $device = factory(device::class)->make()->toArray();

        $createddevice = $this->deviceRepo->create($device);

        $createddevice = $createddevice->toArray();
        $this->assertArrayHasKey('id', $createddevice);
        $this->assertNotNull($createddevice['id'], 'Created device must have id specified');
        $this->assertNotNull(device::find($createddevice['id']), 'device with given id must be in DB');
        $this->assertModelData($device, $createddevice);
    }

    /**
     * @test read
     */
    public function test_read_device()
    {
        $device = factory(device::class)->create();

        $dbdevice = $this->deviceRepo->find($device->id);

        $dbdevice = $dbdevice->toArray();
        $this->assertModelData($device->toArray(), $dbdevice);
    }

    /**
     * @test update
     */
    public function test_update_device()
    {
        $device = factory(device::class)->create();
        $fakedevice = factory(device::class)->make()->toArray();

        $updateddevice = $this->deviceRepo->update($fakedevice, $device->id);

        $this->assertModelData($fakedevice, $updateddevice->toArray());
        $dbdevice = $this->deviceRepo->find($device->id);
        $this->assertModelData($fakedevice, $dbdevice->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_device()
    {
        $device = factory(device::class)->create();

        $resp = $this->deviceRepo->delete($device->id);

        $this->assertTrue($resp);
        $this->assertNull(device::find($device->id), 'device should not exist in DB');
    }
}
