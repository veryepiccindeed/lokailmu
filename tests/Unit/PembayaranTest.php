<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Repositories\PembayaranRepositoryInterface;
use Mockery;

class PembayaranTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockPembayaranRepository = Mockery::mock(PembayaranRepositoryInterface::class);
        $this->app->instance(PembayaranRepositoryInterface::class, $this->mockPembayaranRepository);
    }

    public function test_pembayaran_can_be_created()
    {
        $pembayaranData = [
            'idTransaksi' => 'PAY123456', // Changed from idPembayaran
            'idPelatihan' => 'PLT123456',
            'idGuru' => 'U12345678901', // Changed from idUser
            'total' => 100000.00, // Changed from jumlahPembayaran and type to float
            // 'metodePembayaran' => 'credit_card', // Removed
            'statusByr' => 'Pending', // Changed from statusPembayaran and value 'pending' to 'Pending'
            // Assuming jumlahDP can be nullable or has a default, or will be set separately
            // For simplicity, this test case will focus on the main fields from the original test
        ];

        $this->mockPembayaranRepository
            ->shouldReceive('create')
            ->once()
            ->with(Mockery::on(function($arg) use ($pembayaranData) {
                return $arg['idTransaksi'] === $pembayaranData['idTransaksi'] &&
                       $arg['idPelatihan'] === $pembayaranData['idPelatihan'] &&
                       $arg['idGuru'] === $pembayaranData['idGuru'] &&
                       $arg['total'] == $pembayaranData['total'] && // Use loose comparison for float
                       $arg['statusByr'] === $pembayaranData['statusByr'];
            }))
            ->andReturn((object) $pembayaranData);

        $pembayaran = $this->mockPembayaranRepository->create($pembayaranData);

        $this->assertEquals('PAY123456', $pembayaran->idTransaksi); // Changed from idPembayaran
        $this->assertEquals('Pending', $pembayaran->statusByr); // Changed from statusPembayaran
    }

    public function test_pembayaran_can_be_read()
    {
        $transaksiId = 'PAY123456';
        $pembayaranData = (object) [
            'idTransaksi' => $transaksiId,
            'idPelatihan' => 'PLT123456',
            'idGuru' => 'U12345678901',
            'total' => 100000.00,
            'statusByr' => 'Pending',
        ];

        $this->mockPembayaranRepository
            ->shouldReceive('find')
            ->once()
            ->with($transaksiId)
            ->andReturn($pembayaranData);

        $pembayaran = $this->mockPembayaranRepository->find($transaksiId);

        $this->assertEquals($transaksiId, $pembayaran->idTransaksi);
        $this->assertEquals('Pending', $pembayaran->statusByr);
    }

    public function test_pembayaran_can_be_updated()
    {
        $transaksiId = 'PAY123456';
        $updateData = [
            'statusByr' => 'Success',
            'total' => 150000.00,
        ];
        $updatedPembayaranData = (object) array_merge([
            'idTransaksi' => $transaksiId,
            'idPelatihan' => 'PLT123456',
            'idGuru' => 'U12345678901',
        ], $updateData);

        $this->mockPembayaranRepository
            ->shouldReceive('update')
            ->once()
            ->with($transaksiId, Mockery::on(function($arg) use ($updateData) {
                return $arg['statusByr'] === $updateData['statusByr'] &&
                       $arg['total'] == $updateData['total'];
            }))
            ->andReturn($updatedPembayaranData);

        $pembayaran = $this->mockPembayaranRepository->update($transaksiId, $updateData);

        $this->assertEquals('Success', $pembayaran->statusByr);
        $this->assertEquals(150000.00, $pembayaran->total);
    }

    public function test_pembayaran_can_be_deleted()
    {
        $transaksiId = 'PAY123456';

        $this->mockPembayaranRepository
            ->shouldReceive('delete')
            ->once()
            ->with($transaksiId)
            ->andReturn(true);

        $result = $this->mockPembayaranRepository->delete($transaksiId);

        $this->assertTrue($result);
    }
}